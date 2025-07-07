#______________________________________________________________________________________________________________________________________________________________________
# Interfaces : https://www.php.net/manual/en/language.oop5.interfaces.php


# Interfaces allow you to specify what methods a class should implement.

# Interfaces make it easy to use a variety of different classes in the same way. When one or more classes use the same interface, it is referred to as "polymorphism".

# Interfaces are declared with the interface keyword:
# To implement an interface, a class must use the implements keyword.


# A class that implements an interface must implement all of the interface's methods.


# A class can implements more than one interface:
          class className implements classInterface1, classInterface2, classInterface3{}


# polymorphism:
# it can have only methods, and can not have props.
# all classes that inherit from an interface class must implement all method that found in the interface class.
#----------------------------------------------------------------------
<?php 
interface interfaceName{

      # method: 
      public function funName();  
}
#----------------------------------------------------------------------
class supClassName implements interfaceName{

      # implementation of all interface methods found in interfaceName.
}
?>
#----------------------------------------------------------------------


# PHP - Interfaces vs. Abstract Classes
# Interface are similar to abstract classes. The difference between interfaces and abstract classes are:

# Interfaces cannot have properties, while abstract classes can
# All interface methods must be public, while abstract class methods is public or protected
# All methods in an interface are abstract, so they cannot be implemented in code and the abstract keyword is not necessary
# Classes can implement an interface while inheriting from another class at the same time