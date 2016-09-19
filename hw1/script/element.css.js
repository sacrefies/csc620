/**
 * Check if the element has the given class
 */
var hasClass = function(id, className) {
    var el = element(id);
    return el.classList.contains(className);
}


/**
 * Add a class to the specified element
 */
var addClass = function(id, className) {
    var el = element(id);
    el.classList.add(className)
}


/**
 * Remove a class from the specified element
 */
var removeClass = function(id, className) {
    var el = element(id);
    el.classList.remove(className)
}
