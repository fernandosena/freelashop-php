<div class="row">
    <div class="col-md-12">
        <?php if(!empty($projects)): ?>
            <div class="card card-primary card-outline">
                <!-- /.card-header -->
                <div class="card-body p-0">
                    <table class="table border-white table-hover text-left">
                        <thead>
                        <tr>
                            <th>Criado</th>
                            <th>Projeto</th>
                            <th>Categoria</th>
                            <th>Orçamento</th>
                            <?php if(empty($filter)): ?>
                                <th>Status</th>
                            <?php endif;?>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($projects as $project): ?>
                            <tr data-widget="expandable-table" aria-expanded="false">
                                <td class="align-middle"><?= date_str_project($project->created_at)?>
                                <td class="align-middle">
                                    <strong>
                                        <a href="<?= url("/projetos/{$project->uri}") ?>"><?= $project->title ?></a>
                                    </strong>
                                </td>
                                <td class="align-middle"><strong><?= $project->category()->title ?></strong><br>
                                    Designs de logotipo e/ou identidade corporativa</td>
                                <td class="align-middle">
                                    <strong><?= $project->budget()->text ?></strong><br>
                                    <?= str_title(translate($project->type)) ?>
                                </td>
                                <?php if(empty($filter)): ?>
                                    <td class="align-middle">
                                        <span class="badge bg-<?= oolor_status($project->status)?>"><?= ucfirst(translate($project->status)) ?></span>
                                    </td>
                                <?php endif;?>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php else: ?>
            <?= ($message ?? null) ?>
        <?php endif; ?>
        <!-- /.card -->
    </div>
    <!-- /.col -->
</div>