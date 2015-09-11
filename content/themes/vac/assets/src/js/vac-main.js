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

            this.initFeaturedPosts(document.querySelectorAll('.featured-posts'),
                              FeaturedPosts);

        },

        initFeaturedPosts: function(nodeList, Component) {
            var i, len, component;

            for (i = 0, len = nodeList.length; i < len; i += 1) {
                component = new Component(nodeList[i]);
                component.setupPostLoading();
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
