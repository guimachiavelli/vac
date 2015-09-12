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
