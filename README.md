# Event Core Platform

Events and ticketing app with a public marketplace and an admin dashboard.

## Stack
- Laravel 12
- Vue 3 + Inertia
- Tailwind / Shadcn Vue
- MySQL

## Features
- Browse events, pick ticket tiers, checkout
- Order history with QR / barcode tickets
- Admin: events, tickets, orders, organizers, attendees
- Dark / light mode

## Setup
```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
npm install
npm run dev
php artisan serve
```

## Note
Portfolio project. Demo link coming soon.
