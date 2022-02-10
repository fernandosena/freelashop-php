(function($) {
    /* Preloader */
    $(window).on('load', function() {
        hidePreloader();
    });

    /* End Preloader */

    /* Video Lightbox - Magnific Popup */
    $('.popup-youtube, .popup-vimeo').magnificPopup({
        disableOn: 700,
        type: 'iframe',
        mainClass: 'mfp-fade',
        removalDelay: 160,
        preloader: false,
        fixedContentPos: false,
        iframe: {
            patterns: {
                youtube: {
                    index: 'youtube.com/',
                    id: function(url) {
                        var m = url.match(/[\\?\\&]v=([^\\?\\&]+)/);
                        if ( !m || !m[1] ) return null;
                        return m[1];
                    },
                    src: 'https://www.youtube.com/embed/%id%?autoplay=1'
                },
                vimeo: {
                    index: 'vimeo.com/',
                    id: function(url) {
                        var m = url.match(/(https?:\/\/)?(www.)?(player.)?vimeo.com\/([a-z]*\/)*([0-9]{6,11})[?]?.*/);
                        if ( !m || !m[5] ) return null;
                        return m[5];
                    },
                    src: 'https://player.vimeo.com/video/%id%?autoplay=1'
                }
            }
        }
    });

    /*
     * APP MODAL
     */
    $(".action-project").on("click", function () {

        var description = "Essa alteração pode fazer com que o seu projeto fique pendente para nova análise";
        if (typeof $(".action-project").attr("data-description") !== "undefined") {
            var description = $(".action-project").attr("data-description");
        }

        var title = 'Tem certeza disso?';
        if (typeof $(".action-project").attr("data-title") !== "undefined") {
            var title = $(".action-project").attr("data-title");
        }

        Swal.fire({
            title: title,
            text: description,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sim!',
            cancelButtonText: 'Cancelar'
        }).then((result)=>{
            if (result.isConfirmed) {
                $.ajax({
                    url: $(".action-project").attr("data-action"),
                    type: "POST",
                    dataType: "json",
                    beforeSend: function () {
                        showPreloader();
                    },
                    success: function (response) {
                        if (response.redirect) {
                            window.location.href = response.redirect;
                        }

                        //reload
                        if (response.reload) {
                            window.location.reload();
                        }else {
                            hidePreloader();
                        }

                        //warning
                        if (response.warning) {
                            Swal.fire(
                                'Aviso!',
                                response.warning,
                                'warning'
                            )
                            hidePreloader();
                        }

                        //suceeso
                        if (response.success) {
                            Swal.fire(
                                'Sucesso!',
                                response.success,
                                'success'
                            )
                            hidePreloader();
                        }

                        //error
                        if (response.error) {
                            Swal.fire(
                                'Erro!',
                                response.error,
                                'error'
                            )
                            hidePreloader();
                        }

                    },
                    error: function () {
                        Swal.fire(
                            'Erro!',
                            'Erro, tente novamente mais tarde',
                            'error'
                        );
                        hidePreloader();
                    }

                });
            }
        })
    });
    //CHAT



    $("input[name='value']").keyup(function () {
       var percent = 1-(PERCENTSITE/100);
       var value = $(this).val().replace(/[\.\,]/g, '');
       $(".inputValue").val(parseFloat((value*percent)/100, 10).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1.").toString());
    });


    // $(".action-freelancer").on("click", function () {
    //     $.ajax({
    //         url: $(this).attr("data-action"),
    //         type: "POST",
    //         data: {
    //             "proposal": $(this).attr("data-proposal"),
    //             "project": $(this).attr("data-project")
    //         },
    //         dataType: "json",
    //         beforeSend: function () {
    //             showPreloader();
    //         },
    //         success: function (response) {
    //             if (response.redirect) {
    //                 window.location.href = response.redirect;
    //             }
    //
    //             //reload
    //             if (response.reload) {
    //                 window.location.reload();
    //             }else {
    //                 hidePreloader();
    //             }
    //
    //             //warning
    //             if (response.warning) {
    //                 Swal.fire(
    //                     'Aviso!',
    //                     response.warning,
    //                     'warning'
    //                 )
    //                 hidePreloader();
    //             }
    //
    //             //suceeso
    //             if (response.success) {
    //                 Swal.fire(
    //                     'Sucesso!',
    //                     response.success,
    //                     'success'
    //                 )
    //                 hidePreloader();
    //             }
    //
    //             //error
    //             if (response.error) {
    //                 Swal.fire(
    //                     'Erro!',
    //                     response.error,
    //                     'error'
    //                 )
    //                 hidePreloader();
    //             }
    //         },
    //         error: function () {
    //             Swal.fire(
    //                 'Erro!',
    //                 'Erro ao pausar projeto, tente novamente mais tarde',
    //                 'error'
    //             );
    //             hidePreloader();
    //         }
    //
    //     });
    // });

    /* Details Lightbox - Magnific Popup */
    $('.popup-with-move-anim').magnificPopup({
        type: 'inline',
        fixedContentPos: false, /* keep it false to avoid html tag shift with margin-right: 17px */
        fixedBgPos: true,
        overflowY: 'auto',
        closeBtnInside: true,
        preloader: false,
        midClick: true,
        removalDelay: 300,
        mainClass: 'my-mfp-slide-bottom'
    });


    /* Image Slider - Swiper */
    var imageSlider = new Swiper('.image-slider', {
        autoplay: {
            delay: 2000,
            disableOnInteraction: false
        },
        loop: true,
        spaceBetween: 30,
        slidesPerView: 5,
        breakpoints: {
            // when window is <= 580px
            580: {
                slidesPerView: 1,
                spaceBetween: 10
            },
            // when window is <= 768px
            768: {
                slidesPerView: 2,
                spaceBetween: 20
            },
            // when window is <= 992px
            992: {
                slidesPerView: 3,
                spaceBetween: 20
            },
            // when window is <= 1200px
            1200: {
                slidesPerView: 4,
                spaceBetween: 20
            }
        }
    });

    function chatHtml(name, date, image, content) {
        return '<div class="direct-chat-msg right">\n' +
            '    <div class="direct-chat-infos clearfix">\n' +
            '        <span class="direct-chat-name float-end">\n'+ name +
            '        </span>\n' +
            '        <span class="direct-chat-timestamp float-start">' + date +'</span>\n' +
            '    </div>\n' +
            '    <img class="direct-chat-img" src="\n' + image + '" alt="message user image">\n' +
            '    <div class="direct-chat-text text-end">\n' +
            '        '+content+'\n' +
            '    </div>\n' +
            '</div>';
    }

    /* AJAX FORM */
    $(".form_chat").submit(function (e) {
        e.preventDefault();
        var form = $(this);
        var flashClass = "ajax_response";
        var flash = $("." + flashClass);
        var chat = $(".ajax-chat");

        form.ajaxSubmit({
            url: form.attr("action"),
            type: "POST",
            dataType: "json",
            beforeSend: function () {
                showPreloader();
            },
            success: function (response) {
                //message
                if (response.message) {
                    if (flash.length) {
                        flash.html(response.message);
                    } else {
                        form.prepend("<div class='" + flashClass + "'>" + response.message + "</div>")
                            .find("." + flashClass);
                    }
                    hidePreloader();
                }

                var centerHtml = "";
                if(response.chat){
                    centerHtml += chatHtml(response.chat.name, response.chat.date, response.chat.image, response.chat.content);
                    chat.append(centerHtml);
                    $("input[name='content']").val("");
                    hidePreloader();
                }
            },
            complete: function () {
                if (form.data("reset") === true) {
                    form.trigger("reset");
                }
                $(".alert").delay(3000).fadeOut(2000)
            }
        });
    });

    /* Text Slider - Swiper */
    var textSlider = new Swiper('.text-slider', {
        autoplay: {
            delay: 6000,
            disableOnInteraction: false
        },
        loop: true,
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev'
        }
    });
})(jQuery);

var preloaderFadeOutTime = 500;
function hidePreloader() {
    var preloader = $('.spinner-wrapper');
    setTimeout(function() {
        preloader.fadeOut(preloaderFadeOutTime);
    }, 500);
}
function showPreloader() {
    var preloader = $('.spinner-wrapper');
    setTimeout(function() {
        preloader.fadeIn(preloaderFadeOutTime).css({"background-color": "rgba(0,0,0,.1)"});
    }, 500);
}