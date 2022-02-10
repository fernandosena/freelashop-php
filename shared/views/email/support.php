<?php $v->layout("_theme", ["title" => $subject]); ?>

<?= $message ?>
<?php
    if(!empty($extra)):
        foreach ($extra as $key => $value):
            ?>
            <div class="data-client">
                <h4>Dados <?= $key ?></h4>
                <p>
                    <?php
                        foreach ($value as $itemKey => $itemValue):
                    ?>
                        <label><strong><?= $itemKey ?>:</strong> <span><?= $itemValue ?></span></label><br>
                    <?php
                        endforeach;
                    ?>
                </p>
            </div>
            <?php
        endforeach;
    endif;
?>
