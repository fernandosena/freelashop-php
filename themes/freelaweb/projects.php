<?php $v->layout("_theme"); ?>

<div class="ex-basic-2 mt-7">
    <div class="container">
        <?php $v->insert("views/breadcrumb"); ?>
        <?php if(!empty($filter)): ?>
        <form class="auth_form" action="<?= url("/projetos/buscar"); ?>" method="post" data-toggle="validator" data-focus="false">
        <div class="ajax_response"><?= flash(); ?></div>
            <?= csrf_input(); ?>
            <input type="hidden" name="search" class="form-control" value="search">
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="inputCategoryForm">Categoria:</label>
                                <select id="inputCategoryForm" class="form-control inputCategoryForm" data-url="<?= url("/subcategoria") ?>" name="category" style="width: 100%;">
                                    <option value="all" disabled selected> &ofcir;Selecione uma categoria</option>
                                    <?php foreach ($categories as $category): ?>
                                        <option value="<?= $category->uri ?>"
                                            <?= (!empty($filter->category) && $filter->category == $category->uri ? "selected" : ""); ?>
                                        >&ofcir; <?= $category->title ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="inputSubCategoryForm">Subcategoria:</label>
                                <select id="inputSubCategoryForm" class="form-control" name="subcategory" style="width: 100%;">
                                    <option value="all" disabled selected>&ofcir; Todos</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Termos de pesquisa:</label>
                                <input type="search" name="terms" value="<?= ($filter->terms ?? null)?>" class="form-control" placeholder="Ex: habilidade(s) desejada(s)">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Tipo:</label>
                                <select class="form-control" name="type" style="width: 100%;">
                                    <option value="all" selected>Todos</option>
                                    <option value="fixed">Preço fixo</option>
                                    <option value="hour">Preço por hora</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-md btn-default">
                            PESQUISAR PROJETOS
                        </button>
                    </div>
                </div>
            </div>
        </form>
        <?php endif; ?>
        <?php
            $v->insert("views/projects-list");
            echo ($paginator ?? null);
        ?>
    </div>
</div>