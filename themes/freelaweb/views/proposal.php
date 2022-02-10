<form class="auth_form" action="<?= url("/app/proposal/".$project->uri); ?>" data-modal="true" method="post" data-toggle="validator" data-focus="false">
    <input type="hidden" name="action" value="proposal">
    <input type="hidden" name="id" value="<?= (!empty($proposal->id)) ? $proposal->id : null ?>">
    <div class="modal-body">
        <p class="title"><i class="far fa-calendar-minus"></i> Enviar proposta:</p>
        <div class="ajax_response_modal"><?= flash(); ?></div>
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-4">
                        <div class="form-group">
                            <label><i class="fas fa-dollar-sign"></i> Valor da proposta</label>
                            <input type="text" class="form-control mask-money" value="<?= (!empty($proposal->price)) ? $proposal->price : null ?>" name="value">
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label><i class="fas fa-dollar-sign"></i> Valor a receber</label>
                            <input type="text" value="<?= (!empty($proposal->price)) ? ($proposal->price*((100-CONF_SITE_PERCENTAGE)/100)): null ?>" class="form-control mask-money inputValue" disabled>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label><i class="fas fa-dollar-sign"></i> Taxa</label>
                            <p><small class="text-danger font-weight-bold">Cobramos <?= CONF_SITE_PERCENTAGE ?>% do valor da proposta do contratante</small></p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label><i class="fas fa-calendar-day"></i> Início</label>
                            <input type="date" min="<?= date("Y-m-d") ?>" class="form-control" value="<?= (!empty($proposal->start)) ? $proposal->start : null ?>" name="start">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label><i class="fas fa-calendar-day"></i> Término</label>
                            <input type="date" min="<?= date("Y-m-d", strtotime("+1 days")) ?>" value="<?= (!empty($proposal->delivery)) ? $proposal->delivery : null ?>" class="form-control" name="delivery">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label><i class="fas fa-comments"></i> Mensagem: <span class="text-danger font-weight-bold">*</span></label>
                            <textarea autocomplete="off" id="inputContentForm" class="form-control"
                                      name="content"
                                      placeholder="Digite a sua mensagem aqui de foma bem detalhada e direta..." required><?= (!empty($project)) ? "Olá ".$project->author()->first_name.", tudo bem?&#10;&#10;Gostaria de trabalhar em seu projeto.&#10;&#10;Attr.&#10;".user()->first_name."": str_textarea_reverse($proposal->content); ?></textarea>
                        </div>
                        <div class="form-group checkbox">
                            <input type="checkbox" name="accept" required> Estou ciente que li o <a href="#service-contract" class="popup-with-move-anim">contrato de pestação de serviço</a> e para a minha segurança todas as comunicações e transações
                            financeiras relativas a este trabalho será realizado dentro da plataforma <?= CONF_SITE_NAME ?>.
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-md btn-default">
                                <i class="fas fa-paper-plane"></i> ENVIAR AGORA
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
        