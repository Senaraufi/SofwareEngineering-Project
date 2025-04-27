# Equivalence Partition Testing

## Feature Under Test: Concert Ticket Booking

### Description
This document outlines the equivalence partition testing for the Concert Ticket Booking functionality. Equivalence partitioning is a testing technique that divides the input domain into classes of data from which test cases can be derived.

### Input Domain
The primary input for this feature is the **number of tickets** a user wants to book for a concert. The system must validate this input against various constraints.

### Equivalence Classes

| Class ID | Description | Range | Validity | Representative Value(s) |
|----------|-------------|-------|----------|-------------------------|
| EC1 | Negative numbers | < 0 | Invalid | -5 |
| EC2 | Zero | = 0 | Invalid | 0 |
| EC3 | Small positive numbers | 1-10 | Valid | 5 |
| EC4 | Medium positive numbers | 11-50 | Valid | 25 |
| EC5 | Large positive numbers | 51-100 | Valid | 75 |
| EC6 | Exactly available tickets | = available tickets | Valid | 100 (when 100 available) |
| EC7 | More than available tickets | > available tickets | Invalid | 101 (when 100 available) |
| EC8 | Extremely large numbers | > 1000 | Invalid | 10000 |

### Boundary Values

| Boundary | Description | Value | Validity |
|----------|-------------|-------|----------|
| B1 | Minimum valid value | 1 | Valid |
| B2 | Just below minimum valid value | 0 | Invalid |
| B3 | Maximum valid value (available tickets) | 100 | Valid |
| B4 | Just above maximum valid value | 101 | Invalid |

### Test Cases

| Test ID | Equivalence Class | Input Value | Expected Outcome | Rationale |
|---------|-------------------|-------------|------------------|-----------|
| TC1 | EC1 (Negative numbers) | -5 | Booking fails | Negative number of tickets is invalid |
| TC2 | EC2 (Zero) | 0 | Booking fails | Zero tickets is invalid |
| TC3 | EC3 (Small positive) | 5 | Booking succeeds | Small number of tickets is valid |
| TC4 | EC4 (Medium positive) | 25 | Booking succeeds | Medium number of tickets is valid |
| TC5 | EC5 (Large positive) | 75 | Booking succeeds | Large number of tickets is valid |
| TC6 | EC6 (Exactly available) | 100 | Booking succeeds | Booking exactly all available tickets is valid |
| TC7 | EC7 (More than available) | 101 | Booking fails | Cannot book more tickets than available |
| TC8 | EC8 (Extremely large) | 10000 | Booking fails | Unreasonably large number of tickets is invalid |

### Test Results

[Insert screenshots of test execution results here]

### Conclusion

The equivalence partition testing approach ensures that we test representative values from each class of inputs, covering both valid and invalid scenarios. This provides confidence that the ticket booking system correctly handles all types of inputs without having to test every possible value.
