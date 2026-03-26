# Continental Fitness Gym

A basic full-stack gym management system with a Laravel backend API and Next.js frontend.

## Overview

This project is designed for gym operations with role-based access, including:

- Admin
- Staff
- Trainer
- Member

Core focus areas:

- Membership management
- Booking management
- Class scheduling
- Trainer and staff management
- Secure authentication and authorization

## Tech Stack

### Backend:

- Laravel
- PHP 8.3+
- MySQL or MariaDB

### Frontend:

- Next.js 16
- React
- TypeScript
- Tailwind CSS

## Project Structure

- `backend-api`: Laravel backend API
- `frontend`: Next.js frontend app

## Prerequisites

- PHP 8.3+
- Composer
- Node.js 20+
- npm
- MySQL or MariaDB

## Backend Setup

Go to the backend folder:
```bash
cd backend-api
```

Install dependencies:
```bash
composer install
```

Create environment file:
```bash
cp .env.example .env
```

Generate app key:
```bash
php artisan key:generate
```

Configure database credentials in `.env`

Run migrations:
```bash
php artisan migrate
```

Start backend server:
```bash
php artisan serve
```

Default backend URL:
```
http://127.0.0.1:8000
```

## Frontend Setup

Go to the frontend folder:
```bash
cd frontend
```

Install dependencies:
```bash
npm install
```

Start development server:
```bash
npm run dev
```

Default frontend URL:
```
http://localhost:3000
```

## Environment Notes

Set frontend API base URL in your frontend environment configuration to your backend URL, for example:
```env
NEXT_PUBLIC_API_BASE_URL=http://127.0.0.1:8000
```

## Basic Validation

Backend tests:
```bash
cd backend-api
php artisan test
```

Frontend lint:
```bash
cd frontend
npm run lint
```