<?php
/**
 * DATABASE
 */
define("CONF_DB_HOST", "localhost");
define("CONF_DB_USER", "u813134528_freelashop");
define("CONF_DB_PASS", "Rede2050kl@");
define("CONF_DB_NAME", "u813134528_freelashop");

/**
 * PROJECT URLs
 */
define("CONF_URL_BASE", "https://www.freelashop.com.br");
define("CONF_URL_TEST", "http://localhost/freelashop");

/**
 * SITE
 */
define("CONF_SITE_NAME", "FreelaShop");
define("CONF_SITE_TITLE", "Contrate ou seja um profissional freelancer");
define("CONF_SITE_DESC", "Contrate um profissional de qualidade para realizar o seu projeto ou trabalhe hoje mesmo como um freelancer aqui no ".CONF_SITE_NAME.".");
define("CONF_SITE_LANG", "pt_BR");
define("CONF_SITE_CNPJ", "44.920.388/0001-14");
define("CONF_SITE_DOMAIN", "freelashop.com.br");
define("CONF_SITE_EMAIL", "sac@freelashop.com.br");
define("CONF_SITE_PHONE", "(11) 9 4363-2003");
define("CONF_SITE_WHATSAPP", "(11) 9 4363-2003");
define("CONF_SITE_ADDR_STREET", "Magalhães Lemos");
define("CONF_SITE_ADDR_NUMBER", "203");
define("CONF_SITE_ADDR_COMPLEMENT", "");
define("CONF_SITE_ADDR_CITY", "São Paulo");
define("CONF_SITE_ADDR_STATE", "SP");
define("CONF_SITE_ADDR_ZIPCODE", "05207130");


/**
 * PROJECT
 */
define("CONF_SEND_PROPOSAL", [
    "FREE" => 2,
    "BASIC" => 4,
    "STARDARD" => 9
]);
define("CONF_SITE_PERCENTAGE", 5);

/**
 * SOCIAL
 */
define("CONF_SOCIAL_PAGE", [
    "twitter" => "FreelaShop",
    "facebook" => "freelashop",
    "instagram" => "freelashop.oficial",
    "linkedin" => "freela-shop-852597230"
]);

define("CONF_SOCIAL_TWITTER_CREATOR", CONF_SOCIAL_PAGE["twitter"]);
define("CONF_SOCIAL_TWITTER_PUBLISHER", CONF_SOCIAL_PAGE["twitter"]);
define("CONF_SOCIAL_FACEBOOK_APP", "297249005611704");
define("CONF_SOCIAL_FACEBOOK_PAGE", CONF_SOCIAL_PAGE["facebook"]);
define("CONF_SOCIAL_FACEBOOK_AUTHOR", CONF_SOCIAL_PAGE["facebook"]);

/**
 * DATES
 */
define("CONF_DATE_BR", "d/m/Y H:i:s");
define("CONF_DATE_APP", "Y-m-d H:i:s");

/**
 * PASSWORD
 */
define("CONF_PASSWD_MIN_LEN", 8);
define("CONF_PASSWD_MAX_LEN", 40);
define("CONF_PASSWD_ALGO", PASSWORD_DEFAULT);
define("CONF_PASSWD_OPTION", ["cost" => 10]);

/**
 * VIEW
 */
define("CONF_MANUTENCAO", false);
define("CONF_VIEW_PATH", __DIR__ . "/../../shared/views");
define("CONF_VIEW_EXT", "php");
define("CONF_VIEW_THEME", "freelaweb");
define("CONF_VIEW_APP", "freelaapp");
define("CONF_VIEW_ADMIN", "freelaadm");

/**
 * UPLOAD
 */
define("CONF_UPLOAD_DIR", "storage");
define("CONF_UPLOAD_IMAGE_DIR", "images");
define("CONF_UPLOAD_FILE_DIR", "files");
define("CONF_UPLOAD_MEDIA_DIR", "medias");

/**
 * IMAGES
 */
define("CONF_IMAGE_CACHE", CONF_UPLOAD_DIR . "/" . CONF_UPLOAD_IMAGE_DIR . "/cache");
define("CONF_IMAGE_SIZE", 2000);
define("CONF_IMAGE_QUALITY", ["jpg" => 75, "png" => 5]);

/**
 * MAIL
 */
define("CONF_MAIL_HOST", "smtp.hostinger.com");
define("CONF_MAIL_PORT", "465");
define("CONF_MAIL_USER", "no-reply@freelashop.com.br");
define("CONF_MAIL_PASS", "!ILUzx58ReIv@u2d##");
define("CONF_MAIL_SENDER", ["name" => "FreelaShop", "address" => "no-reply@freelashop.com.br"]);
define("CONF_MAIL_SUPPORT", "sac@freelashop.com.br");
define("CONF_MAIL_OPTION_LANG", "br");
define("CONF_MAIL_OPTION_HTML", true);
define("CONF_MAIL_OPTION_AUTH", true);
define("CONF_MAIL_OPTION_SECURE", "ssl");
define("CONF_MAIL_OPTION_CHARSET", "utf-8");

/**
 * ACCOUNT
 */
define("CONF_ACCOUNT_BANK", "336 - Banco C6 S.A");
define("CONF_ACCOUNT_RECIPIENT", "FreelaShop LTDA");
define("CONF_ACCOUNT_ACCOUNT", "14388103-5");
define("CONF_ACCOUNT_AGENCY", "0001");
define("CONF_ACCOUNT_PIX_KEY", "44.920.388/0001-14");
define("CONF_ACCOUNT_PIX_TYPE", "CNPJ");
define("CONF_ACCOUNT_PIX_QRCODE", "");

/**
 * TELEGRAM
 */
define("CONF_TELEGRAM_KEY", "5081932001:AAHJdrGMnyt62ZxG_bbioIxbmJX-9Iu8Jfw");
define("CONF_TELEGRAM_CHANNEL", "-1001666062093");


/**
 * GETNET
 */
define("CONF_PAY_SANDBOX", true);
define("CONF_PAY_KEY_PUB_PROD", "pk_956xB0jC7HrWwzoK");
define("CONF_PAY_KEY_SECRET_PROD", "sk_EG0pZlFDZh349Deg");

define("CONF_PAY_KEY_PUB_SANDBOX", "pk_test_Z7jqAwqsLRhpkr2v");
define("CONF_PAY_KEY_SECRET_SANDBOX", "sk_test_QVEXyEnFpUd1Xkv2");