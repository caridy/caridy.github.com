YUI.add('gallery-event-binder', function(Y) {

/**
* <p>The Dispatcher satisfies a very common need of developers using the 
* YUI library: dynamic execution of HTML Fragments or remote content. Typical strategies to 
* fulfill this need, like executing the innerHTML property or referencing remote 
* scripts, are unreliable due to browser incompatibilities. The Dispatcher normalize 
* this behavior across all a-grade browsers.
* 
* <p>To use the Dispatcher Module, simply create a new object based on Y.Dispatcher
* and pass a reference to a node that should be handled.</p>
* 
* <p>
* <code>
* &#60;script type="text/javascript"&#62; <br>
* <br>
*		//	Call the "use" method, passing in "gallery-dispatcher".	 This will <br>
*		//	load the script for the Dispatcher Module and all of <br>
*		//	the required dependencies. <br>
* <br>
*		YUI().use("gallery-dispatcher", function(Y) { <br>
* <br>
*			(new Y.Dispatcher ({<br>
*				node: '#demoajax',<br>
*				content: 'Please wait... (Injecting fragment.html)'<br>
*			})).set('uri', 'fragment.html');<br>
* <br>
* <br>		
*	&#60;/script&#62; <br>
* </code>
* </p>
*
* <p>The Dispatcher has several configuration properties that can be 
* set via an object literal that is passed as a first argument during the
* initialization, or using "set" method.
* </p>
*
* @module gallery-event-binder
*/
Y.EventBinder = {
	flush: function (type) {
		var config = Y.config.eventbinder || {};
		
		config.q = config.q || [];
		type = type || 'click';
		
		if (config.fn) {
			Y.Event.detach(type, config.fn, Y.config.doc);
		}
		Y.each(config.q, function(o) {
			
			if (type == o.type) {
				Y.Event.simulate(o.t, type, (new Y.DOMEventFacade(o.e, type)));
			}
		});
	}
};


}, '@VERSION@' ,{requires:['event-simulate','event-base']});
