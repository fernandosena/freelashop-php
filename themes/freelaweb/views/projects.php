<div id="stepperForm" class="bs-stepper">
    <div class="bs-stepper-header" role="tablist">
        <div class="step" data-target="#test-form-1">
            <button type="button" class="step-trigger" role="tab" id="stepperFormTrigger1" aria-controls="test-form-1">
                <span class="bs-stepper-circle">1</span>
                <span class="bs-stepper-label">O que você precisa?</span>
            </button>
        </div>
        <div class="bs-stepper-line"></div>
        <div class="step" data-target="#test-form-2">
            <button type="button" class="step-trigger" role="tab" id="stepperFormTrigger2" aria-controls="test-form-2">
                <span class="bs-stepper-circle">2</span>
                <span class="bs-stepper-label">Realização</span>
            </button>
        </div>
        <div class="bs-stepper-line"></div>
        <div class="step" data-target="#test-form-3">
            <button type="button" class="step-trigger" role="tab" id="stepperFormTrigger3" aria-controls="test-form-3">
                <span class="bs-stepper-circle">3</span>
                <span class="bs-stepper-label">Descrição do projeto</span>
            </button>
        </div>
    </div>
    <div class="bs-stepper-content">
        <form class="auth_form" action="<?= url("/criar-projeto"); ?>" method="post" novalidate>
            <div class="ajax_response"><?= flash(); ?></div>
            <input type="hidden" name="action" id="action" value="" data-action="<?= ($inputAction ?? "create")?>" required>
            <?php
                if(!empty($inputAction)){
            ?>
                    <input type="hidden" name="project" value="<?= ($project->id ?? null)?>">
            <?php
                }
            ?>
            <?= csrf_input(); ?>
            <!-- Part 1 -->
            <div id="test-form-1" role="tabpanel" class="bs-stepper-pane fade" aria-labelledby="stepperFormTrigger1">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="inputTitleForm">Título <span class="text-danger font-weight-bold">*</span></label>
                            <input id="inputTitleForm" type="text" name="title" class="form-control" placeholder="Titulo do projeto" value="<?= ($project->title ?? null)?>" required>
                            <div class="invalid-feedback">Campo Obrigatório</div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="inputCategoryForm">Categoria <span class="text-danger font-weight-bold">*</span></label>
                            <?php
                                $category = ($project->category_id ?? null);
                                $select = function ($value) use ($category) {
                                    return ($category == $value ? "selected" : "");
                                };
                            ?>
                            <select id="inputCategoryForm" data-url="<?= url("/subcategoria") ?>" name="category" class="form-control inputCategoryForm" placeholder="Selecione uma categoria" required>
                                <option value="" disabled selected>&ofcir;  Selecione uma categoria</option>
                                <?php foreach ($categories as $categorie): ?>
                                    <option value="<?= $categorie->uri ?>" <?= $select($categorie->id) ?>>&ofcir; <?= $categorie->title ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback">Campo Obrigatório</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="inputSubCategoryForm">Subcategoria <span class="text-danger font-weight-bold">*</span></label>
                            <select id="inputSubCategoryForm" name="subcategory" class="form-control" placeholder="Selecione uma subcategoria" required>
                                <option value="" disabled selected>&ofcir; Selecione uma subcategoria</option>
                                <?=
                                    (!empty($project->subcategory_id) ? '<option value="'.$project->subcategory_id.'" selected>&ofcir; '.$project->subcategory()->title.'</option>': '>')
                                ?>
                            </select>
                            <div class="invalid-feedback">Campo Obrigatório</div>
                        </div>
                    </div>
                </div>
                <?php if(!user()) : ?>
                    <hr>
                    <div class="cadastre-se">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="inputFirstNameForm">Primeiro nome <span class="text-danger font-weight-bold">*</span></label>
                                    <input autocomplete="off" id="inputFirstNameForm" name="first_name" type="text" class="form-control" placeholder="Seu primeiro nome" required>
                                    <div class="invalid-feedback">Campo Obrigatório</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="inputLastNameForm">Sobrenome <span class="text-danger font-weight-bold">*</span></label>
                                    <input autocomplete="off" id="inputLastNameForm" name="last_name" type="text" class="form-control" placeholder="Seu sobrenome" required>
                                    <div class="invalid-feedback">Campo Obrigatório</div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="inputMailForm">E-mail <span class="text-danger font-weight-bold">*</span></label>
                                    <input autocomplete="off" id="inputMailForm" name="email" type="email" class="form-control" placeholder="Seu e-mail" required>
                                    <div class="invalid-feedback">Campo Obrigatório</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="inputCellForm">Celular <span class="text-danger font-weight-bold">*</span></label>
                                    <input autocomplete="off" id="inputCellForm" name="cell" type="text" class="form-control mask-cell" placeholder="Seu número de telefone" required>
                                    <div class="invalid-feedback">Campo Obrigatório</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="inputPasswordForm">Senha <span class="text-danger font-weight-bold">*</span></label>
                                <input autocomplete="off" id="inputPasswordForm" name="password" type="password" class="form-control" placeholder="Senha" required>
                                <div class="invalid-feedback">Campo Obrigatório</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="inputPasswordRepeatForm">Repita a senha <span class="text-danger font-weight-bold">*</span></label>
                                <input autocomplete="off" id="inputPasswordRepeatForm" name="password_repeat" type="password" class="form-control" placeholder="Repita a senha" required>
                                <div class="invalid-feedback">Campo Obrigatório</div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                <button class="btn btn-primary btn-next-form">Proximo</button>
            </div>

            <!-- Part 2 -->
            <div id="test-form-2" role="tabpanel" class="bs-stepper-pane fade" aria-labelledby="stepperFormTrigger2">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="inputBudgetForm">Orçamento <span class="text-danger font-weight-bold">*</span></label>
                            <?php
                            $budget = ($project->budget ?? null);
                            $select = function ($value) use ($budget) {
                                return ($budget == $value ? "selected" : "");
                            };
                            ?>
                            <select id="inputBudgetForm" name="budget" class="form-control" placeholder="Selecione uma categoria" required>
                                <?php foreach ($budgets as $budget): ?>
                                    <option value="<?= $budget->id ?>" <?= (empty($project->budget)) ? ($budget->id == 4) ? "selected" : "": $select($budget->id) ?>>&ofcir; <?= $budget->text ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback">Campo Obrigatório</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="inputLocalizationForm">Local de trabalho <span class="text-danger font-weight-bold">*</span></label>
                            <select id="inputLocalizationForm" name="localization" class="form-control" placeholder="Selecione uma subcategoria" required>
                                <option value="remote" selected>&ofcir; Remoto</option>
                            </select>
                            <div class="invalid-feedback">Campo Obrigatório</div>
                        </div>
                    </div>
                </div>
                <button class="btn btn-primary btn-previous" onclick="stepperForm.previous()">Anterior</button>
                <button class="btn btn-primary btn-next-form">Próximo</button>
            </div>

            <!-- Part 3 -->
            <div id="test-form-3" role="tabpanel" class="bs-stepper-pane fade" aria-labelledby="stepperFormTrigger3">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="inputContentForm">Descrição <span class="text-danger font-weight-bold">*</span></label>
                            <textarea autocomplete="off" id="inputContentForm" class="form-control" name="content" placeholder="Descreva detalhes do seu projeto de forma mais clara possivel. Dessa forma você terá mais acertos ao encontrar o freelancer" required><?= (!empty($project->content)) ? str_textarea_reverse($project->content) : null ?></textarea>
                            <div class="invalid-feedback">Campo Obrigatório</div>
                        </div>
                    </div>
                </div>
                <div class="form-group checkbox">
                    Ao cadastrar projeto você confirma que leu e concorda com todas as <a href="<?= url("/politica-de-privacidade") ?>" class="link-underline">Política de Privacidade</a> e com todos os <a href="<?= url("/termos-de-uso") ?>" class="link-underline">Termos de Uso</a> descritos no <?= CONF_SITE_NAME ?>
                </div>
                <button class="btn btn-primary btn-previous" onclick="stepperForm.previous()" >Anterior</button>
                <button type="submit" class="btn btn-primary btn-next">Publicar projeto</button>
            </div>
        </form>
    </div>
</div>