(function() {
    'use strict';

    var dom = require('./utils/dom-traversal.js');

    var Accordion;

    Accordion = function(el) {
        this.el = el;
        this.children = el.querySelectorAll('.accordion-item');
    };

    Accordion.prototype.bind = function() {
        this.el.addEventListener('click',
                                 this.onAccordionTitleClick.bind(this));
    };

    Accordion.prototype.onAccordionTitleClick = function(e) {
        var target, parent;

        target = e.target;

        if (this.isAccordionTitle(target) === false) {
            return;
        }

        parent = dom.closestAncestorWithClass(target, 'accordion-item');

        if (parent === null) {
            return;
        }

        this.toggle(parent);
    };

    Accordion.prototype.isAccordionTitle = function(node) {
        return node.nodeName === 'H3';
    };

    Accordion.prototype.toggle = function(node) {
        var current;

        current = node.getAttribute('aria-expanded');

        if (current === 'false') {
            node.setAttribute('aria-expanded', true);
            return;
        }

        node.setAttribute('aria-expanded', false);
    };

    module.exports = Accordion;

}());
