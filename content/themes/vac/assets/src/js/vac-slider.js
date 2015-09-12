(function() {
    'use strict';

    var dom = require('./utils/dom-traversal.js');

    var Slider;

    Slider = function(el) {
        this.el = el;
        this.children = this.el.querySelectorAll('.slider-item');

        if (this.children.length < 2) {
            return;
        }

        this.index = 1;
        this.current = this.children[0];
        this.hideItems();
        this.show(this.current);
        this.setupCounter();
    };

    Slider.prototype.bind = function() {
        this.el.addEventListener('click', this.advance.bind(this));
    };

    Slider.prototype.setupCounter = function() {
        this.counter = this.counterEl();
        this.el.appendChild(this.counter);
    };

    Slider.prototype.updateCounter = function() {
        this.counter.innerHTML = this.index + '/' + this.children.length;
    };

    Slider.prototype.counterEl = function() {
        var counter;

        counter = document.createElement('span');
        counter.innerHTML = this.index + '/' + this.children.length;
        counter.className = 'slider__counter';

        return counter;
    };

    Slider.prototype.hideItems = function() {
        var i, len;

        for (i = 0, len = this.children.length; i < len; i += 1) {
            this.children[i].setAttribute('aria-hidden', true);
        }
    };

    Slider.prototype.advance = function() {
        var next;

        next = dom.nextSiblingOfType(this.current, 'LI');

        if (next === null) {
            this.index = 0;
            next = this.children[0];
        }

        this.hide(this.current);
        this.show(next);

        this.index += 1;
        this.current = next;
        this.updateCounter();
    };

    Slider.prototype.show = function(node) {
        node.setAttribute('aria-hidden', false);
    };

    Slider.prototype.hide = function(node) {
        node.setAttribute('aria-hidden', true);
    };


    module.exports = Slider;

}());
