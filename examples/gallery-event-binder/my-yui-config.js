(YUI_config = YUI_config || {}).eventbinder = {
    // set of options that should be preserved for every event (they are all optional)
    e: {
        ctrlKey: 0,
        altKey: 0,
        shiftKey: 0,
        metaKey: 0,
        keyCode: 0,
        charCode: 0,
        screenX: 0,
        screenY: 0,
        clientX: 0,
        clientY: 0,
        button: 0,
        relatedTarget: 0
    },
    // listener callback function
    fn: function(e) {
        var o = YUI_config.eventbinder,
        classCheck = /yui3-event-binder/,
        i,
        t = (e.target ? e.target: e.srcElement),
        p = {
            target: t,
            type: e.type
        },
        container = t;

        // looking for an element with the class yui3-event-binder
        while (container && !classCheck.test(container.className)) {
            container = container.parentNode;
        }

        if (container) {
            t.className += ' yui3-waiting';

            // backing up the event properties to simulate the event later on
            for (i in (o.e || {})) {
                if (o.e.hasOwnProperty(i)) {
                    p[i] = e[i];
                }
            }
            (o.q = o.q || []).push(p);

            // preventing the default browser action for this event
            if (e.preventDefault) {
                e.preventDefault();
            }
            return (e.returnValue = false);
        }
    },
    add: function(type) {
        var d = document;
        if (d.addEventListener) {
            d.addEventListener(type, this.fn, false);
        }
        else {
            d.attachEvent('on' + type, this.fn);
        }
        return this;
    }
};
// adding events to the monitoring process
YUI_config.eventbinder.add('click');