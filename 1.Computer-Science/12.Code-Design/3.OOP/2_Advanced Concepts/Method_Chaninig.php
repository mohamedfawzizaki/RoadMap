#______________________________________________________________________________________________________________________________________________________________________
# Method Chaining:
          -> It is a technique in object-oriented programming where multiple methods are invoked sequentially on the same object instance in a single statement.  
          -> It can be achieved by returning the object itself ( $this ) from each method call, allowing subsequent methods to be called on the same object.
          -> there are two case :
                        1.Non Static Method Chaining.
                        2.Static Method Chaining.

          -> you can chain methods in the trait as well. 

#-------------------------------------------------------------------------------------
# Non Static Method Chaining:          
<?php
class Calculator{

            private $result;
        
            public function __construct($initialValue) {
                $this->result = $initialValue;
            }
        
            public function add($value){

                $this->result += $value;
                // Return $this for method chaining
                return $this; 
            }
        
            public function subtract($value){
                
                $this->result -= $value;
                
                // Return $this for method chaining
                return $this; 
            }
        
            public function multiply($value){

                $this->result *= $value;
                
                // Return $this for method chaining
                return $this; 
            }
        
            public function getResult(){

                return $this->result;
            }
}
 
// Example usage of method chaining
$calculator = new Calculator(10);

$result = $calculator->add(5)->subtract(3)->multiply(2)->getResult();

# $calculator->add(5);  
# $calculator->subtract(3);  
# $calculator->multiply(2);  
# echo $calculator->getResult();  
 
?> 


#-------------------------------------------------------------------------------------
# Static Method Chaining:  
<?php 
class MyClass{

            public static function methodOne(){

                echo "Method One\n";
                // return new static(); or return new self(); or return new MyClass();
                return new static(); 
            }

            public static function methodTwo(){

                echo "Method Two\n";
                // return new static(); or return new self(); or return new MyClass();
                return new static();  
            }

            public static function methodThree(){

                echo "Method Three\n";
                // return new static(); or return new self(); or return new MyClass();
                return new static();  
            }
}

// Chaining static methods
MyClass::methodOne()->methodTwo()->methodThree();

?>
#______________________________________________________________________________________________________________________________________________________________________
