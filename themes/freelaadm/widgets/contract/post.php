<?php $v->layout("_admin"); ?>
<?php $v->insert("widgets/contract/sidebar.php"); ?>
<section class="dash_content_app">
    <?php if ($contract): ?>
        <header class="dash_content_app_header">
            <h2 class="icon-pencil-square-o">Editar contrato #<?= $contract->id; ?></h2>
            <a class="icon-link btn btn-green" href="<?= url("/projetos/{$contract->project()->uri}"); ?>" target="_blank" title="">Ver projeto</a>
        </header>
        <div class="dash_content_app_box">
            <section class="app_dash_home_stats">
                <article class="control radius">
                    <h4 class="icon-pencil-square-o">Projeto</h4>
                    <p><strong>ID</strong> <?= $contract->project()->id; ?></p>
                    <p><strong>Autor</strong> <?= str_limit_words($contract->project()->author()->fullName(), 2, ''); ?></p>
                    <p><strong>Categoria</strong> <?= $contract->project()->category()->title; ?></p>
                    <p><strong>Subcategoria</strong> <?= $contract->project()->subcategory()->title; ?></p>
                    <p><strong>Titulo</strong> <?= $contract->project()->title; ?></p>
                    <p><strong>Local de trabalho</strong> <?= ucfirst(translate($contract->project()->localization)); ?></p>
                    <p><strong>Orçamento</strong> <?= $contract->project()->budget()->text; ?></p>
                    <p><strong>Tipo</strong> <?= ucfirst(translate($contract->project()->type)); ?></p>
                    <p><strong>Status</strong> <?= ucfirst(translate($contract->project()->status)); ?></p>
                    <p><strong>Cadastro</strong> <?= date_fmt_br($contract->project()->created_at); ?></p>
                    <p><strong>Atualização</strong> <?= date_fmt_br($contract->project()->updated_at); ?></p>
                </article>

                <article class="blog radius">
                    <h4 class="icon-paper-plane">Proposta</h4>
                    <p><strong>ID</strong> <?= $contract->proposal()->id; ?></p>
                    <p><strong>Usuário</strong> <?= str_limit_words($contract->proposal()->user()->fullName(), 2, ''); ?></p>
                    <p><strong>Porcentagem</strong> <?= $contract->proposal()->percentage; ?>%</p>
                    <p><strong>Valor bruto</strong> R$ <?= str_price($contract->proposal()->price); ?></p>
                    <p><strong>Valor liquido</strong> R$ <?= str_price(((100-$contract->proposal()->percentage)/100)*$contract->proposal()->price); ?></p>
                    <p><strong>Início</strong> <?= date_fmt($contract->proposal()->start, "d/m/Y"); ?></p>
                    <p><strong>Entrega</strong> <?= date_fmt($contract->proposal()->delivery, "d/m/Y"); ?></p>
                    <p><strong>Cadastro</strong> <?= date_fmt_br($contract->proposal()->created_at); ?></p>
                    <p><strong>Atualização</strong> <?= date_fmt_br($contract->proposal()->updated_at); ?></p>
                </article>

                <article class="users radius">
                    <h4 class="icon-user">Contrato</h4>
                    <p><strong>ID</strong> <?= $contract->id; ?></p>
                    <p><strong>Valor</strong> R$ <?= str_price($contract->price); ?></p>
                    <p><strong>Status</strong> <?= ucfirst(translate($contract->status)); ?></p>
                    <p><strong>Cadastro</strong> <?= date_fmt_br($contract->created_at); ?></p>
                    <p><strong>Atualização</strong> <?= date_fmt_br($contract->updated_at); ?></p>
                </article>
            </section>
        </div>
        <div class="dash_content_app_box">
            <form class="app_form" action="<?= url("/admin/contract/post/{$contract->id}"); ?>" method="post">
                <!-- ACTION SPOOFING-->
                <input type="hidden" name="action" value="update"/>
                <div class="label_g2">
                    <label class="label">
                        <span class="legend">*Status:</span>
                        <select name="status" required>
                            <?php
                            $status = $contract->status;
                            $select = function ($value) use ($status) {
                                return ($status == $value ? "selected" : "");
                            };
                            ?>
                            <option <?= $select("pending"); ?> value="pending">Pendente</option>
                            <option <?= $select("pay"); ?> value="pay">Pago</option>
                        </select>
                    </label>
                </div>

                <div class="al-right">
                    <button class="btn btn-blue icon-pencil-square-o">Atualizar</button>
                </div>
            </form>
        </div>
    <?php endif; ?>
</section>