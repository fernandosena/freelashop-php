<?php if(!empty(user()) && !empty(user()->plan()->nivel) && user()->plan()->nivel > 1 && user()->subscription()->releasePlan()): ?>
    <div id="whatsapp">
        <a href="https://api.whatsapp.com/send?phone=<?= str_replace(["(",")", "-", " "], "", CONF_SITE_WHATSAPP) ?>&text=Ol%C3%A1%2C%20me%20chamo%20<?= user()->fullName() ?>%20e%20preciso%20de%20suporte" target="_blank">
            <i class="fab fa-whatsapp"></i></i>
        </a>
    </div>
<?php endif; ?>
<?php if(!empty($footerEffect)): ?>
<svg class="footer-frame" data-name="Layer 2" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" viewBox="0 0 1920 79"><defs><style>.cls-2{fill: var(--color-default);}</style></defs><path class="cls-2" d="M0,72.427C143,12.138,255.5,4.577,328.644,7.943c147.721,6.8,183.881,60.242,320.83,53.737,143-6.793,167.826-68.128,293-60.9,109.095,6.3,115.68,54.364,225.251,57.319,113.58,3.064,138.8-47.711,251.189-41.8,104.012,5.474,109.713,50.4,197.369,46.572,89.549-3.91,124.375-52.563,227.622-50.155A338.646,338.646,0,0,1,1920,23.467V79.75H0V72.427Z" transform="translate(0 -0.188)"/></svg>
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