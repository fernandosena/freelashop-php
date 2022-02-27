<?php $v->layout("_theme"); ?>
<!-- Privacy Content -->
<div class="ex-basic-2 mt-7">
    <div class="container">
        <?php $v->insert("views/breadcrumb"); ?>
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-3">
                        <div class="list-group" id="list-tab" role="tablist">
                            <a class="list-group-item list-group-item-action active" id="list-afiliado-list" data-bs-toggle="list" href="#list-afiliado" role="tab" aria-controls="list-afiliado">Afiliado</a>
                            <a class="list-group-item list-group-item-action" id="list-score-list" data-bs-toggle="list" href="#list-score" role="tab" aria-controls="score-home">Pontos</a>
                            <a class="list-group-item list-group-item-action" id="list-home-list" data-bs-toggle="list" href="#list-home" role="tab" aria-controls="list-home">Usuário</a>
                            <a class="list-group-item list-group-item-action" id="list-config-list" data-bs-toggle="list" href="#list-config" role="tab" aria-controls="list-config">Alterar conta</a>
                        </div>
                    </div>
                    <div class="col-9">
                        <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="list-afiliado" role="tabpanel" aria-labelledby="list-afiliado-list">
                                <p>
                                    Compartilhe seu link de afiliado e ganhe dinheiro com isso.</p>
                                <p>
                                    A cada transição realizada com sucesso por quem se cadastradou atravez de seu link
                                    você receba pontos e consegue trocar por dinheiro ou descontos na <?= CONF_SITE_NAME ?>.

                                </p>
                                <p>Link de afiliado: <strong><?= url("/cadastrar/".base64_encode($user->email)."") ?></strong></p>
                                <a class="shared" href="https://www.facebook.com/sharer/sharer.php?u=<?= url("/cadastrar/".base64_encode($user->email)."") ?>">
                                    <i class="fa-brands fa-facebook-square"></i>
                                </a>
                                <a class="shared"  href="https://www.linkedin.com/shareArticle?mini=true&url=<?= url("/cadastrar/".base64_encode($user->email)."") ?>">
                                    <i class="fa-brands fa-linkedin"></i>
                                </a>
                                <a class="shared"  href="https://api.whatsapp.com/send?text=<?= url("/cadastrar/".base64_encode($user->email)."") ?>">
                                    <i class="fa-brands fa-whatsapp-square"></i>
                                </a>
                                <a class="shared"  href="javascript:void(0)" onclick="share()"> <i class="fa-solid fa-share-from-square"></i></a>
                                <script type="text/javascript">
                                    function share(){
                                        if (navigator.share !== undefined) {
                                            navigator.share({
                                                title: 'Ganhe dinheiro comigo',
                                                text: 'Use o meu link e ganhe dinheiro todo dia na <?= CONF_SITE_NAME ?>, Meu link: <?= url("/cadastrar/".base64_encode($user->email)."") ?>',
                                                url: '<?= url("/cadastrar/".base64_encode($user->email)."") ?>',
                                            })
                                                .then(() => console.log('Successful share'))
                                        .catch((error) => console.log('Error sharing', error));
                                        }
                                    }
                                </script>
                            </div>
                            <div class="tab-pane fade" id="list-score" role="tabpanel" aria-labelledby="list-score-list">
                                <?php
                                    if($score){
                                ?>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="card">
                                                <!-- /.card-header -->
                                                <div class="card-body table-responsive p-0" style="height: 300px;">
                                                    <table class="table table-head-fixed text-nowrap">
                                                        <thead>
                                                        <tr>
                                                            <th>ID</th>
                                                            <th>Data</th>
                                                            <th>Pontos</th>
                                                            <th>Comentário</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <?php
                                                            foreach ($score as $item) {
                                                        ?>
                                                            <tr>
                                                                <td><?= $item->id ?></td>
                                                                <td><?= date_fmt_br($item->created_at) ?></td>
                                                                <td><?= $item->value ?> Ponto(s)</td>
                                                                <td><?= $item->comment ?></td>
                                                            </tr>
                                                        <?php
                                                            }
                                                        ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <!-- /.card-body -->
                                            </div>
                                            <!-- /.card -->
                                        </div>
                                    </div>
                                <?php
                                    }else{
                                        echo message()->info("Você ainda não tem pontos ACUMULADOS");
                                    }
                                ?>
                            </div>
                            <div class="tab-pane fade" id="list-home" role="tabpanel" aria-labelledby="list-home-list">
                                <div class="app_formbox app_widget">
                                    <form class="app_form" action="<?= url("/app/perfil"); ?>" method="post">
                                        <input type="hidden" name="update" value="true"/>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <input class="form-control" type="file" id="formFile" name="photo">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <span class="field icon-user">Nome: <span class="text-danger font-weight-bold">*</span></span>
                                                    <input class="form-control" type="text" name="first_name" required
                                                           value="<?= $user->first_name; ?>"/>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <span class="field icon-user-plus">Sobrenome: <span class="text-danger font-weight-bold">*</span></span>
                                                    <input class="form-control" type="text" name="last_name" required
                                                           value="<?= $user->last_name; ?>"/>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <span class="field icon-briefcase">Genero: <span class="text-danger font-weight-bold">*</span></span>
                                                    <select class="form-control" name="genre" required>
                                                        <option value="">&ofcir; Selecione</option>
                                                        <option <?= ($user->genre == "male" ? "selected" : ""); ?> value="male">&ofcir; Masculino</option>
                                                        <option <?= ($user->genre == "female" ? "selected" : ""); ?> value="female">&ofcir; Feminino</option>
                                                        <option <?= ($user->genre == "other" ? "selected" : ""); ?> value="other">&ofcir; Outro</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <span class="field icon-calendar">Nascimento: <span class="text-danger font-weight-bold">*</span></span>
                                                    <input class="form-control mask-date" type="text" name="datebirth" placeholder="dd/mm/yyyy" required
                                                           value="<?= ($user->datebirth ? date_fmt($user->datebirth, "d/m/Y") : null); ?>"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <span class="field icon-briefcase">CPF: <span class="text-danger font-weight-bold">*</span></span>
                                                    <input class="form-control mask-doc" type="text" name="document" placeholder="Apenas números" required
                                                           value="<?= $user->document; ?>"/>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <span class="field icon-envelope">Celular: <span class="text-danger font-weight-bold">*</span></span>
                                                    <input class="form-control mask-cell" type="tel" name="cell" placeholder="Seu número de celular"
                                                           value="<?= $user->cell; ?>" required/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <span class="field icon-envelope">E-mail:</span>
                                                    <input class="form-control" type="email" name="email" placeholder="Seu e-mail de acesso" readonly
                                                           value="<?= $user->email; ?>" disabled/>
                                                </div>
                                            </div>
                                        </div>
                                        <?php if($user->type == "freelancer"): ?>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <span class="field icon-envelope">E-mail paypal:</span>
                                                        <input class="form-control" type="email" name="paypal" placeholder="Seu e-mail o paypal"
                                                               value="<?= $user->paypal; ?>"/>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <span class="field icon-unlock-alt">Senha:</span>
                                                    <input class="form-control" type="password" name="password" placeholder="Sua senha de acesso"/>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <span class="field icon-unlock-alt">Repetir Senha:</span>
                                                    <input class="form-control" type="password" name="password_re" placeholder="Sua senha de acesso"/>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="app_formbox_actions">
                                                <button class="btn-solid-lg page-scroll float-end">Atualizar</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="list-config" role="tabpanel" aria-labelledby="list-config-list">
                                <p>Deseja trocar o seu tipo de conta? então nos envie um email para
                                    <a href="mailto: <?= CONF_MAIL_SUPPORT ?>"><strong><?= CONF_MAIL_SUPPORT ?></a></strong>
                                    ou entre em contato pelo suporte <strong><a class="popup-with-move-anim" href="#moda-support">clicando aqui</a></strong>. A alteração
                                será realizada em até <strong>48h</strong>.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>