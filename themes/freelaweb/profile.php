<?php $v->layout("_theme"); ?>
<!-- Privacy Content -->
<div class="ex-basic-2 mt-7">
    <div class="container">
        <?php $v->insert("views/breadcrumb"); ?>
        <section class="section about-section gray-bg" id="about">
            <div class="row align-items-center flex-row-reverse">
                <div class="col-lg-6">
                    <div class="about-text go-to">
                        <h3 class="dark-color"><?= $user->fullName() ?></h3>
                        <h6 class="theme-color lead"><?= $user->profession ?></h6>
                        <p><?= $user->description ?></p>
                        <div class="row about-list">
                            <div class="col-md-6">
                                <div class="media">
                                    <label>Perfil</label>
                                    <p><?= translate($user->type) ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="about-avatar">
                        <img src="<?= image($user->photo, 300)?>" title="" alt="">
                    </div>
                </div>
            </div>
            <div class="counter">
                <div class="row">
                    <div class="col-6 col-lg-3">
                        <div class="count-data text-center">
                            <h6 class="count h2" data-to="500" data-speed="500">0</h6>
                            <p class="m-0px font-w-600">Projetos</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
