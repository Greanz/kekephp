<?php
define("date_dmy", date('d/m/Y'));
define("date_ymd", date('Y-m-d'));
define("datetime_dmy", date('d/m/Y : h:i:s'));
define("datetime_ymd", date('Y-m-d h:i:s'));

const BASE_URL = 'http://localhost/kkphprouter/';

function dump($array,$isObject=false){
    echo "<pre/>";
    if(!$isObject) {
        var_dump($array);
    }
    else{
        print_r(($array));
    }
    echo "<pre>";
}

function loadView($view,$data,$viewLocation="front"){
    if(is_array($data)) {
        extract($data);
    }
    $v = "views/{$viewLocation}/{$view}.php";
    if(!file_exists($v)){
        exit("Could not load view {$v}");
    }
    include "views/{$viewLocation}/header.php";
    include $v;
    include "views/{$viewLocation}/footer.php";
}

function toClassName($name){
    $n = explode("_",$name);
    $class = [];
    foreach ($n as $v){
        $class[] = ucwords(strtolower($v));
    }
    return implode("_",$class);
}