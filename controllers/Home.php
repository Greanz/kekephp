<?php
    class Home {

        public function __construct()
        {

        }

        function index(){
            $data = [
                'router'=>$this->router
            ];
            loadView("index",$data);
        }

        function method2(){
            echo "Am method 2";
        }

        function method3($val){
            echo "Am method 3 and value is {$val}";
        }

        function methodWithView($val=false){
            $this->router->title = "Home Page";
            $data = [
                'title'     =>  $this->router->title,
                'name'      =>  "Kendrick",
                "covered"   =>  [
                    'Secure and easy mysql lib included',
                    'Routing made easy - see my URL',
                    'Am your own framework needs to be cleaned love me.',
                    'Guess what? I have models too',
                    "My Structure is" => scandir(ROOT_PATH)
                ],
                'router'=>$this->router,
                'value' =>  $val
            ];
            loadView("home",$data);
        }
    }