<?php $v->layout("_theme"); ?>
<!-- Header -->
<header id="header" class="ex-2-header">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h1>Cadastrar</h1>
               <p>
                   Tem uma conta? então, basta fazer
                   seu <a class="white" href="<?= url("/entrar")?>"><strong>Login</strong></a>
               </p>
                <!-- Sign Up Form -->
                <div class="form-container">
                    <ul class="nav  nav-justified nav-tabs myTabRegister" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Contratante</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Freelancer</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                            <form class="auth_form" action="<?= url("/cadastrar"); ?>" method="post" data-toggle="validator" data-focus="false">
                                <div class="ajax_response"><?= flash(); ?></div>
                                <input type="hidden" value="<?= session()->csrf_token; ?>" name="csrf" required>
                                <input type="hidden" value="contractor" name="type" required>
                                <div class="form-group">
                                    <input type="text" autocomplete="off" class="form-control-input" id="snome" name="first_name" required>
                                    <label class="label-control" for="snome">Nome <span class="text-danger font-weight-bold">*</span></label>
                                    <div class="help-block with-errors"></div>
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control-input" id="ssobrenome" name="last_name" autocomplete="off" required>
                                    <label class="label-control" for="ssobrenome">Sobrenome <span class="text-danger font-weight-bold">*</span></label>
                                    <div class="help-block with-errors"></div>
                                </div>
                                <div class="form-group">
                                    <input type="email" class="form-control-input" id="semail" name="email" autocomplete="off" required>
                                    <label class="label-control" for="semail">E-mail <span class="text-danger font-weight-bold">*</span></label>
                                    <div class="help-block with-errors"></div>
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control-input mask-cell notEmpty" id="scelular" name="cell" autocomplete="off" required>
                                    <label class="label-control" for="scelular">Número de Celular <span class="text-danger font-weight-bold">*</span></label>
                                    <div class="help-block with-errors"></div>
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control-input" id="spassword" name="password" autocomplete="off" required>
                                    <label class="label-control" for="spassword">Senha <span class="text-danger font-weight-bold">*</span></label>
                                    <div class="help-block with-errors"></div>
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control-input" id="spasswordrepeat" name="password_repeat" autocomplete="off" required>
                                    <label class="label-control" for="spasswordrepeat">Repita a senha <span class="text-danger font-weight-bold">*</span></label>
                                    <div class="help-block with-errors"></div>
                                </div>
                                <div class="form-group checkbox">
                                    Ao se cadastrar você confirma que leu e concorda com todas as nossas <a href="<?= url("/politica-de-privacidade") ?>" class="link-underline">Políticas de Privacidade</a> e com todos os <a href="<?= url("/termos-de-uso") ?>" class="link-underline">Termos de Uso</a> escritos no <?= CONF_SITE_NAME ?>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="form-control-submit-button">CADASTRAR</button>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                            <form class="auth_form" action="<?= url("/cadastrar"); ?>" method="post" data-toggle="validator" data-focus="false">
                                <div class="ajax_response"><?= flash(); ?></div>
                                <input type="hidden" value="<?= session()->csrf_token; ?>" name="csrf" required>
                                <input type="hidden" value="freelancer" name="type" required>
                                <div class="form-group">
                                    <input type="text" autocomplete="off" class="form-control-input" id="snome" name="first_name" required>
                                    <label class="label-control" for="snome">Nome <span class="text-danger font-weight-bold">*</span></label>
                                    <div class="help-block with-errors"></div>
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control-input" id="ssobrenome" name="last_name" autocomplete="off" required>
                                    <label class="label-control" for="ssobrenome">Sobrenome <span class="text-danger font-weight-bold">*</span></label>
                                    <div class="help-block with-errors"></div>
                                </div>
                                <div class="form-group">
                                    <input type="email" class="form-control-input" id="semail" name="email" autocomplete="off" required>
                                    <label class="label-control" for="semail">E-mail <span class="text-danger font-weight-bold">*</span></label>
                                    <div class="help-block with-errors"></div>
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control-input mask-cell notEmpty" id="scelular" name="cell" autocomplete="off" required>
                                    <label class="label-control" for="scelular">Número de Celular <span class="text-danger font-weight-bold">*</span></label>
                                    <div class="help-block with-errors"></div>
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control-input" id="spassword" name="password" autocomplete="off" required>
                                    <label class="label-control" for="spassword">Senha <span class="text-danger font-weight-bold">*</span></label>
                                    <div class="help-block with-errors"></div>
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control-input" id="spasswordrepeat" name="password_repeat" autocomplete="off" required>
                                    <label class="label-control" for="spasswordrepeat">Repita a senha <span class="text-danger font-weight-bold">*</span></label>
                                    <div class="help-block with-errors"></div>
                                </div>
                                <div class="form-group checkbox">
                                    Ao se cadastrar você confirma que leu e concorda com todas as nossas <a href="<?= url("/politica-de-privacidade") ?>" class="link-underline">Políticas de Privacidade</a> e com todos os <a href="<?= url("/termos-de-uso") ?>" class="link-underline">Termos de Uso</a> escritos no <?= CONF_SITE_NAME ?>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="form-control-submit-button">CADASTRAR</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div> <!-- end of form container -->
                <!-- end of sign up form -->
            </div> <!-- end of col -->
        </div> <!-- end of row -->
    </div> <!-- end of container -->
</header> <!-- end of ex-header -->
<!-- end of header -->
