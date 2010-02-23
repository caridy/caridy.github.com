YUI.add('gallery-quicksand', function(Y) {

/**
* <p>The Accordion Node Plugin makes it easy to transform existing 
* markup into an accordion element with expandable and collapsable elements, 
* elements are  easy to customize, and only require a small set of dependencies.</p>
* 
* 
* <p>To use the Accordion Node Plugin, simply pass a reference to the plugin to a 
* Node instance's <code>plug</code> method.</p>
* 
* <p>
* <code>
* &#60;script type="text/javascript"&#62; <br>
* <br>
* 		//	Call the "use" method, passing in "gallery-node-accordion".  This will <br>
* 		//	load the script and CSS for the Accordion Node Plugin and all of <br>
* 		//	the required dependencies. <br>
* <br>
* 		YUI().use("gallery-node-accordion", function(Y) { <br>
* <br>
* 			//	Use the "contentready" event to initialize the accordion when <br>
* 			//	the element that represente the accordion <br>
* 			//	(&#60;div id="accordion-1"&#62;) is ready to be scripted. <br>
* <br>
* 			Y.on("contentready", function () { <br>
* <br>
* 				//	The scope of the callback will be a Node instance <br>
* 				//	representing the accordion (&#60;div id="accordion-1"&#62;). <br>
* 				//	Therefore, since "this" represents a Node instance, it <br>
* 				//	is possible to just call "this.plug" passing in a <br>
*				//	reference to the Accordion Node Plugin. <br>
* <br>
* 				this.plug(Y.Plugin.NodeAccordion); <br>
* <br>
* 			}, "#accordion-1"); <br>
* <br>		
* 		}); <br>
* <br>	
* 	&#60;/script&#62; <br>
* </code>
* </p>
*
* <p>The Accordion Node Plugin has several configuration properties that can be 
* set via an object literal that is passed as a second argument to a Node 
* instance's <code>plug</code> method.
* </p>
*
* <p>
* <code>
* &#60;script type="text/javascript"&#62; <br>
* <br>
* 		//	Call the "use" method, passing in "gallery-node-accordion".  This will <br>
* 		//	load the script and CSS for the Accordion Node Plugin and all of <br>
* 		//	the required dependencies. <br>
* <br>
* 		YUI().use("gallery-node-accordion", function(Y) { <br>
* <br>
* 			//	Use the "contentready" event to initialize the accordion when <br>
* 			//	the element that represente the accordion <br>
* 			//	(&#60;div id="accordion-1"&#62;) is ready to be scripted. <br>
* <br>
* 			Y.on("contentready", function () { <br>
* <br>
* 				//	The scope of the callback will be a Node instance <br>
* 				//	representing the accordion (&#60;div id="accordion-1"&#62;). <br>
* 				//	Therefore, since "this" represents a Node instance, it <br>
* 				//	is possible to just call "this.plug" passing in a <br>
*				//	reference to the Accordion Node Plugin. <br>
* <br>
* 				this.plug(Y.Plugin.NodeAccordion, { anim: true, effect: Y.Easing.backIn });
* <br><br>
* 			}, "#accordion-1"); <br>
* <br>		
* 		}); <br>
* <br>	
* 	&#60;/script&#62; <br>
* </code>
* </p>
* 
* @module gallery-node-accordion
*/


//	Util shortcuts

var UA = Y.UA,
	getClassName = Y.ClassNameManager.getClassName,
    anims = {},
    wheels = {fast:0.1,slow:0.6,normal:0.4},

	//	Frequently used strings
    QUICKSAND = "quicksand",
	ITEM 	  = "item",
	WIDTH 	  = "width",
	HEIGHT 	  = "height",
	PX 	 	  = "px",
	PERIOD 	  = ".",
	HOST 	  = "host",

	//	Attribute keys
	ATTR_ACTIVE 	 = 'active',
	ATTR_ITEMS 		 = 'items',
	ATTR_ORIENTATION = 'orientation',
	ATTR_SPEED  	 = 'speed',
	ATTR_ANIM		 = 'anim',
	ATTR_FILTER		 = 'filter',
	ATTR_SORT		 = 'sort',
	ATTR_SELECTOR	 = 'selector',
	
	// Aria Attributes
	ARIA_ROLE 	= 'role',
	ARIA_HIDDEN = 'aria-hidden',
	TAB_INDEX 	= 'tabIndex',
	
	//	Utility functions
	/**
	* The NodeAccordion class is a plugin for a Node instance.  The class is used via  
	* the <a href="Node.html#method_plug"><code>plug</code></a> method of Node and 
	* should not be instantiated directly.
	* @namespace plugin
	* @class NodeAccordion
	*/
	Quicksand = function () {
	
	Quicksand.superclass.constructor.apply(this, arguments);
	
	};

Quicksand.NAME = "Quicksand";
Quicksand.NS = QUICKSAND;

Quicksand.ATTRS = {
	/**
	* Nodes representing the whole list of items.
	*
	* @attribute items
	* @type Y.NodeList
	*/
	items: {
		readOnly: true,
		getter: function () {
			return this._all;
		}
	},
	
	/**
	* Nodes representing the list of visible items.
	*
	* @attribute active
	* @type Y.NodeList
	*/
	active: {
		readOnly: true,
		getter: function () {
			return this._root.all(this.get (ATTR_SELECTOR));
		}
	},
	
	/**
	* orientation defines if the accordion will use width or height to expand and collapse items.
	*
	* @attribute orientation
	* @writeOnce
	* @default height
	* @type string
	*/
	orientation: {
		value: '2D',
		writeOnce: true
	},
	/**
	* Boolean indicating that Y.Anim should be used to expand and collapse items.
	* It also supports a function with an specific effect.
	* <p>
	* <code>
	* &#60;script type="text/javascript"&#62; <br>
	* <br>
	* 		//	Call the "use" method, passing in "anim" and "gallery-node-accordion". <br>
	* <br>
	* 		YUI().use("anim", "gallery-node-accordion", function(Y) { <br>
	* <br>
	* 			Y.one("#myaccordion").plug(Y.Plugin.Quicksand, {<br>
	* 				anim: Y.Easing.backIn<br>
	* 			}); <br>
	* <br>	
	* 	&#60;/script&#62; <br>
	* </code>
	* </p>
	* 
	* @attribute anim
	* @default false
	* @type {boolean|function}
	*/
	anim: {
		value: false,
		validator : function (v) {
            return !Y.Lang.isUndefined(Y.Anim);
        }
	},
	/**
	* Numeric value indicating the speed in mili-seconds for the animation process.
	* Also support three predefined strings in lowercase:
	* <ol>
	* <li>fast = 0.1</li>
	* <li>normal = 0.4</li>
	* <li>slow = 0.6</li>
	* </ol>
	* 
	* @attribute speed
	* @readOnly
	* @default 0.4
	* @type numeric
	*/	
	speed: {
		value: 0.4,
		validator : function (v) {
            return (Y.Lang.isNumber(v) || (Y.Lang.isString(v) && wheels.hasOwnProperty(v)));
        },
        setter : function (v) {
            return (wheels.hasOwnProperty(v)?wheels[v]:v);
        }
	},
	selector: {
		value: 'li',
		writeOnce: true
	},
	filter: {
		value: ''
	},
	sort: {
		value: 'asc', // Sort alphabetically and ascending by default
		validator : function (v) {
            return ((v=='asc') || (v=='desc') || (Y.Lang.isFunction(v)));
        }
	}
	
};


Y.extend(Quicksand, Y.Plugin.Base, {

	//	Protected properties

	/** 
	* @property _root
	* @description Node instance representing the root node in the accordion.
	* @default null
	* @protected
	* @type Node
	*/
	_root: null,

	//	Public methods

    initializer: function (config) {
		var _root = this.get(HOST),
			c = [ATTR_SORT, ATTR_FILTER, ATTR_ORIENTATION, ATTR_ANIM, ATTR_SPEED, ATTR_SELECTOR],
			that = this;
		config = config || {};
		if (_root) {

			this._root = _root;
			
			Y.Array.each (c, function (v) {
				if (config[ATTR_SORT]) {
					that.set (ATTR_SORT, config[ATTR_SORT]);
				}
	    	});
			
			this.sync()._compute();
			
		}
    },

	destructor: function () {
    	this._all = null;
    	this._bench = null;
    	this._root = null;
    },
    
  	//	Protected methods

    _setToFloat: function (n) {
    	var r = n.get('region'),
    		c = ["marginTop", "marginLeft", "marginBottom", "marginRight", "borderLeftWidth", "borderTopWidth", "borderRightWidth", "borderBottomWidth"];
    	Y.Array.each (c, function (v) {
    		r[v] = parseInt(n.getStyle (v), 10) || 0; // why not to use getComputedStyle
    	});
    	n.setStyles ({top: r.top-r.borderTopWidth-r.marginTop, left: r.left-r.borderLeftWidth-r.marginLeft, position: 'absolute'});
    	return r;
    },	
    
	/**
	* @method _compute
	* @description Applying filter and sort to produce a new list.
	* @protected
	* @param {NodeList} nodes NodeList reference for the elements that should be removed automatically
	*/
	_compute: function (nodes) {
    	var bench = [],
    		regulars = this.get(ATTR_ACTIVE),
    		emerging = [],
    		filter = this.get (ATTR_FILTER),
    		sort = this.get (ATTR_SORT),
    		query = this.get (ATTR_SELECTOR)+this.get (ATTR_FILTER),
    		that = this;
    	
    	nodes = nodes || [];
    	
    	// applying filter
    	this.get(ATTR_ITEMS).each (function(n, i) {
    		if (nodes.indexOf(n) < 0) {
    			if (n.test(query)) {
	    			// the filter pass
	    			emerging.push (n);
	    		} else {
	    			bench.push (n);
	    		}
    		}
    	});

		// applying sort ...
    	
    	// setting all the visible items to absolute position
    	regulars._nodes.reverse();
    	regulars.each (this._setToFloat, this);
    	
    	// setting the bench and removing the elements from current view
    	(this._bench._nodes = Y.all(bench)).each (this._disappear, this); // fade out
    	// displaying new elements
    	emerging.reverse();
    	Y.all(emerging).each(function (n, i) {
    		that._root.prepend(n.remove());
    		if ((regulars.indexOf(n) < 0) || that._isHidden(n)) {
    			// setting the item ready to become visible soon if needed
    			n.setStyles({position: 'absolute', top: '100px', left: '100px', opacity: 0, display: 'block', visibility: 'visible'});
    			// fade-in for new elements
    			that._appear (n, i);
    			// Set ARIA attributes
    			n.set(ARIA_HIDDEN, false).set(TAB_INDEX, 0);
    		} else {
    			// moving the item to the new position
    			that._move (n, i);
    			// Set ARIA attributes
    			n.set(ARIA_HIDDEN, 'true').set(TAB_INDEX, -1);
    		}
    	});
    	
	},

	/**
	* @method _hidden
	* @description Checking if an item is hidden.
	* @protected
	* @param {Node} n Node instance representing an item.
	* @return Boolean if the item is hidden by default
	*/
	_isHidden: function (n) {
		var r = this._root;
		return (!n || !n.ancestor(function(el) { return (r === el); }) || 
				(n.getStyle('display').toLowerCase() == 'NONE') || 
				(n.getStyle('visibility').toLowerCase() == 'hidden') || 
				(parseInt(n.getStyle('opacity'), 10) === 0));
	},
	
	/**
	* @method _disappear
	* @description Removing an item from the sight.
	* @protected
	* @param {Node} n Node instance representing an item.
	*/
	_disappear: function (n) {
		var fn = function () {
			n.remove ();
		};
		// for performance, we should hide only those that are visible
		if (!this._isHidden(n)) {
			// fade-out 
			this._animate (Y.stamp(n), {
				node: n,
				to: {
					opacity: 0
				}
			}, fn);
		} else {
			fn.call();
		}
	},

	
	_getXY: function (p) {
		return {top: 100, left: 500};
	}, 
	/**
	* @method _appear
	* @description Showing an item in the current view.
	* @protected
	* @param {Node} n Node instance representing an item.
	* @param {Integer} i Index representing the position of the item.
	*/
	_appear: function (n, i) {
		// setting the surge position
		n.setStyles (this._getXY(i));
		// fade-in 
		this._animate (Y.stamp(n), {
			node: n,
			to: {
				opacity: 1
			}
		}, function () {
			n.setStyles({top: '0', left: '0', position: 'relative'});
		});
	},

	/**
	* @method _move
	* @description Move an item to a new position.
	* @protected
	* @param {Node} n Node instance representing an item.
	* @param {Integer} i Index representing the position of the item.
	*/
	_move: function (n, i) {
		// moving to the new position
		this._animate (Y.stamp(n), {
			node: n,
			to: this._getXY(i)
		}, function () {
			n.setStyles({top: '0', left: '0', position: 'relative'});
		});
	},

	/**
	 * @method _animate
	 * @description Using Y.Anim to animate an item.
	 * @protected
	 * @param {String} id Global Unique ID for the animation.
	 * @param {Object} conf Configuration object for the animation.
	 * @param {Function} fn callback function that should be executed after the end of the anim.
	 * @return {Object} Animation handler.
	 */
	_animate: function(id, conf, fn) {
		if (!this.get(ATTR_ANIM)) {
			var anim = anims[id];
			conf.duration =  this.get(ATTR_SPEED);
			// if the animation is underway: we need to stop it...
			if ((anim) && (anim.get ('running'))) {
	        	anim.stop();
	        }
		    if (Y.Lang.isFunction(this.get(ATTR_ANIM))) {
				conf.easing = this.get(ATTR_ANIM);
		    }
		    anim = new Y.Anim(conf);
		    if (fn) {
		    	anim.on('end', fn, this);
		    }
			anim.run();
		    anims[id] = anim;
		    return anim;
		} else {
			// manually configuration
			conf.node.setStyles (conf.to);
			fn.call();
		}
	},
	
	
	
	//	Generic DOM Event handlers
	/**
	* @method clear
	* @description Clear the panel, hiding all the elements.
	* @public
	* @return {object} Plugin reference for chaining
	*/
	clear: function () {
		this._compute (this.get(ATTR_ITEMS));
		return this;
	},	
	
	/**
	* @method sync
	* @description Recollecting a new set of elements from the DOM, and setting the corresponding visibility properties for each item.
	* @public
	* @return {object} Plugin reference for chaining
	*/
	sync: function () {
		// empty list of items in the bench
		this._bench = Y.all([]);
		// just in case you want to use markup ul>li as a simple markup structure
		this._all = this.get (ATTR_ACTIVE);
		// setting area role & computing current visible list
		this._all.set(ARIA_ROLE, 'presentation').set(TAB_INDEX, 0).toFrag(); 
		return this;
	},
	
	/**
	* @method refresh
	* @description Re-apply filter and sort, and refresh the list.
	* @public
	* @param {NodeList} nodes NodeList reference for the elements that should be removed automatically
	* @return {object} Plugin reference for chaining
	*/
	refresh: function () {
		this._compute ();
		return this;
	},	
	
	/**
	* @method displayItem
	* @description Add a new item to the list. This action will trigger the "filter" action to display the new item if needed.
	* @public
	* @param {Node} n Node reference
	* @return {object} Plugin reference for chaining
	*/
	addItem: function ( n ) {
	    return this.addItems([n]);
	},
	
	/**
	* @method removeItem
	* @description Remove a certain item from the list. This action will trigger the "filter" action to reorganize the items if needed.
	* @public
	* @param {object} n Node reference
	* @return {object} Plugin reference for chaining
	*/
	removeItem: function ( n ) {
		if (this.get(ATTR_ITEMS).indexOf(Y.one(n)) >= 0) {
	    	this._compute (Y.all(n));
	    }
	    return this;
	},
	
	/**
	* @method addItems
	* @description Add a new set of items to the list. This action will trigger the "filter" action to display the items if needed.
	* @public
	* @param {NodeList} nodes NodeList reference
	* @return {object} Plugin reference for chaining
	*/
	addItems: function ( nodes ) {
	    var that = this;
		nodes = Y.all(nodes);
	    nodes.each (function (n) {
	    	that.get(ATTR_ITEMS)._nodes.push (n);
	    });
	    this._compute ();
		return this;
	}

});

Y.namespace('Plugin');

Y.Plugin.Quicksand = Quicksand;


}, '@VERSION@' ,{requires:['node-base', 'node-style', 'plugin', 'node-event-delegate', 'classnamemanager'], optional:['anim']});
