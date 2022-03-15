<?php $v->layout("_theme"); ?>
<!-- Header -->
<header id="header" class="header">
    <div class="header-content">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-xl-5">
                    <div class="text-container">
                        <h1>Realize seu sonho com a <?= CONF_SITE_NAME ?> ;)</h1>
                        <p class="p-large">Crie agora mesmo um projeto e tire o seu sonho do papel.</p>
                        <a class="btn-solid-lg page-scroll" href="<?= url("/criar-projeto") ?>">CRIAR PROJETO</a>
                    </div> <!-- end of text-container -->
                </div> <!-- end of col -->
                <div class="col-lg-6 col-xl-7">
                    <div class="image-container">
                        <div class="img-wrapper">
                            <img class="img-fluid" src="<?= image(theme("/assets/images/freelashop-banner-principal.png"), 630) ?>" alt="freelashop-banner-head">
                        </div> <!-- end of img-wrapper -->
                    </div> <!-- end of image-container -->
                </div> <!-- end of col -->
            </div> <!-- end of row -->
        </div> <!-- end of container -->
    </div> <!-- end of header-content -->
</header> <!-- end of header -->
<!-- end of header -->

<!-- Description -->
<div class="cards-1 mt-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="above-heading">PASSO-A-PASSO</div>
                <h2 class="h2-heading">Como funciona?</h2>
            </div> <!-- end of col -->
        </div> <!-- end of row -->
        <div class="row">
            <div class="col-lg-12">

                <!-- Card -->
                <div class="card">
                    <div class="card-image">
                        <span class="icon icon-notext icon-bg"><i class="fa-solid fa-pen-to-square"></i></span>
                    </div>
                    <div class="card-body">
                        <h4 class="card-title">Publique</h4>
                        <p>Conte-nos sobre seu projeto informando quais trabalhos o freelancer irá exercer. Publique sem compromisso!</p>
                    </div>
                </div>
                <!-- end of card -->

                <!-- Card -->
                <div class="card">
                    <div class="card-image">
                        <span class="icon icon-notext icon-bg"><i class="fa-solid fa-arrow-pointer"></i></span>
                    </div>
                    <div class="card-body">
                        <h4 class="card-title">Selecione</h4>
                        <p>Receba a proposta de vários freelancers e escolha aquele que você julgar melhor para o seu projeto.</p>
                    </div>
                </div>
                <!-- end of card -->

                <!-- Card -->
                <div class="card">
                    <div class="card-image">
                        <span class="icon icon-notext icon-bg"><i class="fa-solid fa-circle-play"></i></span>
                    </div>
                    <div class="card-body">
                        <h4 class="card-title">Comece</h4>
                        <p>Deposite o valor combinado na <?= CONF_SITE_NAME ?>, assim você terá segurança total para
                            continuar com o projeto. </p>
                    </div>
                </div>
                <!-- end of card -->

                <!-- Card -->
                <div class="card">
                    <div class="card-image">
                        <span class="icon icon-notext icon-bg"><i class="fa-solid fa-circle-check"></i></span>
                    </div>
                    <div class="card-body">
                        <h4 class="card-title">Aceite</h4>
                        <p>Receba o projeto concluído, e libere o valor para o freelancer.</p>
                    </div>
                </div>
                <!-- end of card -->

            </div> <!-- end of col -->
        </div> <!-- end of row -->
    </div> <!-- end of container -->
</div> <!-- end of cards-1 -->
<!-- end of description -->

<div id="details" class="basic-1 mt-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="text-container">
                    <h2>Ganhe dinheiro compartilhando seu link de afiliado.</h2>
                    <p>Entre na página de <a href="<?= url("/app/perfil")?>">Perfil</a> e na aba afiliado, compartilhe seu link com seus amigos para você conseguir juntar pontos e trocar por dinheiro ou descontos na plataforma.</p>
                    <h4>Ganho pontos quando meu amigo:</h4>
                    <ul class="list-unstyled li-space-lg">
                        <li class="media">
                            <div class="media-body"><i class="fas fa-square"></i> Se cadastra e confirma o e-mail.</div>
                        </li>
                        <li class="media">
                            <div class="media-body"><i class="fas fa-square"></i> Contrata um freelancer na plataforma.</div>
                        </li>
                        <li class="media">
                            <div class="media-body"><i class="fas fa-square"></i> Trabalha em um projeto como freelancer</div>
                        </li>
                        <li class="media">
                            <div class="media-body"><i class="fas fa-square"></i> Assina o plano PREMIUM.</div>
                        </li>
                    </ul>
                    <a class="btn-solid-reg page-scroll" href="<?= url("/app/perfil")?>">MEU LINK DE AFILIADO.</a>
                </div> <!-- end of text-container -->
            </div> <!-- end of col -->
            <div class="col-lg-6">
                <div class="image-container">
                    <img class="img-fluid" src="<?= image(theme("/assets/images/freelashop-afiliado.jpg"), 500)?>" alt="Afiliado">
                </div> <!-- end of image-container -->
            </div> <!-- end of col -->
        </div> <!-- end of row -->
    </div> <!-- end of container -->
