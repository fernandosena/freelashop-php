<?php $v->layout("_theme"); ?>
<!-- Privacy Content -->
<div class="ex-basic-2 mt-7">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="image-container-small optin_page_content">
                    <img class="img-fluid" title="<?= $data->title; ?>" src="<?= $data->image; ?>" alt="<?= $data->title; ?>">
                </div> <!-- end of image-container-large -->
                <div class="text-container">
                    <h3><?= $data->title; ?></h3>
                    <p><?= $data->desc; ?></p>
                </div> <!-- end of text-container-->
                <?php if (!empty($data->link)): ?>
                    <a class="btn-solid-lg page-scroll" href="<?= $data->link; ?>" title="<?= $data->linkTitle; ?>"><?= $data->linkTitle; ?></a>
                <?php endif; ?>
            </div> <!-- end of col-->
        </div> <!-- end of row -->
    </div> <!-- end of container -->
</div> <!-- end of ex-basic-2 -->
<!-- end of privacy content -->
<?php if (!empty($track)): ?>
    <?php $v->start("scripts"); ?>
    <script>
        fbq('track', '<?= $track->fb; ?>');
        gtag('event', 'conversion', {'send_to': '<?= $track->aw;?>'});
    </script>
    <?php $v->end(); ?>
<?php endif; ?>
