<?php $v->layout("_admin"); ?>
<?php $v->insert("widgets/project/sidebar.php", ["balance"=>$balance]); ?>

<section class="dash_content_app">
    <header class="dash_content_app_header">
        <h2 class="icon-pencil-square-o">Projeto</h2>
        <form action="<?= url("/admin/project/home"); ?>" method="post" class="app_search_form">
            <input type="text" name="s" value="<?= $search; ?>" placeholder="Pesquisar projeto:">
            <button class="icon-search icon-notext"></button>
        </form>
    </header>

    <div class="dash_content_app_box">
        <section>
            <div class="app_blog_home">
                <?php if (!$posts): ?>
                    <div class="message info icon-info">Ainda não existem projeto cadastrados.</div>
                <?php else: ?>
                    <?php foreach ($posts as $post):
                        $postCover = ($post->cover ? image($post->cover, 300) : "");
                        ?>
                        <article>
                            <div style="background-image: url(<?= $postCover; ?>);"
                                 class="cover embed radius"></div>
                            <h3 class="tittle">
                                <a target="_blank" href=" <?= url("/projetos/{$post->uri}"); ?>">
                                    <span><?= $post->title; ?></span>
                                </a>
                            </h3>

                            <div class="info">
                                <p class="icon-pencil-square-o"><span class="badge bg-warning"><?= ucfirst(translate($post->status))?></span></p>
                                <p class="icon-clock-o"><?= date_fmt($post->post_at, "d.m.y \à\s H\hi"); ?></p>
                                <p class="icon-bookmark"><?= $post->category()->title; ?></p>
                                <p class="icon-user"><?= $post->author()->fullName(); ?></p>
                                <p class="icon-bar-chart"><?= $post->views; ?></p>
                            </div>

                            <div class="actions">
                                <?php $uri = explode("/",$app) ?>
                                <a class="icon-pencil btn btn-blue" title=""
                                   href="<?= url("/admin/project/post/{$post->id}"); ?>">Editar</a>
                            </div>
                        </article>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <?= $paginator; ?>
        </section>
    </div>
</section>