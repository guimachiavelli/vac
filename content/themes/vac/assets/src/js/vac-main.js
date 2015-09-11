(function() {
    'use strict';

    var Accordion = require('./vac-accordion.js');

    var App;

    App = {
        init: function() {
            this.initNodeList(document.querySelectorAll('.accordion'),
                              Accordion);
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
