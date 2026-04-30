# TaskFlow Pro

A full-featured **Task Management System** built with **Laravel 12**, **Livewire 3**, **Alpine.js**, and **Bootstrap 5**. Supports real-time updates via **Laravel Reverb** (WebSockets), role-based access for **Agents** and **Clients**, Kanban boards, project tracking, notifications, and more.

---

## Features

- 🔐 **Role-based access** — separate layouts and routes for Agents and Clients
- 📋 **Task management** — create, assign, track tasks with statuses, priorities, and due dates
- 📁 **Project management** — organize tasks inside projects
- 🧑‍🤝‍🧑 **User management** — manage agents and clients with avatars
- 📡 **Real-time notifications** — powered by Laravel Reverb (WebSockets) + Laravel Echo
- 📊 **Dashboard** — live overview of tasks, projects, agents, and clients
- 📬 **Email notifications** — task assignment and status update emails
- 🔄 **Queue workers** — background job processing
- 🖼️ **Avatar uploads** — profile photo upload with live preview (up to 10MB)
- ⚡ **Vite + Alpine.js** — fast asset compilation and reactive UI

---

## Tech Stack

| Layer | Technology |
|---|---|
| Backend | Laravel 12 (PHP 8.2+) |
| Frontend | Livewire 3, Alpine.js 3, Bootstrap 5 |
| Build Tool | Vite 7 |
| Real-time | Laravel Reverb (WebSockets) |
| Queue | Laravel Queue (database driver) |
| Database | MySQL |
| Mail | SMTP (Gmail) |

---

## Requirements

- PHP **8.2** or higher
- Composer
- Node.js **18+** and npm
- MySQL database
- A mail account (Gmail SMTP or similar)

---

## Installation

### 1. Clone the repository

```bash
git clone https://github.com/your-username/task-management.git
cd task-management
```

### 2. Install PHP dependencies

```bash
composer install
```

### 3. Install Node dependencies

```bash
npm install
```

### 4. Set up environment file

```bash
cp .env.example .env
php artisan key:generate
```

### 5. Configure your `.env` file

Open `.env` and update the following sections:

#### Database
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=task_management
DB_USERNAME=root
DB_PASSWORD=your_password
```

#### Mail (Gmail example)
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your_email@gmail.com
MAIL_PASSWORD=your_app_password
MAIL_FROM_ADDRESS=your_email@gmail.com
MAIL_FROM_NAME="${APP_NAME}"
```

> **Note:** Use a Gmail [App Password](https://myaccount.google.com/apppasswords), not your regular password.

#### Queue & Broadcasting
```env
QUEUE_CONNECTION=database
BROADCAST_CONNECTION=reverb
```

#### Laravel Reverb (WebSockets)
```env
REVERB_APP_ID=my-app-id
REVERB_APP_KEY=my-app-key
REVERB_APP_SECRET=my-app-secret
REVERB_HOST=localhost
REVERB_PORT=8080
REVERB_SCHEME=http

VITE_REVERB_APP_KEY="${REVERB_APP_KEY}"
VITE_REVERB_HOST="${REVERB_HOST}"
VITE_REVERB_PORT="${REVERB_PORT}"
VITE_REVERB_SCHEME="${REVERB_SCHEME}"
```

---

## Database Setup

### Run migrations

```bash
php artisan migrate
```

### Run seeders (with demo data)

```bash
php artisan db:seed
```

This seeds:
- Users (agents and clients with demo credentials)
- Projects
- Task statuses
- Task types
- Tasks
- Stages and Workflows

### Fresh migration + seed (wipes all data)

```bash
php artisan migrate:fresh --seed
```

---

## Storage Setup

Create the public symlink so uploaded avatars are accessible:

```bash
php artisan storage:link
```

---

## Running the Application

You need **4 processes** running simultaneously. Open 4 terminal tabs:

### Terminal 1 — Laravel web server
```bash
php artisan serve
```

### Terminal 2 — Vite dev server (frontend assets)
```bash
npm run dev
```

### Terminal 3 — Queue worker (emails, notifications)
```bash
php artisan queue:listen --tries=3
```

### Terminal 4 — Reverb WebSocket server (real-time)
```bash
php artisan reverb:start
```

> **Shortcut:** You can also run all at once (server + queue + vite) using:
> ```bash
> composer run dev
> ```

---

## Access the App

Once all processes are running, open your browser:

```
http://localhost:8000
```

### Default login credentials (after seeding)

| Role | Email | Password |
|---|---|---|
| Agent (Admin) | `agent@example.com` | `password` |
| Client | `client@example.com` | `password` |

> Check `database/seeders/DatabaseSeeder.php` for the exact seeded credentials.

---

## User Roles

| Role | Access |
|---|---|
| **Agent** | Full access — dashboard, projects, tasks, users, clients, settings |
| **Client** | Limited access — own projects, own tasks, profile |

Agents and clients get different layouts (sidebar, navbar) and separate route groups. The profile page auto-adapts to show the correct layout per role.

---

## Project Structure (highlights)

```
app/
  Http/Middleware/
    AgentMiddleware.php       # Restricts routes to Agent users
    ClientMiddleware.php      # Restricts routes to Client users
  Livewire/
    Dashboard.php             # Agent dashboard
    Profile/Index.php         # Profile page (shared, layout auto-detected)
    Task/                     # Task CRUD + Kanban board
    User/                     # User management
    Client/                   # Client-specific pages

resources/views/
  components/layouts/
    app.blade.php             # Agent layout (sidebar + navbar)
    client.blade.php          # Client layout
  livewire/
    dashboard.blade.php
    profile/index.blade.php
    task/
    user/

database/
  migrations/                 # All table schemas
  seeders/                    # Demo data seeders
```

---

## Troubleshooting

**Avatars not showing?**
```bash
php artisan storage:link
```

**Notifications not arriving in real-time?**
- Make sure `php artisan reverb:start` is running
- Check `.env` has `BROADCAST_CONNECTION=reverb`
- Check Vite env vars `VITE_REVERB_*` are set

**Emails not sending?**
- Make sure `php artisan queue:listen` is running
- Verify your SMTP credentials in `.env`
- Check `QUEUE_CONNECTION=database` in `.env`

**Migration errors?**
```bash
php artisan migrate:fresh --seed
```

---

## License

This project is open-sourced under the [MIT license](https://opensource.org/licenses/MIT).
