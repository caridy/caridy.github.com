<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
<title>Wizard and Tabview: Multi Step in PHP</title>
<meta name='author' content='Caridy Patino (caridy at gmail.com)' />
<!-- Reset and Fonts -->
<link rel="stylesheet" type="text/css" href="../../assets/example.css">
<link rel="stylesheet" type="text/css" href='http://yui.yahooapis.com/2.7.0/build/assets/skins/sam/skin.css'/>
<script type="text/javascript" src="http://yui.yahooapis.com/2.7.0/build/utilities/utilities.js"></script>
<script type="text/javascript" src="http://yui.yahooapis.com/2.7.0/build/json/json.js"></script>

<!-- Non-required YUI packages -->
<script type="text/javascript" src="http://yui.yahooapis.com/2.7.0/build/button/button.js"></script>
<script type="text/javascript" src="http://yui.yahooapis.com/2.7.0/build/tabview/tabview.js"></script>

<script type="text/javascript" src='http://js.bubbling-library.com/2.1/build/bubbling/bubbling.js'></script>
<script type="text/javascript" src='http://js.bubbling-library.com/2.1/build/dispatcher/dispatcher.js'></script>
<script type="text/javascript" src='http://js.bubbling-library.com/2.1/build/wizard/wizard.js'></script>
<script type="text/javascript">
(function() {
	// adoption the area using the wizard manager
	YAHOO.util.Event.onDOMReady (function() {
		
		var tabView = new YAHOO.widget.TabView('demo');
        
		// first tab adoption plan
		YAHOO.plugin.WizardManager.adopt(tabView.get('tabs')[0].get('contentEl'), {
        	uri: 'index.php',
			dynamic: true,
			onFinish: function (values) {
				alert ('The wizard 1 has end correctly...');
			},
			dataMask: {
			   'param1':'value1'
			} // for AJAX request POST or GET, a new parameter will be included. Use it to identify the request type on the server (submit thru YUI connection maganer or simple browser navigation)
        });

		// second tab delegation plan
        YAHOO.plugin.WizardManager.delegate(new YAHOO.widget.Tab({
            label: 'Second Tab from Javascript',
            content: '<p>Loading... please wait.</p>',
            dataSrc: 'index.php', // the initial state here
            cacheData: true
		}), tabView, {
	    	dynamic: true,
			onFinish: function (values) {
				alert ('The wizard 2 has end correctly...');
			},
			dataMask: {
			   'param1':'value2'
			} // for AJAX request POST or GET, a new parameter will be included. Use it to identify the request type on the server (submit thru YUI connection maganer or simple browser navigation)
        });
	});
})();
</script>
<!-- Non-required Bubbling Packages -->
<script type="text/javascript" src='http://js.bubbling-library.com/2.1/build/behaviors/calendar.js'></script>
<script type="text/javascript" src='http://js.bubbling-library.com/2.1/build/behaviors/autocomplete.js'></script>
</head>
<body id="cms-body" class="yui-skin-sam">
<div id="yui-cms-loading">
    <div id="yui-cms-float">
        Loading, please wait...
    </div>
</div>
<div id="doc">

    <div class="path"> <a href="http://www.bubbling-library.com/" target="_top">Bubbling Library</a> &gt; <a href="http://www.bubbling-library.com/eng/examples" target="_top">Examples</a> </div>

    <h1>Wizard and Tabview: Multi Step in PHP</h1>

	<div class="content" id="dynamic-area">

		<div id="demo" class="yui-navset">
		    <ul class="yui-nav">
		        <li class="selected"><a href="#tab1"><em>First Tab from markup</em></a></li>
		    </ul>            
		    <div class="yui-content">
		        <div>
		        <?php
				    // loading the main content
				    require ( 'steps/'. $uri.'.php' );
		        ?>
				</div>
		    </div>
		</div>

	</div>

</div>
</body>
</html>