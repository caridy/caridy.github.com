<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
<title>Dispatcher Example - Dynamically Loading Content</title>
<meta name='author' content='Caridy Patino (caridy at gmail.com)' />
<link rel="stylesheet" type="text/css" href="../../assets/example.css">
<!-- Javascript Framework -->
<script type="text/javascript" src="http://yui.yahooapis.com/2.7.0/build/utilities/utilities.js"></script>
<script type="text/javascript" src="http://js.bubbling-library.com/2.1/build/bubbling/bubbling.js"></script>
<script type="text/javascript" src="http://js.bubbling-library.com/2.1/build/dispatcher/dispatcher.js"></script>
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
<body id="tms-body" class="yui-skin-sam">
<div id="doc">

  <div class="footer">
    <div class="path"> <a href="http://www.bubbling-library.com/" target="_top">Bubbling Library</a> &gt; <a href="http://www.bubbling-library.com/eng/examples" target="_top">Examples</a> </div>
    <p><strong>Advanced EXAMPLE of the use of the Bubbling Core Object...</strong></p>
  </div>

    <h1>Dynamic Navigation Theory: Dispatcher + Bubbling Core Object = Dynamic Website</h1>
    <p>See how the left menu load the corresponding content in the central area of the page.<br>
    <span class="red">In this example the main area of the page also include external components that will be loaded onDemand (ex. <a href="advanced.php?page=xhtml.with.datatable">Datatable</a> and <a href="advanced.php?page=xhtml.with.autonomous.tabview">Tabview</a>).  </span></p>
    <div class="menu">
		<h3>Main Menu</h3>
		<ul>
			<li><a href="advanced.php?page=index">Home</a></li>
			<li><a href="advanced.php?page=xhtml.with.datatable">Datatable</a></li>
			<li><a href="advanced.php?page=xhtml.with.autonomous.tabview">Tabview</a></li>
			<li><a href="advanced.php?page=simple">Simple Text</a></li>
			<li><a href="simple.php" target="_self">Simple Example</a> (external) </li>
		</ul>
	</div>

	<div class="content" id="dynamic-area">

		<?php
		    // loading the main content
		    require ( 'advanced/'. $uri.'.php' );
        ?>

	</div>

  <div class="footer">
  Footer here... <a href="http://www.bubbling-library.com/" target="_blank">Bubbling Library</a> | <a href="http://developer.yahoo.com/yui/" target="_blank">YUI Library</a> | <a href="http://www.yahoo.com/" target="_blank">Yahoo Home Page</a>  </div>

</div>
</body>
</html>
