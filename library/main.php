<?php
    date_default_timezone_set("Africa/Blantyre");
    session_name("MY_SESSION_NAME_IF_NEEDED");
    session_start();
    header('Access-Control-Allow-Origin: *'); //Allow any domain
    $configuration = json_decode(file_get_contents(ROOT_PATH."/configuration.json"));
    include("helper.php");
    include("mysql.php");
