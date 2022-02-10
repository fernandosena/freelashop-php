<?php $v->layout("_admin"); ?>
<?php $v->insert("widgets/project/sidebar.php", ["balance"=>$balance]); ?>
<section class="dash_content_app">
    <?php if ($post): ?>
        <header class="dash_content_app_header">
            <h2 class="icon-pencil-square-o">Editar projeto #<?= $post->id; ?></h2>
            <a class="icon-link btn btn-green" href="<?= url("/projetos/{$post->uri}"); ?>" target="_blank" title="">Ver no
                site</a>
        </header>
        <div class="dash_content_app_box">
            <section class="app_dash_home_stats_1">
                <article class="control radius">
                    <h4 class="icon-pencil-square-o">Projeto</h4>
                    <p><strong>ID</strong> <?= $post->id; ?></p>
                    <p><strong>Author</strong> <?= $post->author()->fullName(); ?></p>
                    <p><strong>Categoria</strong> <?= $post->category()->title; ?></p>
                    <p><strong>Subcategoria</strong> <?= $post->subcategory()->title; ?></p>
                    <p><strong>Titulo</strong> <?= $post->title; ?></p>
                    <p><strong>Conteúdo</strong> <?= $post->content; ?></p>
                    <p><strong>Local de trabalho</strong> <?= ucfirst(translate($post->localization)); ?></p>
                    <p><strong>Orçamento</strong> <?= $post->budget()->text; ?></p>
                    <p><strong>Tipo</strong> <?= ucfirst(translate($post->type)); ?></p>
                    <p><strong>Status</strong> <?= ucfirst(translate($post->status)); ?></p>
                    <p><strong>Cadastro</strong> <?= date_fmt_br($post->created_at); ?></p>
                    <p><strong>Atualização</strong> <?= date_fmt_br($post->updated_at); ?></p>
                </article>
            </section>
        </div>
        <div class="dash_content_app_box">
            <form class="app_form" action="<?= url("/admin/project/post/{$post->id}"); ?>" method="post">
                <!-- ACTION SPOOFING-->
                <input type="hidden" name="action" value="update"/>
                <?php
                    if(!empty($options)){
                ?>
                <div class="label_g2">
                    <label class="label">
                        <span class="legend">*Status:</span>
                        <select name="status" required>
                            <?php
                            $status = $post->status;
                            $select = function ($value) use ($status) {
                                return ($status == $value ? "selected" : "");
                            };
                            foreach ($options as $option) {
                            ?>
                                <option <?= $select($option); ?> value="<?= $option ?>"><?= ucfirst(translate($option)) ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </label>
                    <div class="al-right">
                        <button class="btn btn-blue icon-pencil-square-o">Atualizar</button>
                    </div>
                </div>
                <?php
                    }
                ?>

            </form>
        </div>
    <?php endif; ?>
</section>