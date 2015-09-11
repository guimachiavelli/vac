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
