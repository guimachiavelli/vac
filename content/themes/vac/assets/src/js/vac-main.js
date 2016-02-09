(function() {
    'use strict';

    var Accordion = require('./vac-accordion.js'),
        SideGallery = require('./vac-side-gallery.js'),
        FeaturedPosts = require('./vac-featured-posts.js'),
        Slider = require('./vac-slider.js'),
        Aside = require('./vac-aside.js'),
        FloatingImage = require('./vac-floating-image.js');

    var App;

    App = {
        init: function() {
            this.initNodeList(document.querySelectorAll('.accordion'),
                              Accordion);

            this.initNodeList(document.querySelectorAll('.slider'),
                              Slider);

            this.initNodeList(document.querySelectorAll('.floating-image'),
                              FloatingImage);

            this.initNodeList(document.querySelectorAll('.side-gallery'),
                              SideGallery);

            this.initNodeList(document.querySelectorAll('.asides'),
                              Aside);

            this.initFeaturedPosts(document.querySelectorAll('.featured-posts'));

            this.initFeaturedPosts(
                            document.querySelectorAll('.archive'),
                            {
                                mainSelector: '.archive',
                                childSelector: '.archive-item',
                                posts: 10
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
