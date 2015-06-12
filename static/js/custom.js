;
(function ($, window, document, undefined) {

    "use strict";


    var Crafty = function () {
        this.views = [];
        this.init = function () {
            var _this = this;
            $('script.mustache-view').each(function (i) {
                _this.views[$(this).data('name')] = $(this).html();
            });
        };
        this.getView = function (view, args) {
            return Mustache.render(this.views[view], args, this.views);
        };
        this.init();
    }


    var crafty = new Crafty();


})(jQuery, window, document);