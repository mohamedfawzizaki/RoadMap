// g++ test.cpp -o test.exe
// .\test.exe 

#include <iostream>
#include <algorithm>  // For binary_search, sort
using namespace std;

int main() {
    // 1. Declare a Static Array (One-dimensional)
    const int SIZE = 10;         // Maximum size of the static array
    int arr[SIZE] = {10, 20, 30, 40, 50}; // Initialize with some values
    int currentSize = 5;         // Current number of filled elements
    // 2. Access by Index**
    cout << "Element at index 2: " << arr[2] << endl;
    // 3. Update**

    
    arr[1] = 99;  // Updates the element at index 1
    // 4. Search (Linear)**
    int key = 40;
    bool found = false;
    for (int i = 0; i < currentSize; i++) {
        if (arr[i] == key) {
            cout << "Found " << key << " at index " << i << endl;
            found = true;
            break;
        }
    }
    if (!found) cout << "Element not found." << endl;
    // 5. Search (Binary) (On Sorted Array)**
    sort(arr, arr + currentSize);  // Ensure the array is sorted first
    if (binary_search(arr, arr + currentSize, key)) {
        cout << "Found " << key << " using binary search." << endl;
    } else {
        cout << "Element not found in binary search." << endl;
    }
    // 6. Insert at End (Only if Space Available)
    if (currentSize < SIZE) {
        arr[currentSize] = 60;  // Insert at the next available position
        currentSize++;
    } else {
        cout << "Array is full, cannot insert." << endl;
    }   
    // 7. Insert at Index (with Shifting)**
    int insertIndex = 2;
    int newValue = 55;
    if (currentSize < SIZE) {
        // Shift elements to the right
        for (int i = currentSize; i > insertIndex; i--) {
            arr[i] = arr[i - 1];
        }
        arr[insertIndex] = newValue;
        currentSize++;
    } else {
        cout << "Array is full, cannot insert at index." << endl;
    }
    // 8. Delete at Index (with Shifting)**
    int deleteIndex = 3;

    if (deleteIndex < currentSize) {
        // Shift elements to the left
        for (int i = deleteIndex; i < currentSize - 1; i++) {
            arr[i] = arr[i + 1];
        }
        currentSize--;
    } else {
        cout << "Invalid delete index." << endl;
    }

    // Declare a Static Array (Two-dimensional)
    const int ROWS = 3, COLS = 3;
    int matrix[ROWS][COLS] = {
        {1, 2, 3},
        {4, 5, 6},
        {7, 8, 9}
    };
    // Accessing elements in a 2D array
    cout << "Element at (1, 2): " << matrix[1][2] << endl; // Accessing element at row 1, column 2
    // Updating an element in a 2D array
    matrix[0][0] = 10; // Updating the element at row 0, column 0
    cout << "Updated element at (0, 0): " << matrix[0][0] << endl;
    // Searching in a 2D array (linear search)
    int searchKey = 5;
    bool foundInMatrix = false;
    for (int i = 0; i < ROWS; i++) {
        for (int j = 0; j < COLS; j++) {
            if (matrix[i][j] == searchKey) {
                cout << "Found " << searchKey << " at (" << i << ", " << j << ")" << endl;
                foundInMatrix = true;
                break;
            }
        }
        if (foundInMatrix) break;
    }
    if (!foundInMatrix) {
        cout << "Element not found in the matrix." << endl;
    }
    // Displaying the final state of the array
    cout << "Final Array: ";
    for (int i = 0; i < currentSize; i++) {
        cout << arr[i] << " ";
    }
    cout << endl;
    // Displaying the final state of the matrix
    cout << "Final Matrix: " << endl;
    for (int i = 0; i < ROWS; i++) {
        for (int j = 0; j < COLS; j++) {
            cout << matrix[i][j] << " ";
        }
        cout << endl;
    }
            

// # ✅ **Final Code Summary**
    const int SIZE = 10;
    int arr[SIZE] = {10, 20, 30, 40, 50};
    int currentSize = 5;

    cout << "Access: " << arr[2] << endl;
    arr[1] = 99;
    cout << "Update: " << arr[1] << endl;

    // Linear search
    int key = 40;
    if (find(arr, arr + currentSize, key) != arr + currentSize)
        cout << "Found " << key << " in linear search.\n";

    // Binary search
    sort(arr, arr + currentSize);
    if (binary_search(arr, arr + currentSize, key))
        cout << "Found " << key << " in binary search.\n";

    // Insert at end
    if (currentSize < SIZE)
        arr[currentSize++] = 60;

    // Insert at index 2
    for (int i = currentSize; i > 2; i--) arr[i] = arr[i - 1];
    arr[2] = 55;
    currentSize++;

    // Delete at index 3
    for (int i = 3; i < currentSize - 1; i++) arr[i] = arr[i + 1];
    currentSize--;

    cout << "Final Array: ";
    for (int i = 0; i < currentSize; i++) cout << arr[i] << " ";
    cout << endl;

    return 0;
}