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
