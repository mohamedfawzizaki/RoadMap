/*                               https://www.php.net/manual/en/language.oop5.basic.php
# Class : 
         -> It's a template for objects.
# Object:
         -> It's an instance of a class.
         -> When the individual objects are created, 
            they inherit all the constants, properties and methods from the class, 
            but each object will have different values for the properties.
 
# instanceof keyword:
         -> You can use the instanceof keyword to check if an object belongs to a specific class:
         -> It returns true or false.
         -> var_dump($objName instanceof className);
         -> echo $objName instanceof className;
         -> var_dump($objName instanceof className);
         -> if($objName instanceof className){}
*/

<?php
include 'ErrorHandler.php';

class Phone{
    public $name;
    public $model;
} 

$iphone = new Phone;

var_dump($iphone instanceof Phone);

?>
 