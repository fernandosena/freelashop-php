<?php $v->layout("_theme"); ?>
<!-- Header -->
<header id="header" class="ex-2-header">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h1>Entrar</h1>
                <p>Ainda não tem uma conta? então <a class="white" href="<?= url("/cadastrar")?>"><strong>Cadastre-se</strong></a></p>
                <!-- Sign Up Form -->
                <div class="form-container">
                    <form class="auth_form" action="<?= url("/entrar"); ?>" method="post" data-toggle="validator" data-focus="false">
                        <!-- <div class="form-message">
                            <div id="lmsgSubmit" class="h3 text-center hidden"></div>
                        </div> -->
                        <div class="ajax_response"><?= flash(); ?></div>
                        <?= csrf_input(); ?>
                        <div class="form-group">
                            <input type="email" class="form-control-input <?= ($cookie ? "notEmpty": null); ?>" value="<?= ($cookie ?? null); ?>" id="lemail" name="email" required>
                            <label class="label-control" for="lemail">E-mail</label>
                            <div class="help-block with-errors"></div>
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control-input" id="lpassword" name="password" required>
                            <label class="label-control" for="lpassword">Senha</label>
                            <div class="help-block with-errors"></div>
                        </div>
                        <div class="form-group checkbox">
                            <input type="checkbox" name="save" <?= (!empty($cookie) ? "checked" : ""); ?> required> Lembrar dados?
                        </div>
                        <div class="form-group">
                            <button type="submit" class="form-control-submit-button">ENTRAR</button>
                        </div>
                        <div>
                            Esqueceu sua senha? <a href="<?= url("/recuperar")?>">clique aqui</a>
                        </div>
                    </form>
                </div> <!-- end of form container -->
                <!-- end of sign up form -->

            </div> <!-- end of col -->
        </div> <!-- end of row -->
    </div> <!-- end of container -->
</header> <!-- end of ex-header -->
<!-- end of header -->