<?php $v->layout("_theme"); ?>
<div class="ex-basic-2 mt-7">
    <div class="container">
        <div class="row g-5">
            <div class="col-md-5 col-lg-4 order-md-last">
                <h4 class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-primary"><?= $product["title"] ?></span>
                </h4>
                <ul class="list-group mb-3">
                    <li class="list-group-item d-flex justify-content-between lh-sm">
                        <div>
                            <h6 class="my-0"><?= $product["name"] ?></h6>
                            <small class="text-muted"><?= ucfirst(translate($product["period"])) ?></small>
                        </div>
                        <span class="text-muted">R$ <?= str_price($product["price"]) ?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <span>Total (<?= $product["currency"] ?>)</span>
                        <strong>R$ <?= str_price($product["price"]) ?></strong>
                    </li>
                </ul>
            </div>
            <?php if(!empty($transfer)): ?>
                <div class="col-md-7 col-lg-8">
                    <h4 class="mb-3">Formas de pagamento</h4>
                    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                        <?php if(empty($pix) && empty($boleto)):?>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="pills-transaction-tab" data-bs-toggle="pill" data-bs-target="#pills-transaction" type="button" role="tab" aria-controls="pills-transaction" aria-selected="false"><i class="fa-solid fa-file-invoice-dollar"></i> Transferência</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-boleto-tab" data-bs-toggle="pill" data-bs-target="#pills-boleto" type="button" role="tab" aria-controls="pills-boleto" aria-selected="true"><i class="fas fa-barcode"></i> Boleto</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-pix-tab" data-bs-toggle="pill" data-bs-target="#pills-pix" type="button" role="tab" aria-controls="pills-pix" aria-selected="true"><i class="fa-brands fa-pix"></i> Pix</button>
                        </li>
                        <?php endif; ?>
                    </ul>

                    <div class="tab-content" id="pills-tabContent">
                        <?php if(!empty($pix)):?>
                            <img src="<?= $pix->qr_code_url ?>" alt="Pix" title="Pix">
                        <?php endif; ?>
                        <?php if(!empty($boleto)):?>
                            <img src="<?= $boleto->qr_code ?>" alt="Qr code" title="Qr code">
                            <p><label>Código de barras:</label> <span><?= $boleto->line ?></span></p>
                            <a href="<?= $boleto->url ?>" class="w-100 btn btn-primary btn-lg btn-pix" target="_blank" title="Boleto">Imprimir boleto</a>
                        <?php endif; ?>
                        <?php if(empty($pix) && empty($boleto)):?>
                        <div class="tab-pane fade show active" id="pills-transaction" role="tabpanel" aria-labelledby="pills-transaction-tab">
                            <p>Envie o valor para os dados bancarios ou pix abaixo e após envie o comprovante para o o email do suporte <a href="mailto: <?= CONF_MAIL_SUPPORT ?>"><?= CONF_MAIL_SUPPORT ?></a> .</p>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item"><strong>Banco: </strong><?= CONF_ACCOUNT_BANK ?></li>
                                <li class="list-group-item"><strong>Beneficiário: </strong><?= CONF_ACCOUNT_RECIPIENT ?></li>
                                <li class="list-group-item"><strong>Conta: </strong><?= CONF_ACCOUNT_ACCOUNT ?></li>
                                <li class="list-group-item"><strong>Agência: </strong><?= CONF_ACCOUNT_AGENCY ?></li>
                                <li class="list-group-item"><strong>Chave pix: </strong><?= CONF_ACCOUNT_PIX_KEY ?><br>
                                    <small style="font-size: 10px"><strong>Tipo de chave: </strong><?= CONF_ACCOUNT_PIX_TYPE ?></small></li>
                            </ul>

                        </div>

                        <div class="tab-pane fade" id="pills-pix" role="tabpanel" aria-labelledby="pills-pix">
                            <form class="auth_form" action="<?= url("/pay/{$product["post"]}"); ?>" method="post" data-toggle="validator" data-focus="false">
                                <input type="hidden" name="type" value="pix">
                                <input type="hidden" name="product" value="<?= $product["id"] ?>">
                                <button class="w-100 btn btn-primary btn-lg btn-pix" type="submit">Gerar QRCode</button>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="pills-boleto" role="tabpanel" aria-labelledby="pills-boleto-tab">
                            <form class="auth_form" action="<?= url("/pay/{$product["post"]}"); ?>" method="post" data-toggle="validator" data-focus="false">
                                <input type="hidden" name="type" value="boleto">
                                <input type="hidden" name="product" value="<?= $product["id"] ?>">
                                <button class="w-100 btn btn-primary btn-lg btn-boleto" type="submit">Gerar boleto</button>
                            </form>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php else: ?>
                <div class="col-md-7 col-lg-8">
                <h4 class="mb-3">Formas de pagamento</h4>
                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="pills-cred-card-tab" data-bs-toggle="pill" data-bs-target="#pills-cred-card" type="button" role="tab" aria-controls="pills-cred-card" aria-selected="true"><i class="fa-solid fa-credit-card"></i> Cartão de crédito</button>
                    </li>
                </ul>
                <div class="ajax_response"><?= flash(); ?></div>
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-cred-card" role="tabpanel" aria-labelledby="pills-cred-card-tab">
                        <form class="auth_form" action="<?= url("/pay/{$product["post"]}"); ?>" method="post" data-toggle="validator" data-focus="false">
                            <input type="hidden" name="type" value="cred-card">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="inputPasswordForm">Número do cartão <span class="text-danger font-weight-bold">*</span></label>
                                        <input autocomplete="off" id="inputPasswordForm" name="cardNumber" type="text" class="form-control mask-card" placeholder="Senha" required>
                                        <div class="invalid-feedback">Campo Obrigatório</div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="inputPasswordRepeatForm">Nome do títular <span class="text-danger font-weight-bold">*</span></label>
                                        <input autocomplete="off" id="inputPasswordRepeatForm" name="cardName" type="text" class="form-control" placeholder="Igual ao impresso no cartão" required>
                                        <div class="invalid-feedback">Campo Obrigatório</div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="inputPasswordRepeatForm">Data de expiração <span class="text-danger font-weight-bold">*</span></label>
                                        <input autocomplete="off" id="inputPasswordRepeatForm" name="cardExpiry" type="text" class="form-control mask-month"required>
                                        <div class="invalid-feedback">Campo Obrigatório</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="inputPasswordRepeatForm">CVV <span class="text-danger font-weight-bold">*</span></label>
                                        <input autocomplete="off" id="inputPasswordRepeatForm" name="cardCVV" type="number" class="form-control" placeholder="Repita a senha" required>
                                        <div class="invalid-feedback">Campo Obrigatório</div>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="product" value="<?= $product["id"] ?>">
<!--                            <input type="hidden" name="brand">-->
<!--                            <input type="hidden" name="token">-->
<!--                            <input type="hidden" name="senderHash">-->
                            <button class="w-100 btn btn-primary btn-lg btn-pagamento" type="submit"">Confirmar Pagamento</button>
                        </form>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $v->start("scripts") ?>
    <script type="text/javascript">
        /*$(function($) {
            $("input[name='cardNumber']").keyup(function () {
                var brand = tgdeveloper.getCardFlag($("input[name='cardNumber']").val());
                $("input[name='brand']").val(brand);
            });
        });*/
    </script>
<?php $v->stop() ?>