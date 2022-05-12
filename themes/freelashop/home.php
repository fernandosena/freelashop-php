<?php $v->layout("_theme"); ?>
<section id="banner">
    <div class="centro">
        <div class="texto">
            <h1>É GRATIS! Temos vários freelancers prontos para começar a trabalhar no seu projeto.</h1>
            <div class="grupo-btn">
                <button class="link"><a href="<?= url("/criar-projeto") ?>">publicar projeto</a></button>
                <a href="<?= url("/freelancers") ?>">ENCONTRAR freelancer</a>
            </div>
        </div>
        <div class="imagem">
            <img src="<?= theme("/assets/img/freelashop-home.png")?>" alt="Banner <?= CONF_SITE_NAME ?> home" title="Banner <?= CONF_SITE_NAME ?> home">
        </div>
    </div>
</section>
<section id="passo-a-passo">
    <div class="centro">
        <div class="grupo-titulo-subtitulo">
            <div class="subtitulo">
                <div class="borda"></div>
                <h3>Passo-a-passo</h3>
            </div>
            <div class="titulo">
                <h3>Passos para publicar seu primeiro projeto</h3>
            </div>
        </div>
        <div class="passos">
            <div class="item">
                <h4>1º passo</h4>
                <img src="<?= theme("/assets/img/item1.png")?>" alt="Passo1" title="Passo1">
                <h3>Publicar</h3>
                <div class="borda"></div>
                <p>Publique o seu projeto em 2 simples passos informando o que você precisa</p>
            </div>
            <div class="item">
                <h4>2º Passo</h4>
                <img src="<?= theme("/assets/img/item2.png")?>" alt="Passo1" title="Passo1">
                <h3>Selecionar</h3>
                <div class="borda"></div>
                <p>Receba centenas de propostas com valores diferentes e escolha qual você achar melhor</p>
            </div>
            <div class="item">
                <h4>3º passo</h4>
                <img src="<?= theme("/assets/img/item3.png")?>" alt="Passo1" title="Passo1">
                <h3>Começar</h3>
                <div class="borda"></div>
                <p>Realize o pagamento e deixa-o seguro na nossa plataforma até o freelance terminar o projeto </p>
            </div>
            <div class="item">
                <h4>4º passo</h4>
                <img src="<?= theme("/assets/img/item4.png")?>" alt="Passo1" title="Passo1">
                <h3>Aceitar</h3>
                <div class="borda"></div>
                <p>Receba o projeto finalizado, analise e libere o valor do projeto para o freelancer.</p>
            </div>
        </div>
    </div>
</section>
<section id="bem-vindo">
    <div class="centro">
        <div class="texto">
            <div class="grupo-titulo-subtitulo">
                <div class="subtitulo">
                    <div class="borda"></div>
                    <h3>Sobre a Freelashop</h3>
                </div>
                <div class="titulo">
                    <h3>Bem-vindo a Freelashop</h3>
                </div>
            </div>
            <p>A FreelaShop te deseja muito sucesso em sua carreira e vida, e queremos te parabenizar por tudo, pois você é
                o nosso maior presente. Venha Conhecer mais sobre nós, é só clicar no botão abaixo.</p>
            <div class="grupo-btn">
                <button class="link"><a href="<?= url("/sobre") ?>">Sobre a freelashop</a></button>
            </div>
        </div>
        <div class="imagem">
            <img src="<?= theme("/assets/img/bem-vindo.png")?>" alt="Bem vindo" title="Bem vindo">
        </div>
    </div>
</section>
<section id="depoimentos">
    <img src="<?= theme("/assets/img/aspas.png")?>" alt="Aspas" title="Aspas">
    <div class="slide-depoimentos">
        <div class="item">
            <p>Texto do depoimentoTexto do depoimentoTexto do depoimento
            </p>
            <img src="<?= theme("/assets/img/user1.png")?>" alt="user1" title="user1">
            <h3>Fernando Sena</h3>
        </div>
        <div class="item">
            <p>Texto do depoimento</p>
            <img src="<?= theme("/assets/img/user1.png")?>" alt="user1" title="user1">
            <h3>Fernando Sena</h3>
        </div>
        <div class="item">
            <p>Texto do depoimento</p>
            <img src="<?= theme("/assets/img/user1.png")?>" alt="user1" title="user1">
            <h3>Fernando Sena</h3>
        </div>
    </div>
</section>
<section id="como-funciona">
    <div class="centro">
        <div class="grupo-titulo-subtitulo">
            <div class="subtitulo">
                <div class="borda"></div>
                <h3>Como Funciona</h3>
            </div>
            <div class="titulo">
                <h3>Entenda como a <?= CONF_SITE_NAME ?> Funciona</h3>
            </div>
        </div>
        <div class="video">
            <figure>
                <img src="<?= theme("/assets/img/video.png")?>" alt="user1" title="user1">
                <figcaption>
                    <i class="fas fa-play-circle"></i>
                </figcaption>
            </figure>
        </div>
        <div class="grupo-btn">
            <button class="link"><a href="<?= url("/cadastre-se") ?>">cadastrar agora</a></button>
        </div>
    </div>
</section>
<section id="categoria">
    <div class="centro">
        <div class="grupo-titulo-subtitulo">
            <div class="subtitulo">
                <div class="borda"></div>
                <h3>Categoria</h3>
            </div>
            <div class="titulo">
                <h3>Conheça as especialidades da casa</h3>
            </div>
        </div>
        <div class="grid">
            <?php for ($i=1;$i <= 8; $i++): ?>
                <div class="item">
                    <a href="<?= url("/freelancers/")?>">
                        <img src="<?= theme("/assets/img/item.png")?>" alt="Passo1" title="Passo1">
                        <h3>WebDesigner</h3>
                    </a>
                    <div class="borda"></div>
                    <p>Lörem ipsum bens geortad kyn. Konpol belogi: om än gädibelt panys för tiskapet.
                        trdttal jskla</p>
                </div>
            <?php endfor; ?>
        </div>
    </div>
</section>
<section id="cta">
    <div class="centro">
        <div class="texto">
            <h3>A melhor prestadora de serviços
                de freelancer do Brasil</h3>
        </div>
        <div>
            <div class="grupo-btn">
                <button class="link"><a href="<?= url("/criar-projeto") ?>">publicar um projeto</a></button>
            </div>
        </div>
    </div>
</section>