</div>

<?php if(!empty($categories)): ?>
    <div id="card-category" class="freelancers-category mt-5">
        <div class="container">
            <div class="row mb-5">
                <div class="col-lg-12">
                    <div class="above-heading">FREELANCERS</div>
                    <h2 class="text-center">Principais habilidades</h2>
                </div> <!-- end of col -->
            </div> <!-- end of row -->
            <div class="row row-cols-1 row-cols-md-4 g-4">
                <?php foreach($categories as $category): ?>
                    <div class="col">
                        <a href="<?= url("/freelancers/buscar/{$category->uri}/all/1") ?>" style="text-decoration: none">
                            <div class="card h-100">
                                <img src="<?= image($category->cover, 300) ?>" class="card-img-top" alt="<?= $category->title ?>">
                                <div class="card-body text-center">
                                    <h5 class="card-title"><?= $category->title ?></h5>
                                    <p class="card-text"><?= $category->description ?></p>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
<?php endif; ?>

<!-- Features -->
<div id="features" class="tabs mt-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="above-heading">DÚVIDAS</div>
                <h2 class="h2-heading">Ainda tem dúvidas?</h2>
                <p class="p-heading">Veja com mais detalhes caso ainda tenha dúvidas para criar o seu projeto ou de
                    como trabalhar na <?= CONF_SITE_NAME ?></p>
            </div> <!-- end of col -->
        </div> <!-- end of row -->
        <div class="row">
            <div class="col-lg-12">
<!--                nav-pills-->

                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">
                            <i class="far fa-money-bill-alt"></i> Contratante
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">
                            <i class="fa-solid fa-users"></i> Freelancer
                        </button>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="image-container">
                                    <img class="img-fluid img-painel" src="<?= image(theme("/assets/images/freelashop-capa-contratante.jpg"), 500)?>" alt="freelashop-capa-contratante">
                                </div> <!-- end of image-container -->
                            </div> <!-- end of col -->
                            <div class="col-lg-6">
                                <div class="text-container">
                                    <h3>Encontre o freelancer perfeito</h3>
                                    <p>É a sua primeira vez na <?= CONF_SITE_NAME?>? Então aprenda a como publicar um
                                        trabalho e ter acesso às propostas dos freelancers para tirar o seu sonho do papel.
                                        <a class="blue page-scroll" href="<?= url("/cadastrar") ?>">Cadastre-se</a>
                                        e tenha em suas mãos, as vantagens e a segurança que nenhum outro site de freelancer
                                        oferece.</p>
                                    <ul class="list-unstyled li-space-lg">
                                        <li class="media">
                                            <div class="media-body">
                                                <i class="fas fa-square"></i>
                                                Crie projetos ilimitados para as diversas categorias de trabalhos
                                            </div>
                                        </li>
                                        <li class="media">
                                            <div class="media-body">
                                            <i class="fas fa-square"></i>
                                            Escolha qual freelancer se adéqua melhor as suas expectativas
                                            </div>
                                        </li>
                                        <li class="media">
                                            <div class="media-body">
                                                <i class="fas fa-square"></i>
                                                Ganhe bônus e descontos ao concluir cada projeto*
                                            </div>
                                        </li>
                                        <a class="btn-solid-reg" href="<?= url("/faq/freelancer") ?>">Perguntas frequentes</a>
                                    </ul>
                                </div> <!-- end of text-container -->
                            </div> <!-- end of col -->
                        </div> <!-- end of row -->
                    </div>
                    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="image-container">
                                    <img class="img-fluid img-painel" src="<?= image(theme("/assets/images/freelashop-capa-freelancer.jpg"), 500)?>" alt="freelashop-capa-freelancer">
                                </div> <!-- end of image-container -->
                            </div> <!-- end of col -->
                            <div class="col-lg-6">
                                <div class="text-container">
                                    <h3>Encontre centenas de projetos</h3>
                                    <p>É a sua primeira vez na <?= CONF_SITE_NAME?>? Então aprenda a como enviar suas propostas
                                        e ter acesso a vários clientes para decolar em sua carreira no mercado de trabalho.
                                        <a class="blue page-scroll" href="<?= url("/cadastrar") ?>">Cadastre-se</a>
                                        e tenha em suas mãos a chance de ter quele dinheiro extra ou uma fonte de renda
                                        com a segurança que nenhum outro site de freelancer
                                        oferece.</p>
                                    <ul class="list-unstyled li-space-lg">
                                        <li class="media">
                                            <div class="media-body">
                                                <i class="fas fa-square"></i>
                                                Encontre vários projetos relacionados a sua área de atuação
                                            </div>
                                        </li>
                                        <li class="media">
                                            <div class="media-body">
                                                <i class="fas fa-square"></i>
                                                Ao concluir o projeto na plataforma o dinheiro cai direto na sua conta
                                            </div>
                                        </li>
                                        <li class="media">
                                            <div class="media-body">
                                                <i class="fas fa-square"></i>
                                                Ganhe bônus e descontos ao concluir cada projeto*
                                            </div>
                                        </li>
                                        <a class="btn-solid-reg" href="<?= url("/faq/contratante") ?>">Perguntas frequentes</a>
                                    </ul>
                                </div> <!-- end of text-container -->
                            </div> <!-- end of col -->
                        </div> <!-- end of row -->
                    </div>
                </div>
            </div> <!-- end of col -->
        </div> <!-- end of row -->
    </div> <!-- end of container -->
