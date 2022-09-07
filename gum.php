<?php

// Gumroaddan geldiyse
if (@$_GET["code"]) {
}else{ // Yok
    echo ":ı";
    exit;
}

function gumLogin(
    $client_id,
    $redirect_uri,
    $scope
) {
    return '
    <a href="https://app.gumroad.com/oauth/authorize?client_id='.$client_id.'&redirect_uri='.$redirect_uri.'&scope='.$scope.'" target="_blank" rel="noopener noreferrer">Gumroad ile giriş yap</a>';
}

function gum(
    $clientid,
    $clientsecret,
    $redirecturi
) {
    global $_GET;

    $code = @$_GET["code"];

    // Client ID, Application ID

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,"https://api.gumroad.com/oauth/token");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS,"code=".$code."&client_id=$clientid&client_secret=$clientsecret&redirect_uri=$redirecturi");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $server_output = curl_exec($ch);
    curl_close ($ch);

    return json_decode($server_output);
}

function gumUser(
    $access_token
) {
    function curl($url){
        $ch         = curl_init();
        $header     = array();
        $header[]   = "Accept-Language: tr-tr,en;q=0.5"; 

        curl_setopt_array($ch, [
            CURLOPT_URL             => $url,
            CURLOPT_USERAGENT       => "Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.181 Safari/537.36",
            CURLOPT_RETURNTRANSFER  => true,
            CURLOPT_SSL_VERIFYPEER  => false,
            CURLOPT_SSL_VERIFYHOST  => false,
            CURLOPT_FOLLOWLOCATION  => true,
            CURLOPT_HTTPHEADER   => $header,
            CURLOPT_AUTOREFERER     => true
        ]);

        $source = curl_exec($ch);
        curl_close($ch);

        return $source;
    }

    $curl = curl("https://api.gumroad.com/v2/user?access_token=$access_token");
    $curl = json_decode($curl, true);

    return $curl;
}

function gumApi($url){
    $ch         = curl_init();
    $header     = array();
    $header[]   = "Accept-Language: tr-tr,en;q=0.5"; 

    curl_setopt_array($ch, [
        CURLOPT_URL             => $url,
        CURLOPT_USERAGENT       => "Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.181 Safari/537.36",
        CURLOPT_RETURNTRANSFER  => true,
        CURLOPT_SSL_VERIFYPEER  => false,
        CURLOPT_SSL_VERIFYHOST  => false,
        CURLOPT_FOLLOWLOCATION  => true,
        CURLOPT_HTTPHEADER   => $header,
        CURLOPT_AUTOREFERER     => true
    ]);

    $source = curl_exec($ch);
    curl_close($ch);

    return $source;
}

$gum = gum(
    "",                  // Client ID
    "",                  // Client Secret
    "https://p"          // Redirect URI
);

/* Gerenal Info */
$access_token   = $gum->access_token;
$token_type     = $gum->token_type;
$refresh_token  = $gum->refresh_token;
$scope          = $gum->scope;
$created_at     = $gum->created_at;

/* User Info */
$gumUser        = gumUser($access_token);

$name           = $gumUser["user"]["name"];
$currency_type  = $gumUser["user"]["currency_type"];
$custom_css     = $gumUser["user"]["custom_css"];
$bio            = $gumUser["user"]["bio"];
$twitter_handle = $gumUser["user"]["twitter_handle"];
$id             = $gumUser["user"]["id"];
$user_id        = $gumUser["user"]["user_id"];
$url            = $gumUser["user"]["url"];
$links          = $gumUser["user"]["links"];
$profile_url    = $gumUser["user"]["profile_url"];
$email          = $gumUser["user"]["email"];
$display_name   = $gumUser["user"]["display_name"];

print_r($email);

/*
gumApi(); içinde kullanılan URL ile her şeyi yapabilirsin.
Üyeleri, ürünleri vs aklınıza ne geldiyse onları çekip istediğiniz gibi kullanabilirsin.

Kılavuzu buraya bırakıyorum. Gerisi çorap söküğü gibi gelir.
https://app.gumroad.com/api
*/
print_r(
    gumApi(
        "https://api.gumroad.com/v2/sales/?access_token=$access_token"
    )
);
