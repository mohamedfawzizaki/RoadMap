#______________________________________________________________________________________________________________________________________________________________________
# Trait :
        -> https://www.w3schools.com/php/php_oop_traits.asp
        -> https://www.php.net/manual/en/language.oop5.traits.php#language.oop5.traits.constants                                               

        -> Single Traits.
        -> Multiple Traits / Conflict Resolution. 
        -> Precedence Order.
        -> Changing Method Visibility. 
        -> Traits Composed from Traits. 
        -> Abstract Trait Members. 
        -> Static Trait Members : properties / Methods / Method's Variables.
        -> Properties / Conflict Resolution. 
        -> Method Chaining.

#-------------------------------------------------------------------------------------------------
# Conflict Resolution:
<?php
trait traitName1{
        public function feature(){
                echo 'hello from traitName1<br/>';
        }
}

trait traitName2{
        public function feature(){
                echo 'hello from traitName2<br/>';
        }
}

class className{
        use traitName1, traitName2{
                
                # traitName::methodName insteadof otherTraitName
                traitName1::feature insteadof traitName2;
                
                # traitName::methodName as newAccessModifier newMethodName;
                traitName2::feature as featureOfTraitName1;
        }
}

$obj = new className();

$obj->feature();
$obj->featureOfTraitName1();

?>
#-------------------------------------------------------------------------------------------------
#


<?php
trait traitName{
    public function feature(){
        echo 'hello from trait';
    }
}

class className{
    use traitName{
        # traitName::methodName as newAccessModifier; 
        # this syntax change the trait method visiblity.
        traitName::feature as public;
        
        # traitName::methodName as newAccessModifier newMehtodName; 
        # this syntax deosn't change the trait method visiblity, but makes an alias from this method but with other visibilty marker.
        traitName::feature as public f;
    }

}

$obj = new className();
$obj->feature();
$obj->f();
 
?>
#-------------------------------------------------------------------------------------------------
#

<?php
trait traitName{
    public function feature(){
        echo 'hello from trait';
    }
}
class parentclass{
    public function feature(){
        echo 'hello from parent class';
    }
}
class subClass extends parentClass{
    use traitName;
    // public function feature(){
    //     echo 'hello from subClass';
    // }
}

$obj = new subClass();
$obj->feature();
?>

#-------------------------------------------------------------------------------------------------
#

<?php
trait traitName1{
    public function feature1(){
        echo 'feature1 from trait1<br>';
        return $this;
    }
}
trait traitName2{
    public function feature2(){
        echo 'feature2 from trait2<br>';
        return $this;
    }
}
class className{
    use traitName1, traitName2;
}

$obj = new className('mohamed'); 
$obj->feature1()->feature2();
?>
#-------------------------------------------------------------------------------------------------
#

<?php
trait traitName1{
    public function featureFromTrait1(){
        echo 'hello from trait1<br/>';
    }
}
trait traitName2{
    public function featureFromTrait2(){
        echo 'hello from trait2<br/>';
    }
}
trait mainTrait{
    use traitName1, traitName2;
    public function featureFromMainTrait(){
        echo 'hello from main trait<br/>';
    }
}

class className{
    use mainTrait;

}

$obj = new className();
$obj->featureFromTrait1();
$obj->featureFromTrait2();
$obj->featureFromMainTrait(); 
 
?>

#-------------------------------------------------------------------------------------------------
#
<?php
trait traitName{
    public function featureFromTrait(){
        echo 'hello from trait<br/>';
    }
    abstract public function abstractTraitMethod();
}

class className{
    use traitName;
    public function abstractTraitMethod(){
        echo 'hello from abstract trait method defined in the class<br/>';
    }

}

$obj = new className();
$obj->featureFromTrait();
$obj->abstractTraitMethod();
?>


#-------------------------------------------------------------------------------------------------
#
<?php
trait traitName{

    public const FLAG_MUTABLE = 1;
    final public const FLAG_IMMUTABLE = 5;

    public $nonStaticProperty;
    public static $staticProperty = 0;

    public static function staticTraitMethod(){
        echo "hello fromstatic Trait Method<br/>"; 
    } 
    public function methodContainingStaticVariable(){
        static $counter = 0;
        $counter++;
        echo "$counter<br/>";
    }
}

class className{
    use traitName; 
    public function __construct(){
        self::$staticProperty++;
        $this->nonStaticProperty = self::FLAG_IMMUTABLE;
        traitName::staticTraitMethod();
    }
}

$obj1 = new className();
$obj2 = new className();

echo '----------------------------------------------<br/>';
echo 'non static property : ';
echo $obj1->nonStaticProperty . '<br/>';

echo '----------------------------------------------<br/>';
echo 'static property :  ';
echo className::$staticProperty . ' : ';

className::$staticProperty++;
echo className::$staticProperty . ' : ';

className::$staticProperty += 2;
echo className::$staticProperty . ' : ';

className::$staticProperty = 0;
echo className::$staticProperty . ' <br/> ';

echo '----------------------------------------------<br/>';
echo 'trait static method : <br/>';
$obj1->staticTraitMethod();
$obj2->staticTraitMethod();

echo '----------------------------------------------<br/>';
echo 'trait method containing static variable : ';
$obj1->methodContainingStaticVariable();
$obj2->methodContainingStaticVariable();
$obj2->methodContainingStaticVariable();
$obj1->methodContainingStaticVariable();

echo '----------------------------------------------<br/>';
echo 'trait constatnts : <br/>';
echo className::FLAG_MUTABLE   . '<br/>';
echo className::FLAG_IMMUTABLE . '<br/>';
?>



#-------------------------------------------------------------------------------------------------
#


