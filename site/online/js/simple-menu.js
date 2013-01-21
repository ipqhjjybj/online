/**
 * The init script for NEU Online's homepage.
 *
 * @licese GPL
 * @author http://plux.is-programmer.com
 *
 */

(function() {
    if (window.SimpleMenu) return;

    function addClass(elem, cls) {
        if (elem.classList) {
            elem.classList.add(cls);
        } else {
            elem.className += ' ' + cls;
        }
    }

    function removeClass(elem, cls) {
        if (elem.classList) {
            elem.classList.remove(cls);
        } else {
            var s = elem.className.split(/\s+/);
            for(var i=0; i<s.length; i++) {
                if (s[i] == cls) delete s[i];
            }
            elem.className = s.join(' ');
        }
    }

    function containClass(elem, cls) {
        if (elem.classList) {
            return elem.classList.contains(cls);
        } else {
            var s = elem.className.split(/\s+/);
            for (var i=0; i<s.length; i++) {
                if (s[i] == cls) {
                    return true;
                }
            }
            return false;
        }
    }

    var doc = document;
    var menuClass = function (btn, box) {
        addClass(box, 'fixed-menu');
        box.style.display = "none";

        var toggle = function () {
            if (containClass(btn, 'active')) {
                removeClass(btn, 'active');
            } else {
                addClass(btn, 'active');
            }
            if (containClass(box, 'active')) {
                removeClass(box, 'active');
                box.style.display = "none";
            } else {
                addClass(box, 'active');
                box.style.display = "block";
            }
        }
        var show = function () {
            if (! containClass(btn, 'active')) {
                addClass(btn, 'active');
            }
            if (! containClass(box, 'active')) {
                addClass(box, 'active');
                box.style.display = "block";
            }
        }
        var hide = function () {
            if (containClass(btn, 'active')) {
                removeClass(btn, 'active');
            }
            if (containClass(box, 'active')) {
                removeClass(box, 'active');
                box.style.display = "none";
            }
        }

        btn.addEventListener('click', function() {
            toggle();
        }, false);

        doc.body.addEventListener('click', function(event) {
            if (event.target != box && event.target != btn 
                && event.tagName != 'a') {
                hide();
            }
        }, false);

        return { 'show': show, 'hide': hide, 'toggle': toggle };
    };
    
    window.SimpleMenu = menuClass;
})();
