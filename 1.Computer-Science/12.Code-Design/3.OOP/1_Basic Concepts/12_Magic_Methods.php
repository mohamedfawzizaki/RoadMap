#_____________________________________________________________________________________________________________________________________________________________________
#_____________________________________________________________________________________________________________________________________________________________________

# Reference :
               -> https://www.tutorialspoint.com/php-magic-methods
               -> https://www.php.net/manual/en/language.oop5.magic.php

#_____________________________________________________________________________________________________________________________________________________________________
#_____________________________________________________________________________________________________________________________________________________________________

# Magic Methods:
          
          -> Magic methods in PHP are special methods that are aimed to perform certain tasks. 
          -> These methods are named with double underscore (__) as prefix. 
          -> All these function names are reserved and can't be used for any purpose other than associated magical functionality. 
          -> Magical method in a class must be declared public. 
          -> These methods act as interceptors that are automatically called when certain conditions are met.
          -> Magic methods are special methods which override PHP's default's action when certain actions are performed on an object. 
          -> they are :
                            __construct()    
                            __destruct()  
                            
                            __call()        
                            __callStatic() 
                            
                            __get()          
                            __set() 
                            
                            __clone()
                            
                            __isset()        
                            __unset()
                            
                            __sleep()        
                            __wakeup()
                            
                            __serialize()    
                            __unserialize()
                            
                            __toString()
                            
                            __invoke()      
                            
                            __set_state() 
                            
                            __debugInfo()

          -> All magic methods, with the exception of __construct(), __destruct(), and __clone(), must be declared as public, otherwise an E_WARNING is emitted.
#_____________________________________________________________________________________________________________________________________________________________________
#_____________________________________________________________________________________________________________________________________________________________________
#_____________________________________________________________________________________________________________________________________________________________________
#_____________________________________________________________________________________________________________________________________________________________________





<?php
class MagicMethods {
    private $data = []; // Array to hold dynamic properties
    private $hiddenProperty = 'Hidden'; // Private property not directly accessible

    // Constructor: Initializes the object with initial data
    public function __construct(array $initialData) {
        $this->data = $initialData; // Store initial data
        echo "Constructor called with: " . json_encode($initialData) . "<br/>";
    }

    // Destructor: Clean-up code when the object is destroyed
    public function __destruct() {
        echo "Destructor called. Cleaning up...<br/>";
    }

    // Called when invoking inaccessible methods in an object context
    // Handles calls to undefined or inaccessible instance methods
    public function __call($method, $params) {
        echo "Attempted to call method [ <mark>$method</mark> ] with parameters: ";
        echo '<pre>';
        print_r($params); // Print parameters
        echo '</pre>';
    }
    
    // Called when invoking inaccessible static methods in an object context 
    // Handles calls to undefined or inaccessible static methods
    public static function __callStatic($method, $params) {
        echo "Attempted to call static method [ <mark>$method</mark> ] with parameters: ";
        echo '<pre>';
        print_r($params); // Print parameters
        echo '</pre>';
    }

    # Called when accessing inaccessible properties
    // Handles reading inaccessible properties
    public function __get($name) {
        echo "Getting value of inaccessible property: <mark>$name</mark><br/>";
        return $this->data[$name] ?? 'Property not found'; // Return property value or default message
    }

    # Called when setting inaccessible properties
    // Handles writing to inaccessible properties
    public function __set($name, $value) {
        echo "Setting value of inaccessible property: <mark>$name</mark> to <mark>$value</mark><br/>";
        $this->data[$name] = $value; // Store value in the data array
    }

    # Called when checking if inaccessible properties are set
    // Checks if inaccessible properties are set
    public function __isset($name) {
        $isset = isset($this->data[$name]); // Check if property exists
        echo "Checking if property <mark>$name</mark> is set: " . ($isset ? 'Yes' : 'No') . "<br/>";
        return $isset; // Return true or false
    }

    # Called when unsetting inaccessible properties
    // Handles unsetting inaccessible properties
    public function __unset($name) {
        echo "Unsetting property: <mark>$name</mark><br/>";
        unset($this->data[$name]); // Remove property from the data array
    }

