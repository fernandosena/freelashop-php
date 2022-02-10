<?php $v->layout("_theme", ["title" => "Freelancer contratado"]); ?>

<h2>Olá <?= $name; ?>. o freelancer <strong><?= $freelancer; ?></strong> foi contratado com sucesso.</h2>
<p>Realize o pagamento para o freelancer iniciar o trabalho em seu projeto</p>
<p><a title='Realizar pagamento' href='<?= $pay_link; ?>'>Realizar pagamento</a></p>