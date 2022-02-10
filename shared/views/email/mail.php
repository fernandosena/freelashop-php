<?php $v->layout("_theme", ["title" => $subject]); ?>

<?= $message; ?>
<?php if(isset($project)): ?>
<h2>Dados do projeto</h2>
<p><label>ID: </label><label><?= $project->id ?></label></p>
<p><label>Titulo: </label><label><?= $project->title ?></label></p>
<p><label>URI: </label><label><?= $project->uri ?></label></p>
<p><label>Cadastro: </label><label><?= $project->create_at ?></label></p>
<?php endif;?>