    # Called when converting an object to a string
    // Defines how the object should be converted to a string
    public function __toString(): string {
        return "MagicMethods Object: [Data: " . json_encode($this->data) . ", Hidden Property: $this->hiddenProperty]";
        // Return a string representation of the object
    }

    # Called when an object is used as a function
    // Allows the object to be used as a function
    public function __invoke($arg) {
        return "Object invoked with argument: <mark>$arg</mark><br/>";
        // Return a string based on the argument passed
    }

    # Called when serializing an object
    // Defines how the object should be serialized
    public function __serialize(): array {
        return [
            'data' => $this->data,
            'hiddenProperty' => $this->hiddenProperty
        ];
        // Return an array of properties to be serialized
    }

    # Called when unserializing an object
    // Defines how the object should be unserialized
    public function __unserialize(array $data): void {
        $this->data = $data['data'] ?? []; // Restore data
        $this->hiddenProperty = $data['hiddenProperty'] ?? 'Hidden'; // Restore hidden property
    }

    # Called when printing object information with var_dump
    // Provides information for debugging
    public function __debugInfo(): array {
        return [
            'data' => $this->data,
            'hiddenProperty' => $this->hiddenProperty,
            'note' => 'This is the debug information'
        ];
        // Return an array with information for debugging purposes
    }
}

// Usage

// Create an instance with initial data
$obj = new MagicMethods(['name' => 'John', 'age' => 30]);                       echo '<br/>';                   

// Access a property (triggers __get)
echo $obj->name . "<br/>";                                                      echo '<br/>';

// Set a property (triggers __set) 
$obj->newProperty = 'New Value';                                                echo '<br/>';

// Check if a property is set (triggers __isset)
var_dump(isset($obj->newProperty));                                             echo '<br/>';

// Unset a property (triggers __unset)
unset($obj->newProperty);                                                       echo '<br/>';

// Convert object to a string (triggers __toString)
echo $obj . "<br/>";                                                            echo '<br/>';

 
// Invoke the object as a function (triggers __invoke)
echo $obj('Hello') . "<br/>";                                                   echo '<br/>';    

// Serialize the object (triggers __serialize) to string
$serializedObj = serialize($obj);
echo "Serialized object: " . $serializedObj . "<br/>";                          echo '<br/>';

// Unserialize the object (triggers __unserialize)
$unserializedObj = unserialize($serializedObj);
echo "Unserialized object:<br/>";
var_dump($unserializedObj);                                                     echo '<br/>';

// Call an undefined method (triggers __call)
$obj->undefinedMethod('param1', 'param2');                                      echo '<br/>';

// Call an undefined static method (triggers __callStatic)
MagicMethods::undefinedStaticMethod('param1', 'param2');                        echo '<br/>';

// Debug object (triggers __debugInfo)
var_dump($obj);
?>










































































#_____________________________________________________________________________________________________________________________________________________________________
#_____________________________________________________________________________________________________________________________________________________________________
#_____________________________________________________________________________________________________________________________________________________________________
#_____________________________________________________________________________________________________________________________________________________________________
#_____________________________________________________________________________________________________________________________________________________________________