</div> <!-- end of tabs -->
<!-- end of features -->

<?php if(!empty($posts)): ?>
    <div id="card-category" class="mt-7">
        <div class="container">
            <div class="row mb-5">
                <div class="col-lg-12">
                    <div class="above-heading">BLOG</div>
                    <h2 class="text-center">Artigos mais vistos</h2>
                </div> <!-- end of col -->
            </div> <!-- end of row -->
            <div class="row row-cols-1 row-cols-md-4 g-4">
                <?php foreach ($posts as $post): ?>
                    <?= $v->insert("blog-list", ["post"=>$post])?>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php
 if(!empty($video)):
?>
<!-- Video -->
<div id="video" class="basic-2">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="above-heading"><?= mb_strtoupper(CONF_SITE_NAME) ?></div>
                        <h2 class="h2-heading">Sobre a plataforma</h2>
                        <p class="p-heading">Assista ao video e veja um pouco mais sobre o <?= CONF_SITE_NAME ?></p>
                    </div> <!-- end of col -->
                </div> <!-- end of row -->
                <!-- Video Preview -->
                <div class="image-container">
                    <div class="video-wrapper">
                        <a class="popup-youtube" href="https://www.youtube.com/watch?v=<?= $video ?>" data-effect="fadeIn">
                            <img class="img-fluid" src="<?= image(theme("/assets/images/freelashop-video-image.png"), 850)?>" alt="freelashop-video-image">
                            <span class="video-play-button">
                                <span></span>
                            </span>
                        </a>
                    </div> <!-- end of video-wrapper -->
                </div> <!-- end of image-container -->
                <!-- end of video preview -->

                <div class="p-heading">
                    Entenda nesse video como funciona a plataforma e como você poderá criar projetos, contratar
                    freelancers ou até mesmo ser um profissional na plataforma e ganhar dinheiro com isso. Aproveite o video!.
                </div>
            </div> <!-- end of col -->
        </div> <!-- end of row -->
    </div> <!-- end of container -->
