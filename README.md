# TalkTempo 

A music platform inspired by Letterboxd, allowing users to discover, review, comment, browse, and purchase concert tickets. Users can create profiles, rate albums, add comments, and buy concert tickets.

## Technology Stack

### Frontend
- HTML5
- CSS3 with TailwindCSS
- JavaScript
- Figma (UI/UX Design wireframes)

### Backend
- PHP
- MySQL

### Project Management
- GitHub (Version Control)
- Trello (Project Management)

## Database Structure
- Users (profiles, preferences, activity)
- Music (albums, artists, tracks)
- Reviews & Comments
- Tickets (concert events)

## Project Structure
```
📂 SofwareEngineering-Project
├── 📂 backend            # Server-side PHP logic
├── 📂 docs               # Documentation files
├── 📂 exportedDB         # Exported database files
├── 📂 frontend           # Client-side files (HTML, CSS, JS)
├── 📂 node_modules       # Node.js dependencies
├── 📂 public             # Publicly accessible files
├── 📂 submission         # Submission files
│   └── 📄 database_submission.sql   # SQL database schema and data
├── 📂 tests              # Unit and functional tests
├── 📂 vendor             # PHP dependencies
├── 📄 .gitattributes     # Git attributes configuration
├── 📄 .gitignore         # Git ignore configuration
├── 📄 composer.json      # PHP dependency management
├── 📄 composer.lock      # PHP dependency lock file
├── 📄 package.json       # Node.js dependency management
├── 📄 phpunit.xml        # PHPUnit test configuration
├── 📄 README.md          # This file
├── 🖥️ start.bat          # Windows startup script
└── 🖥️ start.sh           # Linux/MacOS startup script
```

## Core Features
- User Authentication & Profiles
- Music Discovery & Reviews
- Comments based on threads
- Concert Ticket Sales
- Rating/Review System

## Development Phases
1. UI/UX Design (Figma)
2. Database Design & Implementation
3. Frontend Development
4. Backend Integration
5. Testing 

## Setup Instructions
1. Clone the repository:
   ```bash
   git clone https://github.com/Senaraufi/SofwareEngineering-Project.git
   cd SofwareEngineering-Project
   ```

2. Set up local MySQL database:
   - Create a new database (e.g., `talktempo`)
   - Import the database schema from `submission/database_submission.sql`

3. Configure PHP environment:
   - Install PHP 7.4+ and ensure it's available in your PATH
   - Install required PHP extensions: mysqli, pdo_mysql

4. Install dependencies:
   ```bash
   # Install PHP dependencies
   composer install
   
   # Install JavaScript dependencies (if needed)
   npm install
   ```

5. Start the application:
   - On Windows: Double-click `start.bat` or run it from Command Prompt
   - On Linux/macOS: Run `./start.sh` in terminal (you may need to make it executable with `chmod +x start.sh`)
   
6. Access the application:
   - Open your web browser and navigate to `http://localhost:8000`

## Database
- The full database schema and sample data are available in `submission/database_submission.sql`
- User accounts are stored in the MySQL database in the Users table
- New user accounts are created via the signup process and stored directly in the database

## Requirements
- PHP 7.4+
- MySQL 5.7+
- Web server (Apache/Nginx)
- Modern web browser

## Contributing
This is a public repository.

## Project Management
- Track our progress on Trello: https://trello.com/b/9BtumTgZ/software-engineering-and-testing
- GitHub Repository: https://github.com/Senaraufi/SofwareEngineering-Project

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
All third-party code is referenced within the code files.
All HTML structure was written by me from scratch using personal experience.
Tailwind CSS was used for styling and some components, and they are properly referenced in the code files.
Database schema design is made based in the Databse fundamentals module from semester 1. Every 3rd party code has been referenced in the code files.
PHP and backend code was written based of the WDSS module. Every 3rd party code has been referenced in the code files.

## What We Know

### Pixie Grogan: 
- I've been programming since I was about 15 years old, I've worked with many lanuages, most of which are linked on my personal portfolio on GitHub and my LinkedIn profile: https://www.linkedin.com/in/pixie-grogan-ab1184351/. I've also worked with many frameworks and libraries, such as Node.js, and my main programming languages are Java, Python, but in web would be JavaScript and PHP, as well as HTML and CSS. I've also worked with many databases, such as MySQL and Firebase. In this project, I have stuck to only what I know, and used my resources from the WDSS module to learn PHP and MySQL, as well as what I've learned last year in the Database module and well as my Web Development module.

### Sena Raufi:
- I began learning HTML at the age of 12, driven by a strong interest in web development. Over the years, I’ve built a solid foundation in frontend technologies and have become highly proficient in HTML. In addition to this, I’ve worked extensively with PHP on a variety of personal and academic projects, allowing me to gain experience in backend development as well. I also have a good understanding of JavaScript, which I’ve used to add interactivity and functionality to my web applications. All the code in this repository is written by me and reflects my own learning and development journey.
[Website](https://senaraufi.github.io/website_rs/)

### Ojal Rakwal: 
- I started Programming at 19, once i enrolled in my current course. Although im new to coding, over the course of this program, I’ve built a strong technical foundation through modules like Programming Fundamentals, Web Development (both client and server side), and Database Systems. I've also been introduced to core cybersecurity and forensics concepts and using tools such as wireshark and Cisco packet tracer to further improve my networking skills. In this project, we used PHP and MySQL for the backend, applying what I learned in the WDSS and Database modules, along with HTML, CSS, and JavaScript on the frontend. Our goal was to create something functional and secure, making use of scripting and secure coding practices introduced across my modules.


## Contribution Statement

We, Sena Raufi, Pixie Grogan, and Ojal Rakwal declare that all work presented in this project is our own original work, except where clearly acknowledged. Third-party assets and code references have been properly cited whithin the code and the References section above.