# Constructors/Destructors :

    1.Constructors:
            -> A constructor allows you to initialize an object's properties upon creation of the object.
            -> If you create a __construct() function, PHP will automatically call this function when you create an object from a class.
            -> If you need to keep the constructor of class c protected for some reason, you could define a public constructor in the subclass b and call the parent constructor from there
            -> if you want to define the consructor as protected, you cann't create an objects from this class, 
               but you can inherit from it with ovarriding constructor in the subclass that call the parent::__construct(); 
            -> It's used to create a properity of type object:
               -> Syntax : 

                       public function __construct(){} 
                       public function __construct($arg1, arg2){}

                       protected function __construct(){} 
                       protected function __construct($arg1, arg2){} 
    1.Destructors:
            -> A destructor is called when the object is destructed or the script is stopped or exited.
            -> If you create a __destruct() function, PHP will automatically call this function at the end of the script.
            -> 
            -> Syntax : 

                       public function __destruct(){} 
                       public function __destruct($arg1, arg2){}

                       protected function __destruct(){} 
                       protected function __destruct($arg1, arg2){} 


    #____________________________________________________________________________________________________________________________________________________________________
    <?php
    // a class has public constructor and destructor without arguments:
    class className{

                public function __construct(){}
                public function __destruct(){}

    }
    $obj = new subClassName();
    ?>
    #____________________________________________________________________________________________________________________________________________________________________
    #____________________________________________________________________________________________________________________________________________________________________
    <?php
    // a class has public constructor and destructor with arguments:
    class className{

                public function __construct($arg1, $arg2){}
                public function __destruct(){}

    }
    $obj = new subClassName($par1, $par2);
    ?>
    #____________________________________________________________________________________________________________________________________________________________________
    #____________________________________________________________________________________________________________________________________________________________________
    <?php
    // Parent class has protected constructor and destructor:
    class parentClassName{

                protected function __construct(){}
                protected function __destruct(){}

    }
    // Sub calss has public constructor that constructor call the protected Parent Class Constructor: 
    class subClassName extends parentClassName{

                public function __construct() {
                            
                            // Call the parent constructor: 
                            parent::__construct(); 
                }

                public function __destruct() {
                            
                            // Call the parent constructor: 
                            parent::__destruct(); 
                }
    }

    $obj = new subClassName();
    ?>
    #____________________________________________________________________________________________________________________________________________________________________
    #____________________________________________________________________________________________________________________________________________________________________
    # It's used to create a properity of type object:
    <?php
    // Define the Address class
    class Address{

                public $street;
                public $city;

                public function __construct($street, $city) {
                    $this->street = $street;
                    $this->city = $city;
                }
    }

    // Define the Person class with an Address property
    class Person{

                public $name;
                public Address $address; // Property type is Address

                // Constructor accepts an Address object
                public function __construct($name, Address $address)
                {
                    $this->name = $name;
                    $this->address = $address;
                }

                // Optionally, you can define a setter method
                public function setAddress(Address $address)
                {
                    $this->address = $address;
                }
    }

    // Create an Address object
    $homeAddress = new Address('123 Elm Street', 'Springfield');

    // Create a Person object and pass the Address object to it
    $person = new Person('John Doe', $homeAddress);

    // Output
    echo 'Person Name: ' . $person->name . '<br/>';
    echo 'Address Street: ' . $person->address->street . '<br/>';
    echo 'Address City: ' . $person->address->city . '<br/>';
    ?>
    #____________________________________________________________________________________________________________________________________________________________________
    #____________________________________________________________________________________________________________________________________________________________________
    # type-hinted property and methods:
    <?php
    // Define the Address class
    class Address{
                
                public string $street;
                public string $city;

                public function __construct(string $street, string $city){
                    
                    $this->street = $street;
                    $this->city = $city;
                }
    }

    // Define the Person class with type-hinted property and methods
    class Person{

                public string $name;
                public Address $address; // Property type hinting

                // Constructor with type-hinted parameter
                public function __construct(string $name, Address $address){

                    $this->name = $name;
                    $this->address = $address;
                }

                // Setter with type-hinted parameter
                public function setAddress(Address $address): void{

                    $this->address = $address;
                }

                // Getter with return type hinting
                public function getAddress(): Address {
                    return $this->address;
                }
    }

    // Create an Address object
    $homeAddress = new Address('123 Elm Street', 'Springfield');

    // Create a Person object and pass the Address object to it
    $person = new Person('John Doe', $homeAddress);

    // Output the person's information
    echo 'Person Name: ' . $person->name . '<br/>';
    echo 'Address Street: ' . $person->getAddress()->street . '<br/>';
    echo 'Address City: ' . $person->getAddress()->city . '<br/>';
    ?>

#_____________________________________________________________________________________________________________________________________________________________________
#_____________________________________________________________________________________________________________________________________________________________________
#_____________________________________________________________________________________________________________________________________________________________________
#_____________________________________________________________________________________________________________________________________________________________________
#_____________________________________________________________________________________________________________________________________________________________________
#_____________________________________________________________________________________________________________________________________________________________________
#_____________________________________________________________________________________________________________________________________________________________________
#_____________________________________________________________________________________________________________________________________________________________________
#_____________________________________________________________________________________________________________________________________________________________________

