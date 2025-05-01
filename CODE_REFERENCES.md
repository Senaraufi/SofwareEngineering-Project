# Code References and Attribution

This document provides detailed references for code components, methods, and algorithms used in the TalkTempo project. Proper attribution is essential for academic integrity and to acknowledge the original authors of code snippets, patterns, and techniques.

## Database Components

### Database Connection Pattern (Singleton)
- **File**: `/backend/src/Database.php`
- **Pattern**: Singleton Pattern
- **Source**: PHP: The Right Way - Design Patterns
- **URL**: https://phptherightway.com/pages/Design-Patterns.html#singleton
- **Specific Section**: "Singleton" section
- **Usage**: Implementation of the getInstance() method for database connection management

### PDO Error Handling
- **File**: `/backend/src/Database.php`
- **Source**: PHP Manual - PDO Exception Handling
- **URL**: https://www.php.net/manual/en/pdo.error-handling.php
- **Specific Section**: "Example #1 Forcing errors to be exceptions"
- **Usage**: Setting PDO::ATTR_ERRMODE to PDO::ERRMODE_EXCEPTION

### Database Schema Design
- **File**: `/backend/database/schema.sql`
- **Source**: MySQL Documentation - Foreign Key Constraints
- **URL**: https://dev.mysql.com/doc/refman/8.0/en/create-table-foreign-keys.html
- **Specific Section**: "Using FOREIGN KEY Constraints"
- **Usage**: Implementation of foreign key constraints in table creation

## MVC Architecture

### BaseModel Implementation
- **File**: `/backend/src/Models/BaseModel.php`
- **Pattern**: Active Record Pattern
- **Source**: Laravel Documentation - Eloquent ORM
- **URL**: https://laravel.com/docs/8.x/eloquent
- **Specific Section**: "Retrieving Models" and "Inserts"
- **Usage**: The findAll(), findById(), create(), and update() methods follow Laravel's Eloquent ORM pattern

### Controller Structure
- **File**: `/backend/src/Controllers/PageController.php`
- **Pattern**: MVC Controller Pattern
- **Source**: Symfony Documentation - Controllers
- **URL**: https://symfony.com/doc/current/controller.html
- **Specific Section**: "Controller Classes"
- **Usage**: Structure of controller methods that render templates with data

## Templating System

### Twig Template Usage
- **Files**: Various template files
- **Source**: Twig Documentation
- **URL**: https://twig.symfony.com/doc/3.x/templates.html
- **Specific Section**: "Template Inheritance" and "Including Templates"
- **Usage**: Template inheritance, variable rendering, and control structures

## Comment System

### Threaded Comment Algorithm
- **File**: `/backend/src/Controllers/CommentController.php`
- **Method**: `buildCommentTree()`
- **Source**: Stack Overflow - Building a Comment Tree
- **URL**: https://stackoverflow.com/questions/4048151/what-are-the-options-for-storing-hierarchical-data-in-a-relational-database
- **Specific Answer**: Answer by user "Quassnoi" (https://stackoverflow.com/a/4048520)
- **Usage**: Algorithm for converting flat comment data to hierarchical structure

### Comment Display
- **File**: Template files for comments
- **Source**: Reddit's Comment System
- **URL**: https://www.reddit.com/dev/api/
- **Specific Section**: "Comment Trees" in API documentation
- **Usage**: Inspiration for the nested comment display approach

## User Authentication

### Password Hashing
- **File**: `/backend/src/Controllers/UserController.php`
- **Source**: PHP Manual - Password Hashing Functions
- **URL**: https://www.php.net/manual/en/function.password-hash.php
- **Specific Section**: "Example #1 password_hash() example"
- **Usage**: Implementation of secure password hashing

### Session Management
- **File**: Various controller files
- **Source**: PHP Manual - Session Handling
- **URL**: https://www.php.net/manual/en/book.session.php
- **Specific Section**: "Session Functions"
- **Usage**: Session initialization, storage, and validation

## Front-end Components

### UI Components
- **File**: Various template files
- **Source**: Tailwind UI Components
- **URL**: https://tailwindui.com/components
- **Specific Sections**:
  - Navigation: https://tailwindui.com/components/application-ui/navigation/navbars
  - Forms: https://tailwindui.com/components/application-ui/forms/form-layouts
  - Cards: https://tailwindui.com/components/marketing/sections/feature-sections
- **Usage**: Adaptation of Tailwind UI components for the application interface

### CSS Framework
- **File**: CSS files
- **Source**: Tailwind CSS
- **URL**: https://tailwindcss.com/docs
- **Specific Section**: "Utility-First Fundamentals"
- **Usage**: Utility classes for styling the application

## Error Handling

### Database Error Handling
- **File**: `/backend/src/Database.php`
- **Source**: PHP Manual - Exceptions
- **URL**: https://www.php.net/manual/en/language.exceptions.php
- **Specific Section**: "Extending Exceptions"
- **Usage**: Custom exception handling for database operations

### Form Validation
- **File**: Various controller files
- **Source**: PHP Manual - Filter Functions
- **URL**: https://www.php.net/manual/en/book.filter.php
- **Specific Section**: "Validating filters"
- **Usage**: Input validation and sanitization

## Testing

### PHPUnit Tests
- **File**: `/tests/TestsAssignment4/Unit/AlbumTest.php`
- **Source**: PHPUnit Documentation
- **URL**: https://phpunit.de/documentation.html
- **Specific Section**: "Writing Tests for PHPUnit"
- **Usage**: Unit test structure and assertions

## Additional Resources and Inspirations

### Concert Booking Logic
- **File**: `/backend/src/Models/Concert.php`
- **Method**: `bookTickets()`
- **Source**: Ticketmaster Developer Documentation
- **URL**: https://developer.ticketmaster.com/products-and-docs/apis/getting-started/
- **Specific Section**: "Commerce API"
- **Usage**: Inspiration for ticket booking validation logic

### Review System
- **File**: Review-related models and controllers
- **Source**: Goodreads API Documentation (now retired)
- **URL**: https://www.goodreads.com/api (archived)
- **Usage**: Inspiration for the rating and review system

---

## Academic References

The following academic resources were consulted during the development of this project:

1. Fowler, M. (2002). *Patterns of Enterprise Application Architecture*. Addison-Wesley Professional.
   - Referenced for the Active Record pattern implemented in BaseModel

2. Gamma, E., Helm, R., Johnson, R., & Vlissides, J. (1994). *Design Patterns: Elements of Reusable Object-Oriented Software*. Addison-Wesley Professional.
   - Referenced for the Singleton pattern used in the Database class

3. Lockhart, J. (2015). *Modern PHP: New Features and Good Practices*. O'Reilly Media.
   - Referenced for PHP best practices throughout the codebase

4. Zaninotto, F., & Potencier, F. (2007). *The Definitive Guide to symfony*. Apress.
   - Referenced for MVC architecture implementation

---

This document should be updated whenever new code sources are incorporated into the project.
