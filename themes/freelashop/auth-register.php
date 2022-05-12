<?php $v->layout("_theme"); ?>
<section id="cadastro">
    <div class="box-cadastro">
        <h2><a href="<?= url() ?>"><?= CONF_SITE_NAME ?></a></h2>
        <div class="container-cadastro">
            <div class="cadastro">
                <h1>Crie uma conta</h1>
                <form action="<?= url("/cadastrar")?>" method="post">
                    <label>
                        <span>Nome</span>
                        <input type="text" name="first_name" placeholder="Seu nome" required>
                    </label>
                    <label>
                        <span>Sobrenome</span>
                        <input type="text" name="last_name" placeholder="Seu sobrenome" required>
                    </label>
                    <label>
                        <span>E-mail</span>
                        <input type="email" name="email" placeholder="Seu e-mail" required>
                    </label>
                    <label>
                        <span>Senha</span>
                        <input type="password" name="password" placeholder="Sua senha" required>
                    </label>
                    <label>
                        <span>Retira a Senha</span>
                        <input type="password" name="password_repeat" placeholder="Sua senha" required>
                    </label>
                    <label>
                        <span>Calular</span>
                        <input type="text" name="cell" placeholder="Numero de celular" required>
                    </label>
                    <div class="grupo-btn">
                        <button type="submit" class="no-link">CADASTRAR</button>
                    </div>
                </form>
            </div>
            <div class="info">
                <p>Você já está registrado na <?= CONF_SITE_NAME ?>? <a href="<?= url("/entrar")?>">Logar</a></p>
            </div>
        </div>
    </div>
</section>
