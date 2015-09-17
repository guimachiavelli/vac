(function() {
    'use strict';

    var Aside;

    Aside = function(el) {
        this.els = el.querySelectorAll('.aside-item');
        this.paragraphs = this.postParagraphs();
        this.position(this.els, this.paragraphs);
        this.lastResize = 0;
    };

    Aside.prototype.postParagraphs = function() {
        return document.querySelector('.column--wide').querySelectorAll('p');
    };

    Aside.prototype.position = function(els, paragraphs) {
        var i, len, el, index, y;

        for (i = 0, len = els.length; i < len; i += 1) {
            el = els[i];
            index = parseInt(els[i].getAttribute('data-paragraph'), 10) - 1;

            if (!paragraphs[i]) {
                continue;
            }

            y = paragraphs[index].offsetTop;

            el.style.position = 'absolute';
            el.style.top = y + 'px';
        }
    };

    Aside.prototype.bind = function(){
        window.addEventListener('resize', this.onResize.bind(this));
    };

    Aside.prototype.onResize = function() {
        var now;
        console.log('resize');

        now = new Date().getTime();

        if (now - this.lastResize > 200) {
            this.position(this.els, this.paragraphs);
            this.lastResize = now;
        }
    };

    module.exports = Aside;

}());
