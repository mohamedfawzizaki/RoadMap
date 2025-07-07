<?php

/*_____________________________________________________________________OOP__________________________________________________________________________________________
/*_____________________________________________________________________OOP__________________________________________________________________________________________
/*_____________________________________________________________________OOP__________________________________________________________________________________________
OOP Concepts:

                                                              1_Class/Object/Instance.
                                                              2_Constants/Properities/Methods.
                                                              3_Visibility/Access Modifiers.
                                                              4_Static Properities/Methods.
                                                              5_Constructor/Destructor.
                                                              6_Magic Methods.
                                                              7_Method Chaining.    

                                                              1_Scope Resolution Operator (::).
                                                              2_this / self / parent keywords.
                                                              

                                                              1_Nullsafe operator.
                                                              2.Null Coalescing Operator. 


                                                              1_Encapsulation.
                                                              2_Inheritance/Trait.
                                                              3_Abstraction. 
                                                              4_interface / Polymorphism.
                                                              

                                                              1_Composition.
                                                              2_Aggregation.
                                                              3_Association.


                                                              5_Final Keyword.
                                                              6_Overriding.
                                                              7_Overloading.
                                                              
                                                              1_Depenedency Injection 'DI'. 

                                                              1_NameSpaces.
                                                              2_Autoloading Classes.
                                                              3_Anonymous classes.
                                                              
                                                              1_Object Iteration.
                                                              2_Object Cloning.             
                                                              3_Objects Comparison.
                                                              4_Object Serialization.
                                                              

                                                              1_Late Static Bindings.
                                                              2_Covariance and Contravariance.
                                                              3_OOP Changelog. 
                                                              

                                                              1_Objects and references.
                                                              2.Map and WeakMap.
                                                              3.Collections.
                                                              4.Generators.
                                                              5.SPL Classes.


/*_____________________________________________________________________OOP__________________________________________________________________________________________
/*_____________________________________________________________________OOP__________________________________________________________________________________________*/

