# 📝 PHP Note-Taking Application

A lightweight yet powerful **note-taking app** built with **PHP** and **MySQL**, designed to keep your thoughts organized and accessible anywhere.  

## ✨ Features
- 🖊️ **CRUD Notes** – Create, view, update, and delete notes with ease  
- 📸 **Image Upload** – Drag-and-drop image support for visual note-taking  
- 📤 **Export Options** – Save notes as **PDF** or **Word** documents  
- 📱 **Responsive Design** – Works seamlessly across desktop and mobile  

## 🚀 Getting Started

Follow these steps to set up the application locally:

1. **Clone the repository**  
   ```bash
   git clone https://github.com/your-username/php-note-app.git
   cd php-note-app

2. **Install dependencies**
    ```bash
    composer install

3. **Configure the database**
    ```bash
     - Copy config/database.php.example → config/database.php
     - Update your DB credentials inside the file

4. **Import database structure**
    ```bash
    mysql -u your_user -p your_database < database/schema.sql

5. **Set file permissions (for uploads)**
    ```bash
    chmod -R 775 assets/images/

6. **Start the application 🎉**
    - Using XAMPP: Navigate to http://localhost/php-note-app/
    - Using PHP built-in server: php -S localhost:8000

## Requirements
- PHP 7.4+
- MySQL 5.7+
- GD or Imagick extension
- Composer
- Web server (Apache, Nginx, or PHP built-in server)

## 📸 Screenshots
(Coming soon – show off your UI!)

## 🤝 Contributing
Contributions are welcome! Here's how you can help:
    1. Fork the repo
    2. Create a feature branch (git checkout -b feature/amazing-feature)
    3. Commit your changes (git commit -m 'Add amazing feature')
    4. Push to the branch (git push origin feature/amazing-feature)
    5. Submit a pull request

## 🙏 Acknowledgments
- Bootstrap for the responsive UI framework
- TCPDF and PHPWord for export functionality
- The open-source community for inspiration and tools