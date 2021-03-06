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
        this.callback();
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
