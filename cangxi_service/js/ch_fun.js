
$(function () {
    $('.zf-btn').click(function () {

        $("#iframeA").contents().find(".hd_content").addClass("hide");
        $("#iframeA").contents().find(".zf").removeClass("hide");
    });
    $('.zy-btn').click(function () {
        $("#iframeA").contents().find(".hd_content").addClass("hide");
        $("#iframeA").contents().find(".zy").removeClass("hide");
    });
    $('.bm-btn').click(function () {

        $("#iframeA").contents().find(".hd_content").addClass("hide");
        $("#iframeA").contents().find(".bm").removeClass("hide");
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