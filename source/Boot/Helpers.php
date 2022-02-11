<?php

/**
 * ####################
 * ###   VALIDATE   ###
 * ####################
 */

/**
 * @param string $email
 * @return bool
 */
function is_email(string $email): bool
{
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

/**
 * @param string $password
 * @return bool
 */
function is_passwd(string $password): bool
{
    if (password_get_info($password)['algo'] || (mb_strlen($password) >= CONF_PASSWD_MIN_LEN && mb_strlen($password) <= CONF_PASSWD_MAX_LEN)) {
        return true;
    }

    return false;
}

function int_to_float(int $value){
    return $value/100;
}

function is_cpf($cpf) {
    // Extrai somente os números
    $cpf = preg_replace( '/[^0-9]/is', '', $cpf );

    // Verifica se foi informado todos os digitos corretamente
    if (strlen($cpf) != 11) {
        return false;
    }

    // Verifica se foi informada uma sequência de digitos repetidos. Ex: 111.111.111-11
    if (preg_match('/(\d)\1{10}/', $cpf)) {
        return false;
    }

    // Faz o calculo para validar o CPF
    for ($t = 9; $t < 11; $t++) {
        for ($d = 0, $c = 0; $c < $t; $c++) {
            $d += $cpf[$c] * (($t + 1) - $c);
        }
        $d = ((10 * $d) % 11) % 10;
        if ($cpf[$c] != $d) {
            return false;
        }
    }
    return true;
}
/**
 * ##################
 * ###   STRING   ###
 * ##################
 */

/**
 * @param string $string
 * @return string
 */
function str_slug(string $string): string
{
    $string = filter_var(mb_strtolower($string), FILTER_SANITIZE_STRIPPED);
    $formats = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜüÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿRr"!@#$%&*()_-+={[}]/?;:.,\\\'<>°ºª';
    $replace = 'aaaaaaaceeeeiiiidnoooooouuuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr                                 ';

    $slug = str_replace(["-----", "----", "---", "--"], "-",
        str_replace(" ", "-",
            trim(strtr(utf8_decode($string), utf8_decode($formats), $replace))
        )
    );
    return $slug;
}

/**
 * @param string $string
 * @return string
 */
function str_studly_case(string $string): string
{
    $string = str_slug($string);
    $studlyCase = str_replace(" ", "",
        mb_convert_case(str_replace("-", " ", $string), MB_CASE_TITLE)
    );

    return $studlyCase;
}

/**
 * @param string $string
 * @return string
 */
function str_camel_case(string $string): string
{
    return lcfirst(str_studly_case($string));
}

/**
 * @param string $string
 * @return string
 */
function str_title(string $string): string
{
    return mb_convert_case(filter_var($string, FILTER_SANITIZE_SPECIAL_CHARS), MB_CASE_TITLE);
}

/**
 * @param string $text
 * @return string
 */
function str_textarea(string $text): string
{
    $text = filter_var($text, FILTER_SANITIZE_STRIPPED);
//    $arrayReplace = ["&#10;", "&#10;&#10;", "&#10;&#10;&#10;", "&#10;&#10;&#10;&#10;", "&#10;&#10;&#10;&#10;&#10;"];
//    return "<p>" . str_replace($arrayReplace, "</p><p>", $text) . "</p>";
    return $text;
}

function str_textarea_reverse(string $text): string
{
    $text = filter_var($text, FILTER_SANITIZE_STRIPPED);
    $arrayPlace = ["<br />", "<br /><br />", "<br /><br /><br />", "<br /><br /><br /><br />", "<br /><br /><br /><br /><br />"];
    $arrayReplace = ["&#10;", "&#10;&#10;", "&#10;&#10;&#10;", "&#10;&#10;&#10;&#10;", "&#10;&#10;&#10;&#10;&#10;"];
    return str_replace($arrayPlace, $arrayReplace, $text);
}

/**
 * @param string $string
 * @param int $limit
 * @param string $pointer
 * @return string
 */
function str_limit_words(string $string, int $limit, string $pointer = "..."): string
{
    $string = trim(filter_var($string, FILTER_SANITIZE_SPECIAL_CHARS));
    $arrWords = explode(" ", $string);
    $numWords = count($arrWords);

    if ($numWords < $limit) {
        return $string;
    }

    $words = implode(" ", array_slice($arrWords, 0, $limit));
    return "{$words}{$pointer}";
}

/**
 * @param string $string
 * @param int $limit
 * @param string $pointer
 * @return string
 */
function str_limit_chars(string $string, int $limit, string $pointer = "..."): string
{
    $string = trim(filter_var($string, FILTER_SANITIZE_SPECIAL_CHARS));
    if (mb_strlen($string) <= $limit) {
        return $string;
    }

    $chars = mb_substr($string, 0, mb_strrpos(mb_substr($string, 0, $limit), " "));
    return "{$chars}{$pointer}";
}

/**
 * @param string $price
 * @return string
 */
function str_price(?string $price): string
{
    return number_format((!empty($price) ? $price/100 : 0), 2, ",", ".");
}

function str_price_app($price)
{
    $price = explode(",", $price);
    $price = str_replace(".","", $price[0]).".".$price[1];
    return $price;
}

function price_symbol(float $price, $symbol = "R$",  int $decimals = 2, string $decimal_point = ",", string $thousand_point = "."): string
{
    return "{$symbol} ".number_format($price, $decimals, $decimal_point, $thousand_point);
}

/**
 * @param string|null $search
 * @return string
 */
function str_search(?string $search): string
{
    if (!$search) {
        return "all";
    }

    return (!empty($search) ? $search : "all");
}

function translate(string $string): string
{
    $string = filter_var($string, FILTER_SANITIZE_STRIPPED);
    $words = [
        "contractor" => "contratante",
        "remote" => "remoto",
        "active" => "ativo",
        "paid" => "pago",
        "pay" => "pago",
        "fixed" => "preço fixo",
        "not_authorized" => "Não autorizado",
        "month" => "Mensal",
        "processing" => "processando",
        "failed" => "falha",
        "captured" => "Capturado",
        "credit" => "crédito",
        "credit_card" => "cartão de crédito",
        "hour" => "por hora",
        "pending" => "pendente",
        "pending_pay" => "pagamento pendente",
        "paused"=>"pausado",
        "accepted"=>"publicado",
        "waiting"=>"aguardando",
        "concluded"=>"concluido",
        "canceled"=>"cancelado",
        "closed"=>"finalizado",
    ];

    return (array_key_exists($string, $words) ? $words[$string] : $string);
}

function str_code($text)
{
    $array = [
        "[SITE_NAME]" => CONF_SITE_NAME,
        "[URL]" => url(),
        "[MAIL_SUPPORT]" => CONF_MAIL_SUPPORT
    ];

    if (preg_match('/\[POST=(.*?)\]/', $text, $match) == 1) {
        $postId = $match[1];
        if(!empty($postId)){
            $post = (new \Source\Models\Post())->findById($postId);
            $array = array_merge($array, ["[POST={$postId}]"=>url()."/blog/{$post->uri}"]);
        }
    }

    return str_replace(array_keys($array), array_values($array), $text);
}
/**
 * ###############
 * ###   URL   ###
 * ###############
 */

/**
 * @param string $path
 * @return string
 */
function url(string $path = null)
{
    if (mb_strpos($_SERVER['HTTP_HOST'], "localhost") !== false) {
        if ($path) {
            if(mb_strpos($path, "#") !== false){
                if (filter_input(INPUT_GET, "route", FILTER_DEFAULT) != $path) {
                    return CONF_URL_TEST."/".$path;
                }
                return $path;
            }

            return CONF_URL_TEST . "/" . ($path[0] == "/" ? mb_substr($path, 1) : $path);
        }
        return CONF_URL_TEST;
    }

    if ($path) {
        if(mb_strpos($path, "#") !== false){
            if (filter_input(INPUT_GET, "route", FILTER_DEFAULT) != $path) {
                return CONF_URL_BASE."/".$path;
            }
            return $path;
        }
        return CONF_URL_BASE . "/" . ($path[0] == "/" ? mb_substr($path, 1) : $path);
    }

    return CONF_URL_BASE;
}

/**
 * @return string
 */
function url_back(): string
{
    return ($_SERVER['HTTP_REFERER'] ?? url());
}

/**
 * @param string $url
 */
function redirect(string $url): void
{
    header("HTTP/1.1 302 Redirect");
    if (filter_var($url, FILTER_VALIDATE_URL)) {
        header("Location: {$url}");
        exit;
    }

    if (filter_input(INPUT_GET, "route", FILTER_DEFAULT) != $url) {
        $location = url($url);
        header("Location: {$location}");
        exit;
    }
}

/**
 * ##################
 * ###   ASSETS   ###
 * ##################
 */

/**
 * @return \Source\Models\User|null
 */
function user(): ?\Source\Models\User
{
    return \Source\Models\Auth::user();
}

/**
 * @return \Source\Core\Session
 */
function session(): \Source\Core\Session
{
    return new \Source\Core\Session();
}

/**
 * @return \Source\Support\Message
 */
function message(): \Source\Support\Message
{
    return new \Source\Support\Message();
}

function AppProject(): \Source\Models\FreelaApp\AppProject
{
    return new \Source\Models\FreelaApp\AppProject();
}

/**
 * @param string|null $path
 * @param string $theme
 * @return string
 */
function theme(string $path = null, string $theme = CONF_VIEW_THEME): string
{
    if (strpos($_SERVER['HTTP_HOST'], "localhost") !== false) {
        if ($path) {
            return CONF_URL_TEST . "/themes/{$theme}/" . ($path[0] == "/" ? mb_substr($path, 1) : $path);
        }

        return CONF_URL_TEST . "/themes/{$theme}";
    }

    if ($path) {
        return CONF_URL_BASE . "/themes/{$theme}/" . ($path[0] == "/" ? mb_substr($path, 1) : $path);
    }

    return CONF_URL_BASE . "/themes/{$theme}";
}

/**
 * @param string $image
 * @param int $width
 * @param int|null $height
 * @return string
 */
function image(?string $image, int $width, int $height = null): ?string
{
    if ($image) {
        if (filter_var($image, FILTER_VALIDATE_URL)) {
            return url() . "/".(new \Source\Support\Thumb())->make(str_replace(url()."/", "", $image), $width, $height);
        }
        return url() . "/" . (new \Source\Support\Thumb())->make(CONF_UPLOAD_DIR."/{$image}", $width, $height);
    }

    return url() . "/" . (new \Source\Support\Thumb())->make(CONF_UPLOAD_DIR."/images/avatar.jpg", $width, $height);
}
/**
 * #################
 * ###   COLOR   ###
 * #################
 */

function oolor_status(string $status): ?string
{
    switch ($status){
        case "canceled":
        case "closed":
            return "danger";
            break;
        case "pending":
        case "paused":
        case "pending_pay":
            return "warning";
            break;
        case "accepted":
            return "info";
            break;
        case "concluded":
        case "active":
            return "success";
            break;
        default:
            return null;
            break;
    }
}

function statusPay(string $value){
    switch ($value){
        case "new":
            return "new";
            break;
        case "waiting":
            return "waiting";
            break;
        case "paid":
        case "settled":
            return "paid";
            break;
        case "unpaid":
            return "unpaid";
            break;
        case "refunded":
            return "refunded";
            break;
        case "contested":
            return "contested";
            break;
        case "canceled":
            return "canceled";
            break;
        default:
            return $value;
    }

    return $value;
}
/**
 * ################
 * ###   DATE   ###
 * ################
 */

/**
 * @param string $date
 * @param string $format
 * @return string
 * @throws Exception
 */
function date_fmt(?string $date = null, string $format = "d/m/Y H\hi"): string
{
    $date = (empty($date) ? "now" : $date);
    return (new DateTime($date))->format($format);
}

function date_fmt_diff(string $date, string $diff= "NOW", string $format = "Y-m-d h:i:s")
{
    return (new DateTime($date))->diff(new DateTime($diff));
}

function date_str(string $data, ?string $date = "NOW")
{
    $diff = date_fmt_diff($data, $date);
    if($diff->d && $diff->d <= 7){
        return "Há {$diff->d} dia(s) atrás";
    }else if($diff->h){
        return "Há {$diff->h} horas(s) e {$diff->i} minutos atrás";
    }else{
        if($diff->i == 0){
            return "Agora Mesmo";
        }
        return "Há {$diff->i} minutos(s) atrás";
    }

    return date_fmt($data);
}

function stars(int $qtd)
{
    echo '<div class="estrelas">';
    for($i=1; $i<=5; $i++){
        echo '<label for="cm_star-1"><i class="fa '.(($qtd >= $i) ? 'fa-yellow' : '').'"></i></label>';
    }
    echo '</div>';
}

function date_str_project(string $data, string $format = "Y-m-d h:i:s")
{
    if(date_fmt($data, "Y-m-d") == date_fmt(null, "Y-m-d")){
        return "<label><span><strong>".date_fmt($data, 'H:i')."</strong></span><br><span>Hoje</span></label>";
    }

    return "<strong>".date_fmt($data, 'H:i')."</strong><br><p>".date_fmt($data, 'd/m/Y')."</p>";
}
/**
 * @param string $date
 * @return string
 * @throws Exception
 */
function date_fmt_br(?string $date): string
{
    $date = (empty($date) ? "now" : $date);
    return (new DateTime($date))->format(CONF_DATE_BR);
}

/**
 * @param string $date
 * @return string
 * @throws Exception
 */
function date_fmt_app(?string $date): string
{
    $date = (empty($date) ? "now" : $date);
    return (new DateTime($date))->format(CONF_DATE_APP);
}

/**
 * @param string|null $date
 * @return string|null
 */
function date_fmt_back(?string $date): ?string
{
    if (!$date) {
        return null;
    }

    if (strpos($date, " ")) {
        $date = explode(" ", $date);
        return implode("-", array_reverse(explode("/", $date[0]))) . " " . $date[1];
    }

    return implode("-", array_reverse(explode("/", $date)));
}

/**
 * ####################
 * ###   PASSWORD   ###
 * ####################
 */

/**
 * @param string $password
 * @return string
 */
function passwd(string $password): string
{
    if (!empty(password_get_info($password)['algo'])) {
        return $password;
    }

    return password_hash($password, CONF_PASSWD_ALGO, CONF_PASSWD_OPTION);
}

/**
 * @param string $password
 * @param string $hash
 * @return bool
 */
function passwd_verify(string $password, string $hash): bool
{
    return password_verify($password, $hash);
}

/**
 * @param string $hash
 * @return bool
 */
function passwd_rehash(string $hash): bool
{
    return password_needs_rehash($hash, CONF_PASSWD_ALGO, CONF_PASSWD_OPTION);
}

/**
 * ###################
 * ###   REQUEST   ###
 * ###################
 */

/**
 * @return string
 */
function csrf_input(): string
{
    $session = new \Source\Core\Session();
    $session->csrf();
    return "<input type='hidden' name='csrf' value='" . ($session->csrf_token ?? "") . "'/>";
}

/**
 * @param $request
 * @return bool
 */
function csrf_verify($request): bool
{
    $session = new \Source\Core\Session();
    if (empty($session->csrf_token) || empty($request['csrf']) || $request['csrf'] != $session->csrf_token) {
        return false;
    }
    return true;
}

/**
 * @return null|string
 */
function flash(): ?string
{
    $session = new \Source\Core\Session();
    if ($flash = $session->flash()) {
        return $flash;
    }
    return null;
}

/**
 * @param string $key
 * @param int $limit
 * @param int $seconds
 * @return bool
 */
function request_limit(string $key, int $limit = 5, int $seconds = 60): bool
{
    $session = new \Source\Core\Session();
    if ($session->has($key) && $session->$key->time >= time() && $session->$key->requests < $limit) {
        $session->set($key, [
            "time" => time() + $seconds,
            "requests" => $session->$key->requests + 1
        ]);
        return false;
    }

    if ($session->has($key) && $session->$key->time >= time() && $session->$key->requests >= $limit) {
        return true;
    }

    $session->set($key, [
        "time" => time() + $seconds,
        "requests" => 1
    ]);

    return false;
}

/**
 * @param string $field
 * @param string $value
 * @return bool
 */
function request_repeat(string $field, string $value): bool
{
    $session = new \Source\Core\Session();
    if ($session->has($field) && $session->$field == $value) {
        return true;
    }

    $session->set($field, $value);
    return false;
}