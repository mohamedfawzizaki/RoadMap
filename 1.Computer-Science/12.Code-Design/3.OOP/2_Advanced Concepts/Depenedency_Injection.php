#______________________________________________________________________________________________________________________________________________________________________

# Depenedency Injection :
           -> https://www.tutorialspoint.com/what-is-dependency-injection-in-php
           -> https://php-di.org/doc/understanding-di.html#with-php-di
           -> https://designpatternsphp.readthedocs.io/en/latest/Structural/DependencyInjection/README.html
           -> https://allanmacgregor.com/posts/dependency-injection-php

#______________________________________________________________________________________________________________________________________________________________________








<?php
class Database {
    // Database class implementation
}

class SomeClass {
        public ?Database $db = null;
        
        public function setDatabase(Database $db) {
            $this->db = $db;
        }
        
        public function getDatabase(): ?Database {
            return $this->db;
        }
}

        $instance = new SomeClass();
        $instance->setDatabase(new Database());
        $db = $instance->getDatabase();
?>

