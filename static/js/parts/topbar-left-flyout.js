;
(function ($, window, document, undefined) {

    "use strict";

    $('body').on('click', '.topbar-left-flyout .action-menu', function (e) {
        $('body').addClass('topbar-left-flyout-active');
        $(this).parent().addClass('active');
        e.preventDefault();
        return false;
    }).on('click', '.topbar-left-flyout .overlay', function (e) {
        $('body').removeClass('topbar-left-flyout-active');
        $(this).parent().removeClass('active');
        e.preventDefault();
        return false;
    });

})(jQuery, window, document);