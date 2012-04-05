<div id="dynamic-tab-with-script">
	<h3>INDEX: Dynamic Content with one script tab inside</h3>
	<p>
  	  <strong>Facts:</strong><br />
		- The script tags inside the content will be executed every time.<br />
		- The dynamic links are created on the fly.<br />
	</p>

	<a title="This is the static link number 1" href="http://www.bubbling-library.com/"  target="_top" id="link1">1.  Static link</a><br>
	<br>
	<a title="This is the static link number 2" href="http://www.bubbling-library.com/"  target="_top" id="link2">2.  Static link</a><br>
	<br>
	<a title="This is the static link number 3" href="http://www.bubbling-library.com/"  target="_top" id="link3">3.  Static link</a><br>
	<br>
	<a title="This is the static link number 4" href="http://www.bubbling-library.com/"  target="_top" id="link4">4.  Static link</a><br>
	<br>
	<a title="This is the static link number 5" href="http://www.bubbling-library.com/"  target="_top" id="link5">5.  Static link</a><br>
	<br>

</div>
<script>

    // Creating dynamic links...
	function createDynamicLinks() {
        var p = YAHOO.util.Dom.get ("dynamic-tab-with-script");
		for (var i=6;i<=10;i++) {
			var a = document.createElement("a");
			a.id = "link" + i;
			a.target = "_top";
			a.href = "http://www.bubbling-library.com/";
			a.title = "This is the dynamic link number " + i;
			a.innerHTML = i + ".  Dynamic link";

			p.appendChild(a);
			p.appendChild(document.createElement("br"));
			p.appendChild(document.createElement("br"));

		}
	}

	createDynamicLinks();

</script>