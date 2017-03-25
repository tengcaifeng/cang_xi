
$(function () {
    $('.zf-btn').click(function () {
        $('.content').addClass("none");
        $('.zf').removeClass("none");


    });
    $('.zy-btn').click(function () {
        $('.content').addClass("none");
        $('.zy').removeClass("none");

    });
    $('.bm-btn').click(function () {
        $('.content').addClass("none");
        $('.bm').removeClass("none");

    });

    $('nav#menu').mmenu({
        extensions: ['effect-slide-menu', 'pageshadow'],
        searchfield: true,
        counters: true,
        navbar: {
            title: 'Advanced menu'
        },
        navbars: [
            {
                position: 'top',
                content: ['searchfield']
            }, {
                position: 'top',
                content: [
                    'prev',
                    'title',
                    'close'
                ]
            }, {
                position: 'bottom',
                content: [
                    ' WordPress plugin '
                ]
            }
        ]
    });
});