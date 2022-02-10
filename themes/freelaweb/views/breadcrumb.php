<!-- Content Header (Page header) -->
<section class="content-header pl-0">
    <div class="mt-2">
        <div class="row mb-2 mt-5">
            <div class="col-sm-6 mt-2">
                <h1><?= ($title ?? null)?></h1>
                <p><?= ($subtitle ?? null)?></p>
            </div>
            <?php if(!empty($breadcrumb)): ?>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= url("/app")?>">Home</a></li>
                    <li class="breadcrumb-item"><?= ($breadcrumb ?? "")?></li>
                </ol>
            </div>
            <?php endif; ?>
        </div>
    </div><!-- /.container-fluid -->
</section>
<div class="ajax_response"><?= flash(); ?></div>


