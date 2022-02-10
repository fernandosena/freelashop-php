<?php $v->layout("_theme"); ?>

<!-- Privacy Content -->
<div class="ex-basic-2 mt-7">
    <div class="container">
        <?php $v->insert("views/breadcrumb"); ?>

        <?php if(!empty($faq_site) || !empty($faqs)): ?>
            <?php if(!empty($faqs)): ?>
                <h5 class="mb-3">Dúvidas dos <?= $faq_name?></h5>
                <div class="accordion" id="<?= $faq_name?>">
                    <?php $c0 = 0; foreach ($faqs as $faq): $c0++;?>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading<?= $faq_name.$c0 ?>">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#<?= $faq_name.$c0 ?>" aria-expanded="true" aria-controls="<?= $faq_name.$c0 ?>">
                                <?= str_code($faq->question) ?>
                            </button>
                        </h2>
                        <div id="<?= $faq_name.$c0 ?>" class="accordion-collapse collapse" aria-labelledby="heading<?= $faq_name.$c0 ?>" data-bs-parent="#<?= $faq_name?>">
                            <div class="accordion-body">
                                <?= str_code($faq->response) ?>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            <?php if(!empty($faq_site)): ?>
            <h5 class="mt-3">Dúvidas sobre o site</h5>
            <div class="accordion" id="site">
                <?php $c1 = 0; foreach ($faq_site as $question): $c1++;?>

                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingsite<?= $c1 ?>">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#site<?= $c1 ?>" aria-expanded="true" aria-controls="site<?= $c1 ?>">
                            <?= str_code($question->question) ?>
                        </button>
                    </h2>
                    <div id="site<?= $c1 ?>" class="accordion-collapse collapse" aria-labelledby="headingsite<?= $c1 ?>" data-bs-parent="#site">
                        <div class="accordion-body">
                            <?= str_code($question->response) ?>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <?php else: ?>
            <?= message()->warning("Nenhuma pergunta encontrada no momento, favor tente novamente mais tarde ou
             mande a sua pergunta para o nosso email <a href='mailto: ".CONF_MAIL_SUPPORT."'>".CONF_MAIL_SUPPORT."</a>"); ?>
        <?php endif; ?>
    </div>
</div>