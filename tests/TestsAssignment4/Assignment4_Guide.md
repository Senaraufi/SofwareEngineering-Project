# Software Engineering and Testing - Assignment 4 Guide

This guide will help you implement and document the testing requirements for Assignment 4. I've created a testing framework in the `tests/TestsAssignment4` directory that covers all the required testing components.

## Test Structure

All tests for Assignment 4 are organized in the `tests/TestsAssignment4` directory with the following structure:

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

For the Unit Testing section, I've created 5 test files for your core model classes:

1. **AlbumTest.php**: Tests the Album model functionality
   - Tests album creation
   - Tests title validation
   - Tests release date validation
   - Tests image URL validation
   - Tests getters and setters

2. **ArtistTest.php**: Tests the Artist model functionality
   - Tests artist creation
   - Tests name validation
   - Tests bio validation
   - Tests formed year validation
   - Tests getters and setters

3. **ConcertTest.php**: Tests the Concert model functionality
   - Tests concert creation
   - Tests venue validation
   - Tests date validation
   - Tests ticket booking functionality
   - Tests ticket price validation

4. **ReviewTest.php**: Tests the Review model functionality
   - Tests review creation
   - Tests rating validation
   - Tests content validation
   - Tests getting reviews by album ID
   - Tests review update functionality

5. **UserTest.php**: Tests the User model functionality
   - Tests user creation
   - Tests email validation
   - Tests password validation and hashing
   - Tests user authentication
   - Tests user role validation

**Documentation Task**: Take screenshots of running these tests and include them in your assignment submission.

### B. User Interface Testing (10 marks)

For the UI Testing section, you need to create a PDF document that demonstrates 5 UI principles:

1. **Consistency**: Show how your UI maintains consistent styling, layout, and behavior
   - Take screenshots of similar elements across different pages
   - Highlight consistent color schemes, button styles, and navigation patterns

2. **Feedback**: Show how your UI provides feedback to users
   - Take screenshots of form validation messages
   - Show success/error notifications
   - Demonstrate loading indicators or progress feedback

3. **Recoverability**: Show how your UI helps users recover from errors
   - Take screenshots of error handling mechanisms
   - Show how users can undo actions or recover from mistakes
   - Demonstrate form validation with helpful error messages

4. **Minimal User Clicks**: Show how your UI minimizes the number of clicks needed
   - Take screenshots of navigation shortcuts
   - Show streamlined workflows (e.g., checkout process)
   - Demonstrate efficient form design

5. **Guidance**: Show how your UI guides users
   - Take screenshots of help text or tooltips
   - Show onboarding elements or wizards
   - Demonstrate clear call-to-action buttons

**Documentation Task**: Create a PDF document with screenshots and explanations for each UI principle.

### C. Validation Testing (5 marks)

For the Validation Testing section, I've created a `ValidationTests.php` file that tests 5 different validation scenarios:

1. **Email Validation**: Tests various email formats
2. **Password Strength Validation**: Tests password requirements
3. **Concert Date Validation**: Tests date validation for future events
4. **Price Range Validation**: Tests price boundaries
5. **Review Content Validation**: Tests content length and appropriateness

**Documentation Task**: Take screenshots of running these validation tests and include them in your assignment submission.

### D. Requirements Testing (3 marks)

For the Requirements Testing section, you need to create a PDF document with checklists for 3 core Use Cases:

1. **User Registration/Login**
   - List all requirements from your original Use Case specification
   - Mark which requirements have been implemented
   - Mark which requirements are still pending

2. **Concert Booking/Viewing**
   - List all requirements from your original Use Case specification
   - Mark which requirements have been implemented
   - Mark which requirements are still pending

3. **Album Review System**
   - List all requirements from your original Use Case specification
   - Mark which requirements have been implemented
   - Mark which requirements are still pending

**Documentation Task**: Create a PDF document with the requirements checklists.

### E. Equivalence Partition Testing (1 mark)

For the Equivalence Partition Testing section, I've created an `EquivalencePartitionTest.php` file that tests the Concert Ticket Booking functionality using equivalence classes:

- **Negative numbers** (invalid)
- **Zero** (invalid)
- **Small positive numbers (1-10)** (valid)
- **Medium positive numbers (11-50)** (valid)
- **Large positive numbers (51-100)** (valid)
- **Exactly available tickets** (valid)
- **More than available tickets** (invalid)
- **Extremely large numbers** (invalid)

**Documentation Task**: Create a PDF document explaining the equivalence classes and boundary values, and include screenshots of the test results.

### F. Basis Path Testing (1 mark)

For the Basis Path Testing section, I've created a `BasisPathTest.php` file that tests the User Authentication method using basis path testing:

- **Path 1**: User not found
- **Path 2**: User found but password incorrect
- **Path 3**: User found and password correct

**Documentation Task**: Create a PDF document showing the control flow graph, cyclomatic complexity calculation, and basis paths, and include screenshots of the test results.

## Documentation Templates

To help you create the required PDF documents, I've provided templates in the respective directories:

- `UI/UITestingTemplate.php`: Template for UI Testing
- `Requirements/RequirementsTestingTemplate.php`: Template for Requirements Testing

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
