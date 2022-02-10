<?php $v->layout("_admin"); ?>
<?php $v->insert("widgets/control/sidebar.php"); ?>

<section class="dash_content_app">
    <?php if (!$plan): ?>
        <header class="dash_content_app_header">
            <h2 class="icon-plus-circle">Novo Plano</h2>
        </header>

        <div class="dash_content_app_box">
            <form class="app_form" action="<?= url("/admin/control/plan"); ?>" method="post">
                <!--ACTION SPOOFING-->
                <input type="hidden" name="action" value="create"/>

                <div class="label_g2">
                    <label class="label">
                        <span class="legend">Plano:</span>
                        <input type="text" name="name" placeholder="Nome do plano" required/>
                    </label>
                    <label class="label">
                        <span class="legend">Preço:</span>
                        <input class="mask-money" type="text" name="minimum_price" required/>
                    </label>
                </div>

                <div class="label_g1">
                    <label class="label">
                        <span class="legend">Descrição:</span>
                        <textarea name="description" placeholder="Descrição" required></textarea>
                    </label>
                </div>
                <div class="label_g2">
                    <label class="label">
                        <span class="legend">Período:</span>
                        <select name="interval" required>
                            <option value="day">Diario</option>
                            <option value="week">Semanal</option>
                            <option value="month" selected>Mensal</option>
                            <option value="year">Anual</option>
                        </select>
                    </label>
                    <label class="label">
                        <span class="legend">Periodo quantidade:</span>
                        <select name="interval_count" required>
                            <option value="1" selected>1</option>
                            <?php for($i=2;$i<=6;$i++): ?>
                                <option value="<?= $i ?>"><?= $i ?></option>
                            <?php endfor; ?>
                        </select>
                    </label>
                </div>
                <div class="label_g2">
                    <label class="label">
                        <span class="legend">Nível:</span>
                        <select name="nivel" required>
                            <?php for($i=1;$i<=3;$i++): ?>
                                <option value="<?= $i ?>"><?= $i ?></option>
                            <?php endfor; ?>
                        </select>
                    </label>
                    <label class="label">
                        <span class="legend">Tipo:</span>
                        <select name="type" required>
                            <option value="freelancer" selected>freelancer</option>
                            <option value="contractor">Contratante</option>
                        </select>
                    </label>
                </div>
                <div class="label_g2">
                    <label class="label">
                        <span class="legend">Periodo de teste:</span>
                        <select name="trial_period_days">
                            <option value="" selected>Não aplicavel</option>
                            <?php for($i=1;$i<=28;$i++): ?>
                                <option value="<?= $i ?>"><?= $i ?> Dia(s)</option>
                            <?php endfor; ?>
                        </select>
                    </label>
                    <label class="label">
                        <span class="legend">Descrição na fatura:</span>
                        <input type="text" name="statement_descriptor" placeholder="Descrição na fatura" required/>
                    </label>
                </div>
                <div class="label_g1">
                    <label class="label">
                        <span class="legend">*Beneficios:</span>
                        <textarea id="codeMirrorDemo" name="benefits"></textarea>
                    </label>
                </div>

                <div class="al-right">
                    <button class="btn btn-green icon-check-square-o">Criar Plano</button>
                </div>
            </form>
        </div>
    <?php else: ?>
        <header class="dash_content_app_header">
            <h2 class="icon-pencil-square-o">Editar Plano</h2>
        </header>

        <div class="dash_content_app_box">
            <form class="app_form" action="<?= url("/admin/control/plan/{$plan->id}"); ?>" method="post">
                <!--ACTION SPOOFING-->
                <input type="hidden" name="action" value="update"/>

                <div class="label_g1">
                    <label class="label">
                        <span class="legend">Codigo:</span>
                        <input type="text" value="<?= $plan->code ?>" placeholder="Código" disabled/>
                    </label>
                </div>
                <div class="label_g2">
                    <label class="label">
                        <span class="legend">Plano:</span>
                        <input type="text" name="name" value="<?= $plan->name; ?>" required/>
                    </label>

                    <label class="label">
                        <span class="legend">Preço:</span>
                        <input class="mask-money" type="text" name="minimum_price"
                               value="<?= $plan->minimum_price ?>" required/>
                    </label>
                </div>

                <div class="label_g1">
                    <label class="label">
                        <span class="legend">Descrição:</span>
                        <textarea name="description" placeholder="Descrição" required><?= $plan->description ?></textarea>
                    </label>
                </div>

                <div class="label_g2">
                    <label class="label">
                        <span class="legend">*Período:</span>
                        <select name="interval" required>
                            <?php
                                $period = $plan->interval;
                                $selected = function ($value) use ($period) {
                                    return ($period == $value ? "selected" : "");
                                };
                            ?>
                            <option <?= $selected("day"); ?> value="day">Diario</option>
                            <option <?= $selected("week"); ?> value="week">Semanal</option>
                            <option <?= $selected("month"); ?> value="month">Mensal</option>
                            <option <?= $selected("year"); ?> value="year">Anual</option>
                        </select>
                    </label>

                    <label class="label">
                        <span class="legend">Periodo quantidade:</span>
                        <select name="interval_count" required>
                            <?php
                                $period = $plan->interval_count;
                                $selected = function ($value) use ($period) {
                                    return ($period == $value ? "selected" : "");
                                };
                            ?>
                            <option value="1" selected>1</option>
                            <?php for($i=2;$i<=6;$i++): ?>
                                <option <?= $selected($i); ?> value="<?= $i ?>"><?= $i ?></option>
                            <?php endfor; ?>
                        </select>
                    </label>
                </div>
                <div class="label_g2">
                    <label class="label">
                        <span class="legend">Nível:</span>
                        <select name="nivel" required>
                            <?php
                                $nivel = $plan->nivel;
                                $selected = function ($value) use ($nivel) {
                                    return ($nivel == $value ? "selected" : "");
                                };
                            ?>
                            <?php for($i=1;$i<=3;$i++): ?>
                                <option <?= $selected($i); ?> value="<?= $i ?>"><?= $i ?></option>
                            <?php endfor; ?>
                        </select>
                    </label>
                    <label class="label">
                        <span class="legend">Tipo:</span>
                        <select name="type" required>
                            <?php
                                $type = $plan->type;
                                $selected = function ($value) use ($type) {
                                    return ($type == $value ? "selected" : "");
                                };
                            ?>
                            <option <?= $selected("freelancer"); ?>  value="freelancer" selected>freelancer</option>
                            <option <?= $selected("contractor"); ?> value="contractor">Contratante</option>
                        </select>
                    </label>
                </div>
                <div class="label_g2">
                    <label class="label">
                        <span class="legend">Periodo de teste:</span>
                        <select name="trial_period_days">
                            <?php
                                $trial_period_days = $plan->trial_period_days;
                                $selected = function ($value) use ($trial_period_days) {
                                    return ($trial_period_days == $value ? "selected" : "");
                                };
                            ?>
                            <option <?= $selected(null); ?> value="">Não aplicavel</option>
                            <?php for($i=1;$i<=28;$i++): ?>
                                <option <?= $selected($i); ?> value="<?= $i ?>"><?= $i ?> Dia(s)</option>
                            <?php endfor; ?>
                        </select>
                    </label>
                    <label class="label">
                        <span class="legend">Descrição na fatura:</span>
                        <input type="text" value="<?=  $plan->statement_descriptor; ?>" name="statement_descriptor" placeholder="Descrição na fatura" required/>
                    </label>
                </div>
                <div class="label_g2">
                    <label class="label">
                        <span class="legend">*Status:</span>
                        <select name="status" required>
                            <?php
                            $status = $plan->status;
                            $selected = function ($value) use ($status) {
                                return ($status == $value ? "selected" : "");
                            };
                            ?>
                            <option <?= $selected("active"); ?> value="active">Ativo</option>
                            <option <?= $selected("inactive"); ?> value="inactive">Desativado</option>
                        </select>
                    </label>
                </div>

                <div class="label_g1">
                    <label class="label">
                        <span class="legend">*Beneficios:</span>
                        <textarea id="codeMirrorDemo" name="benefits" class="p-3"><?= $plan->benefits ?></textarea>
                    </label>
                </div>

                <div class="app_form_footer">
                    <button class="btn btn-blue icon-check-square-o">Atualizar</button>
                    <?php if (!$subscribers): ?>
                        <a href="#" class="remove_link icon-error"
                           data-post="<?= url("/admin/control/plan"); ?>"
                           data-action="delete"
                           data-confirm="Tem certeza que deseja excluir este plano?"
                           data-plan_id="<?= $plan->id; ?>">Excluir Plano</a>
                    <?php endif; ?>
                </div>
            </form>
        </div>
    <?php endif; ?>
</section>

<?php $v->start("scripts"); ?>
<script>
    CodeMirror.fromTextArea(document.getElementById("codeMirrorDemo"), {
        mode: "htmlmixed",
        theme: "monokai"
    });
</script>
<?php $v->stop(); ?>
