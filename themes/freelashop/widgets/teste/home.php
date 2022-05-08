<?php $v->layout("_theme"); ?>
<?php if(!empty($teste)): ?>
<section id="criar-projeto">
    <div class="centro">
        <div id="stepper1" class="bs-stepper">
            <?php foreach ($teste->questions() as $tab): ?>
            <div class="bs-stepper-header" role="tablist" style="display: none">
                <div class="bs-stepper-line"></div>
                <div class="step" data-target="#question<?= $tab->id ?>">
                    <button type="button" class="step-trigger" role="tab" id="stepper1trigger<?= $tab->id ?>" aria-controls="question<?= $tab->id ?>">
                        <span class="bs-stepper-circle"><?= $tab->id ?></span>
                        <span class="bs-stepper-label"><?= $tab->id ?></span>
                    </button>
                </div>
                <div class="bs-stepper-line"></div>
            </div>
            <?php endforeach; ?>
            <div class="bs-stepper-content">
                <div class="info">
                    <?= $info ?>
                    </p>
                    <h5>Não pode repetir a nota para em cada questão. são
                        <?= $quantidade ?> questões.</h5>

                </div>
                <form action="<?= url("/teste/{$teste->uri}/checkout")?>" method="post" class="form ajax_off" onsubmit="return false">
                    <?php $i = 1;$o = 1;foreach ($teste->questions() as $question): ?>
                    <div id="question<?= $question->id ?>" role="tabpanel" class="bs-stepper-pane" aria-labelledby="stepper1trigger<?= $question->id ?>">
                        <div class="card conta">
                            <div class="header">
                                <label class="label-qtd" data-qtd-question="<?= $teste->qtd_options ?>"><?= $i ?> - <?= $question->question ?></label>
                            </div>
                            <div class="body">
                                <?php $e = 1;foreach ($question->options() as $option): ?>
                                <div class="form-group form-group-flex">
                                    <div class="">
                                        <label for="first_name">
                                            <input type="text" autocomplete="off" class="form-control input" <?= ($e == 1) ? "autofocus" : null ?> data-question="<?= $question->id ?>" id="<?= $e ?>" name="<?= $o ?>">
                                            <?= $option->option ?>
                                        </label>
                                    </div>
                                </div>
                                <?php $e++;$o++; endforeach; ?>
                                <?php if($i == $quantidade): ?>
                                    <div class="grupo-btn">
                                        <input type="submit" class="no-link submit" value="TERMINAR">
                                    </div>
                                <?php else: ?>
                                <div class="grupo-btn">
                                    <button onclick="stepper1.next()" class="no-link proximo<?= $question->id ?>" disabled><a>Próximo</a></button>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <?php $i++; endforeach; ?>
                </form>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>