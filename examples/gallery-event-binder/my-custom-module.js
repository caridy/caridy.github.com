YUI.add('my-custom-module', function (Y) {
	
	Y.one('#output').append('<li>[my-cutom-module] was loaded and it is ready to be initialized</li>');
	
	Y.on('click', function(e) {
		
		Y.one('#output').append('<li>Listener for [#democlick a] on click executed.');
		e.halt();
		
	}, '#democlick a')
	
	Y.delegate('click', function(e) {
		
		Y.one('#output').append('<li>Listener for [#demodelegate a] using delegate executed.');
		e.halt();
		
	}, '#demodelegate', 'a')
	
}, '@VERSION@' ,{requires:['event']});