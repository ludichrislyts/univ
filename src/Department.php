<?php 
    class Department
	{
        private $name;
        private $counselor;
        private $id;

        function __construct($name, $counselor, $id = null){
                $this->name = $name;
                $this->counselor = $counselor;
                $this->id = $id;
        }
                
        function setName($new_name){
            $this->name = (string) $new_name;
        }

        function getName(){
            return $this->name;
        }

        function setCounselor($counselor){
            $this->counselor = $counselor;
        }
        
        function getCounselor(){
            return $this->counselor;
        }
        
        function getId(){
            return $this-id;
        }       
        
        
        function save(){
            $GLOBALS['DB']->exec("INSERT INTO departments (name, counselor) VALUES ('{$this->getName()}, {$this->getCounselor()};");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }		
	
	}
		
        
	
	
	
?>