# call / callStatic:

    1.call :
           -> It is called when invoking a method not found in the class.
           -> It is called when invoking a method not accessiable like protected or private methods.
           -> It accept 2 parameters : (string $method, array $params)
           -> Syntax : 

                    public function __call($method, $params){}    
    2.callStatic:
           -> It is called when invoking a static method not found in the class.
           -> It is called when invoking a static method not accessiable like protected or private methods.
           -> It accept 2 parameters : (string $method, array $params)
           -> Syntax : 

                    public static function __callStatic($method, $params){}  
           ->                           
    #____________________________________________________________________________________________________________________________________________________________________
    1.call :
    <?php
    class className{
                
                private function privateFunctionName(){}  
                public function __call($method, $params){
                           
                          echo "The method [<mark> " . $method . " </mark> ] not found in the class or not accessiable.<br/>";
                         
                          echo "The parameters you passed are :  ";
                          echo '<pre>';
                          print_r($params);
                          echo '</pre>';
                }

    }
    $obj = new className();
    # trying to call a private function:
    $obj->privateFunctionName(); 
    $obj->privateFunctionName('mo',23); 
    # trying to call a function that is not found in the class:
    $obj->sayHello(); 
    $obj->sayBye('mo',23);

    ?>
    #____________________________________________________________________________________________________________________________________________________________________
    2.callStatic:
    <?php
    class className{
                
                private static function privateFunctionName(){}  
                public  static function __callStatic($method, $params){
                           
                          echo "The method [<mark> " . $method . " </mark> ] not found in the class or not accessiable.<br/>";
                         
                          echo "The parameters you passed are :  ";
                          echo '<pre>';
                          print_r($params);
                          echo '</pre>';
                }

    }
    $obj = new className();
    # trying to call a private function:
    className::privateFunctionName(); 
    className::privateFunctionName('mo',23); 
    # trying to call a function that is not found in the class:
    className::sayHello(); 
    className::sayBye('mo',23);

    ?>
#_____________________________________________________________________________________________________________________________________________________________________
#_____________________________________________________________________________________________________________________________________________________________________
#_____________________________________________________________________________________________________________________________________________________________________
#_____________________________________________________________________________________________________________________________________________________________________
#_____________________________________________________________________________________________________________________________________________________________________
#_____________________________________________________________________________________________________________________________________________________________________
#_____________________________________________________________________________________________________________________________________________________________________
#_____________________________________________________________________________________________________________________________________________________________________
#_____________________________________________________________________________________________________________________________________________________________________

# Getter and Setter:

    1.getter:
           -> It is called when getting a properity not found in the class.
           -> It is called when getting a properity not accessiable like protected or private properity.
           -> It accept 1 parameter : ($properity)
           -> Syntax:  

                    function __get($properity){}

                    public function __get($properity){} 

    2.setter:
           -> It is called when setting a value to a properity not found in the class.
           -> It is called when setting a value to a properity not accessiable like protected or private properity.
           -> It accept 2 parameters : ($properity, $value)
           -> Syntax:  

                    function __set($properity, $value){}

                    public function __set($properity, $value){}




    #____________________________________________________________________________________________________________________________________________________________________
    #____________________________________________________________________________________________________________________________________________________________________
    # __get:
    <?php
    // a class has public constructor and destructor without arguments:
    class className{
                
                private $name =  'mohamed';  
                public function __get($properity){
                           
                          echo "The properity [<mark> " . $properity . " </mark> ] not found in the class or not accessiable.<br/>";
                          
                }

    }
    $obj = new className();

    # trying to get a private properity:
    echo $obj->name; 
      
    # trying to get a properity that is not found in the class:
    $age = $obj->age;  

    ?>
    #____________________________________________________________________________________________________________________________________________________________________
    #____________________________________________________________________________________________________________________________________________________________________
    # __set:
    <?php
    // a class has public constructor and destructor without arguments:
    class className{
                
                private $name;  
                public function __set($properity, $value){
                           
                          echo "The properity [<mark> " . $properity . " </mark> ] not found in the class or not accessiable.<br/>";
                          echo "The value [<mark> " . $value . " </mark> ] that you set.<br/>";
                          
                }

    }
    $obj = new className();

    # trying to set a private properity:
    $obj->name = 'ahmed'; 
      
    # trying to set a properity that is not found in the class:
    $obj->age = 23;  

    ?>
