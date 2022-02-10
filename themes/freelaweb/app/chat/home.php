<?php $v->layout("_theme"); ?>
<div class="ex-basic-2 mt-7">
    <div class="container">
        <?php $v->insert("views/breadcrumb"); ?>
        <div class="row">
            <?php if(!empty($rooms)): ?>
                <?php foreach ($rooms as $room): ?>
                    <?php
                    $v->insert("views/user", [
                        "subtitle" => "<a href='".url("projetos/".$room->project()->uri)."'>{$room->project()->title}</a>",
                        "vip" => (!empty($room->proposal()->user()->plan()->name) && ($room->proposal()->user()->plan()->name == "PROFESSIONAL") && ($room->proposal()->user()->subscription()->status == "paid") ? true : null),
                        "title" => $room->proposal()->user()->fullName(),
                        "image" => $room->proposal()->user()->photo(),
                        "btnPrimaryLink" => url("/app/chat/{$room->id}"),
                        "btnPrimaryTitle" => "Chat com o freelancer",
                        "btnPrimaryValueBadge" => $room->chat(),
                        "btnWarningLink" => url("/app/proposta/{$room->proposal_id}"),
                        "btnWarningTitle" => "Ver proposta"
                    ]);
                    ?>
                <?php endforeach; ?>
                <?= $paginator ?>
            <?php else: ?>
                <?= message()->warning("Você ainda não tem nenhuma mensagem")->render() ?>
            <?php endif; ?>
            <!-- /.card -->
        </div>
    </div>
</div>
