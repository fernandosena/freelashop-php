<?php
if (strpos(url(), "localhost")) {
    /**
     * CSS
     */
    $minCSS = new MatthiasMullie\Minify\CSS();
    //Glogal

    //Theme
    $minCSS->add(__DIR__ . "/../../../shared/plugins/bs-stepper-master/css/bs-stepper.css");
    $minCSS->add(__DIR__ . "/../../../shared/plugins/slick-1.8.1/slick/slick.css");
    $minCSS->add(__DIR__ . "/../../../shared/plugins/slick-1.8.1/slick/slick-theme.css");
    $minCSS->add(__DIR__ . "/../../../themes/freelashop/assets/css/style.css");

    //Minify CSS
    $minCSS->minify(__DIR__ . "/../../../themes/" . CONF_VIEW_THEME . "/assets/style.css");

    /**
     * JS
     */
    $minJS = new MatthiasMullie\Minify\JS();

    //Glogal
    $minJS->add(__DIR__ . "/../../../shared/plugins/jquery-3.4.1/jquery-3.4.1.min.js");
    $minJS->add(__DIR__ . "/../../../shared/plugins/bs-stepper-master/js/bs-stepper.min.js");
    $minJS->add(__DIR__ . "/../../../shared/plugins/bs-stepper-master/js/main.js");
    $minJS->add(__DIR__ . "/../../../shared/plugins/slick-1.8.1/slick/slick.min.js");
    $minJS->add(__DIR__ . "/../../../shared/scripts/script.js");

    //Theme


    //Minify JS
    $minJS->minify(__DIR__ . "/../../../themes/" . CONF_VIEW_THEME . "/assets/scripts.js");
}