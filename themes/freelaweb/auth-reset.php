<?php $v->layout("_theme"); ?>

<!-- Privacy Content -->
<div class="ex-basic-2 mt-7">
    <div class="container">
        <div class="mb-5 p-4 bg-white">
            <div class="row">
                <div class="col-md-5 m-auto">
                    <header class="auth_header">
                        <h1>Criar nova senha</h1>
                        <p>Informe e repita uma nova senha para recuperar seu acesso.</p>
                    </header>

                    <form class="auth_form" action="<?= url("/recuperar/resetar"); ?>" method="post"
                  enctype="multipart/form-data">

                    <div class="ajax_response"><?= flash(); ?></div>
                    <input type="hidden" name="code" value="<?= $code; ?>"/>
                    <?= csrf_input(); ?>
                        <div class="form-group">
                            <span class="icon-envelope">Nova Senha:</span>
                            <span><a title="Voltar e entrar!" href="<?= url("/entrar"); ?>">Voltar e entrar!</a></span>
                            <input type="password" class="form-control" name="password" placeholder="Nova senha:" required/>
                            <div class="help-block with-errors"></div>
                        </div>
                        <div class="form-group">
                            <span class="icon-envelope">Repita a nova senha:</span>
                            <input type="password" class="form-control" name="password_re" placeholder="Repita a nova senha:" required/>
                            <div class="help-block with-errors"></div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="auth_form_btn form-control-submit-button">Alterar Senha</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> <!-- end of container -->
</div> <!-- end of ex-basic-2 -->
<!-- end of privacy content -->