(function e(t,n,r){function s(o,u){if(!n[o]){if(!t[o]){var a=typeof require=="function"&&require;if(!u&&a)return a(o,!0);if(i)return i(o,!0);var f=new Error("Cannot find module '"+o+"'");throw f.code="MODULE_NOT_FOUND",f}var l=n[o]={exports:{}};t[o][0].call(l.exports,function(e){var n=t[o][1][e];return s(n?n:e)},l,l.exports,e,t,n,r)}return n[o].exports}var i=typeof require=="function"&&require;for(var o=0;o<r.length;o++)s(r[o]);return s})({1:[function(require,module,exports){
(function(){
    'use strict';

    function firstElementChild(parentNode, index, children) {
        children = children || parentNode.childNodes;
        index = index || 0;

        if (children[index].nodeName === '#text') {
            return firstElementChild(parentNode, index + 1, children);
        }

        return children[index];
    }

    function hasClass(node, className) {
        className = ' ' + className + ' ';

        return (' ' + node.className + ' ')
                                .replace(/[\n\t]/g, ' ')
                                .indexOf(className) > -1;

    }

    function closestAncestorWithClass(el, className) {
        if (hasClass(el, className)) {
            return el;
        }

        if (el.nodeName === 'BODY') {
            return null;
        }

        return closestAncestorWithClass(el.parentNode, className);
    }

    function nextSiblingOfType(el, nodeName) {
        if (el.nextSibling === null) {
            return null;
        }

        if (el.nextSibling.nodeName === nodeName) {
            return el.nextSibling;
        }

        return nextSiblingOfType(el.nextSibling, nodeName);
    }

    function previousSiblingOfType(el, nodeName) {
        if (el.previousSibling === null) {
            return null;
        }

        if (el.previousSibling.nodeName === nodeName) {
            return el.previousSibling;
        }

        return previousSiblingOfType(el.previousSibling, nodeName);
    }


    function parentAnchor(el) {
        if (el.nodeName === 'A') {
            return el;
        }

        if (el.nodeName === 'BODY') {
            return false;
        }

        return parentAnchor(el.parentNode);
    }

    module.exports = {
        parentAnchor: parentAnchor,
        closestAncestorWithClass: closestAncestorWithClass,
        firstElementChild: firstElementChild,
        nextSiblingOfType: nextSiblingOfType,
        previousSiblingOfType: previousSiblingOfType
    };

}());

},{}],2:[function(require,module,exports){
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

},{"./utils/dom-traversal.js":1}],3:[function(require,module,exports){
(function() {
    'use strict';

    var dom = require('./utils/dom-traversal.js');

    var FloatingImage;

    FloatingImage = function(el) {
        this.el = el;
        this.el.setAttribute('aria-hidden', false);
    };

    FloatingImage.prototype.bind = function() {
        this.el.addEventListener('click', this.onImageClick.bind(this));
    };

    FloatingImage.prototype.onImageClick = function() {
        this.el.setAttribute('aria-hidden', true);
    };


    module.exports = FloatingImage;

}());

},{"./utils/dom-traversal.js":1}],4:[function(require,module,exports){
(function() {
    'use strict';

    var Accordion = require('./vac-accordion.js'),
        FloatingImage = require('./vac-floating-image.js');

    var App;

    App = {
        init: function() {
            this.initNodeList(document.querySelectorAll('.accordion'),
                              Accordion);

            this.initNodeList(document.querySelectorAll('.floating-image'),
                              FloatingImage);
        },

        initNodeList: function(nodeList, Component) {
            var i, len, component;

            for (i = 0, len = nodeList.length; i < len; i += 1) {
                component = new Component(nodeList[i]);
                component.bind();
            }
        }

    };

    App.init();
}());

},{"./vac-accordion.js":2,"./vac-floating-image.js":3}]},{},[4]);
