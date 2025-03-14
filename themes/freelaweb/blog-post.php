<?php $v->layout("_theme"); ?>

<div class="ex-basic-2 mt-7">
    <div class="container">
        <article class="post_page">
        <header class="post_page_header">
            <div class="post_page_hero">
                <h1><?= ucfirst($post->title) ?></h1>
                <img class="post_page_cover" alt="<?= $post->title; ?>" title="<?= $post->title; ?>"
                     src="<?= image($post->cover, 1280); ?>"/>
                <div class="post_page_meta">
                    <div class="author">
                        <div><img alt="<?= "{$post->author()->first_name} {$post->author()->last_name}"; ?>"
                                  title="<?= "{$post->author()->first_name} {$post->author()->last_name}"; ?>"
                                  src="<?= image($post->author()->photo, 150); ?>"/></div>
                        <div class="name">
                            Por: <?= str_limit_words($post->author()->fullName(), 2, ""); ?>
                        </div>
                    </div>
                    <div class="date">Dia <?= date_fmt($post->post_at); ?></div>
                </div>
            </div>
        </header>

        <div class="post_page_content">
            <div class="htmlchars" style="float: left">
                <h2 class="subtitle"><?= ucfirst($post->subtitle); ?></h2>
                <?= html_entity_decode(str_code($post->content)); ?>
            </div>
            <aside class="social_share">
                <h3 class="social_share_title icon-heartbeat">Ajude seus amigos a ver esse conteúdo:</h3>
                <div class="social_share_medias">
                    <!--facebook-->
                    <div class="fb-share-button" data-href="<?= url("/blog/{$post->uri}"); ?>" data-layout="button_count"
                         data-size="large"
                         data-mobile-iframe="true">
                        <a rel="nofollow" target="_blank"
                           href="https://www.facebook.com/sharer/sharer.php?u=<?= urlencode(url("/blog/{$post->uri}")); ?>"
                           class="fb-xfbml-parse-ignore">Compartilhar</a>
                    </div>

                    <!--twitter-->
                    <div class="btn-twitter">
                        <a rel="nofollow" href="https://twitter.com/share?ref_src=site" class="twitter-share-button" data-size="large"
                           data-text="<?= $post->title; ?>" data-url="<?= url("/blog/{$post->uri}"); ?>"
                           data-via="<?= str_replace("@", "", CONF_SOCIAL_TWITTER_CREATOR); ?>"
                           data-show-count="true">Tweet</a>
                    </div>
                </div>
            </aside>
        </div>

        <?php if (!empty($related)): ?>
            <div class="post_page_related content">
                <section>
                    <header class="post_page_related_header">
                        <h4>Veja também:</h4>
                        <p>Confira mais artigos relacionados e obtenha ainda mais dicas de controle para suas
                            contas.</p>
                    </header>

                    <div class="blog_articles">
                        <?php foreach ($related as $more): ?>
                            <?php $v->insert("blog-list", ["post" => $more]); ?>
                        <?php endforeach; ?>
                    </div>
                </section>
            </div>
        <?php endif; ?>
    </article>
    </div>
</div>
<?php $v->start("scripts"); ?>
    <div id="fb-root"></div>
    <script>(function (d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s);
            js.id = id;
            js.src = 'https://connect.facebook.net/pt_BR/sdk.js#xfbml=1&version=v3.1';
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));</script>

    <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
<?php $v->end(); ?>