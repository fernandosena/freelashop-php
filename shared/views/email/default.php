<?php $v->layout("_theme"); ?>

<h2><?= $title; ?></h2>
<?= $message; ?>

<?php if(!empty($title_link) && !empty($link)): ?>
<p><a title='<?= $title_link ?>' href='<?= $link; ?>'><?= $title_link ?></a></p>
<?php endif; ?>
