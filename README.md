**College Club Event Management System**
A simple PHP + MySQL web project for managing college club events.
It includes login/signup, admin & student roles, and event management features like adding, editing, and deleting events — all in a clean, responsive UI.

**Features**

**Admin:**
Add, edit, or delete events.
View all club events.
Manage registration form links for students.
**Student:**
View upcoming events.
Register for events via provided form links.
**Authentication:**
Login & Signup system using secure password_hash() and password_verify().
Role-based redirection (Admin → manage events | Student → view events).
Session handling to remember logged-in users.

**Project Structure**
ProjectPHP/
│
├── db_connect.php        # Database connection file
├── index.php             # Login page (redirects to club_home.php after login)
├── signup.php            # Signup page (creates new users)
├── club_home.php         # Main dashboard (different view for Admin & Student)
├── logout.php            # Ends the session and logs out user              
└── README.md             # This file
