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
        }
        this.getView = function (view, args) {
            return Mustache.render(this.views[view], args, this.views);
        }
        this.init();
    }


    var crafty = new Crafty();

    var view = crafty.getView('index',{
        title:'From js!',
        posts:[{
            title:'Post title',
            content:'Some post content, ready for some async stuff! :D'
        }]
    });
    $('body').append(view);
})(jQuery, window, document);