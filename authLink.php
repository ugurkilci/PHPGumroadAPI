<?php

include 'gumroadapi.php';

function gumroadAuthLink(
    $client_id,
    $redirect_uri,
    $scope
) {
    return "https://app.gumroad.com/oauth/authorize?client_id=$client_id&redirect_uri=$redirect_uri&scope=$scope";
}

$authLink = gumroadAuthLink(
    "R1frASAiDF0nx5LUjPzXGqeWcxdcfEbXeD65CutOWZ8",
    "https://ugurkilci.com/projects/gumroadapi/gumroadconnect.php",
    "view_profile%20view_sales%20edit_products%20mark_sales_as_shipped%20refund_sales"
);

echo '<a href="' . $authLink . '">Gumroad ile giriş yap</a>';
