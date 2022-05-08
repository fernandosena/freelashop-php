<?php $v->layout("_theme"); ?>
<!--OPTIN-->
<div id="home_optin">
    <div class="centro">
        <div class="home_optin_content">
            <header class="home_optin_content_flex">
                <h2>QUEM É O TUCA COACH?</h2>
                <p>Master Coach e Treinador Comportamental que já impactou centenas de vidas por meio de suas mentorias,
                    cursos, palestras e imersões. Especialista em produtividade ajuda pessoas a terem uma vida com sentido
                    por meio da gestão do tempo, simplicidade e amor para tornar o mundo um lugar melhor.</p>
                <p>Conhecimento em Desenvolvimento Humano com formações em Master Coach, Master OKR, Practitioner em PNL,
                    Certificado em Gestão de Projetos com mais de 20 anos de experiência em gestão e desenvolvimento de
                    equipes.</p>
            </header>
            <div class="home_optin_content_flex">
                <h4>Informe seus dados para realizar o teste</h4>
                <form class="ajax_on" action="<?= url("/home"); ?>" method="post" enctype="multipart/form-data">
                    <?= csrf_input(); ?>
                    <input type="hidden" name="teste" value="<?= $teste ?>">
                    <input type="text" name="full_name" placeholder="Nome Completo" required/>
                    <input type="email" name="email" placeholder="Seu melhor e-mail:" required/>
                    <input type="tel" name="phone" placeholder="Telefone:" required/>
                    <button class="radius transition">Realizar teste</button>
                </form>
            </div>
        </div>
    </div>
</div>