?>
<?php
"
                   _______________________________________________________________________________________________________________________________________________
                  | **OOP Concept**                       | **Description**                                                                                       |
                  |_______________________________________|_______________________________________________________________________________________________________|
                  | **1. Class/Object/Instance:           | Fundamental building blocks of OOP. A class is a blueprint, an object is an instance of a class.      |
                  |-----------------------------------------------------------------------------------------------------------------------------------------------|
                  | **2. Constants/Properties/Methods:    | Constants are immutable values, properties are variables within a class, methods are functions.       |
                  |-----------------------------------------------------------------------------------------------------------------------------------------------|
                  | **3. Visibility/Access Modifiers:     | Control access to class members (`public`, `protected`, `private`).                                   |
                  |-----------------------------------------------------------------------------------------------------------------------------------------------|
                  | **4. Static Properties/Methods:       | Belong to the class itself rather than any object instance.                                           |
                  |-----------------------------------------------------------------------------------------------------------------------------------------------|
                  | **6. Constructor/Destructor:          | Special methods for object initialization and cleanup.                                                |
                  |-----------------------------------------------------------------------------------------------------------------------------------------------|
                  | **7. Magic Methods:                   | Special methods prefixed with `__`, providing hooks into object behavior (e.g., `__construct`).       |
                  |-----------------------------------------------------------------------------------------------------------------------------------------------|
                  | **8. Scope Resolution Operator (::):  | Access static, constant, and overridden properties/methods of a class.                                |
                  |-----------------------------------------------------------------------------------------------------------------------------------------------|
                  | **9. `$this` / `self` / `parent` :    | `$this` refers to the current object, `self` to the current class,`parent` to the parent class. |
                  |-----------------------------------------------------------------------------------------------------------------------------------------------|
                  | **10. Encapsulation:                  | Bundling data with methods that operate on that data.                                                 |
                  |-----------------------------------------------------------------------------------------------------------------------------------------------|
                  | **11. Inheritance/Trait:              | Mechanism for a class to inherit properties/methods from another class. Traits allow code reuse.      |
                  |-----------------------------------------------------------------------------------------------------------------------------------------------|
                  | **12. Abstraction:                    | Hiding complex implementation details and showing only the necessary features.                        |
                  |-----------------------------------------------------------------------------------------------------------------------------------------------|
                  | **13. Polymorphism/Interface:         | Ability for different classes to be treated as instances of the same class through interfaces.        |
                  |-----------------------------------------------------------------------------------------------------------------------------------------------|
                  | **14. Final Keyword:                  | Prevents further inheritance of a class or overriding of a method.                                    |
                  |-----------------------------------------------------------------------------------------------------------------------------------------------|
                  | **15. Overriding:                     | Redefining a parent class method in a child class.                                                    |
                  |-----------------------------------------------------------------------------------------------------------------------------------------------|
                  | **16. Overloading:                    | Providing multiple methods with the same name but different parameters (not natively supported in PHP)|
                  |-----------------------------------------------------------------------------------------------------------------------------------------------|
                  | **17. Dependency Injection (DI):      | Design pattern for passing dependencies into objects rather than creating them internally.            |
                  |-----------------------------------------------------------------------------------------------------------------------------------------------|
                  | **18. Namespaces:                     | Provide a way to group related classes, interfaces, functions, and constants.                         |
                  |-----------------------------------------------------------------------------------------------------------------------------------------------|
                  | **19. Iterables:                      | Any value that can be looped through with `foreach` (e.g., arrays, objects implementing `Traversable`)|
                  |-----------------------------------------------------------------------------------------------------------------------------------------------|
                  | **20. Autoloading Classes:            | Automatically loading class files when they are needed.                                               |
                  |-----------------------------------------------------------------------------------------------------------------------------------------------|
                  | **21. Anonymous Classes:              | Classes defined without a name, useful for one-off objects.                                           |
                  |-----------------------------------------------------------------------------------------------------------------------------------------------|
                  | **22. Object Cloning:                 | Creating a copy of an object with the `clone` keyword.                                                |
                  |-----------------------------------------------------------------------------------------------------------------------------------------------|
                  | **23. Object Iteration:               | Iterating over an object's properties using `foreach`.                                                |
                  |-----------------------------------------------------------------------------------------------------------------------------------------------|
                  | **24. Object Comparison:              | Comparing objects using `==` (equality) and `===` (identity).                                         |
                  |-----------------------------------------------------------------------------------------------------------------------------------------------|
                  | **25. Late Static Bindings:           | Referring to the called class in a context of static inheritance.                                     |
                  |-----------------------------------------------------------------------------------------------------------------------------------------------|
                  | **26. Objects and References:         | Understanding how objects are referenced and copied in PHP.                                           |
                  |-----------------------------------------------------------------------------------------------------------------------------------------------|
                  | **27. Object Serialization:           | Converting an object to a storable string format and vice versa.                                      |
                  |-----------------------------------------------------------------------------------------------------------------------------------------------|
                  | **28. Covariance and Contravariance:  | Rules for method overriding concerning parameter and return types.                                    |
                  |-----------------------------------------------------------------------------------------------------------------------------------------------|
                  | **29. OOP Changelog:                  | Changes and updates in OOP features across different PHP versions.                                    |
                  |-----------------------------------------------------------------------------------------------------------------------------------------------|
                  | **30. Map and WeakMap:                | Map is a collection of key-value pairs. WeakMap is similar, but keys are weakly referenced.           |     
                  |-----------------------------------------------------------------------------------------------------------------------------------------------|
                  | **31. Collections:                    | Data structures like arrays, lists, and dictionaries that store and manage groups of objects.         |     
                  |-----------------------------------------------------------------------------------------------------------------------------------------------|
                  | **32. Generators:                     | Simplify iteration by yielding values one at a time, maintaining state between yields.                |     
                  |-----------------------------------------------------------------------------------------------------------------------------------------------|
                  | **33. SPL Classes:                    | Standard PHP Library classes for common data structures and algorithms (e.g., SplStack, SplQueue).    |     
                  |-----------------------------------------------------------------------------------------------------------------------------------------------|
                  |-----------------------------------------------------------------------------------------------------------------------------------------------|
                  |-----------------------------------------------------------------------------------------------------------------------------------------------|
                  |_______________________________________|_______________________________________________________________________________________________________|
"?>


