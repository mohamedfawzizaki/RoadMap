#______________________________________________________________________________________________________________________________________________________________________
#______________________________________________________________________________________________________________________________________________________________________


An abstract class is a class that contains at least one abstract method. 
An abstract method is a method that is declared, but not implemented in the code.

An abstract class or method is defined with the abstract keyword:

when a child class is inherited from an abstract class, we have the following rules:

The child class method must be defined with the same name and it redeclares the parent abstract method
The child class method must be defined with the same or a less restricted access modifier
The number of required arguments must be the same. However, the child class may have optional arguments in addition


the abstract method should be defined in all the child classes and they should return the same datatype.
The child class may define optional arguments that are not in the parent's abstract method, and this arguments must have default values.






PHP - Interfaces vs. Abstract Classes
Interface are similar to abstract classes. The difference between interfaces and abstract classes are:

Interfaces cannot have properties, while abstract classes can
All interface methods must be public, while abstract class methods is public or protected
All methods in an interface are abstract, so they cannot be implemented in code and the abstract keyword is not necessary
Classes can implement an interface while inheriting from another class at the same time



you cannot create an instance of an abstract class in PHP. 
Abstract classes are designed to be extended by other classes, not instantiated directly. 
#______________________________________________________________________________________________________________________________________________________________________
#______________________________________________________________________________________________________________________________________________________________________



<?php
abstract class AbstClass{
    public     $name;
    protected  $age;
    private    $salary;
    
    const PI = 3.14;

    public function __construct($name){ $this->name = $name; }
    
    public    function method1(){echo 'method1<br/>';}
    protected function method2(){echo 'method2<br/>';}

    abstract public    function method3();
    abstract protected function method4(): string;
}

class Person extends AbstClass{
    public    function method3(){
        $this->method2();
        $this->name = 'mohamed'; 
        echo $this->name;}
    protected function method4(): string{}
}



$user1 = new Person;

$user1->method1();
$user1->method3();
?>


#______________________________________________________________________________________________________________________________________________________________________
#______________________________________________________________________________________________________________________________________________________________________



<?php
interface Inface{
 
    const PI = 3.14;
    
    public function method1();
    public function method2();
    public function method3();
    public function method4();

}

class Person implements Inface{
    public function method1(){
        echo Inface::PI . '<br/>';
        echo Person::PI . '<br/>';
        echo self::PI   . '<br/>';
    }
    public function method2(){}
    public function method3(){}
    public function method4(){}
}

$user1 = new Person;

$user1->method1();
?> 


#______________________________________________________________________________________________________________________________________________________________________
#______________________________________________________________________________________________________________________________________________________________________
