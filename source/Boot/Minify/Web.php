<?php
if (strpos(url(), "localhost")) {
    /**
     * CSS
     */
    $minCSS = new MatthiasMullie\Minify\CSS();
    //Glogal

    //Theme
    $minCSS->add(__DIR__ . "/../../../shared/plugins/bootstrap/bootstrap.min.css");
    $minCSS->add(__DIR__ . "/../../../shared/plugins/bs-stepper-master/css/bs-stepper.min.css");
    $minCSS->add(__DIR__ . "/../../../themes/" . CONF_VIEW_THEME . "/assets/css/style.css");

    //Minify CSS
    $minCSS->minify(__DIR__ . "/../../../themes/" . CONF_VIEW_THEME . "/assets/style.css");

    /**
     * JS
     */
    $minJS = new MatthiasMullie\Minify\JS();

    //Glogal
    $minJS->add(__DIR__ . "/../../../shared/plugins/jquery-3.4.1/jquery-3.4.1.slim.min.js");
    $minJS->add(__DIR__ . "/../../../shared/scripts/jquery.min.js");
    $minJS->add(__DIR__ . "/../../../shared/scripts/jquery.form.js");
    $minJS->add(__DIR__ . "/../../../shared/scripts/jquery.mask.js");
    $minJS->add(__DIR__ . "/../../../shared/plugins/bootstrap/bootstrap.min.js");
    $minJS->add(__DIR__ . "/../../../shared/plugins/bs-stepper-master/js/bs-stepper.min.js");
    $minJS->add(__DIR__ . "/../../../shared/plugins/bs-stepper-master/js/main.js");

    //Theme
    $minJS->add(__DIR__ . "/../../../themes/".CONF_VIEW_THEME."/assets/js/script.js");


    //Minify JS
    $minJS->minify(__DIR__ . "/../../../themes/" . CONF_VIEW_THEME . "/assets/scripts.js");
}