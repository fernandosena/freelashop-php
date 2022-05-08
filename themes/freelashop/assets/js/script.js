$(function () {
    $(".proximo").on("click", function () {
        $(this).prop('disabled', true);
    });

    $(".submit").on("click", function () {
        $(".form").attr('onsubmit', true);
    });

    $(document).on("change", ".input", function() {
        var campoAtual = $(this);
        $("input[type='text']").each(function(){
            var input = $(this);
            var qtdLabel = $(".label-qtd").data("qtd-question");
            if(campoAtual.val() <= qtdLabel){
                if(campoAtual.data('question') === input.data('question')){
                    if (campoAtual.attr('id') !== input.attr('id') && campoAtual.val() !== "") {
                        if (campoAtual.val() === input.val()) {
                            alert("NÃO PODE CONTER NÚMERO IGUAL, INFORME OUTRO.");
                            campoAtual.val('');
                            campoAtual.focus();
                            return false;
                        }

                        if(input.val() === ""){
                            $(".proximo"+campoAtual.data('question')).prop('disabled', true);
                        }else{
                            $(".proximo"+campoAtual.data('question')).prop('disabled', false);
                        }
                    }
                }
            }else{
                alert("NÃO PODE CONTER NÚMERO MAIOR QUE "+qtdLabel);
                campoAtual.val('');
            }
        });
    });

    //ajax form
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
            beforeSend: function () {
                load.fadeIn(200).css("display", "flex");
            },
            success: function (response) {
                //redirect
                if (response.redirect) {
                    window.location.href = response.redirect;
                } else {
                    load.fadeOut(200);
                }

                //message
                if (response.message) {
                    if (flash.length) {
                        flash.html(response.message).fadeIn(100).effect("bounce", 300);
                    } else {
                        form.prepend("<div class='" + flashClass + "'>" + response.message + "</div>")
                            .find("." + flashClass).effect("bounce", 300);
                    }
                } else {
                    flash.fadeOut(100);
                }
            },
            complete: function () {
                if (form.data("reset") === true) {
                    form.trigger("reset");
                }
            }
        });
    });
});

function AnalizaTeclas(){
    var tecla=window.event.keyCode;
    if (tecla==13) {event.keyCode=0; event.returnValue=false;}
}