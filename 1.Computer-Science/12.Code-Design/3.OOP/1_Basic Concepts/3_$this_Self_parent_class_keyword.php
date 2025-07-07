#______________________________________________________________________________________________________________________________________________________________________
# $this / self keywords:
           # $this keyword:
                     # The pseudo-variable $this is available when a method is called from within an object context. 
                     # $this is the value of the calling object.
                     # it is used to access class non static properities and methods from inside the class :
                                                 -> note that we don't use $ sign when accessing constant  :   $this->prop_name;
                     # it can not be used inside static function.
                     # it is only available inside class methods, and can not be used outside the class.
          
           # self:
                     # it's used to access class static/const properities and methods from inside  the class           :     self::$staticPropNameOrMethod;
                                                                                                                             className::$staticPropNameOrMethod; 

                     # note that we don't use $ sign when accessing constant                                           :     self::constantName;
                                                                                                                             className::constantName;

           # parent :
                     # it's used to access parent class properities and methods from inside  the class                 :     parent::$propName;
                                                                                                                       :     parentClassName::$propName; 
           # class  :
                     # https://www.php.net/manual/en/language.oop5.basic.php#:~:text=on%20line%2014-,%3A%3Aclass,-%C2%B6
                     # The class keyword is also used for class name resolution. To obtain the fully qualified name of a class ClassName use ClassName::class. 
                       This is particularly useful with namespaced classes.
                     # ClassName::class; 
                     # $objName::class; 

                     $c = new ClassName();
                     print $c::class;



<?php                                           
class className{         
           
            public function funName($nonStaticArg, $staticArg){
                   
                      $this->funNameerr();
                      $this->nonStaticProp  = $nonStaticArg;
                      self::$staticPropName = $staticArg;
                      className::$staticPropName = $staticArg;
           }

           public static function staticfunName(){
                    
                      echo self::$staticProp;
                      echo className::$staticProp;
           }

           public function funNameerr($nonStaticArg, $staticArg){
                   
                      $this->nonStaticProp  = $nonStaticArg;
                      self::$staticPropName = $staticArg;
                      self::staticfunName();
                      className::staticfunName();
           }
} 
?>

<?php
class className {
    
    // Method that returns the current instance using $this
    public function instance1() {
        return $this;
    }

    // Method that returns a new instance of the class using self
    public function instance2() {
        return new self;
    }
}

// Creating an instance of className
$obj = new className();

// Example usage
$instance1 = $obj->instance1(); // $instance1 is the same instance as $obj
$instance2 = $obj->instance2(); // $instance2 is a new instance of className

// Checking if $instance1 and $obj are the same instance
var_dump($instance1 === $obj); // Output: bool(true)

// Checking if $instance2 is a new instance different from $obj
var_dump($instance2 === $obj); // Output: bool(false)
?>




<?php
namespace NS {
    class ClassName {
    }
    
    echo ClassName::class;
}
?>

#______________________________________________________________________________________________________________________________________________________________________
