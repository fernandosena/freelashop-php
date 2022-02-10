<div id="<?= $id ?>" class="lightbox-basic zoom-anim-dialog mfp-hide">
    <div class="container">
        <div class="row">
            <button title="Close (Esc)" type="button" class="mfp-close x-button">×</button>
            <div class="col-lg-12">
                <?php
                    $page = (!empty($modal) ? $modal : "modal-notFound");
                    $v->insert("views/{$page}")
                ?>
                <a class="btn-outline-reg mfp-close as-button float-end" href="#screenshots">VOLTAR</a>
            </div> <!-- end of col -->
        </div> <!-- end of row -->
    </div> <!-- end of container -->
</div> <!-- end of lightbox-basic -->