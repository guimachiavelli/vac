(function() {
    'use strict';

    var dom = require('./utils/dom-traversal.js');

    var FeaturedPosts;

    FeaturedPosts = function(el) {
        this.el = el;
        this.posts = el.querySelectorAll('.featured-post');
        this.button = this.loadButton();
        this.hideExcess();
    };

    FeaturedPosts.prototype.initialPosts = 3;
    FeaturedPosts.prototype.loadNumber = 10;
    FeaturedPosts.prototype.hiddenPosts = 0;

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

    FeaturedPosts.prototype.setupPostLoading = function() {
        if (this.hiddenPosts < 1) {
            return;
        }

        this.setupButton();
    };

    FeaturedPosts.prototype.setupButton = function() {
        this.el.appendChild(this.button);
        this.updateButtonText();
        this.button.addEventListener('click', this.load.bind(this));
    };

    FeaturedPosts.prototype.load = function() {
        var i, len, postsToLoad;

        postsToLoad = this.postsToLoad();

        for (i = 0, len = this.posts.length; postsToLoad > 0; i += 1) {
            if (this.posts[i].getAttribute('aria-hidden') === 'true') {
                postsToLoad -= 1;
                this.hiddenPosts -= 1;
                this.posts[i].setAttribute('aria-hidden', false);
            }
        }

        if (this.hiddenPosts < 1) {
            this.removeButton();
            return;
        }

        this.updateButtonText();
    };

    FeaturedPosts.prototype.removeButton = function() {
        this.el.removeChild(this.button);
    };

    FeaturedPosts.prototype.updateButtonText = function() {
        this.button.innerHTML = '+ ' + this.postsToLoad() + ' more';
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
