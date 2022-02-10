<form class="auth_form" action="<?= url("/app/report/".$project->uri.""); ?>" data-modal="true" method="post" data-toggle="validator" data-focus="false">
    <div class="modal-body">
        <p class="title"><i class="far fa-calendar-minus"></i> Relatar problema:</p>
        <div class="ajax_response_modal"><?= flash(); ?></div>
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label><i class="far fa-life-ring"></i> Qual o problema?</label>
                            <select class="form-control" name="subject" style="width: 100%;">
                                <option value="Não consigo enviar uma proposta" selected="selected">Não consigo enviar uma proposta</option>
                                <option value="Projeto enganoso">Projeto enganoso</option>
                                <option value="Não é possivel realiza-lo">Não é possivel realiza-lo</option>
                                <option value="Sem retorno do contratante">Sem retorno do contratante</option>
                                <option value="Outro">Outro</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label><i class="fas fa-comments"></i> Mensagem:</label>
                            <textarea autocomplete="off" id="inputContentForm" class="form-control"
                                      name="message" placeholder="Digite a sua mensagem aqui de foma bem detalhada e direta..." required></textarea>

                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-md btn-default">
                                ENVIAR AGORA
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>