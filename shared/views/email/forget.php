<?php $v->layout("_theme", ["title" => "Recupere sua senha para acessar o ". CONF_SITE_NAME]); ?>

<h2>Perdeu sua senha <?= $first_name; ?>?</h2>
<p>Você está recebendo este e-mail pois foi solicitado a recuperação de senha no site do <?= CONF_SITE_NAME; ?>.</p>
<p><a title='Recuperar Senha' href='<?= $forget_link; ?>'>CLIQUE AQUI PARA CRIAR UMA NOVA SENHA</a></p>
<p><b>IMPORTANTE:</b> Se não foi você que solicitou ignore o e-mail. Seus dados permanecem seguros.</p>