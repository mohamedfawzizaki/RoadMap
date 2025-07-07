# Properities / Methods:
         
         1.public    Properities.
         2.protected Properities.
         3.private   Properities.
         
         1.Uninitialized Properities.
         2.Initialized Properities.

         1.Non Static Properities.
         2.Static Properities.

         1.Non Constant Properities.
         2.Constant Properities.
      
# Class  Constant:
              
          -> we can access a constant from inside the class by using the self keyword followed by the scope resolution operator (::) followed by the constant name,
          -> Class constants are inherently static, meaning they belong to the class itself rather than any instance of the class. 
          -> We can access a constant from outside the class by using the class name followed by the scope resolution operator (::) followed by the constant name, like here:
          -> the constants must be have a value.
          -> Syntax : 
                  -> constatnt declaration:
                           public    const CONSTNAME = 'value'; 
                           protected const CONSTNAME = 'value'; 
                           private   const CONSTNAME = 'value'; 
                  -> access a constatnt from inside  a class:
                         
                           self::CONSTNAME;
                           className::CONSTNAME;
                  -> access a constatnt from outside a class:
                           className::CONSTNAME;

# Access Modifiers :
          -> Properties and methods can have access modifiers which control where they can be accessed.
          -> There are three access modifiers:

                  1.public    : the property or method can be accessed from everywhere. This is default.
                  2.protected : the property or method can be accessed within the class and by classes derived from that class.
                  3.private   : the property or method can ONLY be accessed within the class.

#____________________________________________________________________________________________________________________________________________________________________
#____________________________________________________________________________________________________________________________________________________________________
# non Typed Properities:
<?php
class className{
           # uninitialized / non static properities: 
           public     $publicNonStaticProp;
           protected  $protectedNonStaticProp;
           private    $privateNonStaticProp;

           # uninitialized / static properities: 
           public    static $publicStaticProp;
           protected static $protectedStaticProp;
           private   static $privateStaticProp;
           
           #_________________________________________________________

           # initialized / non static properities:
           public     $publicNonStaticProp = 'mohamed';
           protected  $protectedNonStaticProp = 23;
           private    $privateNonStaticProp = 'asd@gmail.com';

           # initialized / static properities:
           public    static $publicStaticProp = 11;
           protected static $protectedStaticProp = 121;
           private   static $privateStaticProp = 45;
           
           #_________________________________________________________

           # const properity:
           const CONSTPROPERITY1 = 3.14;
           const CONSTPROPERITY2 = 'welcome to my website';
         
           #_________________________________________________________

           # methods:
           function funName(){}                             # public method bt default.
 
           public    function funName(){}
           protected function funName(){}
           private   function funName(){}
 
           public    static function funName(){}
           protected static function funName(){}
           private   static function funName(){}
}

#_________________________________________________________

# objects :
$objName1 = new className;
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





#-----------------------------------------------------------------------------------------------------------------------
# Typed Properities:
<?php

class DataTypeDemo {
        // Basic data types
        public int $publicInt;
        public float $publicFloat;
        public string $publicString;
        public bool $publicBool;
        public array $publicArray;
        public ?object $publicObject; // Nullable object type
        public $publicMixed; // No type specified (can be any type)
        
        // Special types
        public ?callable $publicCallable = null; // Nullable callable type
        public $publicResource; // Resource type (e.g., file handles)

        // Nullable types
        public ?int $nullableInt = null;
        public ?float $nullableFloat = null;
        public ?string $nullableString = null;
        public ?bool $nullableBool = null;

        // Static property
        public static string $publicStaticString = "Static Property";

        public function __construct() {
                $this->publicInt = 42;
                $this->publicFloat = 3.14;
                $this->publicString = "Hello, World!";
                $this->publicBool = true;
                $this->publicArray = ["apple", "banana", "cherry"];
                $this->publicObject = (object) ['key' => 'value']; // Creating a new stdClass object
                $this->publicMixed = "I can be anything";
                $this->publicCallable = function() {
                return "I'm callable!";
                };
                $this->publicResource = fopen('php://memory', 'r'); // Example resource
        }

        public function __destruct() {
                if (is_resource($this->publicResource)) {
                fclose($this->publicResource); // Closing resource if it's still open
                }
        }

        // Functions to return each data type
        public function getInt(): int {
                return $this->publicInt;
        }

        public function getFloat(): float {
                return $this->publicFloat;
        }

        public function getString(): string {
                return $this->publicString;
        }

        public function getBool(): bool {
                return $this->publicBool;
        }

        public function getArray(): array {
                return $this->publicArray;
        }

        public function getObject(): ?object {
                return $this->publicObject;
        }

        public function getMixed() {
                return $this->publicMixed;
        }

        public function getCallable(): ?callable {
                return $this->publicCallable;
        }

        public function getResource() {
                return $this->publicResource;
        }

        public function getNullableInt(): ?int {
                return $this->nullableInt;
        }

        public function getNullableFloat(): ?float {
                return $this->nullableFloat;
        }

        public function getNullableString(): ?string {
                return $this->nullableString;
        }

        public function getNullableBool(): ?bool {
                return $this->nullableBool;
        }

        public static function getStaticString(): string {
                return self::$publicStaticString;
        }
}

// Example of creating an instance of the class
$demo = new DataTypeDemo();

// Accessing properties via functions
echo $demo->getInt() . "\n";
echo $demo->getFloat() . "\n";
echo $demo->getString() . "\n";
echo $demo->getBool() ? 'true' : 'false' . "\n";
print_r($demo->getArray());
echo $demo->getObject()->key . "\n";
echo $demo->getMixed() . "\n";
echo ($demo->getCallable())() . "\n";

// Accessing the static property via function
echo DataTypeDemo::getStaticString() . "\n";
?>




