<?php $v->layout("_theme", ["title" => "Novo projeto criado "]); ?>

<h2>Novo Projeto criado no <?= CONF_SITE_NAME ?> </h2>
<p>Olá <?= $first_name ?>,</p>
<p>Um novo projeto com o título <strong><?= $title_project ?></strong> foi postado no <?= CONF_SITE_NAME ?>.</p>
<p>Clique no botão abaixo para ver o projeto.</p>
<p><a title='<?= $title_project ?>' href='<?= $project_link; ?>'>VER PROJETO</a></p>