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

    /* Mask */
    $(".mask-date").mask('00/00/0000');
    $(".mask-datetime").mask('00/00/0000 00:00');
    $(".mask-month").mask('00/0000', {reverse: true, placeholder: "mm/aaaa"});
    $(".mask-doc").mask('000.000.000-00', {reverse: true});
    $(".mask-card").mask('0000  0000  0000  0000', {reverse: true, placeholder: "**** **** **** ****"});
    $(".mask-cvv").mask('000', {reverse: true, placeholder: "***"});
    $(".mask-money").mask('00.000,00', {reverse: true, placeholder: "R$ 0,00"});
    $(".mask-cell").mask('(00) 0 0000-0000', {placeholder: "(99) 9 9999-9999"});
    /* End Mask */

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

                if(response.pix){
                    // $("#qrcode").html("Código pix: "+response.pix.pix);
                    $("#image_qrcode").attr("src", response.pix.qrcode);
                    $(".btn-pix").hide();
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


    // Pesquisa Subcategoria
    $('#inputCategoryForm').change(function() {
        var option = $(this).find(":selected").val();
        showPreloader();

        $.ajax({
            type: "POST",
            url: $(this).attr("data-url"),
            data: {"id": option},
            success: function(text) {
                $("#inputSubCategoryForm").html(text);
                hidePreloader();
            }
        });
    });

    // BS-Stepper Init
    document.addEventListener('DOMContentLoaded', function () {
        var stepperFormEl = document.querySelector('#stepperForm');
        window.stepperForm = new Stepper(stepperFormEl, {
            animation: true
        });

        var btnNextList = [].slice.call(document.querySelectorAll('.btn-next-form'));
        var stepperPanList = [].slice.call(stepperFormEl.querySelectorAll('.bs-stepper-pane'));

        //Projeto
        var inputTitleForm = document.getElementById('inputTitleForm');
        var inputCategoryForm = document.getElementById('inputCategoryForm');
        var inputSubCategoryForm = document.getElementById('inputSubCategoryForm');
        var inputBudgetForm = document.getElementById('inputBudgetForm');
        var inputLocalizationForm = document.getElementById('inputLocalizationForm');
        var inputContentForm = document.getElementById('inputContentForm');

        //Usuario
        var inputFirstNameForm = document.getElementById('inputFirstNameForm');
        var inputLastNameForm = document.getElementById('inputLastNameForm');
        var inputMailForm = document.getElementById('inputMailForm');
        var inputCellForm = document.getElementById('inputCellForm');
        var inputPasswordForm = document.getElementById('inputPasswordForm');
        var inputPasswordRepeatForm = document.getElementById('inputPasswordRepeatForm');

        var form = stepperFormEl.querySelector('.bs-stepper-content form');

        btnNextList.forEach(function (btn) {
            btn.addEventListener('click', function () {
                window.stepperForm.next();
            })
        });

        stepperFormEl.addEventListener('show.bs-stepper', function (event) {
            form.classList.remove('was-validated');
            var nextStep = event.detail.indexStep;
            var currentStep = nextStep;

            if (currentStep > 0) {
                currentStep--
            }

            var stepperPan = stepperPanList[currentStep];

            if (
                (stepperPan.getAttribute('id') === 'test-form-1' && !inputTitleForm.value.length) ||
                (stepperPan.getAttribute('id') === 'test-form-1' && !inputCategoryForm.value.length) ||
                (stepperPan.getAttribute('id') === 'test-form-1' && !inputSubCategoryForm.value.length) ||
                (stepperPan.getAttribute('id') === 'test-form-1' && !inputFirstNameForm.value.length) ||
                (stepperPan.getAttribute('id') === 'test-form-1' && !inputLastNameForm.value.length) ||
                (stepperPan.getAttribute('id') === 'test-form-1' && !inputMailForm.value.length) ||
                (stepperPan.getAttribute('id') === 'test-form-1' && !inputCellForm.value.length) ||
                (stepperPan.getAttribute('id') === 'test-form-1' && !inputPasswordForm.value.length) ||
                (stepperPan.getAttribute('id') === 'test-form-1' && !inputPasswordRepeatForm.value.length) ||
                (stepperPan.getAttribute('id') === 'test-form-2' && !inputBudgetForm.value.length) ||
                (stepperPan.getAttribute('id') === 'test-form-2' && !inputLocalizationForm.value.length) ||
                (stepperPan.getAttribute('id') === 'test-form-3' && !inputContentForm.value.length)
            ) {

                event.preventDefault();
                form.classList.add('was-validated')
            }
        });
    });

    $(".btn-previous").on("click", function () {
        $("#action").val("");
    });

    $(".btn-next").on("click", function () {
        $("#action").val($("#action").attr("data-action"));
    });
    //=================================================================================================================

    /* Navbar Scripts */
    // jQuery to collapse the navbar on scroll
    $(window).on('scroll load', function() {
        if ($(".navbar").offset().top > 60) {
            $(".fixed-top").addClass("top-nav-collapse");
        } else {
            $(".fixed-top").removeClass("top-nav-collapse");
        }
    });

    // jQuery for page scrolling feature - requires jQuery Easing plugin
    $(function() {
        $(document).on('click', 'a.page-scroll', function(event) {
            var $anchor = $(this);
            $('html, body').stop().animate({
                scrollTop: $($anchor.attr('href')).offset().top
            }, 600, 'easeInOutExpo');
            event.preventDefault();
        });
    });

    // closes the responsive menu on menu item click
    $(".navbar-nav li a").on("click", function(event) {
        if (!$(this).parent().hasClass('dropdown'))
            $(".navbar-collapse").collapse('hide');
    });

    /* Move Form Fields Label When User Types */
    // for input and textarea fields
    $("input, textarea").keyup(function(){
        if ($(this).val() != '') {
            $(this).addClass('notEmpty');
        } else {
            $(this).removeClass('notEmpty');
        }
    });

    /* Removes Long Focus On Buttons */
    $(".button, a, button").mouseup(function() {
        $(this).blur();
    });

})(jQuery);