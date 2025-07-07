#______________________________________________________________________________________________________________________________________________________________________
# Static Keyword:
          -> Declaring a property and method as static makes them accessible without needing an instantiation of the class.
          -> The pseudo-variable $this is not available inside the static methods.
          -> the self keyword used to access class static/const properities from inside  the class   :  self::$staticPropNameOrMethod;
                                                                                                     :  className::$staticPropNameOrMethod; 
                                                                                                     :  traitName::$staticPropNameOrMethod; 

          -> we can access class static/const properities from outside  the class                    :  className::$staticPropName;

           
          
<?php
class className{

            public $nonStaticProp = 'mohamed'; 
            public static $staticProp = 23;

            function funName($nonStaticArg, $staticArg){

                     $this->funNamee();
                     $this->nonStaticProp  = $nonStaticArg;
                     self::$staticPropName = $staticArg;
                     self::staticFun();
                     className::staticFun();
            }

            public static function staticFun(){

                   echo self::$staticProp;
                   echo className::$staticProp;
            } 
}   

#_________________________________________________________


# objects :
$objName1 = new className();
$objName2 = new className('mohamed', 23);

# access non static properities:
$objName->publicNonStaticProp = 'mohamed';

# access static properities:
className::$publicStaticProp    = '23';



# access non static functions:
$objName->funName();
$objName->funName('mo',23);

# access static functions:
className::$funName();
className::$funName('mo',23);
?>

#_________________________________________________________
 

# Note:
          -> can i access non static property in a static methods ?
        
                 -> No, you cannot directly access non-static properties within a static method in PHP. Static methods belong to the class itself, 
                    not to any particular instance of the class. Non-static properties, on the other hand, are tied to specific instances of the class.
                    However, you can access non-static properties within a static method if you pass an instance of the class to the static method.
<?php
class MyClass {
            public $instanceVar = 'Instance variable value';
            public static $staticVar = 'Static variable value';

            // Static method with an instance parameter
            public static function staticMethod($instance) {

                // Access non-static property through the instance
                echo $instance->instanceVar;
            }

            // Non-static method
            public function nonStaticMethod() {

                echo $this->instanceVar;
            }
}

// Create an instance of the class
$instance = new MyClass();

// Call the static method with the instance as a parameter
MyClass::staticMethod($instance); // Outputs: Instance variable value

// Call the non-static method
$instance->nonStaticMethod(); // Outputs: Instance variable value
?>


#______________________________________________________________________________________________________________________________________________________________________

