<?php $v->layout("_theme", ["title" => "Cadastro de criado"]); ?>

<h2>Olá <?= $first_name; ?>. Seu projeto "<?= $project_name; ?>" foi <?= $msg; ?> com sucesso!</h2>
<p>Aguarde enquanto nossos especialistas avaliam para poder coloca-lo no ar, caso esteja tudo nos conformes o
    projeto ficará disponível na plataforma <?= CONF_SITE_NAME ?> em até <strong>48h</strong>.</p>
<p><a title="Ver projeto" href="<?= $link; ?>">CLIQUE AQUI PARA VER SEU PROJETOR</a></p>