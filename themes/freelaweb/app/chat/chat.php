<?php $v->layout("_theme"); ?>
<div class="ex-basic-2 mt-7">
    <div class="container">
        <?php $v->insert("views/breadcrumb"); ?>
        <!-- DIRECT CHAT -->
        <div class="card direct-chat direct-chat-primary">
            <div class="card-header">
                <span class="card-title float-start">
                    <a href="<?= url("/projetos/{$chat->project()->uri}") ?>"><?= $chat->project()->title ?></a>
                </span>
                <span class="card-title float-end">
                    <a href="<?= url("/app/proposta/{$chat->proposal()->id}") ?>">Ver proposta</a>
                </span>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <!-- Conversations are loaded here -->
                <div class="direct-chat-messages">
                    <?php
                        if(!empty($conversations)):
                            foreach ($conversations as $conversation):
                    ?>
                            <?= $v->insert("app/chat/conversation", ["conversation"=>$conversation]) ?>
                    <?php
                            endforeach;
                        endif;
                    ?>
                    <!-- /.direct-chat-msg -->
                    <div class="ajax-chat"></div>
                </div>
                <!--/.direct-chat-messages-->
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <form class="ajax_off form_chat" action="<?= url("/app/chat/send/{$chat->id}")?>" method="post">
                    <div class="input-group">
                        <input type="text" name="content" placeholder="Digite sua mensagem aqui..." class="form-control" required>
                        <span class="input-group-append">
                          <button type="submit" class="btn btn-primary">Enviar</button>
                        </span>
                    </div>
                </form>
            </div>
            <!-- /.card-footer-->
        </div>
        <!--/.direct-chat -->
    </div>
</div>