<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>

<!-- Mirrored from www.bubbling-library.com/sandbox/bubbling/wizard/login/dynamic.php by HTTrack Website Copier/3.x [XR&CO'2010], Wed, 04 Apr 2012 15:59:37 GMT -->
<head>
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
<title>Bubbling Library (YUI Extension) - Wizard Example - Management your forms (YAHOO-CMS: YAHOO.plugin.WizardManager)</title>
<meta name='author' content='Caridy Patino (caridy at gmail.com)' />
<link rel="stylesheet" type="text/css" href="../../assets/example.css">
<!-- YUI Basement Style -->
<link rel="stylesheet" type="text/css" href="http://yui.yahooapis.com/2.6.0/build/button/assets/skins/sam/button.css">
<link rel="stylesheet" type="text/css" href="http://yui.yahooapis.com/2.6.0/build/container/assets/skins/sam/container.css">
<!-- YUI Library -->
<script type="text/javascript" src="http://yui.yahooapis.com/2.6.0/build/utilities/utilities.js"></script>
<script type="text/javascript" src='http://yui.yahooapis.com/2.6.0/build/json/json-min.js'></script>
<script type="text/javascript" src="http://yui.yahooapis.com/2.6.0/build/button/button-min.js"></script>
<script type="text/javascript" src="http://yui.yahooapis.com/2.6.0/build/container/container-min.js"></script>
<!-- YUI-CMS Extension: Bubbling Library -->
<script type="text/javascript" src="../../../../../js.bubbling-library.com/2.0/build/bubbling/bubbling.js"></script>
<script type="text/javascript" src="../../../../../js.bubbling-library.com/2.0/build/dispatcher/dispatcher.js"></script>
<script type="text/javascript" src="../../../../../js.bubbling-library.com/2.0/build/wizard/wizard.js"></script>
<script type="text/javascript">
(function() {
    YAHOO.example.init = function( ){
	    // loading the form dynamically...
        YAHOO.plugin.WizardManager.add( 'myprofilearea', {
		    uri: 'simple/index.php',
        	dataMask: {
			   'tpl':'ajax'
			} // for AJAX request POST or GET, a new parameter will be included. Use it to identify the request type on the server (submit thru YUI connection maganer or simple browser navigation)
        });
    };
    YAHOO.util.Event.onDOMReady(YAHOO.example.init);
}());
</script>
<style type="text/css">
.boxing {
	float: right;
	width: 250px;
	border: 1px solid;
	margin: 0;
	padding: 5px;
	overflow: auto;
}
</style>
</head>
<body class="yui-skin-sam">
<div id="doc">

	<div class="path">
	  <a href="../../../../index.html" target="_top">Bubbling Library</a> &gt; <a href="../../../../eng/examples.html" target="_top">Examples</a>
	</div>

  <h1>Wizard Example - Management your forms (YAHOO.plugin.WizardManager)</h1>

  <h2>Wizard plugin for a login form:</h2>

  <div class="boxing" id="myprofilearea">
    Loading...
  </div>

  <p>In this example you will see how the wizard can add (YAHOO.plugin.WizardManager.add) content to a certain area (DIV), and how it will manage the submition events in this area thru the YUI connection manager (using the Dispatcher plugin which is required).</p>
  <h4>Special Note</h4>
  <p>In this example, you can test the login form with <span style="color: red;">username=admin</span> and <span style="color: red;">password=123</span></p>
  
<!-- THE EXAMPLE's CODE END HERE, FROM NOW ON IS JUST THE DOCUMENTATION //-->
</div>
</body>

<!-- Mirrored from www.bubbling-library.com/sandbox/bubbling/wizard/login/dynamic.php by HTTrack Website Copier/3.x [XR&CO'2010], Wed, 04 Apr 2012 15:59:38 GMT -->
</html>