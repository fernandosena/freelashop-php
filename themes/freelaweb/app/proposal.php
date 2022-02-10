<?php $v->layout("_theme"); ?>

<div class="ex-basic-2 mt-7">
    <div class="container">
        <?php $v->insert("views/breadcrumb"); ?>
        <?php if(!empty($proposal)): ?>
        <div class="row">
            <div class="col-12">
                <h2 class="text-primary"> <?= $proposal->project()->title ?></h2>
            </div>
            <?= $message; ?>
            <div class="col-12 col-md-12 col-lg-8 order-2 order-md-1 mb-3 mt-3">
                <div class="row">
                    <div class="col-12 col-sm-4">
                        <div class="info-box bg-light">
                            <div class="info-box-content">
                                <span class="info-box-number text-center text-muted"><strong>Valor</strong></span>
                                <span class="info-box-text text-center text-muted mb-0">
                                    <?= ($proposal->price) ? "R$ ".str_price($proposal->price) : "<span class='text-danger'><i class='fa-solid fa-xmark'></i> A definir</span>" ?>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-4">
                        <div class="info-box bg-light">
                            <div class="info-box-content">
                                <span class="info-box-number text-center text-muted"><strong>Início</strong></span>
                                <span class="info-box-text text-center text-muted mb-0">
                                    <?= ($proposal->start) ? date_fmt($proposal->start, "d/m/Y") : "<span class='text-danger'><i class='fa-solid fa-xmark'></i> A definir</span>" ?>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-4">
                        <div class="info-box bg-light">
                            <div class="info-box-content">
                                <span class="info-box-number text-center text-muted"><strong>Entrega</strong></span>
                                <span class="info-box-text text-center text-muted mb-0">
                                    <?= ($proposal->delivery) ? date_fmt($proposal->delivery, "d/m/Y") : "<span class='text-danger'><i class='fa-solid fa-xmark'></i> A definir</span>" ?>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="mb-3">
                            <h5><strong>Descrição da proposta</strong></h5>
                        </div>
                        <div class="post">
                            <div class="p-3">
                                <!-- /.user-block -->
                                <?= $proposal->content?>
                            </div>
                            <?= ($buttom ?? null) ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-12 col-lg-4 order-1 order-md-2">
                <p>Freelancer</p>
                <div class="card-body box-profile ">
                    <div class="text-center list-user">
                        <img class="profile-user-img img-fluid img-circle" src="<?= image($proposal->user()->photo, 150, 150) ?>" alt="">
                    </div>
                    <h3 class="profile-username text-center"><?= "{$proposal->user()->fullName()}" ?></h3>
                </div>
                <?= ($action ?? null) ?>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>
<?php if(user()): ?>
    <?php if(user()->id == $proposal->user_id): ?>
        <?= $v->insert("views/modal", ["id"=>"modal-proposal","modal"=>"proposal"]); ?>
    <?php endif; ?>
    <?= $v->insert("views/modal", ["id"=>"service-contract","modal"=>"service-contract"]); ?>
<?php endif; ?>