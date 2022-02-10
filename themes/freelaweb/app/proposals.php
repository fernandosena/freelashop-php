<?php $v->layout("_theme"); ?>

<div class="ex-basic-2 mt-7">
    <div class="container">
        <?php $v->insert("views/breadcrumb"); ?>
        <div class="row">
            <?php if(!empty($proposals)): ?>
                <?php foreach ($proposals as $proposal): ?>
                    <?php
                        $v->insert("views/user", [
                            "subtitle" => ($proposal->user()->profission()->name ?? null),
                            "title" => $proposal->user()->fullName(),
                            "image" => $proposal->user()->photo(),
                            "description" => $proposal->user()->description,
                            "btnWarningLink" => url("/app/proposta/".$proposal->id),
                            "btnWarningTitle" => "Visualizar proposta"
                        ]);
                    ?>
                <?php endforeach; ?>
                <?= $paginator ?>
            <?php else: ?>
                <?= message()->warning("Nenhuma proposta encontrada")->render() ?>
            <?php endif; ?>
            <!-- /.card -->
        </div>
        <!-- /.col -->
    </div>
</div>