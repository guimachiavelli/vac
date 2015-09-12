(function e(t,n,r){function s(o,u){if(!n[o]){if(!t[o]){var a=typeof require=="function"&&require;if(!u&&a)return a(o,!0);if(i)return i(o,!0);var f=new Error("Cannot find module '"+o+"'");throw f.code="MODULE_NOT_FOUND",f}var l=n[o]={exports:{}};t[o][0].call(l.exports,function(e){var n=t[o][1][e];return s(n?n:e)},l,l.exports,e,t,n,r)}return n[o].exports}var i=typeof require=="function"&&require;for(var o=0;o<r.length;o++)s(r[o]);return s})({1:[function(require,module,exports){
(function(){
    'use strict';

    function toggleAttribute(node, attribute) {
        var current;

        current = node.getAttribute(attribute);
        console.log(current);

        if (current === 'true') {
            node.setAttribute(attribute, false);
            return;
        }

        if (current === 'false') {
            node.setAttribute(attribute, true);
        }

    }

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
        previousSiblingOfType: previousSiblingOfType,
        toggleAttribute: toggleAttribute
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

    var dom = require('./utils/dom-traversal.js'),
        Filters = require('./vac-filters.js');

    var FeaturedPosts;

    FeaturedPosts = function(el, filters, configs) {
        configs = configs || {};
        this.el = el;
        this.mainSelector = configs.mainSelector || '.featured-posts';
        this.childSelector = configs.childSelector || '.featured-post';
        this.initialPosts = configs.posts || 4;
        this.loadNumber = configs.posts || 12;
        this.posts = el.querySelectorAll(this.childSelector);
        this.button = this.loadButton();
        this.setupButton();

        if (filters) {
            this.filters = new Filters(this.el,
                                      this.mainSelector,
                                      this.reset.bind(this));
        }
    };

    FeaturedPosts.prototype.initialPosts = 4;
    FeaturedPosts.prototype.loadNumber = 10;
    FeaturedPosts.prototype.hiddenPosts = 0;
    FeaturedPosts.prototype.filters = null;

    FeaturedPosts.prototype.reset = function() {
        this.hiddenPosts = 0;
        this.setup();
    };

    FeaturedPosts.prototype.loadButton = function() {
        var button = document.createElement('button');

        button.className = 'featured-posts__load';
        button.type = 'button';

        return button;
    };

    FeaturedPosts.prototype.postsToLoad = function() {
        if (this.loadNumber > this.hiddenPosts) {
            return this.hiddenPosts;
        }

        return this.loadNumber;
    };

    FeaturedPosts.prototype.setupButton = function() {
        this.el.appendChild(this.button);
        this.button.addEventListener('click', this.load.bind(this));
        this.updateButton();
    };

    FeaturedPosts.prototype.updateButton = function() {
        var moreText;

        if (!this.button) {
            return;
        }

        if (this.hiddenPosts < 1) {
            this.button.disabled = true;
            return;
        }

        moreText = document.documentElement.lang === 'ru' ? 'Больше' : 'more';

        this.button.innerHTML = '+ ' + this.postsToLoad() + ' ' + moreText;
        this.button.disabled = false;
    };

    FeaturedPosts.prototype.load = function() {
        var i, len, postsToLoad;

        postsToLoad = this.postsToLoad();

        for (i = 0, len = this.posts.length; postsToLoad > 0; i += 1) {
            if (this.posts[i] === undefined) {
                break;
            }

            if (!this.shouldShow(this.posts[i])) {
                continue;
            }

            postsToLoad -= 1;
            this.hiddenPosts -= 1;
            this.posts[i].setAttribute('aria-hidden', false);
        }

        this.updateButton();
    };

    FeaturedPosts.prototype.setup = function() {
        var i, len, count, post;

        count = 0;

        for (i = 0, len = this.posts.length; i < len; i += 1) {
            post = this.posts[i];
            console.log(this.hasCategory(post));

            if (count < this.initialPosts && this.hasCategory(post)) {
                count += 1;
                post.setAttribute('aria-hidden', false);
                continue;
            }

            if (this.hasCategory(post)) {
                this.hiddenPosts += 1;
            }

            post.setAttribute('aria-hidden', true);
        }

        this.updateButton();
    };

    FeaturedPosts.prototype.shouldShow = function(node) {
        if (this.filters === null || this.filters.categories.length < 1) {
            return node.getAttribute('aria-hidden') === 'true';
        }


        return node.getAttribute('aria-hidden') === 'true' &&
                this.hasCategory(node);
    };

    FeaturedPosts.prototype.hasCategory = function(node) {
        var categories, i, len;

        if (this.filters === null || this.filters.categories.length < 1) {
            return true;
        }

        categories = node.getAttribute('data-categories').split(', ');

        for (i = 0, len = categories.length; i < len; i += 1) {
            if (this.filters.categories.indexOf(categories[i]) > -1) {
                return true;
            }
        }

        return false;
    };

    FeaturedPosts.prototype.hideExcess = function() {
        var i, len, count;

        count = 0;

        for (i = 0, len = this.posts.length; i < len; i += 1) {
            if (i < this.initialPosts) {
                continue;
            }
            count += 1;
            this.posts[i].setAttribute('aria-hidden', true);
        }

        this.hiddenPosts = count;
    };


    module.exports = FeaturedPosts;

}());

},{"./utils/dom-traversal.js":1,"./vac-filters.js":4}],4:[function(require,module,exports){
(function() {
    'use strict';

    var Filters;

    Filters = function(el, selector, callback) {
        this.categories = [];
        this.el = el.querySelector(selector + '__filters');
        this.button = this.el.querySelector('button');
        this.bind();
        this.callback = callback;
    };

    Filters.prototype.bind = function() {
        this.el.addEventListener('change', this.update.bind(this));
        this.el.addEventListener('reset', this.reset.bind(this));
    };

    Filters.prototype.update = function() {
        var checkedElements, values;
        checkedElements = this.el.querySelectorAll(':checked');
        values = this.checkedValues(checkedElements);
        this.categories = values;
        this.updateButtonState();
        this.callback();
    };

    Filters.prototype.checkedValues = function(nodes) {
        var i, len, values = [];

        for (i = 0, len = nodes.length; i < len; i += 1) {
            values.push(nodes[i].value);
        }

        return values;
    };

    Filters.prototype.reset = function() {
        this.categories = [];
        this.resetCheckboxes(this.el.querySelectorAll(':checked'));
    };

    Filters.prototype.resetCheckboxes = function(nodeList) {
        var i, len;

        for (i = 0, len = nodeList.length; i < len; i += 1) {
            nodeList[i].checked = false;
        }

        this.updateButtonState();
    };

    Filters.prototype.updateButtonState = function() {
        if (!this.button) {
            return;
        }

        var checked = this.el.querySelectorAll(':checked');
        this.button.disabled = checked.length < 1;
    };

    module.exports = Filters;

}());

},{}],5:[function(require,module,exports){
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

},{"./utils/dom-traversal.js":1}],6:[function(require,module,exports){
(function() {
    'use strict';

    var Accordion = require('./vac-accordion.js'),
        SideGallery = require('./vac-side-gallery.js'),
        FeaturedPosts = require('./vac-featured-posts.js'),
        FloatingImage = require('./vac-floating-image.js');

    var App;

    App = {
        init: function() {
            this.initNodeList(document.querySelectorAll('.accordion'),
                              Accordion);

            this.initNodeList(document.querySelectorAll('.floating-image'),
                              FloatingImage);

            this.initNodeList(document.querySelectorAll('.side-gallery'),
                              SideGallery);

            this.initFeaturedPosts(document.querySelectorAll('.featured-posts'));

            this.initFeaturedPosts(
                            document.querySelectorAll('.archive'),
                            {
                                mainSelector: '.archive',
                                childSelector: '.archive-item',
                                posts: 1
                            });

            this.initFeaturedPosts(
                            document.querySelectorAll('.schools'),
                            {
                                mainSelector: '.schools',
                                childSelector: '.school',
                                posts: 1
                            });

            this.initFeaturedPosts(
                            document.querySelectorAll('.talks'),
                            {
                                mainSelector: '.talks',
                                childSelector: '.featured-post',
                            });



        },

        initFeaturedPosts: function(nodeList, configs) {
            var i, len, component, node, filters;

            for (i = 0, len = nodeList.length; i < len; i += 1) {
                node = nodeList[i];
                filters = node.getAttribute('data-filters');
                component = new FeaturedPosts(node, filters, configs);
                component.setup();
            }
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

},{"./vac-accordion.js":2,"./vac-featured-posts.js":3,"./vac-floating-image.js":5,"./vac-side-gallery.js":7}],7:[function(require,module,exports){
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

},{"./utils/dom-traversal.js":1}]},{},[6]);
