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
    $('body').append(crafty.getView('index', {
        title: 'From js!',
        posts: [{
            title: 'Post title',
            content: 'Some post content, ready for some async stuff! :D'
        }]
    }));

    $('body').append('<div class="updatable"></div>');

    $('.updatable').html(crafty.getView('index', {
        title: 'Updating :D',
        posts: [{
            title: new Date(),
            content: 'Can be updated afterwards!'
        }]
    }));

    setInterval(function () {
        $('.updatable').html(crafty.getView('index', {
            title: 'Updating :D',
            posts: [{
                title: new Date(),
                content: 'Can be updated afterwards!'
            }]
        }));
    }, 1000);


    $('body').append('<h1>New lsit!</h1>');
    $('body').append('<form id="addToList" action=""><input class="name" name="name" type="text" /><input type="submit" value="New" /></form>');

    var list = [
        {
            title: 'test'
        }
    ];

    $('#addToList').on('submit', function (e) {
        e.preventDefault();
        list.push({title: $(this).find('.name').val()});
        $(this).find('.name').val('');
        $('.addable').html(crafty.getView('index', {
            title: 'Addable:',
            posts: list
        }));
    });

    $('body').append('<div class="addable"></div>');
    $('body').append('<div class="addable"></div>');


    $('.addable').html(crafty.getView('index', {
        title: 'Addable:',
        posts: list
    }));

    $('body').append('<h1>Style change!</h1>');
    $('body').append('<form id="colorChange" action=""><input class="color" name="color" type="color" /><input type="submit" value="Change" /></form>');
    $('#colorChange').on('submit', function (e) {
        e.preventDefault();
        $('.style').html(crafty.getView('style/background', {
            color: $(this).find('.color').val()
        }));
    });
    $('body').append('<div class="style"></div>');

})(jQuery, window, document);