#_____________________________________________________________________________________________________________________________________________________________________
#_____________________________________________________________________________________________________________________________________________________________________
#_____________________________________________________________________________________________________________________________________________________________________
#_____________________________________________________________________________________________________________________________________________________________________
#_____________________________________________________________________________________________________________________________________________________________________
#_____________________________________________________________________________________________________________________________________________________________________
#_____________________________________________________________________________________________________________________________________________________________________
#_____________________________________________________________________________________________________________________________________________________________________
#_____________________________________________________________________________________________________________________________________________________________________

# Cloninig:
       -> https://www.w3schools.com/php/keyword_clone.asp       
       -> the copying by reference.
       -> the copying by clone keyword.
       -> the copying by clone magic method.


       <?php
       #1.copying by reference:
       class className{
                
                public $name = 'mohmed';
                public $age  = 23;
       }
       $original = new className();
       $copy = $original;

       # before modifying:
       echo '<mark>before Modifying : </mark><br/><br/>'; 
       echo '------------------------------------------------------------<br/>';
       echo 'the original object : <pre>';   print_r($original);    echo '</pre>';
       echo '------------------------------------------------------------<br/>';
       echo 'the copy object     : <pre>';   print_r($copy);        echo '</pre>';
       echo '------------------------------------------------------------<br/>';

       $copy->name = 'sayed';
       
       # after modifying:
       echo '<mark>after Modifying : </mark><br/><br/>'; 
       echo '------------------------------------------------------------<br/>';
       echo 'the original object : <pre>';   print_r($original);    echo '</pre>';
       echo '------------------------------------------------------------<br/>';
       echo 'the copy object     : <pre>';   print_r($copy);        echo '</pre>';
       echo '------------------------------------------------------------<br/>';
    
       ?>
       #---------------------------------------------------------------------------
       #---------------------------------------------------------------------------
       #---------------------------------------------------------------------------
       <?php
       #2.copying by clone keyword:
       class className{
                
                public $name = 'mohmed';
                public $age  = 23;
       }
       $original = new className();
       $copy = clone $original;

       # before modifying:
       echo '<mark>before Modifying : </mark><br/><br/>'; 
       echo '------------------------------------------------------------<br/>';
       echo 'the original object : <pre>';   print_r($original);    echo '</pre>';
       echo '------------------------------------------------------------<br/>';
       echo 'the copy object     : <pre>';   print_r($copy);        echo '</pre>';
       echo '------------------------------------------------------------<br/>';

       $copy->name = 'sayed';
       
       # after modifying:
       echo '<mark>after Modifying : </mark><br/><br/>'; 
       echo '------------------------------------------------------------<br/>';
       echo 'the original object : <pre>';   print_r($original);    echo '</pre>';
       echo '------------------------------------------------------------<br/>';
       echo 'the copy object     : <pre>';   print_r($copy);        echo '</pre>';
       echo '------------------------------------------------------------<br/>';
    
       ?>
       #---------------------------------------------------------------------------
       #---------------------------------------------------------------------------
       #---------------------------------------------------------------------------
       <?php
       #2.copying by clone magic method:
       class Address {
                public $street;
                public $city;

                public function __construct($street, $city) {
                    $this->street = $street;
                    $this->city = $city;
                }

                public function __clone() {
                    // If Address contained references to other objects, you would clone them here
                    // In this case, Address contains no objects, so no additional cloning needed
                }
        }

        class Person {
                public $name;
                public $address; // Address object

                public function __construct($name, Address $address) {
                    $this->name = $name;
                    $this->address = $address;
                }

                public function __clone() {
                    // Cloning the Address object contained in Person
                // $this->address = clone $this->address;
                }
        }

        $originalAddress = new Address('123 Elm Street', 'Springfield');
        $originalPerson = new Person('John Doe', $originalAddress);

        $copyPerson = clone $originalPerson;

        # Before modifying:
        echo '<mark>Before Modifying:</mark><br/><br/>';
        echo 'Original Person: <pre>'; print_r($originalPerson); echo '</pre>';
        echo 'Cloned Person: <pre>';   print_r($copyPerson); echo '</pre>';
        echo '------------------------------------------------------------<br/>';

        # Modify the cloned object's address
        $copyPerson->address->street = '456 Oak Avenue';

        # After modifying:
        echo '<mark>After Modifying:</mark><br/><br/>';
        echo 'Original Person: <pre>'; print_r($originalPerson); echo '</pre>';
        echo 'Cloned Person: <pre>';   print_r($copyPerson); echo '</pre>';
        echo '------------------------------------------------------------<br/>';

        ?>
