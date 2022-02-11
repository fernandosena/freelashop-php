<?php $v->layout("_theme"); ?>

<div class="ex-basic-2 mt-7">
    <div class="container">
        <?php $v->insert("views/breadcrumb"); ?>
        <form class="auth_form" action="<?= url("/freelancers/buscar"); ?>" method="post" data-toggle="validator" data-focus="false">
            <div class="ajax_response"><?= flash(); ?></div>
            <input type="hidden" name="search" class="form-control" value="search">
            <?= csrf_input(); ?>
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="inputCategory">Categoria:</label>
                                <select id="inputCategory" class="form-control inputCategoryForm" data-url="<?= url("/subcategoria") ?>" name="category" style="width: 100%;">
                                    <option value="all" disabled selected> &ofcir;Selecione uma categoria</option>
                                    <?php foreach ($categories as $category): ?>
                                        <option value="<?= $category->uri ?>"
                                            <?= (!empty($filter->category) && $filter->category == $category->uri ? "selected" : ""); ?>
                                        >&ofcir; <?= $category->title ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Termos de pesquisa:</label>
                                <input type="search" name="terms" value="<?= ($filter->terms ?? null)?>"  class="form-control" placeholder="Ex: habilidade(s) desejada(s)">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-md btn-default">
                            PESQUISAR FREELANCER
                        </button>
                    </div>
                </div>
            </div>
        </form>
        <div class="row">
            <?php if(!empty($freelancers)): ?>
                <?php foreach ($freelancers as $freelancer): ?>
                    <?php
                    $v->insert("views/user", [
                        "subtitle" => ($freelancer->profission()->name ?? null),
                        "vip" => (!empty($freelancer->plan()->name) && ($freelancer->plan()->name == "PROFESSIONAL") && ($freelancer->subscription()->status == "paid") ? true : null),
                        "title" => $freelancer->fullName(),
                        "image" => $freelancer->photo(),
                        "description" => $freelancer->description,
                        "btnPrimaryLink" => url("/freelancers/perfil/".base64_encode($freelancer->email)),
                        "btnPrimaryTitle" => "Ver perfil"
                    ]);
                    ?>
                <?php endforeach; ?>
                <?= $paginator ?>
            <?php else: ?>
                <?= $message ?>
            <?php endif; ?>
            <!-- /.card -->
        </div>
    </div>
</div>