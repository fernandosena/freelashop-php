<?php $v->layout("_theme"); ?>
<section id="login">
    <div class="box-login">
        <h2><a href="<?= url() ?>"><?= CONF_SITE_NAME ?></a></h2>
        <div class="container-login">
            <div class="login">
                <h1>Login</h1>
                <form>
                    <label>
                        <span>E-mail</span>
                        <input type="email" placeholder="Digite seu e-mail" required>
                    </label>
                    <label>
                        <span>Senha</span>
                        <input type="password" placeholder="Sua senha" required>
                    </label>
                    <div class="grupo-btn">
                        <button type="submit" class="no-link">login</button>
                    </div>
                </form>
            </div>
            <div class="info">
                <p>Ainda não criou sua conta na <?= CONF_SITE_NAME ?>? <a href="<?= url("/cadastre-se")?>">Cadastre-se</a></p>
            </div>
        </div>
    </div>
</section>
