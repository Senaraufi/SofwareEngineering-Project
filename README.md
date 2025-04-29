#TalkTempo 

A comprehensive music platform inspired by Letterboxd, allowing users to discover, review, and share music. Users can create profiles, rate albums, create lists, purchase merchandise, and buy concert tickets.

## Technology Stack

### Frontend
- HTML5
- CSS3 with Bootstrap/Tailwind
- JavaScript
- Figma (UI/UX Design)

### Backend
- PHP
- MySQL

### Project Management
- GitHub (Version Control)
- Trello (Project Management)

## Database Structure
- Users (profiles, preferences, activity)
- Music (albums, artists, tracks)
- Reviews & Ratings
- Tickets (concert events)
- User Lists & Collections

## Project Structure
```
📂 SoftwareEngineeringProject
├── 📂 backend
│   ├── 📂 cache
│   ├── 📂 config
│   ├── 📂 database
│   ├── 📂 docs
│   ├── 📂 logs
│   ├── 📂 src
├── 📂 frontend
│   ├── 📂 assets
│   ├── 📂 node_modules
│   ├── 📂 templates
│   ├── 📄 package-lock.json
│   ├── 📄 package.json
│   ├── 📄 tailwind.config.js
├── 📂 public
├── 📂 vendor
├── 📄 .gitattributes
├── 📄 .gitignore
├── 📄 composer.json
├── 📄 composer.lock
├── 📄 README.md
├── 🖥️ start.bat
├── 🖥️ start.sh
              # Figma designs and prototypes
```

## Core Features
- User Authentication & Profiles
- Music Discovery & Reviews
- Custom Lists & Collections
- Social Features (following, sharing)
- Concert Ticket Sales
- Rating/Review System

## Development Phases
1. UI/UX Design (Figma)
2. Database Design & Implementation
3. Frontend Development
4. Backend Integration
5. Testing & Refinement

## Setup Instructions
1. Clone the repository
2. Set up local MySQL database
3. Configure PHP environment
4. Import database schema
5. Update configuration files
6. Start local development server (run start.sh on Linux or MacOs, or start.bat on Windows)

## Requirements
- PHP 7.4+
- MySQL 5.7+
- Web server (Apache/Nginx)
- Modern web browser

## Contributing
This is a public repository. Please refer to CONTRIBUTING.md for guidelines.

## Project Management
Track our progress on Trello: https://trello.com/b/9BtumTgZ/software-engineering-and-testing
GitHub Repository: https://github.com/Senaraufi/SofwareEngineering-Project

## References and Third-Party Assets

### Libraries and Frameworks
- [Tailwind CSS](https://tailwindcss.com/) - Used for styling and UI components
- [Twig Template Engine](https://twig.symfony.com/) - Used for frontend templating
- [PHPUnit](https://phpunit.de/) - Used for unit testing

### Design Resources
- Icons from [FontAwesome](https://fontawesome.com/) (Free version)
- Fonts from [Google Fonts](https://fonts.google.com/): Roboto, Open Sans
- Stock images from [Unsplash](https://unsplash.com/) (Royalty-free)

### Code References
//

### Academic References
- Database schema design based on concepts from "Database Systems: The Complete Book" by Hector Garcia-Molina, Jeffrey D. Ullman, and Jennifer Widom
- SQL queries optimized using techniques from "SQL Performance Explained" by Markus Winand

## Contribution Statement

We, Sena Raufi, Pixie Grogan, and Ojal Rakwal declare that all work presented in this project is our own original work, except where clearly acknowledged. Third-party assets and code references have been properly cited in the References section above.

The following components were developed entirely by me:
- Database design and implementation
- Backend MVC architecture
- User authentication system
- CRUD operations for all entities
- Frontend templates and styling
- Client and server-side validation
- Session management
- Shopping cart functionality

The following components utilized third-party resources (as referenced above):
- CSS framework (Tailwind)
- Template engine (Twig)
- Icons and images
- Testing framework (PHPUnit)

I understand that plagiarism is a serious academic offense, and I have properly referenced all external sources used in this project.
