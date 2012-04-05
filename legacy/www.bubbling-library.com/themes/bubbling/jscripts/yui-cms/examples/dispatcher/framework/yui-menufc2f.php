<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>

<!-- Mirrored from www.bubbling-library.com/themes/bubbling/jscripts/yui-cms/examples/dispatcher/framework/yui-menu.php?page=item5 by HTTrack Website Copier/3.x [XR&CO'2010], Wed, 04 Apr 2012 15:59:22 GMT -->
<head>
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
<title>Dispatcher Example - Dynamically Loading Content</title>
<meta name='author' content='Caridy Patino (caridy at gmail.com)' />
<link rel="stylesheet" type="text/css" href="../../assets/example.css">
<!-- YUI Basement Style -->
<link rel="stylesheet" type="text/css" href='http://yui.yahooapis.com/2.7.0/build/menu/assets/skins/sam/menu.css'/>
<!-- YUI Library -->
<script type="text/javascript" src='http://yui.yahooapis.com/2.7.0/build/utilities/utilities.js'></script>
<script type="text/javascript" src='http://yui.yahooapis.com/2.7.0/build/container/container-min.js'></script>
<script type="text/javascript" src='http://yui.yahooapis.com/2.7.0/build/menu/menu-min.js'></script>
<script type="text/javascript" src="../../../../../../../../js.bubbling-library.com/2.1/build/bubbling/bubbling.js"></script>
<script type="text/javascript" src="../../../../../../../../js.bubbling-library.com/2.1/build/dispatcher/dispatcher.js"></script>
<style type="text/css">
.yuimenubar {
    visibility: visible;
    position: static;
}
.yuimenubar li {
    list-style-type: none;
}
.boxing {
	float: left;
	width: 45%;
	border: 1px solid;
	margin: 1%;
	padding: 1%;
}
.footer, .header {
	diaplay: block;
	clear: both;
	padding: 2%;
	border: 1px solid;
}
.red { color: #FF0000; }
.content {
	border: 1px solid;
	margin: 1% 0;
	padding: 0 1%;
}
</style>
<script type="text/javascript">
(function() {
    // using the dispatcher to load the dynamic content
    function dynamic_navigation ( url ) {
    	YAHOO.plugin.Dispatcher.fetch ( 'dynamic-area', url + '&tpl=ajax' );
    };
    // default behavior: this method will be executed every time you click on the page...
    var dynamicNav = function (layer, args) {
      var e = args[0],
    	  el = args[1].anchor;
      if (!args[1].decrepitate && el) {
    	  var h = el.getAttribute("href",2),
    	  	  r = el.getAttribute("rel"),
    	  	  t = el.getAttribute("target"),
    		  l = new String(document.location);
      	  // checking if the href is not the current page or a jump anchor or a javascript function
      	  // checking if the rel or target attribute are defined...
    	  if ((h && ((h.indexOf('#') === 0) || (h.indexOf('javascript:') === 0) || ((h.indexOf('#') > 0) && (l.indexOf(h) === 0)))) ||
    	      (r == 'external') || (r == 'internal') || (t && t != '') || (h == '')) {
    		  // nothing happen
          } else {
        	  dynamic_navigation (h);
              args[1].decrepitate = true;
              args[1].stop = true;
          }
      }
    };
    // initialization: subscribing the lowlevel behavior
    YAHOO.Bubbling.on('god', dynamicNav);
})();

YAHOO.util.Event.onDOMReady (function(){
    var oMenuBar = new YAHOO.widget.MenuBar('myMenuBar', { autosubmenudisplay: true, hidedelay: 750, lazyload: true });
    oMenuBar.render();
});
</script>

</head>
<body id="tms-body" class="yui-skin-sam">
<div id="doc">

  <div class="footer">
  	<div class="path">
	  <a href="../../../../../../../index.html" target="_top">Bubbling Library</a> &gt; <a href="../../../../../../../eng/examples.html" target="_top">Examples</a>	</div>
  	<p><strong>Simple EXAMPLE of the use of the Bubbling Core Object...</strong></p>
  </div>

    <h1>Dynamic Navigation Theory: Dispatcher + Bubbling Core Object = Dynamic Website</h1>
    <p>See how the YUI MenuBar load the corresponding content in the central area of the page.<br>

    <div id="myMenuBar" class="yuimenubar yuimenubarnav">
      <div class="bd">
    	<ul class="first-of-type">
    	  <li class="yuimenubaritem"><a href="yui-menu708f.html?page=index">Home</a></li>
    	  <li class="yuimenubaritem"><a href="yui-menucdd7.html?page=item1">Menu Item 1</a></li>
    	  <li class="yuimenubaritem"><a href="yui-menua519.html?page=item2">Menu Item 2</a></li>
    	  <li class="yuimenubaritem"><a href="yui-menu5d72.html?page=item3">Menu Item 3</a></li>
    	  <li class="yuimenubaritem"><a href="#">More Pages</a>
            <div class="yuimenu">
        		<div class="bd">
        			<ul>
        			  <li class="yuimenuitem"><a href="yui-menu2800.html?page=item4">Menu Item 4</a></li>
        			  <li class="yuimenuitem"><a href="yui-menufc2f.php?page=item5">Menu Item 5</a></li>
        			  <li class="yuimenuitem"><a href="yui-menu3cd6.html?page=item6">Menu Item 6</a></li>
        			</ul>
        		</div>
        	</div>
          </li>
    	  <li class="yuimenubaritem"><a href="#">External Pages</a>
            <div class="yuimenu">
        		<div class="bd">
        			<ul>
        			  <li class="yuimenuitem"><a href="../../../../../../../eng/api/docs/plugins/dispatcher.html" target="_self">Dispatcher</a></li>
        			  <li class="yuimenuitem"><a href="../../../../../../../eng/api/docs/plugins/selectorhtml.html" target="_self">Selector</a></li>
        			  <li class="yuimenuitem"><a href="../../../../../../../eng/api/docs/plugins/tooltips.html" target="_self">Tooltips</a></li>
        			  <li class="yuimenuitem"><a href="../../../../../../../eng/api/docs/plugins/wizard.html" target="_self">Wizard</a></li>
        			</ul>
        		</div>
        	</div>
          </li>
    	  <li class="yuimenubaritem"><a href="#">More Examples</a>
            <div class="yuimenu">
        		<div class="bd">
        			<ul>
        			  <li class="yuimenuitem"><a href="simple.html" target="_self">Simple Example</a></li>
        			  <li class="yuimenuitem"><a href="advanced.html" target="_self">Advanced Example</a></li>
        			</ul>
        		</div>
        	</div>
          </li>
    	</ul>

      </div>
    </div>

	<div class="content" id="dynamic-area">

		<div class="story">
	<h3>Page #5: Static Content...</h3>
    <p>Nunc quam elit, consectetuer adipiscing elit. Maecenas sit amet metus. Nunc quam elit, posuere nec, auctor in, rhoncus quis, dui. Aliquam erat volutpat. Ut dignissim, massa sit amet dignissim cursus, quam lacus feugiat.Nunc quam elit, consectetuer adipiscing elit. Maecenas sit amet metus. Nunc quam elit, posuere nec, auctor in, rhoncus quis, dui. </p>
    <p>Nunc quam elit, consectetuer adipiscing elit. Maecenas sit amet metus. Nunc quam elit, posuere nec, auctor in, rhoncus quis, dui. Aliquam erat volutpat. Ut dignissim, massa sit amet dignissim cursus, quam lacus feugiat.Nunc quam elit, consectetuer adipiscing elit. Maecenas sit amet metus. Nunc quam elit, posuere nec, auctor in, rhoncus quis, dui. </p>
    <p>Nunc quam elit, consectetuer adipiscing elit. Maecenas sit amet metus. Nunc quam elit, posuere nec, auctor in, rhoncus quis, dui. Aliquam erat volutpat. Ut dignissim, massa sit amet dignissim cursus, quam lacus feugiat.Nunc quam elit, consectetuer adipiscing elit. Maecenas sit amet metus. Nunc quam elit, posuere nec, auctor in, rhoncus quis, dui. </p>
</div>
	</div>

    <div class="footer">
  	  Footer here...
    </div>

</div>
</body>

<!-- Mirrored from www.bubbling-library.com/themes/bubbling/jscripts/yui-cms/examples/dispatcher/framework/yui-menu.php?page=item5 by HTTrack Website Copier/3.x [XR&CO'2010], Wed, 04 Apr 2012 15:59:22 GMT -->
</html>