</div> <!-- end of basic-2 -->
<!-- end of video -->
<?php
endif;
?>
<?php if($depositions): ?>
<!-- Testimonials -->
<div class="slider-2">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <!-- Text Slider -->
                <div class="slider-container">
                    <div class="swiper-container text-slider">
                        <div class="swiper-wrapper">
                            <?php foreach ($depositions as $deposition): ?>
                                <!-- Slide -->
                                <div class="swiper-slide">
                                    <div class="image-wrapper">
                                        <img class="img-fluid" src="<?= image(theme($deposition->user()->photo), 150) ?>" alt="<?= $deposition->user()->fullName() ?>">
                                    </div> <!-- end of image-wrapper -->
                                    <div class="text-wrapper">
                                        <div class="testimonial-text"><?= $deposition->text ?></div>
                                        <div class="testimonial-author">
                                            <?= "{$deposition->user()->fullName()}"?> -
                                            <?= $deposition->user()->profission()->name ?></div>
                                    </div> <!-- end of text-wrapper -->
                                </div> <!-- end of swiper-slide -->
                                <!-- end of slide -->
                            <?php endforeach; ?>
                        </div> <!-- end of swiper-wrapper -->

                        <!-- Add Arrows -->
                        <div class="swiper-button-next"></div>
                        <div class="swiper-button-prev"></div>
                        <!-- end of add arrows -->

                    </div> <!-- end of swiper-container -->
                </div> <!-- end of slider-container -->
                <!-- end of text slider -->

            </div> <!-- end of col -->
        </div> <!-- end of row -->
    </div> <!-- end of container -->
</div> <!-- end of slider-2 -->
<!-- end of testimonials -->
<?php endif; ?>
<?php if(!user()): ?>
    <!-- Newsletter -->
    <div class="form">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="text-container">
                        <div class="above-heading">NEWSLETTER</div>
                        <h2>Receba as novidades em primeira mão pelo seu e-mail.</h2>

                        <!-- Newsletter Form -->
                        <form class="auth_form" action="<?= url("/newsletter"); ?>" method="post" data-toggle="validator" data-focus="false">
                            <div class="ajax_response"><?= flash(); ?></div>
                            <?= csrf_input(); ?>
                            <div class="form-group">
                                <input type="email" class="form-control-input" id="nemail" name="email" required>
                                <label class="label-control" for="nemail">Seu melhor e-mail</label>
                                <div class="help-block with-errors"></div>
                            </div>
                            <div class="form-group checkbox">
                                Ao cadastrar o e-mail você confirma que leu e concorda com todas as
                                <a href="<?= url("/politica-de-privacidade") ?>" class="link-underline">Políticas de Privacidade</a>
                                e com todos os <a href="<?= url("/termos-de-uso") ?>" class="link-underline">Termos de Uso</a> escritos no <?= CONF_SITE_NAME ?>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="form-control-submit-button">CADASTRAR E-MAIL</button>
                            </div>
                            <div class="form-message">
                                <div id="nmsgSubmit" class="h3 text-center hidden"></div>
                            </div>
                        </form>
                        <!-- end of newsletter form -->

                    </div> <!-- end of text-container -->
                </div> <!-- end of col -->
            </div> <!-- end of row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="icon-container">
                    <span class="fa-stack">
                        <a href="https://facebook.com/<?= CONF_SOCIAL_PAGE["facebook"]?>" rel=”nofollow" target="_blank">
                            <i class="fas fa-circle fa-stack-2x"></i>
                            <i class="fab fa-facebook-f fa-stack-1x"></i>
                        </a>
                    </span>
                        <span class="fa-stack">
                        <a href="https://www.twitter.com/<?= CONF_SOCIAL_PAGE["twitter"]?>" rel=”nofollow" target="_blank">
                            <i class="fas fa-circle fa-stack-2x"></i>
                            <i class="fab fa-twitter fa-stack-1x"></i>
                        </a>
                    </span>
                        <span class="fa-stack">
                        <a href="https://www.instagram.com/<?= CONF_SOCIAL_PAGE["instagram"]?>" rel=”nofollow" target="_blank">
                            <i class="fas fa-circle fa-stack-2x"></i>
                            <i class="fab fa-instagram fa-stack-1x"></i>
                        </a>
                    </span>
                        <span class="fa-stack">
                        <a href="https://www.linkedin.com/in/<?= CONF_SOCIAL_PAGE["linkedin"]?>" rel=”nofollow" target="_blank">
                            <i class="fas fa-circle fa-stack-2x"></i>
                            <i class="fab fa-linkedin-in fa-stack-1x"></i>
                        </a>
                    </span>
                    </div> <!-- end of col -->
                </div> <!-- end of col -->
            </div> <!-- end of row -->
        </div> <!-- end of container -->
    </div> <!-- end of form -->
    <!-- end of newsletter -->
<?php endif; ?>


