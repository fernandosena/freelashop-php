<div class="col-md-12">
    <div class="user-default row g-0 border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-100 position-relative">
        <div class="float-start">
            <div class="col-auto d-none d-lg-block list-user">
                <figure>
                    <img class="bd-placeholder-img float-start img-circle user-default-photo" src="<?= image((!empty($image)) ? $image : null, 150, 150); ?>">
                    <?php if(!empty($vip)): ?>
                        <figcaption>
                            <img src="<?= image(url("/storage/images/icon-vip.png"), 60) ?>" title="VIP" class="icon-vip" alt="Icon VIP">
                        </figcaption>
                    <?php endif; ?>
                </figure>
            </div>
            <div class="col d-flex flex-column position-static user-default-info">
                <strong class="d-inline-bloc text-success"><?= (!empty($subtitle)) ? $subtitle : null; ?></strong>
                <h3 class="mb-2"><?= (!empty($title)) ? $title : null; ?></h3>
                <p class="mb-auto"><?= (!empty($description)) ? $description : null; ?></p>
                <div class="text-start">
                    <?php if(!empty($btnPrimaryLink)): ?>
                        <a href="<?= $btnPrimaryLink ?>" class="btn btn-border-ui btn-sm btn-primary" ><?= $btnPrimaryTitle ?>
                            <?php if(!empty($btnPrimaryValueBadge)): ?>
                                <span class="badge badge-danger navbar-badge"><?= $btnPrimaryValueBadge ?></span>
                            <?php endif; ?>
                        </a>
                    <?php endif; ?>
                    <?php if(!empty($btnWarningLink)): ?>
                        <a href="<?= $btnWarningLink ?>" class="btn btn-border-ui btn-sm btn-warning" ><?= $btnWarningTitle ?></a>
                    <?php endif; ?>
                    <?php if(!empty($btnErrorLink)): ?>
                        <a href="<?= $btnErrorLink ?>" class="btn btn-border-ui btn-sm btn-error" ><?= $btnErrorTitle ?></a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>