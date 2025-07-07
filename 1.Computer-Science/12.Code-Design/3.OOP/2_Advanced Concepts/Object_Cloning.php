https://www.php.net/manual/en/language.oop5.cloning.php


https://medium.com/@farmanali1588594/understanding-deep-copy-and-shallow-copy-in-php-a-comprehensive-guide-d6eb26073545




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