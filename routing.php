<?php
    /*
     * Author: Owen Kalungwe
     * https://github.com/Greanz
     */
    class routing{

        public $urlSegments  = [];
        public $revolvedPath = null;
        public $title        = null;
        protected $base      = null;

        public $virtualRoutes = [
            'index' => 'home'
        ];

        public function __construct($configuration,$base)
        {
            $this->base = $base;
            $this->title   = $configuration->title;
            $this->urlSegments = $this->urlSegments();

            if(empty($this->revolvedPath)){
                $this->revolvedPath = $configuration->index;
            }

            if(count($this->urlSegments) > 0) {
                //Let's check if we have any virtual route then we redirect
                $vKey = current($this->urlSegments);
                if (array_key_exists($vKey, $this->virtualRoutes) && count($this->urlSegments) === 1) {
                    $url = $this->virtualRoutes[$vKey];
                    header("Location: {$url}");
                    exit("Please wait ...");
                }
                // Let's try to resolve one path if any present
                $this->revolvedPath = current($this->urlSegments);
            }else{
                $this->urlSegments[] = $configuration->index;
            }

            $this->revolvedPath = $this->resolveFile();

            //dump($this,true); // I will show you my nakedness try me

        }

        protected function resolveFile(){
            $file = $this->base."/controllers/{$this->revolvedPath}.php";
            if(!file_exists($file)){
                $file = str_replace($this->revolvedPath,"errors",$file);
                $this->revolvedPath = "Page not found";
            }
            return $file;
        }

        public function resolveGetRequest(){
            if(strpos($_SERVER['REQUEST_URI'],'?')){
                $params = explode("?",$_SERVER['REQUEST_URI']);
                if(is_array($params)) {
                    $params = explode("&", end($params));
                    foreach ($params as $v){
                        $p = explode("=",$v);
                        if(!isset($p[1])){
                            $p[1] = "";
                        }
                        $_GET[$p[0]] = $p[1];
                    }
                }
                return $_GET;
            }
            return false;
        }

        private function urlSegments(){
            $n = explode("/", parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
            $n = array_values(array_filter($n));
            if(isset($n[0])){
                unset($n[0]);
            }
            return str_replace(".php","",array_values(array_filter($n)));
        }

        /*
         * This is bad idea but it will safely get your GET/POST values
         */
        function input($input){
            return !empty($_REQUEST[$input]) ? $_REQUEST[$input] : '';
        }

    }