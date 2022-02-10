<?php $v->layout("_theme", ["title" => "Troca de senha realizada com sucesso"]); ?>

<h2>Sua senha foi alterada <?= $first_name; ?></h2>
<p>Você está recebendo este e-mail pois sua senha foi alterada no site do <?= CONF_SITE_NAME; ?> com sucesso.</p>
<p><b>IMPORTANTE:</b> Se não foi você que realizou essa troca de senha nos envie um e-mail para <a title='E-mail de suporte' href='mailto: <?= CONF_MAIL_SUPPORT; ?>'><?= CONF_MAIL_SUPPORT; ?></a></p>