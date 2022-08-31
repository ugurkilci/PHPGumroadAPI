<?php

include 'gumroadapi.php';

$access_token = gumroadAccessToken(
    "R1frASAiDF0nx5LUjPzXGqeWcxdcfEbXeD65CutOWZ8",
    "GvuLgmWSfGJsFxhR5SfvA7zJasXp7EbHBzCGuWqJ-i0",
    "https://ugurkilci.com/projects/gumroadapi/gumroadconnect.php",
    @$_GET["code"]
);

print_r(
    $access_token
);
