<?php
    /*
     * Helping poor men hard work to be smooth
     * Author: Owen Kalungwe
     * https://github.com/Greanz
     * 13-09-2022 for the Love of Kendrick
     */
    const ROOT_PATH    = __DIR__;
    include "library/main.php";
    include "routing.php";

    /*Bro/Sis ? Play with me here*/
    //dump($configuration,1);
    //echo $configuration->site;
    //echo $configuration->info->phone;

    $router = new routing($configuration,ROOT_PATH);
    $router->resolveGetRequest();

    //url/val1/val2/val3
    /*
     * You can get these values by
     * echo $router->urlSegments[indexNo] -- Poor man - index starts on Zero discarding ur dir name
     * echo $router->urlSegments[0] - val1
     * echo $router->urlSegments[1] - val2
     */

    include ($router->revolvedPath);
    $callback  = toClassName(current($router->urlSegments));

    if(class_exists($callback)){
        $callback = new $callback();
        $callback->{"router"} = $router;
        if(empty($router->urlSegments[1])){
            if(!method_exists($callback,"index")){
                exit("<p>There is no index in the module</p>");
            }
            exit($callback->index());
        }
        else{
            $myMethod = null;
            $arg = false;
            foreach ($router->urlSegments as $index => $method){
                if(method_exists($callback,$method)){
                    $myMethod = $method;
                    if(!empty($router->urlSegments[$index + 1])){
                        $arg = end($router->urlSegments); //It takes the last arg as value
                    }
                    break;
                }
            }
            if($myMethod != null){
                if($arg){
                    exit($callback->$myMethod($arg));
                }
                else{
                    exit($callback->$myMethod());
                }
            }
            else{
                $myMethod = $router->urlSegments[1];
                exit("<p>There is no method {$myMethod}</p>");
            }
        }
    }
    else{
        exit("<p>There is no class {$callback}</p>");
    }