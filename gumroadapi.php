<?php

function gumroadAccessToken(
    $clientid,
    $clientsecret,
    $redirecturi,
    $code
) {
    // Client ID, Application ID

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,"https://api.gumroad.com/oauth/token");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS,"code=".$code."&client_id=$clientid&client_secret=$clientsecret&redirect_uri=$redirecturi");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $server_output = curl_exec($ch);
    curl_close ($ch);

    return $server_output;
}

function gumroadUser(
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

    $json = json_decode($access_token, true);
    $access_token = $json["access_token"];

    $curl = curl("https://api.gumroad.com/v2/user?access_token=$access_token");
    $curl = json_decode($curl, true);

    return $curl;
}
