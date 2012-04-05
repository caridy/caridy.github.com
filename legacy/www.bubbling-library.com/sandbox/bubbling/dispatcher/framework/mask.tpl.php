<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
<title>Dispatcher Example - Advanced EXAMPLE of the use of the Loading Mask Widget</title>
<meta name='author' content='Caridy Patino (caridy at gmail.com)' />
<!-- Reset and Fonts -->
<link rel="stylesheet" type="text/css" href="../../assets/example.css">
<!-- Javascript Framework -->
<script type="text/javascript" src="http://yui.yahooapis.com/2.7.0/build/utilities/utilities.js"></script>
<script type="text/javascript" src="http://js.bubbling-library.com/2.1/build/bubbling/bubbling.js"></script>
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
	padding: 0;
	margin: 1% 0;
	border: 1px solid;
	background-color: #cccccc;
}
	.menu h3 {
		margin: 0;
	}
.content {
	float: right;
	width: 75%;
	border: 1px solid;
	margin: 1% 0;
	padding: 1%;
}

#yui-cms-loading {
    background:#FFFFFF;
	color: #333333;
    display: none;
}
    #yui-cms-loading #yui-cms-float {
        text-align: center;
        font-size: 80%;
        background-image: url(../../images/loading.gif);
        background-repeat:no-repeat;
        background-position: top;
        padding-top: 20px;
    }

</style>
</head>
<body id="tms-body" class="yui-skin-sam">
<div id="yui-cms-loading">
    <div id="yui-cms-float">
        Loading, please wait...
    </div>
</div>
<script type="text/javascript" src="http://js.bubbling-library.com/2.1/build/loading/loading.js"></script>
<script type="text/javascript" src="http://js.bubbling-library.com/2.1/build/dispatcher/dispatcher.js"></script>
<script type="text/javascript">
(function() {
	// configuring the loading mask
	YAHOO.widget.Loading.config({
		effect: true,  // animated mask
		opacity: 0.9   // transparent mask
	});
    // using the dispatcher to load the dynamic content (including the corresponding actions to show/hide the loading mask)
    function dynamic_navigation ( url ) {
    	YAHOO.plugin.Dispatcher.fetch ( 'dynamic-area', url + '&tpl=ajax', {
		  onStart: function () {
		    YAHOO.widget.Loading.show();
		  },
		  onLoad: function () {
		    YAHOO.widget.Loading.hide();
		  }
		});
    };
    // initialization: subscribing the lowlevel behavior
    YAHOO.Bubbling.on('god', function (layer, args) {
	  // this method will be executed every time you click on the page...
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
    });
})();
</script>
<div id="doc">

  <div class="footer">
    <div class="path"> <a href="http://www.bubbling-library.com/" target="_top">Bubbling Library</a> &gt; <a href="http://www.bubbling-library.com/eng/examples" target="_top">Examples</a> </div>
    <p><strong>Advanced EXAMPLE of the use of the Loading Mask Widget...</strong></p>
  </div>

    <h1> Loading Mask + Dispatcher + Bubbling Core Object = Dynamic Website</h1>
  <p>Every time you click on a dynamic link, the  <a href="http://bubbling-library.com/eng/api/docs/widgets/loading-mask" target="_top">LOADING MASK</a> will block user actions during the loading process using a fade in/out animation.</p>
<div class="menu">
		<h3>Main Menu</h3>
		<ul>
			<li><a href="advanced.php?page=index">Home</a></li>
			<li><a href="advanced.php?page=xhtml.with.datatable">Datatable</a></li>
			<li><a href="advanced.php?page=xhtml.with.autonomous.tabview">Tabview</a></li>
			<li><a href="advanced.php?page=simple">Simple Text</a></li>
			<li><a href="advanced.php" target="_self">Example without mask</a> (external) </li>
			<li><a href="../../loading/index.html" target="_self">Other examples</a> (external) </li>
		</ul>
	</div>

	<div class="content" id="dynamic-area">

		<?php
		    // loading the main content
		    require ( 'advanced/'. $uri.'.php' );
        ?>

	</div>

</div>
</body>
</html>
