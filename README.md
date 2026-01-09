# LinkBio - Link-in-Bio Builder

A production-ready Mini SaaS Link-in-Bio platform built with Laravel, Tailwind CSS, and Supabase.

## 🚀 Features

- **User Management** - Registration, login, email verification
- **Profile Customization** - Custom themes, backgrounds, colors, fonts
- **Link Management** - Add, edit, delete, reorder, toggle links
- **Social Links** - 16+ social platforms with icons
- **Analytics** - View/click tracking, device breakdown, top links
- **Admin Dashboard** - User management, platform analytics, audit logs
- **SEO Optimized** - Custom meta tags, OG images, dynamic titles

## 📋 Requirements

- PHP 8.2+
- Composer 2.x
- Node.js 18+
- PostgreSQL (Supabase) or SQLite for local dev
- Redis (optional, for caching & queues)

## 🛠 Installation

### 1. Clone & Install Dependencies

```bash
# Install PHP dependencies
composer install

# Install NPM dependencies
npm install
```

### 2. Environment Setup

```bash
# Copy environment file
cp .env.example .env

# Generate app key
php artisan key:generate
```

### 3. Configure Database

**For Local Development (SQLite):**
```bash
touch database/database.sqlite
```

Update `.env`:
```
DB_CONNECTION=sqlite
```

**For Production (Supabase PostgreSQL):**
```
DB_CONNECTION=pgsql
DB_HOST=your-project.supabase.co
DB_PORT=5432
DB_DATABASE=postgres
DB_USERNAME=postgres
DB_PASSWORD=your-password
```

### 4. Run Migrations & Seed

```bash
php artisan migrate
php artisan db:seed
```

### 5. Build Assets & Start Server

```bash
# Development
npm run dev

# In another terminal
php artisan serve
```

Visit `http://localhost:8000`

## 🔐 Default Accounts

After seeding:

| Email | Password | Role |
|-------|----------|------|
| admin@linkbio.io | password | Admin |
| demo@linkbio.io | password | User |

## 📁 Project Structure

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── Admin/          # Admin controllers
│   │   ├── Auth/           # Auth controllers
│   │   └── Dashboard/      # User dashboard
│   ├── Middleware/         # Custom middleware
│   └── Requests/           # Form requests
├── Models/                 # Eloquent models
├── Policies/               # Authorization
└── Services/               # Business logic

resources/views/
├── admin/                  # Admin dashboard
├── auth/                   # Login, register
├── dashboard/              # User dashboard
├── layouts/                # Base layouts
├── pages/                  # Marketing pages
├── partials/               # Reusable components
└── profile/                # Public profiles
```

## 🔧 Key Commands

```bash
# Run migrations
php artisan migrate

# Reset database
php artisan migrate:fresh --seed

# Clear caches
php artisan optimize:clear

# Build production assets
npm run build
```

## 🔒 Security Features

- CSRF protection on all forms
- Rate limiting on login/API
- Password hashing with bcrypt
- Security headers (CSP, HSTS)
- Input sanitization
- Role-based access control

## 📊 Database Schema

| Table | Description |
|-------|-------------|
| users | User accounts |
| profiles | User profiles |
| links | Profile links |
| social_links | Social media links |
| profile_views | View analytics |
| link_clicks | Click analytics |
| plans | Subscription plans |
| subscriptions | User subscriptions |
| audit_logs | Admin action logs |

## 🚀 Deployment

### Production Checklist

- [ ] Set `APP_ENV=production`
- [ ] Set `APP_DEBUG=false`
- [ ] Configure Supabase database
- [ ] Configure Redis for caching
- [ ] Set up email provider
- [ ] Configure CDN for assets
- [ ] Enable HTTPS
- [ ] Run `npm run build`
- [ ] Run `php artisan config:cache`
- [ ] Run `php artisan route:cache`

## 📝 License

MIT License
