#include <iostream>
#include <algorithm>
using namespace std;
// 1. Find Max/Min in an Array
//   Logic: Traverse the array, compare each element.
//   Time Complexity: O(n)
int main() {
    int arr[] = {3, 7, 2, 9, 5};
    int n = sizeof(arr) / sizeof(arr[0]);

    int maxVal = arr[0], minVal = arr[0];
    for (int i = 1; i < n; i++) {
        if (arr[i] > maxVal) maxVal = arr[i];
        if (arr[i] < minVal) minVal = arr[i];
    }

    cout << "Max: " << maxVal << ", Min: " << minVal << endl;
    return 0;
// 2. Reverse an Array
//   Logic: Swap first and last, second and second-last, etc.
//   Time Complexity: O(n)
    for (int i = 0; i < n / 2; i++) {
        swap(arr[i], arr[n - i - 1]);
    }
    // manually:
    int arr[10] = {1, 2, 3, 4, 5, 6, 7, 8, 9, 10};
    int size = sizeof(arr) / sizeof(arr[0]);
    for (int i = 0; i < size; i++) {
        cout << arr[i] << " ";
    }
    cout << endl;
    int x;
    int n = 1;
    for (int i = 0; i < size - n; i++, n++) { // 1
        x = arr[size-n]; // 3 - 1 = 2 ->>> 3
        arr[size-n] = arr[i]; // 1
        arr[i] = x;
    }

    for (int i = 0; i < size; i++) {
        cout << arr[i] << " ";
    }

// 3. Rotate an Array
//  Rotate Right by k Steps
//  Logic (Optimal):
//      1. Reverse entire array.
//      2. Reverse first k elements.
//      3. Reverse the rest.
//  Time Complexity: O(n)
    int k = 2;
    k %= n;  // Handle k > n
    reverse(arr, arr + n);
    reverse(arr, arr + k);
    reverse(arr + k, arr + n);
// 4. Search in a Sorted Array (Binary Search)
//   Logic: Divide and conquer.
//   Time Complexity: O(log n)
    int key = 9;
    if (binary_search(arr, arr + n, key))
        cout << key << " found\n";
    else
        cout << key << " not found\n";
    // Or implement manually:
    int left = 0, right = n - 1;
    while (left <= right) {
        int mid = left + (right - left) / 2;
        if (arr[mid] == key) { /* found */ break; }
        else if (arr[mid] < key) left = mid + 1;
        else right = mid - 1;
    }
//  5. Sorting an Array
//   Logic: Use built-in sort (`quick sort`, `intro sort`, etc.)
//   Time Complexity: O(n log n)
    sort(arr, arr + n);
//  6. Prefix Sum Array
//   Logic: Each element is the sum of all previous elements.
//   Time Complexity: O(n)
    int prefixSum[n];
    prefixSum[0] = arr[0];
    for (int i = 1; i < n; i++) {
        prefixSum[i] = prefixSum[i - 1] + arr[i];
    }
    // Now prefixSum[i] stores sum of arr[0] to arr[i]
    int sum = prefixSum[r] - (l > 0 ? prefixSum[l - 1] : 0);

// # 🔚 Summary Table

// | Operation          | Algorithm/Method        | Time Complexity |
// | ---------------------- | --------------------------- | ------------------- |
// | Find Max/Min           | Single loop                 | O(n)                |
// | Reverse an Array       | Two-pointer swap            | O(n)                |
// | Rotate an Array        | Reverse method              | O(n)                |
// | Search in Sorted Array | Binary Search               | O(log n)            |
// | Sorting                | `sort()` (Quick/Heap/Merge) | O(n log n)          |
// | Prefix Sum             | Iterative sum               | O(n)                |
}
