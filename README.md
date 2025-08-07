# 📇 Laravel AJAX Contact Manager

A Laravel-based contact management system with full **AJAX** functionality, **XML import**, **bulk delete**, and **client/server-side validation**. Seamlessly manage your contacts using a beautiful UI and real-time interactions — all without page reloads.

---

## 🚀 Features

- 📥 Import contacts from an XML file
- ➕ Add new contacts
- ✏️ Edit existing contacts
- ❌ Delete one or multiple contacts (bulk delete)
- ✅ Validate form inputs on both frontend and backend
- 🔁 All operations use AJAX (no page reload)
- 💾 Contacts are saved in a **MySQL** database
- 🌐 Supports **international characters** in names and phone numbers (e.g., Şeküre Ruhiye)

---

## 💻 Tech Stack

| Layer        | Tool / Version     |
|--------------|--------------------|
| Backend      | Laravel 12         |
| Programming  | PHP 8              |
| Database     | MySQL 5.7 or 8+    |
| Frontend     | jQuery 3.6         |
| Design       | Custom CSS         |
| XML Handling | SimpleXML (PHP)    |

---

## 📂 Project Structure

- `resources/views/contacts/index.blade.php` - Main contact list with AJAX actions
- `resources/views/contacts/form.blade.php` - Add/Edit contact form (AJAX-enabled)
- `app/Http/Controllers/ContactController.php` - All CRUD + import logic
- `routes/web.php` - Route definitions
- `SQL FILE/contacts.sql` - Exported SQL file (database schema)

---

## 🧪 Validation Rules

- **Name**: Required, only letters, spaces, and some special characters (supports Unicode)
- **Phone**: Must be 10 digits and stored with +91 prefix (`+911234567890`)

---

## 📁 SQL Setup

To set up the database manually:

1. Create a MySQL database (e.g., `contact_crud`)
2. Import the provided SQL file:
