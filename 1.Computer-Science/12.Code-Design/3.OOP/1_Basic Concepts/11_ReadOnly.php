https://stitcher.io/blog/readonly-classes-in-php-82#only-typed-properties

https://php.watch/versions/8.1/readonly
https://php.watch/versions/8.2/readonly-classes


https://wiki.php.net/rfc/readonly_properties_v2
https://wiki.php.net/rfc/readonly_classes





<?php
readonly class BankAccount {
  // Public readonly properties
  public string $accountNumber;
  public string $accountHolder;
  public float $balance;

  // Constructor to initialize properties
  public function __construct(string $accountNumber, string $accountHolder, float $balance) {
    $this->accountNumber = $accountNumber;
    $this->accountHolder = $accountHolder;
    $this->balance = $balance;
  }

  // Method to display account information
  public function displayAccountInfo() {
    echo "Account Number: {$this->accountNumber}<br/>";
    echo "Account Holder: {$this->accountHolder}<br/>";
    echo "Balance: {$this->balance}<br/>";
  }
}

// Create an instance of the readonly class BankAccount
$account = new BankAccount('123456789', 'John Doe', 1000.00);
$account->displayAccountInfo(); // Outputs account information

// Attempt to modify a readonly property will result in an error
// $account->balance = 2000.00; // This will cause an error
?>