#_____________________________________________________________________________________________________________________________________________________________________
#_____________________________________________________________________________________________________________________________________________________________________
#_____________________________________________________________________________________________________________________________________________________________________
#_____________________________________________________________________________________________________________________________________________________________________
#_____________________________________________________________________________________________________________________________________________________________________
#_____________________________________________________________________________________________________________________________________________________________________
#_____________________________________________________________________________________________________________________________________________________________________
#_____________________________________________________________________________________________________________________________________________________________________
#_____________________________________________________________________________________________________________________________________________________________________
<?php
class className {
    private $property1;
    private $property2;
    
    public function __construct($prop1, $prop2) {
        $this->property1 = $prop1;
        $this->property2 = $prop2;
    }

    // Implement the __serialize method
    public function __serialize(): array {
        return [
            'property1' => $this->property1,
            'property2' => $this->property2,
        ];
    }

    // Optionally, implement __unserialize to handle deserialization
    public function __unserialize(array $data): void {
        $this->property1 = $data['property1'] ?? null;
        $this->property2 = $data['property2'] ?? null;
    }
}

// Create an instance of className
$obj = new className('mohamed', 23);

// Serialize the object
$serializedObj = serialize($obj);
echo "Serialized object: <br/>" . $serializedObj . "<br/><br/>";

// Unserialize the object
$unserializedObj = unserialize($serializedObj);
echo "Unserialized object:<br/>";
var_dump($unserializedObj);
?>




#_____________________________________________________________________________________________________________________________________________________________________
#_____________________________________________________________________________________________________________________________________________________________________
#_____________________________________________________________________________________________________________________________________________________________________
#_____________________________________________________________________________________________________________________________________________________________________

<?php
class className {
    private $property1;
    private $property2;

    public function __construct($prop1, $prop2) {
        $this->property1 = $prop1;
        $this->property2 = $prop2;
    }

    // Implement the __toString method
    public function __toString(): string {
        return "className Object: [Property1: $this->property1, Property2: $this->property2]";
    }
}

// Create an instance of className
$obj = new className('value1', 'value2');

// Use the object in a string context
echo $obj; // Output: className Object: [Property1: value1, Property2: value2]
?>


#_____________________________________________________________________________________________________________________________________________________________________
#_____________________________________________________________________________________________________________________________________________________________________
<?php
class CallableClass {
    private $message;

    public function __construct($msg) {
        $this->message = $msg;
    }

    // Implement the __invoke method
    public function __invoke($additionalMessage) {
        return $this->message . ' ' . $additionalMessage;
    }
}

// Create an instance of CallableClass
$obj = new CallableClass('Hello');

// Use the object as if it were a function
echo $obj('World!'); // Output: Hello World!
?>




#_____________________________________________________________________________________________________________________________________________________________________
#_____________________________________________________________________________________________________________________________________________________________________

#_____________________________________________________________________________________________________________________________________________________________________
#_____________________________________________________________________________________________________________________________________________________________________

#_____________________________________________________________________________________________________________________________________________________________________
#_____________________________________________________________________________________________________________________________________________________________________

#_____________________________________________________________________________________________________________________________________________________________________
#_____________________________________________________________________________________________________________________________________________________________________

#_____________________________________________________________________________________________________________________________________________________________________
#_____________________________________________________________________________________________________________________________________________________________________

#_____________________________________________________________________________________________________________________________________________________________________
#_____________________________________________________________________________________________________________________________________________________________________
#_____________________________________________________________________________________________________________________________________________________________________


