<?php $v->layout("_theme"); ?>
<!-- Header -->
<header id="header" class="ex-header">
    <div class="container">
        <div class="row">
            <div class="col-md-12 mb-4">
                <h1><?= ($title ?? "BLOG"); ?></h1>
                <p class="text-white"><?= ($search ?? $desc ?? "Confira nossas dicas para tirar o seu sonho do papel"); ?></p>
            </div> <!-- end of col -->
            <div class="col-md-6 m-auto">
                <form name="search" action="<?= url("/blog/buscar"); ?>" method="post" enctype="multipart/form-data">
                    <input type="text" class="form-control search" name="s" placeholder="Encontre um artigo:" required/>
                </form>
            </div>
        </div> <!-- end of row -->
    </div> <!-- end of container -->
</header> <!-- end of ex-header -->
<!-- end of header -->

<!-- Privacy Content -->
<div class="ex-basic-2">
    <div class="container">
        <?php if (empty($blog) && !empty($search)): ?>
            <div class="content content">
                <div class="empty_content">
                    <h3 class="empty_content_title">Sua pesquisa não retornou resultados :/</h3>
                    <p class="empty_content_desc">Você pesquisou por <b><?= $search; ?></b>. Tente outros termos.</p>
                    <a class="empty_content_btn gradient gradient-green gradient-hover radius"
                       href="<?= url("/blog"); ?>" title="Blog">...ou volte ao blog</a>
                </div>
            </div>
        <?php elseif (empty($blog)): ?>
            <div class="content text-center">
                <div class="empty_content">
                    <h3 class="empty_content_title">Ainda estamos trabalhando aqui!</h3>
                    <p class="empty_content_desc">Nossos editores estão preparando um conteúdo de primeira para você.</p>
                </div>
            </div>
        <?php else: ?>
            <div class="blog_content">
                <div class="blog_articles">
                    <?php foreach ($blog as $post): ?>
                        <?php $v->insert("blog-list", ["post" => $post]); ?>
                    <?php endforeach; ?>
                </div>
                <?= $paginator; ?>
            </div>
        <?php endif; ?>
    </div>
</div>
