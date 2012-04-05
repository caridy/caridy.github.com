<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
<title>Wizard: Multi Step in PHP</title>
<meta name='author' content='Caridy Patino (caridy at gmail.com)' />
<!-- Reset and Fonts -->
<link rel="stylesheet" type="text/css" href="../../assets/example.css">
<link rel="stylesheet" type="text/css" href='http://yui.yahooapis.com/2.7.0/build/assets/skins/sam/skin.css'/>
<style>
#dynamic-area {
	width: 500px;
}
#yui-cms-loading {
    background:#ccc;
    color: #333;
    display: none;
}
    #yui-cms-loading #yui-cms-float {
        text-align: center;
        font-size: 80%;
        background-image: url(../../images/loading.gif);
        background-repeat:no-repeat;
        background-position: top;
        padding-top: 25px;
    }
.yui-cms-autocomplete {
    width:13em; /* set width of widget here*/
    height:2em; /* define height for container to appear inline */
}
    .yui-cms-autocomplete ul,
    .yui-cms-autocomplete li {
        list-style-type: none;
        text-align: left;
    }
    .yui-cms-autocomplete .yui-cms-container {
        position: absolute;
        width:13em; /* set width of widget here*/
        height:12em; /* define height for container to appear inline */
    }
    .yui-cms-autocomplete input {
        _position:absolute; /* abs pos needed for ie quirks */
    }
        .yui-cms-autocomplete .yui-ac-content {
            max-height:11em;overflow:auto;overflow-x:hidden; /* scrolling */
            _height:11em; /* ie6 */
            z-index:9000; /* z-index needed on top instance for ie & sf absolute inside relative issue */
        }
</style>
<script type="text/javascript" src="http://yui.yahooapis.com/2.7.0/build/utilities/utilities.js"></script>
<script type="text/javascript" src="http://yui.yahooapis.com/2.7.0/build/json/json.js"></script>

<!-- Non-required YUI packages -->
<script type="text/javascript" src="http://yui.yahooapis.com/2.7.0/build/button/button.js"></script>
<script type="text/javascript" src="http://yui.yahooapis.com/2.7.0/build/container/container.js"></script>
<script type="text/javascript" src="http://yui.yahooapis.com/2.7.0/build/calendar/calendar.js"></script>
<script type="text/javascript" src="http://yui.yahooapis.com/2.7.0/build/datasource/datasource.js"></script>
<script type="text/javascript" src="http://yui.yahooapis.com/2.7.0/build/autocomplete/autocomplete.js"></script>

<script type="text/javascript" src='http://js.bubbling-library.com/2.1/build/bubbling/bubbling.js'></script>
<script type="text/javascript" src='http://js.bubbling-library.com/2.1/build/loading/loading.js'></script>
<script type="text/javascript" src='http://js.bubbling-library.com/2.1/build/dispatcher/dispatcher.js'></script>
<script type="text/javascript" src='http://js.bubbling-library.com/2.1/build/wizard/wizard.js'></script>
<script type="text/javascript">
(function() {
	// configuring the loading mask
	YAHOO.widget.Loading.config({
	});
	// adoption the area using the wizard manager
	YAHOO.util.Event.onDOMReady (function(){
	    YAHOO.plugin.WizardManager.adopt( 'dynamic-area', {
        	dynamic: true,
			onFinish: function (values) {
				alert ('The wizard has end correctly...');
			},
			dataMask: {
			   'param1':'value1'
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

    <h1>Wizard: Multi Step in PHP</h1>

	<div class="content" id="dynamic-area">

		<?php
		    // loading the main content
		    require ( 'steps/'. $uri.'.php' );
        ?>

	</div>

</div>
</body>
</html>