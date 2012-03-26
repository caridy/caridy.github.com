/**
 *
 * Provides a secure, evented communication layer for cross-domain HTML5 web
 * applications.
 *
 * @module cl
 * @requires json, event-custom-base
 */
YUI.add('cl', function (Y, NAME) {

    var ERROR = 'error',
        WARN  = 'warn',
        INFO  = 'info',
        DEBUG = 'debug';

    /**
     * @class CommunicationLayer
     * @param config {Object} Configuration object
     * @constructor
     */
    function CommunicationLayer (config) {
        NAME = NAME+': '+Y.config.win.location.pathname; // friendlier logs

        config = config || {};

        this._WIN               = Y.config.win;
        this._APPREADY          = 'appready';
        this._BUFFER_TIMEOUT    = config.bufferTimeout    || 10000;
        this._CALLBACK_TIMEOUT  = config.callbackTimeout  || 10000;

        // Lookup for event targets that act as internal proxies.
        this._proxyFor = {};

        // Lookup for subscriptions that represent open connections.
        this._subscriptionFor = {};

        // We use the parent origin alias to look up the parent event target
        // when we don't yet know the parent's origin (i.e., before the
        // handshake completes). This should only be used during the handshake
        // or if we are not sure if the handshake has already completed.
        this._PARENT_ORIGIN_ALIAS = 'parent';
        this._parentProxy = this._createEventProxy(this._PARENT_ORIGIN_ALIAS);

        if (config.debug) {
            this._initDebugMode();
        }

        this._init();
    }

    CommunicationLayer.prototype = {

        _init: function () {
            this._initWindowMessageHandler();
            this._initParentConnection();
        },

        _initWindowMessageHandler: function () {
            var self = this;

            Y.log('Initializing handler for window messages', INFO, NAME);

            self._addListener(self._WIN, 'message', function (e) {
                var source = e.source,
                    origin = e.origin,
                    parsed,
                    name,
                    data;

                try {
                    parsed = Y.JSON.parse(e.data);
                    name   = parsed && parsed.name;
                } catch (err) {
                    Y.log('Invalid data structure as part of the message, discarded message.', INFO, NAME);
                }

                Y.log('Received window message: '+e.data+' from '+origin, DEBUG, NAME);

                if (! name) {
                    Y.log('Dropping window message since it does not fulfill the requirements of a CL message', DEBUG, NAME);
                    return;
                }

                data = {
                    data: parsed.data,
                    origin: origin,
                    source: source
                };

                if (parsed.cbid) {
                    /**
                     * A callback facade that transparently invokes a callback
                     * associated with another CL instance.
                     */
                    data.callback = function () {
                        self._postMessage(source, {
                            name: parsed.cbid,
                            data: {
                                args: Array.prototype.slice.call(arguments)
                            }
                        }, origin);
                    };
                }

                // If there is a proxy associated with the event name, it is a
                // dedicated handshake proxy and we assume we are in the middle
                // of a handshake.
                if (self._proxyFor[name]) {
                    Y.log('Firing "'+name+'" on dedicated handshake proxy', DEBUG, NAME);
                    self._proxyFor[name].fire(name, data);
                }
                // If there is a proxy associated with the origin, we fire the
                // message on it to notify any subscribers.
                else if (self._proxyFor[origin]) {
                    Y.log('Firing "'+name+'" on dedicated proxy for '+origin, DEBUG, NAME);
                    self._proxyFor[origin].fire(name, data);
                }
                // We should never reach this point unless we receive a window
                // message that resembles a CL message.
                else {
                    Y.log('Proxy lookup failed. This should never happen!', WARN, NAME);
                }
            });
        },

        _initParentConnection: function () {
            var self = this,
                win  = self._WIN,
                href = win.location.href,
                token;

            if (href) {
                token = self._getHandshakeToken(href);

                // We only listen for the token once on the handshake proxy
                // because subsequent window messages from the parent will be
                // identifiable using the now-available parent origin.
                self._createEventProxy(token).once(token, function (e) {
                    Y.log('ACK received from parent '+e.origin, INFO, NAME);

                    self._deleteEventProxy(token); // delete handshake-specific event proxy

                    self._parentSource = e.source;
                    self._parentOrigin = e.origin;

                    // We record the parent event proxy under the actual origin.
                    self._proxyFor[e.origin] = self._parentProxy;

                    Y.log('Connection established with parent '+self._parentOrigin, INFO, NAME);

                    Y.log('Flushing any buffered events', INFO, NAME);
                    self._parentProxy.fire(self._APPREADY);
                });

                // We don't specify the parent origin here because it is
                // unknown until the connection is established.
                self._postMessage(win.parent, {name: token}, '*');
                Y.log('SYN sent to parent', INFO, NAME);
            }
        },

        register: function (iframe, cb) {
            var self = this,
                src,
                token;

            // Wrap with Y.Node if not wrapped already
            iframe = Y.one(iframe);
            src = iframe && iframe.test('iframe') && iframe.get('src');

            if (! src) {
                Y.log('Only iframes with src attributes can be registered', ERROR, NAME);
                return;
            }

            token = self._getHandshakeToken(src);
            Y.log('Initiating the registration process using the token '+token, INFO, NAME);

            // We listen for a handshake request initiated by the iframe.
            self._createEventProxy(token).once(token, function (e) {
                var origin = e.origin,
                    source = e.source,
                    proxy  = self._createEventProxy(origin);

                Y.log('SYN received from child '+origin, INFO, NAME);

                if (Y.Lang.isFunction(cb)) {
                    var clProxy = self._createCLProxy(iframe, proxy, origin, source);
                    cb(clProxy);
                }

                // Delete handshake-specific event proxy
                self._deleteEventProxy(token);

                Y.log('Connection established with child '+origin, INFO, NAME);
                self._postMessage(source, {name: token}, origin);
                Y.log('ACK sent to child '+origin, INFO, NAME);
            });
        },

        _createCLProxy: function (iframe, proxy, origin, source) {
            var self = this;

            return {
                iframe: iframe,
                on: function (name, handler) {
                    return proxy.on(name, function (e) {
                        if (origin === e.origin) {
                            handler(e);
                        }
                    });
                },
                once: function (name, handler) {
                    return proxy.once(name, function (e) {
                        if (origin === e.origin) {
                            handler(e);
                        }
                    });
                },
                fire: function (name, data, cb) {
                    self._fireWindowMessageEvent(name, source, origin, {
                        data: data,
                        callback: cb
                    });
                },
                open: function (name, cb) {
                    return self._createConnectionObject(name, cb, {
                        source: source,
                        origin: origin
                    });
                },
                /**
                 * Allows the parent to subscribe to the point in time when the
                 * child is ready to receive CL message events.
                 *
                 * @method ready
                 * @param cb {Function} A callback
                 * @public
                 */
                ready: function (cb) {
                    Y.log('Registering a callback to execute when the child is ready', DEBUG, NAME);
                    return proxy.on(self._APPREADY, cb);
                },
                purge: function () {
                    proxy.detachAll();
                    Y.log('All listeners have been detached', DEBUG, NAME);
                }
            };
        },

        /**
         * Notifies the parent that the application is ready to receive CL
         * message events.
         *
         * @method ready
         * @public
         */
        ready: function () {
            Y.log('Ready to receive messages from the parent', DEBUG, NAME);
            this._fireParentMessageEvent(this._APPREADY);
        },

        on: function (name, handler) {
            if (name && handler) {
                return this._onParentMessageEvent(name, handler);
            }
        },

        once: function (name, handler) {
            if (name && handler) {
                return this._onParentMessageEvent(name, handler, once);
            }
        },

        fire: function (name, data, cb) {
            if (name) {
                this._fireParentMessageEvent(name, data, cb);
            }
        },

        /**
         * Opens a 'persistent' connection (as opposed to
         * <code>fire</code> which only executes its callback once).
         *
         * @method open
         * @param name {String} The connection name
         * @param cb {Function} A callback
         * @return {Object} A connection object
         * @public
         */
        open: function (name, cb) {
            return this._createConnectionObject(name, cb, {
                origin: this._PARENT_ORIGIN_ALIAS
            }, true);
        },

        /**
         * Creates a connection object that represents an open connection.
         *
         * @method _createConnectionObject
         * @param name {String} The connection name
         * @param cb {Function} A callback
         * @param win {Object} Window metadata used to fire the event (e.g., source and origin)
         * @param connectingToParent {Boolean} Indicates that we are connecting to the parent
         * @private
         */
        _createConnectionObject: function (name, cb, win, connectingToParent) {
            var self = this,
                cbid,
                sub;

            if (! (name && Y.Lang.isFunction(cb) && win)) {
                return null;
            }

            cbid = self._registerCallback(cb, win.origin, name);

            Y.log('Creating a connection bound to the event name "'+name+'" and the callback "'+cbid+'"', INFO, NAME);

            return {
                write: function (data) {
                    if (! self._subscriptionFor[name]) {
                        Y.log('The connection has already been closed', WARN, NAME);
                        return;
                    }

                    Y.log('Writing data to the open "'+name+'" connection', DEBUG, NAME);

                    // If we're connecting with the parent we need to go
                    // through _fireParentMessageEvent to account for the case
                    // where the handshake has not yet completed and we need to
                    // buffer the write.
                    if (connectingToParent) {
                        self._fireParentMessageEvent(name, data, cbid);
                    }
                    else {
                        self._fireWindowMessageEvent(name, win.source, win.origin, {
                            data: data,
                            callback: cbid
                        });
                    }
                },
                close: function () {
                    sub = self._subscriptionFor[name];
                    if (sub) {
                        Y.log('Closing connection for: '+name, INFO, NAME);
                        sub.detach();
                        delete self._subscriptionFor[name];
                    }
                }
            };
        },

        _onParentMessageEvent: function (name, handler, once) {
            return this._onWindowMessageEvent(
                name, this._PARENT_ORIGIN_ALIAS, handler, { once: once }
            );
        },

        /**
         * Fires a message event at the parent.
         *
         * Wrapper around <code>_fireWindowMessageEvent</code> that buffers any
         * message events fired at the parent if the parent window is not yet
         * ready. Note that this buffer times out after a default of 10s but
         * this is configurable via <code>config.bufferTimeout</code>.
         *
         * @method _fireParentMessageEvent
         * @param name {String} The event name
         * @param data {Object} Optional event data
         * @param cb {Function|String} Optional callback or callback ID
         * @private
         */
        _fireParentMessageEvent: function (name, data, cb) {
            var self = this,
                fireParentMessageEvent,
                sub;

            fireParentMessageEvent = function () {
                self._fireWindowMessageEvent(name, self._parentSource, self._parentOrigin, {
                    data: data,
                    callback: cb
                });
            };

            if (! self._parentAppIsReady()) {
                // Buffer the message event until the parent is ready or until
                // the timeout, whichever comes first.
                sub = self._parentProxy.once(self._APPREADY, fireParentMessageEvent);

                // Kill the subscription after a timeout to prevent a memory leak
                Y.later(self._BUFFER_TIMEOUT, null, function () {
                    if (! self._parentAppIsReady()) {
                        Y.log('Handshake timeout! Killing the buffered event "'+name+'" that was fired at the parent', WARN, NAME);
                        sub.detach();
                    }
                });
            }
            else {
                fireParentMessageEvent();
            }
        },

        /**
         * Determines if the parent application is ready (i.e., whether or not
         * the handshake has completed).
         *
         * @method _parentAppIsReady
         * @private
         */
        _parentAppIsReady: function () {
            var evt = this._parentProxy.getEvent(this._APPREADY);
            return evt.fired;
        },

        /**
         * Gets a token to use for the handshake.
         *
         * We use the origin since it is known by both handshake participants.
         *
         * @method _getHandshakeToken
         * @param href {String} The URL of the window we want to establish a connection with
         * @private
         *
         */
        _getHandshakeToken: function (href) {
            return href.replace(/[?].*$/, '').replace(/[#].*$/, '');
        },

        _registerCallback: function (cb, origin, name, timeout) {
            var proxy = this._proxyFor[origin],
                cbid  = Y.stamp(cb),
                timer,
                sub;

            if (! proxy) {
                Y.log('Proxy lookup failed for '+origin+' during callback registration', ERROR, NAME);
                return;
            }

            // If a timeout was provided, we want to subscribe to a single
            // response generated by the callback facade corresponding to this
            // callback id within the timeout period.
            if (timeout) {
                sub = proxy.once(cbid, function (e) {
                    timer.cancel();
                    cb.apply(null, e.data.args); // invoke the callback with the argument array
                    Y.log('Successful callback execution for event "'+name+'" using id: '+cbid, INFO, NAME);
                });

                // Kill the subscription after a timeout to prevent a memory leak
                timer = Y.later(timeout, null, function () {
                    Y.log('Callback timeout! Unsubscribing the callback for event "'+name+'" using id: '+cbid, INFO, NAME);
                    sub.detach();
                });
            }
            // If a timeout wasn't provided, we want to subscribe to every
            // response generated by the invocation of the callback facade
            // corresponding to this callback id.
            else {
                Y.log('Opening connection for: '+name, INFO, NAME);
                this._subscriptionFor[name] = proxy.on(cbid, function (e) {
                    cb.apply(null, e.data.args); // invoke the callback with the argument array
                    Y.log('Successful callback execution for event "'+name+'" using id: '+cbid, INFO, NAME);
                });
            }

            return cbid;
        },

        _createEventProxy: function (origin) {
            if (origin) {
                Y.log('Creating event proxy for '+origin, DEBUG, NAME);
                var proxy = new Y.EventTarget();

                proxy.publish(this._APPREADY, {
                    fireOnce: true
                });
                this._proxyFor[origin] = proxy;

                return proxy;
            }
        },

        _deleteEventProxy: function (origin) {
            Y.log('Deleting event proxy for '+origin, DEBUG, NAME);
            if (this._proxyFor[origin]) {
                this._proxyFor[origin].detachAll();
                delete this._proxyFor[origin];
            }
        },

        _onWindowMessageEvent: function (name, origin, handler, o) {
            if (name && origin && handler) {
                var proxy = this._proxyFor[origin];
                o = o || {};

                if (! proxy) {
                    Y.log('The proxy lookup for '+origin+' failed; creating one now..', DEBUG, NAME);
                    proxy = this._createEventProxy(origin);
                }

                return proxy[o.once ? 'once' : 'on'](name, handler);
            }
        },

        /**
         * Fires a CL message event at a window.
         *
         * Transforms the outgoing message into a structure that can be
         * understood by the CL message event handler on the other end.
         *
         * @method _fireWindowMessageEvent
         * @param name {String} The event name
         * @param source {Window} A reference to a window
         * @param origin {String} The origin of the window
         * @param o {Object} Optional arguments
         * @private
         */
        _fireWindowMessageEvent: function (name, source, origin, o) {
            var msg,
                cb;

            if (name && source && origin) {
                o   = o || {};
                cb  = o.callback;
                msg = { name: name };

                if (o.data) {
                    msg.data = o.data;
                }

                if (Y.Lang.isFunction(cb)) {
                    msg.cbid = this._registerCallback(cb, origin, name, this._CALLBACK_TIMEOUT);
                }
                else if (Y.Lang.isString(cb)) {
                    msg.cbid = cb;
                }

                this._postMessage(source, msg, origin);
            }
        },

        /**
         * Posts a window message through the win.postMessage API.
         *
         * @method _postMessage
         * @param win {Object} window reference
         * @param msg {Object} literal object representing the message to be sent
         * @param origin {Object} reference to the origin window
         * @return {boolean} whether or not the message was sent.
         * @protected
         */
        _postMessage: function (win, msg, origin) {
            if (win && win.postMessage && msg && origin) {
                win.postMessage(Y.JSON.stringify(msg), origin);
                return true;
            }
        },

        /**
         * Initializes debug mode where you can hook into communication between
         * the current application and its parent.
         *
         * @private
         */
        _initDebugMode: function () {
            var self = this,
                proxy = self._createEventProxy(DEBUG);

            Y.log('Initializing debug mode', WARN, NAME);

            // Global methods which can be used to simulate parent interaction.
            YUI.CL = {
                fire: function (name, data) {
                    proxy.fire(name, {
                        data: data
                    });
                },
                on: function (name, handler) {
                    return proxy.on(name, handler);
                },
                once: function (name, handler) {
                    return proxy.once(name, handler);
                }
            };

            // Wrapping some methods on this CL instance so that we can
            // leak incoming/outgoing events through to the debug event proxy.
            Y.Array.each(['fire', 'on', 'once'], function (name) {
                var orig = self[name]; // save original
                self[name] = function () {
                    var args = Array.prototype.slice.call(arguments);
                    proxy[name].apply(proxy, args);
                    orig.apply(self, args);
                };
            });
        },

        // -- Y.one('window').on('message', ...) IE9 workarounds -----

        _addListener: function (el, ev, fn) {
            if (el.addEventListener) {
                el.addEventListener(ev, fn, false);
            } else if (el.attachEvent) {
                el.attachEvent('on'+ev, fn);
            } else {
                el['on'+ev] = fn;
            }
        },

        _removeListener: function(el, ev, fn) {
            if (el.removeEventListener) {
                // this can throw an uncaught exception in FF
                try {
                    el.removeEventListener(ev, fn);
                } catch (ex) {}
            } else if (el && el.detachEvent) {
                el.detachEvent('on'+ev, fn);
            }
        }

    };

    Y.CommunicationLayer = CommunicationLayer;

}, '0.0.1', {requires: ['json', 'event-custom-base']});
