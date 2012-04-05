<link rel="stylesheet" type="text/css" href="http://yui.yahooapis.com/2.7.0/build/tabview/assets/skins/sam/tabview.css">
<script type="text/javascript" src="http://yui.yahooapis.com/2.7.0/build/tabview/tabview-min.js"></script>
<div id="dynamic-tab-autonomous">
	<h3>INDEX: Dynamic content with an tabview control within...</h3>
	<p>
  	  <strong>Facts:</strong><br />
		- This content have autonomy (the script inside the content prepare the tabview control).<br />
		- The dispatcher execute the script block (initialization:YAHOO.example.childTabview).<br />
		- The tabview skin (css) is injected by the dispatcher.<br />
	</p>

    <div id="autonomouschildtabview" class="yui-navset">
        <ul class="yui-nav">
            <li class="selected"><a href="#tab4"><em>tab4</em></a></li>
            <li><a href="#tab5"><em>tab5</em></a></li>
            <li><a href="#tab6"><em>tab6</em></a></li>
        </ul>
        <div class="yui-content">

            <div id="tab4">
                <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat.</p>
            </div>
            <div id="tab5">
                <ul>
                    <li><a href="#">Lorem ipsum dolor sit amet.</a></li>
                    <li><a href="#">Lorem ipsum dolor sit amet.</a></li>

                    <li><a href="#">Lorem ipsum dolor sit amet.</a></li>
                    <li><a href="#">Lorem ipsum dolor sit amet.</a></li>
                </ul>
            </div>
            <div id="tab6">
                <form action="#">
                    <fieldset>
                        <legend>Lorem Ipsum</legend>

                        <label for="foo"> <input id="foo" name="foo"></label>
                        <input type="submit" value="submit">
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

YAHOO.example.childTabview = function() {
  var myTabs = new YAHOO.widget.TabView('autonomouschildtabview');
}();

</script>