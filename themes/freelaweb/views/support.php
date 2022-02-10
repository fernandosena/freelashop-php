<form class="auth_form" action="<?= url("/app/support"); ?>" method="post" data-toggle="validator" data-focus="false">
    <div class="modal-body">
        <p class="title"><i class="far fa-calendar-minus"></i> Fale conosco:</p>
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label><i class="far fa-life-ring"></i> O que precisa? <span class="text-danger font-weight-bold">*</span></label>
                            <select class="form-control" name="subject" style="width: 100%;">
                                <option value="Pedido de suporte" selected><i class="far fa-dot-circle"></i>&ofcir; Preciso de suporte</option>
                                <option value="Nova sugestão"><i class="far fa-dot-circle"></i>&ofcir; É uma sugestão</option>
                                <option value="Nova reclamação"><i class="far fa-dot-circle"></i>&ofcir; É uma reclamação</option>
                                <option value="Mudança de plano"><i class="far fa-dot-circle"></i>&ofcir; Mudar meu plano</option>
                                <option value="Mudança de conta"><i class="far fa-dot-circle"></i>&ofcir; Mudar minha conta</option>
                                <option value="Abrir uma disputa"><i class="far fa-dot-circle"></i>&ofcir; Abrir uma disputa</option>
                                <option value="Cancelamento de assinatura"><i class="far fa-dot-circle"></i>&ofcir; Cancelar assinatura</option>
                                <option value="Outro"><i class="far fa-dot-circle"></i>&ofcir; Outro</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label><i class="fas fa-comments"></i> Mensagem: <span class="text-danger font-weight-bold">*</span></label>
                            <textarea autocomplete="off" id="inputContentForm" class="form-control"
                                      name="message" placeholder="Digite a sua mensagem aqui..." required></textarea>

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