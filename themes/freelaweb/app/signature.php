<?php $v->layout("_theme"); ?>
<!-- /.content -->
<div id="pricing" class="cards-2 mt-5">
    <div class="container">
        <div class="ajax_response"><?= flash(); ?></div>

        <?php if(user()->subscription()) : ?>
        <div class="row text-start">
            <div class="col-12">
                <div class="callout callout-info">
                    <?= $message ?>
                </div>

                <!-- Main content -->
                <div class="invoice p-3 mb-3">
                    <!-- title row -->
                    <div class="row">
                        <div class="col-12">
                            <h4>
                                <?= CONF_SITE_NAME?>,
                                <small class="float-right">Data: <?= date("d/m/Y")?></small>
                            </h4>
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- info row -->
                    <div class="row invoice-info">
                        <div class="col-sm-4 invoice-col">
                            <address>
                                <strong>Plano</strong><br>
                                <?= user()->plan()->name ?><br>
                                Valor: R$ <?= str_price(user()->plan()->minimum_price) ?><br>
                                Periodo:  <?= ucfirst(translate(user()->plan()->interval)) ?>
                            </address>
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-4 invoice-col">
                            <address>
                                <strong>Pagamento</strong><br>
                                <?php foreach (user()->subscriptionPayment() as $key => $value): ?>
                                    <?= "<strong>{$key}</strong>: {$value}<br>"?>
                                <?php endforeach; ?>
                            </address>
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-4 invoice-col">
                            <strong>Assinatura #<?= user()->subscription()->id ?></strong><br>
                            <br>
                            <strong>Contratação:</strong> <?= date_fmt(user()->subscription()->start_at, "d/m/Y") ?><br>
                            <strong>Status:</strong> <?= ucfirst(translate(user()->subscription()->status)) ?>
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                    <?php if(!empty($transactions)): ?>
                    <div class="row">
                        <div class="col-12 table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Código</th>
                                        <th>Data</th>
                                        <th>Tipo</th>
                                        <th>Status</th>
                                        <th>Valor</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($transactions as $transaction): ?>
                                    <tr>
                                        <td><?= $transaction->code ?></td>
                                        <td><?= date_fmt_br($transaction->created_at) ?></td>
                                        <td><?= ucfirst(translate($transaction->transaction_type)) ?></td>
                                        <td><?= ucfirst(translate($transaction->status)) ?></td>
                                        <td>R$ <?= str_price($transaction->amount) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.col -->
                    </div>
                    <?php endif; ?>
                    <div class="row mt-3">
                        <!-- accepted payments column -->
                        <div class="col-6">
                            <p class="lead">Meios de pagamento:</p>
                            <i class="fa fa-credit-card"></i> Cartão de crédito
                            <i class="fa fa-barcode"></i> Boleto

                            <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">

                            </p>
                        </div>
                        <!-- /.col -->
                        <div class="col-6">
                            <p class="lead">Proximo pagamento <?= date_fmt(user()->subscription()->next_billing_at, "d/m/Y") ?></p>
                            <div class="table-responsive">
                                <table class="table">
                                    <tr>
                                        <th style="width:50%">Subtotal:</th>
                                        <td>R$ <?= str_price(user()->subscription()->plan()->minimum_price) ?></td>
                                    </tr>
                                    <tr>
                                        <th>Total:</th>
                                        <td>R$ <?= str_price(user()->subscription()->plan()->minimum_price) ?></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->

                    <!-- this row will not appear when printing -->
                    <div class="row no-print">
                        <div class="col-12">
                            <?php if(!empty($linkBoleto)): ?>
                                <a href="<?= $linkBoleto ?>" target="_blank">
                                    <button type="button" class="btn btn-primary float-right" style="margin-right: 5px;">
                                        <i class="fas fa-barcode"></i> Pagar Boleto
                                    </button>
                                </a>
                            <?php endif;?>
                        </div>
                    </div>
                </div>
                <!-- /.invoice -->
            </div><!-- /.col -->
        </div><!-- /.row -->
        <?php else: ?>
        <div class="row">
            <div class="col-lg-12 mb-5">
                <div class="above-heading">PLANOS</div>
                <h2 class="h2-heading">Tabela de planos</h2>
            </div> <!-- end of col -->
        </div> <!-- end of row -->
        <?php if(!empty($plans)): ?>
        <div class="row">
            <div class="col-lg-12">
                <?php foreach($plans as $plan): ?>
                <!-- Card-->
                <div class="card border-grey">
                    <div class="card-body">
                        <div class="card-title"><?= $plan->name ?></div>
                        <div class="price"><span class="currency">R$ </span><span class="value"><?= str_price($plan->minimum_price) ?></span></div>
                        <div class="frequency">Mensal</div>
                        <div class="divider"></div>
                        <?= $plan->benefits ?>
                        <div class="button-wrapper">
                            <a class="btn-solid-reg page-scroll" href="<?= url("/app/plan/checkout/{$plan->id}") ?>">CONTRATAR</a>
                        </div>
                    </div>
                </div> <!-- end of card -->
                <!-- end of card -->
                <?php endforeach; ?>
            </div> <!-- end of col -->
        </div> <!-- end of row -->
        <?php else: ?>
            <?= message()->warning("Ainda não existe nenhum plano no momento")->render() ?>
        <?php endif;
        endif; ?>
    </div> <!-- end of container -->
</div> <!-- end of cards-2 -->
<!-- end of pricing -->