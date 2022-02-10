<?php $v->layout("_admin"); ?>
<?php $v->insert("widgets/contract/sidebar.php"); ?>

<section class="dash_content_app">
    <header class="dash_content_app_header">
        <h2 class="icon-pencil-square-o">Projeto</h2>
        <form action="<?= url("/admin/contract/home"); ?>" method="post" class="app_search_form">
            <input type="text" name="s" value="<?= $search; ?>" placeholder="Pesquisar projeto:">
            <button class="icon-search icon-notext"></button>
        </form>
    </header>

    <div class="dash_content_app_box">
        <section>
            <div class="app_blog_home">
                <?php if (!$contracts): ?>
                    <div class="message info icon-info">Ainda não existem projeto cadastrados.</div>
                <?php else: ?>
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Projeto</th>
                                <th>Valor</th>
                                <th>Status</th>
                                <th>Opções</th>
                            </tr>
                        </thead>
                        <tbody>
                    <?php
                        foreach ($contracts as $contract):
                    ?>
                        <tr>
                            <td><?= $contract->id; ?></td>
                            <td>
                                <h3 class="tittle">
                                    <a target="_blank" href=" <?= url("/projetos/{$contract->project()->uri}"); ?>">
                                        <span><?= $contract->project()->title; ?></span>
                                    </a>
                                </h3>
                            </td>
                            <td><p>R$ <?= str_price($contract->price) ?></p></td>
                            <td>
                                <span class="badge bg-<?= oolor_status($contract->status)?>">
                                    <?= ucfirst(translate($contract->status)) ?>
                                </span>
                            </td>
                            <td>
                                <div class="actions">
                                    <a class="icon-pencil btn btn-blue" title=""
                                       href="<?= url("/admin/contract/post/{$contract->id}"); ?>">Editar</a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>

            <?= $paginator; ?>
        </section>
    </div>
</section>