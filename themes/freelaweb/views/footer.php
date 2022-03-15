<?php if(!empty(user()) && !empty(user()->plan()->nivel) && user()->plan()->nivel > 1 && user()->subscription()->releasePlan()): ?>
    <div id="whatsapp">
        <a href="https://api.whatsapp.com/send?phone=<?= str_replace(["(",")", "-", " "], "", CONF_SITE_WHATSAPP) ?>&text=Ol%C3%A1%2C%20me%20chamo%20<?= user()->fullName() ?>%20e%20preciso%20de%20suporte" target="_blank">
            <i class="fab fa-whatsapp"></i></i>
        </a>
    </div>
<?php endif; ?>
<?php if(!empty($footerEffect)): ?>
<?php else: ?>
<div class="mt-1"></div>
<?php endif; ?>
<div id="footer">
    <div class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="footer-col first">
                        <h4>Sobre</h4>
                        <p class="p-small"><?= CONF_SITE_DESC ?></p>
                    </div>
                </div> <!-- end of col -->
                <div class="col-md-4">
                    <div class="footer-col middle">
                        <h4>Links Importantes</h4>
                        <ul class="nav flex-column list-unstyled nav-footer">
                            <li class="nav-item mb-2"><a href="<?= url("/home")?>" class="nav-link p-0 text-muted"><i class="fas fa-square"></i> Home</a></li>
                            <li class="nav-item mb-2"><a href="<?= url("/sobre")?>" class="nav-link p-0 text-muted"><i class="fas fa-square"></i> Sobre</a></li>
                            <li class="nav-item mb-2"><a href="<?= url("/politica-de-privacidade")?>" class="nav-link p-0 text-muted"><i class="fas fa-square"></i> Política de Privacidade</a></li>
                            <li class="nav-item mb-2"><a href="<?= url("/termos-de-uso")?>" class="nav-link p-0 text-muted"><i class="fas fa-square"></i> Termos de Uso</a></li>
                        </ul>
                    </div>
                </div> <!-- end of col -->
                <div class="col-md-4">
                    <div class="footer-col last">
                        <h4>Contato</h4>
                        <ul class="list-unstyled li-space-lg p-small">
                            <li class="media">
                                <div class="media-body">
                                    <i class="fas fa-map-marker-alt"></i> <?= CONF_SITE_ADDR_STREET." Nº ".CONF_SITE_ADDR_NUMBER.", ".CONF_SITE_ADDR_CITY." ".CONF_SITE_ADDR_STATE." - ".CONF_SITE_ADDR_ZIPCODE ?></div>
                            </li>
                            <li class="media-body">
                                <i class="fas fa-envelope"></i> <a class="white" href="mailto:<?= CONF_MAIL_SUPPORT ?>"><?= CONF_MAIL_SUPPORT ?></a>
                            </li>
                        </ul>
                    </div>
                </div> <!-- end of col -->
            </div> <!-- end of row -->
        </div> <!-- end of container -->
    </div> <!-- end of footer -->
    <!-- end of footer -->


    <!-- Copyright -->
    <div class="copyright">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <p class="p-small">Copyright © <?= date("Y") ?> - Desenvolvido por <a target="_blank" href="https://softhubo.com.br">Softhubo</a></p>
                </div> <!-- end of col -->
            </div> <!-- enf of row -->
        </div> <!-- end of container -->
    </div> <!-- end of copyright -->
</div>