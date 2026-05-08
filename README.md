# School Trip Manager

A Laravel application for managing school trips (uitstappen) in Belgian primary and secondary schools. Teachers can create trips, track which students have permission, and monitor payments — replacing paper forms, cash envelopes, and Excel chaos.

## Concept

### Problem
Teachers manage school trips with paper forms, cash in envelopes, and Excel spreadsheets. Parents forget deadlines, teachers lose overview. This is still super common in Belgian schools, especially smaller ones.

### Why It Matters
- Every Belgian school does multiple trips per year
- Paper + cash + WhatsApp chaos is the norm
- Many schools don't have proper tooling for this

### Users
- **Teachers (admin)**: Create trips, track who has permission and who has paid
- **Parents**: Represented implicitly via student records with permission/paid status

## Installation

```bash
# Clone the repository
git clone <repo-url>
cd School-Trip-Manager

# Copy environment file and configure
cp .env.example .env

# Install dependencies
composer install

# Generate application key
php artisan key:generate

# Run migrations and seed the database
php artisan migrate --seed

# Create storage link (for Filament)
php artisan storage:link

# Start the development server
php artisan serve
```

Visit `http://127.0.0.1:8000` in your browser.

### Default Login
- **Email**: `teacher@school.be`
- **Password**: `password`

### Filament Admin Panel
Visit `http://127.0.0.1:8000/admin` for the admin dashboard (same credentials).

## Database Structure

### Tables

| Table | Description |
|-------|-------------|
| `trips` | School trips (name, destination, date, price) |
| `students` | Students (name, class) |
| `student_trip` | Pivot table linking students to trips with status |

### Pivot Fields (`student_trip`)
- `permission_given` (boolean) — Has the parent given permission?
- `paid` (boolean) — Has the student paid?
- `notes` (text, nullable) — e.g. allergies, special needs

### Relationships
- **Trip** belongsToMany **Student** (many-to-many)
- **Student** belongsToMany **Trip** (many-to-many)

## Usage

### Web Interface (Blade + Bootstrap 5)

1. **Login** at `/login` with `teacher@school.be` / `password`
2. **View all trips** at `/trips` — see percentages for permission and payment completion
3. **Create a trip** at `/trips/create`
4. **View trip details** — see all students with their permission/paid status
5. **Toggle permission/paid** — click buttons on the trip detail page
6. **Add notes** — per student per trip (e.g. allergies)

### Filament Admin Panel

1. Visit `/admin` and log in
2. Manage **Trips** — full CRUD with table view
3. Manage **Students** — full CRUD with table view

### Example Scenario
> "Trip to Bokrijk for classes 3A and 3B. The teacher opens the trip detail page and sees at a glance: 15 students, 10 permission given, 8 paid. They can immediately see who hasn't paid yet before sending a reminder."

## Tech Stack

- **Laravel 13** — PHP framework
- **Filament 5** — Admin panel
- **Bootstrap 5** — Frontend CSS
- **SQLite** — Database (configurable to MySQL/PostgreSQL)
- **Carbon** — Date/time handling
- **Blade** — Templating engine

## Future Improvements

- Multi-school setup with authentication
- Email reminders for parents
- CSV export for secretariaat
- Parent login to give consent online
- Permission timestamp tracking
- Filtering by class on trip detail page

