YUI.add('my-custom-module', function (Y) {
	
	Y.one('#output').append('<li>[my-custom-module] was loaded and initialized</li>');
	
	Y.on('click', function(e) {
		
		Y.one('#output').append('<li>[#democlick a] click executed.');
		e.halt();
		
	}, '#democlick a')
	
	Y.delegate('click', function(e) {
		
		Y.one('#output').append('<li>[#demodelegate a] delegate executed.');
		e.halt();
		
	}, '#demodelegate', 'a')
	
}, '@VERSION@' ,{requires:['event']});