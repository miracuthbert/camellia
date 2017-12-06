
window._ = require('lodash');

/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

try {
    window.$ = window.jQuery = require('jquery');

    require('bootstrap-sass');

    //bootstrap datetimepicker
    $.fn.datetimepicker = require('eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min');
} catch (e) {}
