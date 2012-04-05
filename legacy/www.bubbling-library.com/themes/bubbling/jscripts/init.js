//<![CDATA[
/*
 Copyright (c) 2007 Caridy Patiño. All rights reserved.
 version 0.1.1
 Author: Caridy Patino (caridy at gmail.com)
*/
YAHOO.namespace("App");
(function() {

  var $B = YAHOO.Bubbling,
  	  $E = YAHOO.util.Event,
	  $D = YAHOO.util.Dom,
	  $ =  YAHOO.util.Dom.get;

	YAHOO.App.Core = function () {
	    var obj = {};
		try {
			obj.flags = DEFAULT_VARS;
		} catch(e) {
			obj.flags = {};
		}
        // Private Methods
		var actions = {
			navMPPrintableVersion: function () {
				window.open (YAHOO.plugin.Dispatcher.augmentURI ( obj.navHistory[obj.navHistory.length - 1], {'tpl':'tpls/printable'} ),'','scrollbars=yes,width=800,height=600');
				return true;
			},
			actionFormFieldFocus: function (layer, args) {
				  var el = args[1].anchor;
				  if (el && el.id && (el.id.indexOf('setfocus') === 0)) {
				  	// calculating the form field ID
				  	var field = $(el.id.slice (8, el.id.length));
					if (field) {
					  field.focus();
					  return true;
					}
				  }
			}
		};
	    $B.on('navigate', function (layer, args) {
		  $B.processingAction (layer, args, actions);
	    });

        // Public Vars
		obj.navHistory = [];
        // Public Methods
		obj.init = function () {
		  this.navHistory.push ( window.location.href );
		};
		obj.initHighlighter = function () {
		    YAHOO.util.SyntaxHighlighter.HighlightAll('code');
		};
		obj.initCategories = function () {};
		obj.initSelector = function () {};
		obj.initHints = function () {};
		obj.initMenuBar = function () {
		  var oMenuBar = new YAHOO.widget.MenuBar('quickaccess', { autosubmenudisplay: true, hidedelay: 750, lazyload: true });
          oMenuBar.render();
		};
  	    return obj;
	}();

	YAHOO.App.Buttons = function () {
		var obj = {};
		// Private Methods
		var buttons = {};
		var buttonsControl = function (layer, args) {
		  $B.processingAction (layer, args, buttonsControl);
		};
		$B.on('navigate', buttonsControl);
		// Public Methods
		return obj;
	}();

	// Initialize and render dynamic elements using onContentReady event for each webpart
	$E.onDOMReady(YAHOO.App.Core.init, YAHOO.App.Core, true);
	$E.onContentReady('quickaccess', YAHOO.App.Core.initMenuBar, YAHOO.App.Core, true);

})();
//]]>