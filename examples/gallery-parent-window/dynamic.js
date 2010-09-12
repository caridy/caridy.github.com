(function(d){
    // initialization process for gallery-parent-window
    function _init() {
        YUI().use('gallery-parent-window', function (iframeBinderY) {
          
            var app = iframeBinderY.config.app; // this is how we can inject configuration into this execution

            iframeBinderY.ParentWindow().use ('node', function(Y) {
                
                // doing your stuff here...
                var node = Y.one (app.trigger);
                node.on('click', function(e) {
                    alert ('Hey, this click event is being controlled from the iframe Y instance.');
                    e.halt();
                });
                // notification
                node.append (' &nbsp; <em>(is ready now)</em>');
                
            })

        });
    }
    // DO NOT CHANGE THE CODE FROM THIS LINE TO THE END.
    // injecting the YUI3 Loader in the current page and calling init when it gets ready
    var s = d.createElement('script');
    s.type = "text/javascript";
    if (s.readyState) { //IE
        s.onreadystatechange = function(){
            if (s.readyState == "loaded" || s.readyState == "complete"){
                s.onreadystatechange = null;
                _init();
            }
        };
    } else {  // Others
        s.onload = _init;
    }
    s.src = 'http://yui.yahooapis.com/3.2.0/build/yui/yui-min.js';
    d.getElementsByTagName('head')[0].appendChild(s);
})(document);