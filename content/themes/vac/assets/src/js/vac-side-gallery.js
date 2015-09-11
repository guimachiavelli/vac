(function() {
    'use strict';

    var dom = require('./utils/dom-traversal.js');

    var SideGallery;

    SideGallery = function(el) {
        this.el = el;
        this.mask = el.querySelector('.side-gallery__mask');
    };

    SideGallery.prototype.bind = function() {
        this.el.addEventListener('click', this.onImageClick.bind(this));
    };

    SideGallery.prototype.onImageClick = function() {
        dom.toggleAttribute(this.el, 'aria-expanded');
        this.mask.appendChild(this.button);
    };

    SideGallery.prototype.button = (function() {
        var button, lang;
        button = document.createElement('button');
        lang = document.documentElement.lang;
        button.innerHTML = lang === 'ru' ? 'Закрыть' : 'close';
        button.className = 'side-galery__close';
        button.type = 'button';
        return button;
    }());


    module.exports = SideGallery;

}());
