<!-- Message. Default to the left -->
<div class="direct-chat-msg <?= ($conversation->user_id == user()->id) ? "right" : "" ?>">
    <div class="direct-chat-infos clearfix">
        <span class="direct-chat-name <?= ($conversation->user_id == user()->id) ? "float-end" : "float-start" ?>">
            <?= $conversation->user()->fullName() ?>
        </span>
        <span class="direct-chat-timestamp <?= ($conversation->user_id == user()->id) ? "float-start" : "float-end" ?>"><?= date_fmt($conversation->created_at, "d/m/Y H:m:s") ?></span>
    </div>
    <!-- /.direct-chat-infos -->
    <img class="direct-chat-img" src="<?= image($conversation->user()->photo(), 160)?>" alt="<?= $conversation->user()->fullName() ?>">
    <!-- /.direct-chat-img -->
    <div class="direct-chat-text <?= ($conversation->user_id == user()->id) ? "text-end" : "text-start" ?>">
        <?= $conversation->content ?>
    </div>
    <!-- /.direct-chat-text -->
</div>