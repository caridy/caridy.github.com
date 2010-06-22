YUI_config = {
    // standard YUI_config configuration
    combine: true,
    filter: 'min',

    // event binder configuration starts here
    eventbinder: {
        // set of options that should be preserved for every event (all optional)
        eventProperties: [
            "ctrlKey", "altKey",
            "shiftKey", "metaKey",
            "keyCode", "charCode",
            "screenX", "screenY",
            "clientX", "clientY",
            "button",
            "relatedTarget"
        ],

        // listener callback function
        fn: function(e) {
            var binder = YUI_config.eventbinder,
                props = binder.eventProperties,
                filter = /yui3-event-binder/,
                target = (e.target || e.srcElement),
                container = target,
                info = {
                    target: target,
                    type : e.type
                },
                i;

            if (target.nodeType === 3) {
                // target is a text node, so use its parent element
                target = target.parentNode;
            }

            // look for an element with the class yui3-event-binder
            while (container && !filter.test(container.className)) {
                container = container.parentNode;
            }

            if (container) {
                target.className += ' yui3-waiting';

                // back up the event properties to simulate the event later on
                for (i = props.length - 1; i >= 0; --i) {
                    info[props[i]] = e[props[i]];
                }

                (binder.q = binder.q || []).push(info);

                // prevent the default browser action for this event
                if (e.preventDefault) {
                    e.preventDefault();
                }
                return (e.returnValue = false);
            }
        },

        add: function(type) {
            var d = document;

            if (d.addEventListener) {
                d.addEventListener(type, this.fn, false);
            } else {
                d.attachEvent('on' + type, this.fn);
            }

            return this;
        }
    }
};

// add events to the monitoring process
YUI_config.eventbinder.add('click');