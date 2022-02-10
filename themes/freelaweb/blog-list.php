<article class="blog_article">
    <a title="<?= $post->title; ?>" href="<?= url("/blog/{$post->uri}"); ?>">
        <img title="<?= $post->title; ?>" alt="<?= $post->title; ?>" src="<?= image($post->cover, 600, 340); ?>"/>
    </a>
    <header>
        <p class="meta">
            <a title="Artigos em <?= $post->category()->title; ?>"
               href="<?= url("/blog/em/{$post->category()->uri}"); ?>"><?= $post->category()->title; ?></a>
            &bull; Por <?= str_limit_words($post->author()->fullName(), 2, ""); ?>
            &bull; <?= date_fmt($post->post_at); ?>
        </p>
        <h3><a title="<?= $post->title; ?>" href="<?= url("/blog/{$post->uri}"); ?>"><?= $post->title; ?></a></h3>
        <p><a title="<?= $post->title; ?>" href="<?= url("/blog/{$post->uri}"); ?>">
                <?= str_limit_chars($post->subtitle, 120); ?></a></p>
    </header>
</article>