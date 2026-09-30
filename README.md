# 🎟️ Event Core Platform
> **Events & Ticketing Operations Management Platform**

![Laravel](https://img.shields.io/badge/Laravel-12-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![Vue.js](https://img.shields.io/badge/Vue.js-3-4FC08D?style=for-the-badge&logo=vuedotjs&logoColor=white)
![Inertia.js](https://img.shields.io/badge/Inertia.js-SPA-9553E8?style=for-the-badge&logo=inertia)
![TailwindCSS](https://img.shields.io/badge/Tailwind_CSS-38B2AC?style=for-the-badge&logo=tail-wind-css&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-Database-4479A1?style=for-the-badge&logo=mysql&logoColor=white)

---

## 📌 Overview
**Event Core Platform** is a full-stack ticketing, event registration, and organizer management platform. Designed for high scalability and modern user experience, it features a public Marketplace for attendees alongside a robust operational suite for organizers, ticket tiers, orders, and administrative control.

---

## ✨ Features

* **Public Marketplace:** Browse events, select ticket tiers, and seamless checkout.
* **Order & Ticket Management:** Order history with QR / barcode ticket generation.
* **Admin Dashboard:** Full operational management for events, tickets, orders, organizers, and attendees.
* **Modern UI:** Built-in Dark / Light mode UI with Shadcn Vue and Tailwind CSS.
* **Enterprise Security:** Protected admin middleware (`is_admin = true`) and 2FA support.

---

## 🛠️ Stack

* **Backend:** Laravel 12
* **Frontend:** Vue 3 + Inertia.js
* **Styling & UI:** Tailwind CSS / Shadcn Vue
* **Database:** MySQL

---

## 🚀 Setup Instructions

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
npm install
npm run dev
php artisan serve
```

---

## 🔑 Demo Admin Credentials (After Seeding)

* **Email:** `admin@eventcore.test`
* **Password:** `password`
* **Note:** Admin routes require the `admin` middleware (`is_admin = true`).

---

## 📝 Note
Portfolio project. Demo link coming soon.
