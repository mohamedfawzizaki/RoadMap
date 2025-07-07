Serialization : 
             -> https://www.php.net/manual/en/language.oop5.serialization.php
             -> Serialization in PHP allows you to convert an object into a string representation, 
                which can be stored or transmitted and later restored to its original form using unserialization. 
                This can be particularly useful for saving objects in sessions or databases.



Here's an example script demonstrating how serialization and unserialization work in PHP:



<?php
class User {
    private $name;
    private $email;
    private $age;
    private $data;

    // Constructor to initialize the object
    public function __construct($name, $email, $age) {
        $this->name = $name;
        $this->email = $email;
        $this->age = $age;
        $this->data = [
            'additionalInfo' => 'Some additional info',
            'preferences' => ['darkMode' => true, 'notifications' => false]
        ];
    }

    // Define how the object should be serialized
    public function __serialize(): array {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'age' => $this->age,
            'data' => $this->data
        ];
    }

    // Define how the object should be unserialized
    public function __unserialize(array $data): void {
        $this->name = $data['name'];
        $this->email = $data['email'];
        $this->age = $data['age'];
        $this->data = $data['data'];
    }

    // Display user information
    public function display() {
        echo "Name: $this->name<br/>";
        echo "Email: $this->email<br/>";
        echo "Age: $this->age<br/>";
        echo "Data: " . json_encode($this->data) . "<br/>";
    }
}

// Create a User object
$user = new User("John Doe", "john.doe@example.com", 30);

// Display the user information before serialization
echo "<strong>Before Serialization:</strong><br/>";
$user->display();

// Serialize the User object
$serializedUser = serialize($user);
echo "<strong>Serialized User:</strong><br/>" . htmlspecialchars($serializedUser) . "<br/>";

// Unserialize the string back to a User object
$unserializedUser = unserialize($serializedUser);

// Display the user information after unserialization
echo "<strong>After Unserialization:</strong><br/>";
$unserializedUser->display();
?>




