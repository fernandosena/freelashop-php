(function($) {
    /* Preloader */
    $(window).on('load', function() {
        hidePreloader();
    });

    window.setTimeout(function(){
        $('.message-fade').fadeOut(2000);
    }, 6000);

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

    $(".btn-cookie").on("click", function () {
        setCookie("lgpd","true", 1);
        $(".cookie").fadeOut(preloaderFadeOutTime);
    });

    function setCookie(cname, cvalue, exdays) {
        const d = new Date();
        d.setTime(d.getTime() + (exdays*24*60*60*1000));
        var expires = "expires="+ d.toUTCString();
        document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
    }
    /* End Preloader */

    /* AJAX FORM */
    $("form:not('.ajax_off')").submit(function (e) {
        e.preventDefault();
        var form = $(this);
        var load = $(".ajax_load");
        var flashClass = "ajax_response";
        var flash = $("." + flashClass);

        form.ajaxSubmit({
            url: form.attr("action"),
            type: "POST",
            dataType: "json",
            beforeSubmit: validate,
            beforeSend: function () {
                showPreloader();
            },
            success: function (response) {
                //redirect
                if (response.redirect) {
                    window.location.href = response.redirect;
                }

                //reload
                if (response.reload) {
                    window.location.reload();
                }

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
            },
            complete: function () {
                if (form.data("reset") === true) {
                    form.trigger("reset");
                }
                $(".alert").delay(3000).fadeOut(2000)
            }
        });
    });

    //Valida se todos so campos foram preenchidos antes de enviar ajax
    function validate(formData, jqForm, options) {
        for (var i=0; i < formData.length; i++) {
            if(formData[i].required){
                if (!formData[i].value) {
                    return false;
                }
            }
        }
    }
    /* End AJAX FORM */



})(jQuery);