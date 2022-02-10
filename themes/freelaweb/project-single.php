<?php $v->layout("_theme"); ?>
<div class="ex-basic-2 mt-7">
    <div class="container">
        <?php $v->insert("views/breadcrumb"); ?>
        <div class="ajax_response"><?= flash(); ?></div>
<?php
if(!empty($project)):
    ?>
    <div class="card">
        <div class="card-body">
            <?= $message; ?>
            <div class="row">
                <div class="col-12">
                    <h2 class="text-primary"> <?= $project->title ?></h2>
                </div>
                <div class="col-12 col-md-12 col-lg-8 order-2 order-md-1 mb-3 mt-3">
                    <div class="row">
                        <div class="col-12 col-sm-4">
                            <div class="info-box bg-light">
                                <div class="info-box-content">
                                    <span class="info-box-number text-center text-muted"><strong><?= $project->category()->title ?></strong></span>
                                    <span class="info-box-text text-center text-muted mb-0"><?= $project->subcategory()->title ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-4">
                            <div class="info-box bg-light">
                                <div class="info-box-content">
                                    <span class="info-box-number text-center text-muted"><strong><?= $project->budget()->text ?></strong></span>
                                    <span class="info-box-text text-center text-muted mb-0"><?= ucfirst(translate($project->localization)) ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-4">
                            <div class="info-box bg-light">
                                <div class="info-box-content">
                                    <span class="info-box-number text-center text-muted"><strong>Status</strong></span>
                                    <span class="info-box-text text-center text-muted mb-0"><span class="badge bg-<?= oolor_status($project->status)?>"><?= ucfirst(translate($project->status)) ?></span></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="mb-3">
                                <h5><strong>Descrição do Projeto</strong></h5>
                            </div>
                            <div class="post">
                                <div class="p-3">
                                    <!-- /.user-block -->
                                    <?= $project->content?>
                                </div>
                                <?= ($buttom ?? null) ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-12 col-lg-4 order-1 order-md-2">
                    <p>Empregador</p>
                    <div class="card-body box-profile">
                        <div class="text-center">
                            <img class="profile-user-img img-fluid img-circle" src="<?= image($project->author()->photo, 150, 150) ?>" alt="<?= $project->author()->first_name?>">
                        </div>

                        <h3 class="profile-username text-center"><?= "{$project->author()->first_name} {$project->author()->last_name}" ?></h3>

                        <ul class="list-group">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Projetos criados
                                <span class="badge bg-primary badge-pill"><?= $project->balance($project->author())->full ?></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Projetos ativos
                                <span class="badge bg-primary badge-pill"><?= $project->balance($project->author())->accepted ?></span>
                            </li>
                        </ul>
                    </div>
                    <br>
                    <div class="text-muted">
                        <p class="text-sm">Cadastro
                            <b class="d-block"><?= date_str($project->created_at) ?></b>
                        </p>
                        <p class="text-sm">Propostas
                            <b class="d-block"><?= $project->proposal()->count() ?> Proposta(s)</b>
                        </p>
                    </div>
                    <?= ($action ?? null) ?>
                </div>
            </div>
        </div>
        <!-- /.card-body -->
    </div>
<?php endif; ?>
    </div>
</div>
<?php if(user()): ?>
    <?= $v->insert("views/modal", ["id"=>"modal-problem","modal"=>"problem"]); ?>
    <?= $v->insert("views/modal", ["id"=>"modal-project","modal"=>"projects", "inputAction"=>"update"]); ?>
    <?= $v->insert("views/modal", ["id"=>"modal-proposal","modal"=>"proposal"]); ?>
    <?= $v->insert("views/modal", ["id"=>"service-contract","modal"=>"service-contract"]); ?>
<?php endif; ?>
