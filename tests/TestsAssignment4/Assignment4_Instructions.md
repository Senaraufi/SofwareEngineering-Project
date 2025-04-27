# Software Engineering and Testing - Assignment 4 Instructions

This document provides instructions on how to run the tests and complete the documentation for Assignment 4.

## Test Structure

All tests for Assignment 4 have been organized in the `tests/TestsAssignment4` directory with the following structure:

```
tests/TestsAssignment4/
├── Unit/                       # Unit Tests (5 classes)
│   ├── AlbumTest.php
│   ├── ArtistTest.php
│   ├── ConcertTest.php
│   ├── ReviewTest.php
│   └── UserTest.php
├── Validation/                 # Validation Tests
│   └── ValidationTests.php
├── UI/                         # UI Testing Template
│   └── UITestingTemplate.php
├── Requirements/               # Requirements Testing Template
│   └── RequirementsTestingTemplate.php
├── EquivalencePartition/       # Equivalence Partition Testing
│   └── EquivalencePartitionTest.php
└── BasisPath/                  # Basis Path Testing
    └── BasisPathTest.php
```

## Running the Tests

To run the tests, use the following commands:

### 1. Run All Tests

```bash
./vendor/bin/phpunit tests/TestsAssignment4
```

### 2. Run Unit Tests Only

```bash
./vendor/bin/phpunit tests/TestsAssignment4/Unit
```

### 3. Run Validation Tests Only

```bash
./vendor/bin/phpunit tests/TestsAssignment4/Validation
```

### 4. Run Equivalence Partition Tests Only

```bash
./vendor/bin/phpunit tests/TestsAssignment4/EquivalencePartition
```

### 5. Run Basis Path Tests Only

```bash
./vendor/bin/phpunit tests/TestsAssignment4/BasisPath
```

## Documentation Requirements

### A. Unit Testing (10 marks)

✅ **Completed**: 5 unit test files for core classes have been created:
- `AlbumTest.php`
- `ArtistTest.php`
- `ConcertTest.php`
- `ReviewTest.php`
- `UserTest.php`

Each test file contains multiple test methods to verify the functionality of the respective class.

### B. User Interface Testing (10 marks)

To complete this section, you need to:

1. Take screenshots of your application's UI demonstrating the 5 principles:
   - Consistency
   - Feedback
   - Recoverability
   - Minimal User Clicks
   - Guidance

2. Create a PDF document with the following structure for each principle:
   - Principle name and description
   - Screenshots showing the implementation
   - Explanation of how the principle is implemented
   - Test case to verify the implementation

3. Save the PDF in the `tests/TestsAssignment4/UI` directory as `UITesting.pdf`

### C. Validation Testing (5 marks)

✅ **Completed**: The `ValidationTests.php` file contains 5 validation tests:
1. Email Validation
2. Password Strength Validation
3. Concert Date Validation
4. Price Range Validation
5. Review Content Validation

Each test validates different aspects of data input with appropriate test cases.

### D. Requirements Testing (3 marks)

To complete this section, you need to:

1. Identify 3 core Use Cases from your original Use Case specifications
2. For each Use Case, create a checklist of requirements
3. Mark which requirements have been completed and which have not
4. Create a PDF document with these checklists
5. Save the PDF in the `tests/TestsAssignment4/Requirements` directory as `RequirementsTesting.pdf`

Example Use Cases:
- User Registration/Login
- Concert Booking
- Album Review System

### E. Equivalence Partition Testing (1 mark)

✅ **Completed**: The `EquivalencePartitionTest.php` file implements equivalence partition testing for the Concert Ticket Booking functionality.

For documentation, you need to:

1. Create a PDF document explaining:
   - The input domain (number of tickets)
   - The equivalence classes identified
   - The boundary values
   - The test cases for each equivalence class

2. Save the PDF in the `tests/TestsAssignment4/EquivalencePartition` directory as `EquivalencePartition.pdf`

### F. Basis Path Testing (1 mark)

✅ **Completed**: The `BasisPathTest.php` file implements basis path testing for the User Authentication method.

For documentation, you need to:

1. Create a PDF document explaining:
   - The control flow graph of the method
   - The calculation of cyclomatic complexity
   - The identified basis paths
   - The test cases for each path

2. Save the PDF in the `tests/TestsAssignment4/BasisPath` directory as `BasisPath.pdf`

## Submission Checklist

Ensure you have the following files ready for submission:

- [ ] 5 PHP files for Unit Testing
- [ ] 1 PDF file for UI Testing with screenshots
- [ ] 1 PHP file for Validation Testing
- [ ] 1 PDF file for Requirements Testing with checklists
- [ ] 1 PDF file for Equivalence Partition Testing
- [ ] 1 PHP file for Equivalence Partition Testing
- [ ] 1 PDF file for Basis Path Testing
- [ ] 1 PHP file for Basis Path Testing

## Demo Preparation

For the demo, be prepared to:

1. Run the tests and show the results
2. Explain the UI Testing principles and show the implementation
3. Demonstrate the Requirements Testing checklists
4. Explain the Equivalence Partition Testing
5. Explain the Basis Path Testing

## Screenshots for Documentation

To take screenshots for documentation:

1. Run your application
2. Use your system's screenshot tool (e.g., Command+Shift+4 on Mac)
3. Capture the relevant UI elements
4. Save the screenshots in a logical naming convention
5. Include the screenshots in your PDF documents

## PDF Creation Tips

You can create the required PDF documents using:
- Word/Google Docs and export as PDF
- Markdown with a converter like Pandoc
- LaTeX if you're familiar with it
- Any PDF creation tool of your choice

Make sure to include:
- Clear headings and structure
- Screenshots where required
- Explanations and justifications
- References to your code where applicable
