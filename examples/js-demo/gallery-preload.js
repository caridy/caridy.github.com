YUI.add('gallery-preload', function(Y) {

/**
 * Y.preload() function for YUI3
 * Preload images, CSS and JavaScript files without executing them
 * Port of Stoyan Stefanov's Script – http://www.phpied.com/preload-cssjavascript-without-execution/
 * Note that since this script relies on YUI Loader, the preloading process will not start until YUI has finished loading.
 * 
 * @module gallery-preload
 */

/**
 * Preload images, CSS and JavaScript files without executing them
 * @namespace Y
 * @class preload
 * @static
 * @param files {String|Array} collection of files to be loaded
 */
Y.preload = function(files) {
	var o, ie = Y.UA.ie, doc = Y.config.doc;
	
	// If the first argument is not an array, we can assume the user is trying to load one
	// single file or a list of files like: Y.preload ('file1.js', 'file2.css');
	files = (Y.Lang.isArray(files)?files:Y.Array(arguments, 0, true));
	
	Y.log("Preloading files: " + files.join(', '), "info", "Y.preload");
	
	Y.Array.each(files, function (f) {
		if (ie) {
            (new Image()).src = f;
        } else {
	        o = doc.createElement('object');
	        o.data = f;
	        o.width = o.height = 0;
	        doc.body.appendChild(o);
        }
    });
};


}, '@VERSION@' ,{optional:['yui'], requires:['yui'], supersedes:['yui']});
