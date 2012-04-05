<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>

<!-- Mirrored from www.bubbling-library.com/themes/bubbling/jscripts/yui-cms/examples/dispatcher/framework/simple.php?page=index by HTTrack Website Copier/3.x [XR&CO'2010], Wed, 04 Apr 2012 15:59:20 GMT -->
<head>
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
<title>Dispatcher Example - Dynamically Loading Content</title>
<meta name='author' content='Caridy Patino (caridy at gmail.com)' />
<link rel="stylesheet" type="text/css" href="../../assets/example.css">
<!-- Javascript Framework -->
<script type="text/javascript" src="http://yui.yahooapis.com/2.7.0/build/utilities/utilities.js"></script>
<script type="text/javascript" src="../../../../../../../../js.bubbling-library.com/2.1/build/bubbling/bubbling.js"></script>
<script type="text/javascript" src="../../../../../../../../js.bubbling-library.com/2.1/build/dispatcher/dispatcher.js"></script>
<style type="text/css">
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
.menu {
	float: left;
	clear: both;
	width: 20%;
	padding: 1%;
	margin: 1% 0;
	border: 1px solid;
	background-color: #cccccc;
}
.content {
	float: right;
	width: 75%;
	border: 1px solid;
	margin: 1% 0;
	padding: 1%;
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
</script>

</head>
<body id="tms-body">
<div id="doc">

  <div class="footer">
  	<div class="path">
	  <a href="../../../../../../../index.html" target="_top">Bubbling Library</a> &gt; <a href="../../../../../../../eng/examples.html" target="_top">Examples</a>	</div>
  	<p><strong>Simple EXAMPLE of the use of the Bubbling Core Object...</strong></p>
  </div>

    <h1>Dynamic Navigation Theory: Dispatcher + Bubbling Core Object = Dynamic Website</h1>
    <p>See how the left menu load the corresponding content in the central area of the page.<br>
    <span class="red">If you'll like to see an advanced example, and learn how to include external components that will be loaded onDemand in the main area of the page, <a href="advanced.html" target="_self">click here</a>. </span></p>

	<div class="menu">
		<h3>Main Menu</h3>
		<ul>
			<li><a href="simple708f.php?page=index">Home</a></li>
			<li><a href="simplecdd7.html?page=item1">Menu Item 1 </a></li>
			<li><a href="simplea519.html?page=item2">Menu Item 2 </a></li>
			<li><a href="simple5d72.html?page=item3">Menu Item 3 </a></li>
			<li><a href="advanced.html" target="_self">Advanced Example</a> (external) </li>
		</ul>
	</div>

	<div class="content" id="dynamic-area">

		<div class="story">
	<h3>Home Page: Static Content...</h3>
    <p class="red">In all this DEMO, we don't use event listeners for the links. The event are drive in using the bubbling technique to the corresponding layer.</p>
    <p class="red"><a href="simple3cd6.html?page=item6">Click here to see the page Item #6</a></p>
    <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Maecenas sit amet metus. Nunc quam elit, posuere nec, auctor in, rhoncus quis, dui. Aliquam erat volutpat. Ut dignissim, massa sit amet dignissim cursus, quam lacus feugiat.Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Maecenas sit amet metus. Nunc quam elit, posuere nec, auctor in, rhoncus quis, dui. </p>
    <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Maecenas sit amet metus. Nunc quam elit, posuere nec, auctor in, rhoncus quis, dui. Aliquam erat volutpat. Ut dignissim, massa sit amet dignissim cursus, quam lacus feugiat.Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Maecenas sit amet metus. Nunc quam elit, posuere nec, auctor in, rhoncus quis, dui. </p>
    <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Maecenas sit amet metus. Nunc quam elit, posuere nec, auctor in, rhoncus quis, dui. Aliquam erat volutpat. Ut dignissim, massa sit amet dignissim cursus, quam lacus feugiat.Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Maecenas sit amet metus. Nunc quam elit, posuere nec, auctor in, rhoncus quis, dui. </p>
</div>
	</div>

  <div class="footer">
  	Footer here...
  <a href="simple2800.html?page=item4">Menu Item 4 </a> | <a href="simplefc2f.html?page=item5">Menu Item 5 </a> | <a href="simple3cd6.html?page=item6">Menu Item 6 </a></div>

</div>
</body>

<!-- Mirrored from www.bubbling-library.com/themes/bubbling/jscripts/yui-cms/examples/dispatcher/framework/simple.php?page=index by HTTrack Website Copier/3.x [XR&CO'2010], Wed, 04 Apr 2012 15:59:20 GMT -->
</html>
