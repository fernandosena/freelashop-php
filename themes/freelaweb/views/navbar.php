<nav class="navbar navbar-expand-lg navbar-dark fixed-top navbar-custom <?= (empty($topTransparent)) ? "nav-active" : ""?>">
    <div class="container">
        <!-- Image Logo -->
        <a class="navbar-brand logo-text" href="<?= url(); ?>">
            <h1><?= CONF_SITE_NAME ?></h1>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarCollapse">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link page-scroll" href="<?= url("/sobre"); ?>">SOBRE</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link page-scroll" href="<?= url("/blog"); ?>">BLOG</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link page-scroll" href="<?= url("/projetos") ?>">PROJETOS</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link page-scroll" href="<?= url("/freelancers") ?>">FREELANCERS</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link page-scroll" href="<?= url("/criar-projeto") ?>">CRIAR PROJETO</a>
                </li>
                <?php if(user()): ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link notification_center_open" href="<?= url("/app/chat"); ?>"
                           data-count="<?= url("/app/notification/chat/count"); ?>" aria-expanded="false">
                            <i class="far fa-comments"></i>
                            <span class="badge badge-danger navbar-badge">0</span>
                        </a>
                    </li>
                    <div class="flex-shrink-0 dropdown text-end user-menu">
                        <a href="#" class="d-block link-dark text-decoration-none" id="dropdownUser2" data-bs-toggle="dropdown" aria-expanded="true">
                            <figure>
                                <img src="<?= image(user()->photo(), 100) ?>" alt="<?= user()->first_name ?>" width="32" height="32" class="rounded-circle">
                                <?php if(!empty(user()->plan()->nivel) && (user()->plan()->nivel == 3) && user()->subscription()->releasePlan()): ?>
                                <figcaption>
                                    <img src="<?= image(url("/storage/images/icon-vip.png"), 60) ?>" title="VIP" class="icon-vip" alt="Icon VIP">
                                </figcaption>
                                <?php endif; ?>
                            </figure>
                        </a>
                        <ul class="dropdown-menu text-small" aria-labelledby="dropdownUser2" data-popper-placement="bottom-end" style="position: absolute; inset: 0px 0px auto auto; margin: 0px; transform: translate(0px, 34px);">
                            <li class="user-header">
                                <figure>
                                    <img src="<?= image(user()->photo(), 100) ?>" title="<?= user()->first_name ?>" class="img-circle elevation-2" alt="<?= user()->first_name ?>">
                                    <?php if(!empty(user()->plan()->nivel) && (user()->plan()->nivel == 3) && user()->subscription()->releasePlan()): ?>
                                        <figcaption>
                                            <img src="<?= image(url("/storage/images/icon-vip.png"), 60) ?>" title="VIP" class="icon-vip" alt="Icon VIP">
                                        </figcaption>
                                    <?php endif; ?>
                                </figure>
                                <p>
                                    <?= str_limit_chars(user()->first_name." ".user()->last_name, 25, "") ?>
                                    <small><strong>Conta:</strong> <?= ucfirst(translate(user()->type)); ?></small>
                                    <small><strong>Plano:</strong> <?= (!empty(user()->plan()) ? user()->plan()->name : "Free") ?></small>
                                </p>
                            </li>

                            <li class="user-body">
                                <div class="row">
                                    <div class="col-6 text-center">
                                        <a class="popup-with-move-anim" href="#moda-support">Suporte</a>
                                    </div>
                                    <div class="col-6 text-center">
                                        <a href="<?= url("/app/assinatura") ?>">Planos</a>
                                    </div>
                                </div>

                            </li>

                            <li class="item"><a class="dropdown-item" href="<?= url("/app/projetos") ?>">Meus projetos</a></li>
                            <li class="user-footer">
                                <a href="<?= url("/app/perfil") ?>" class="btn btn-default btn-flat">Perfil</a>
                                <a href="<?= url("/app/sair") ?>" class="btn btn-default btn-flat float-end">Sair</a>
                            </li>
                        </ul>
                    </div>
                <?php endif; ?>
            </ul>
            <?php if(!user()): ?>
                <div class="text-end">
                    <a href="<?= url("/entrar")?>"><button type="button" class="btn btn-login">LOGIN</button></a>
                    <a href="<?= url("/cadastrar")?>"><button type="button" class="btn btn-light text-dark me-2 btn-cadastrar">CADASTRAR</button></a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</nav>