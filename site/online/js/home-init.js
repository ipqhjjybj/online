// @dependency impress.js
// @dependency simple-menu.js 

/**
 * The init script for NEU Online's homepage.
 *
 * @author http://plux.is-programmer.com
 *
 */

var imp = impress();
imp.init();

(function(imp) {
    var doc = document;

    var rmenu = new SimpleMenu(
     doc.querySelector('#menu-btn'), 
     doc.querySelector('#menu-btn ~ .box'));

    doc.querySelector('.related')
        .addEventListener('click', function(event) {
        rmenu.toggle();
        event.preventDefault();
        event.stopImmediatePropagation();
     }, false);

    if (! imp) return;
    var navTools = doc.createElement('div');
    with(navTools) {
    className = 'actionbar';

    var leftBtn = doc.createElement('a');
    leftBtn.onclick = function () {
        imp.prev();
        return false;
    };
    leftBtn.appendChild(doc.createTextNode('<'));
    appendChild(leftBtn);

    var homeBtn = doc.createElement('a');
    homeBtn.href = '#home';
    homeBtn.appendChild(doc.createTextNode('We are NEU Online.'));
    appendChild(homeBtn);

    var rightBtn = doc.createElement('a');
    rightBtn.onclick = function() {
        imp.next()
        return false;
    };
    rightBtn.appendChild(doc.createTextNode('>'));
    appendChild(rightBtn);
    }
    doc.body.appendChild(navTools);

})(imp);
