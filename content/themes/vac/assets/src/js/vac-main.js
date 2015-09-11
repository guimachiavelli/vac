(function() {
    'use strict';

    var Accordion = require('./vac-accordion.js'),
        FloatingImage = require('./vac-floating-image.js');

    var App;

    App = {
        init: function() {
            this.initNodeList(document.querySelectorAll('.accordion'),
                              Accordion);

            this.initNodeList(document.querySelectorAll('.floating-image'),
                              FloatingImage);
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
