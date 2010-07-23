/* YUI Node ID Controller by Caridy */
YUI().use('node', function(Y) {

  if (!window.__YUI_NODE_ID_CONTROLLER__ && 
      confirm('Do you want to remove all YUI Generated IDs?')) {

    window.__YUI_NODE_ID_CONTROLLER__ = [];
    Y.all('div[id]').each(function(n) {
	  if (n.get('id') == n._yuid) {
		console.log ('removing: ', n._node, n._yuid);
		n._node.id = '';
		window.__YUI_NODE_ID_CONTROLLER__.push(n);
      }
    });

  } else if (confirm('Do you want to restore all YUI Generated IDs?')) {

    Y.each(window.__YUI_NODE_ID_CONTROLLER__, function(n) {
		console.log ('restoring: ', n._node, n._yuid);
		n._node.id = n._yuid;
    });
    window.__YUI_NODE_ID_CONTROLLER__ = null;

  }

});