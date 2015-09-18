(function() {
    'use strict';

    var dom = require('./utils/dom-traversal.js');

    var SideGallery;

    SideGallery = function(el) {
        this.el = el;
        this.wrapper = el.querySelector('.side-gallery__wrapper');
        this.container = el.querySelector('.side-gallery__container');
        this.wrapper.appendChild(this.button);
        this.lastResize = 0;

        //defer
        setTimeout(this.adjustHeight.bind(this), 100);
    };

    SideGallery.prototype.adjustHeight = function() {
        this.wrapper.style.height = this.container.offsetHeight + 'px';
    };

    SideGallery.prototype.bind = function() {
        this.el.addEventListener('click', this.onImageClick.bind(this));
        window.addEventListener('resize', this.onResize.bind(this));
    };

    SideGallery.prototype.onImageClick = function() {
        dom.toggleAttribute(this.el, 'aria-expanded');
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

    SideGallery.prototype.onResize = function() {
        var now;

        now = new Date().getTime();

        if (now - this.lastResize > 200) {
            this.adjustHeight();
            this.lastResize = now;
        }
    };


    module.exports = SideGallery;

}());
