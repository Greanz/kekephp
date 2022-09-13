<?php
    date_default_timezone_set("Africa/Blantyre");
    session_name("MY_SESSION_NAME_IF_NEEDED");
    session_start();
    define("APPLICATION_NAME","TEST APP",true);
    header('Access-Control-Allow-Origin: *'); //Allow any domain
    $http_origin = str_replace('www.','',$_SERVER['HTTP_HOST']);  //Allow multiple domains
    define("LOGIN_USER_ID",'1',true);
    @include("mysql.php");
    @include("helper.php");