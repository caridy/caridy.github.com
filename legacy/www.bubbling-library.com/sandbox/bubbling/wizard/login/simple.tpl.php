<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
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
<script type="text/javascript" src="../http://js.bubbling-library.com/2.0/build/bubbling/bubbling.js"></script>
<script type="text/javascript" src="../http://js.bubbling-library.com/2.0/build/dispatcher/dispatcher.js"></script>
<script type="text/javascript" src="../http://js.bubbling-library.com/2.0/build/wizard/wizard.js"></script>
<script type="text/javascript">
(function() {
    YAHOO.example.init = function( ){
        YAHOO.plugin.WizardManager.adopt( 'myprofilearea', {
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
	  <a href="http://www.bubbling-library.com/" target="_top">Bubbling Library</a> &gt; <a href="http://www.bubbling-library.com/eng/examples" target="_top">Examples</a>
	</div>

  <h1>Wizard Example - Management your forms (YAHOO.plugin.WizardManager)</h1>

  <h2>Wizard plugin for a login form:</h2>

  <div class="boxing" id="myprofilearea">
    <?php
	    // loading the main content
	    require ( 'simple/'. $uri.'.php' );
    ?>
  </div>

  <p>In this example you will see how the wizard can adopt (YAHOO.plugin.WizardManager.adopt) an area (DIV), and how it will manage the submition events in this area thru the YUI connection manager (using the Dispatcher plugin which is required).</p>
  <p>The Wizard uses an <a href="http://www.wait-till-i.com/index.php?p=86" title="Unobtrusive JavaScript" target="_blank">Unobtrusive JavaScript</a> mechanism:</p>
  <ul>
    <li>  1. If the browser do not support javascript, the form will work applying a normal submition process.</li>
    <li>2. If javascript is available, the wizard will submitting the form thru the YUI connection manager, including an indentification parameter (in this case tpl=ajax), and you will use this parameter in the server to determine the response type (the full page or a html chunk).</li>
  </ul>
  <h4>Special Note</h4>
  <p>In this example, you can test the login form with <span style="color: red;">username=admin</span> and <span style="color: red;">password=123</span></p>
  <h4>Jasascript Source Code</h4>
  <pre>YAHOO.plugin.WizardManager.adopt( 'myprofilearea', {<br>	morePostData: {'tpl':'ajax'} // for AJAX submit, a new parameter will be included. Use it to identify the request type on the server (submit thru YUI connection maganer or simple browser navigation)<br>});  </pre>
  
<!-- THE EXAMPLE's CODE END HERE, FROM NOW ON IS JUST THE DOCUMENTATION //-->
  
</div>
</body>
</html>