# Movie Application

This is a simple movie application built with Laravel 5.8 that integrates with the OMDb API to display movie data. The application features user authentication, movie listing with infinite scrolling, and the ability to manage favorite movies.

## Architecture

- **Framework**: Laravel 5.8
- **Frontend**: Blade
- **Backend**: PHP 7.4
- **Database**: MySQ
- **Build Tool**: Laravel Mix (Webpack)
- **API**: OMDb API for fetching movie data

## Libraries and Packages

### Backend
- `laravel/framework`: 5.8
- `laravel/ui`: For authentication

### Frontend
- `laravel-mix`: For compiling assets (CSS and JS)
- `sass`: CSS preprocessor

### Development Dependencies
- `cross-env`: For setting environment variables
- `webpack`: Module bundler

## Usage

- **Login**: Use the provided credentials to log in.
- **Movie List**: Browse movies with infinite scrolling.
- **Favorite Movies**: Add or remove movies from your favorites list.

## Setup Instructions

### 1. Clone the repository

Clone the repository from GitHub:

```bash
git clone https://github.com/yustikodm/movie.git movie-app
cd movie-app


### 2. Install dependencies

Install PHP dependencies using Composer:

```bash
composer install

### 3. Set up environment variables

Copy the .env.example file to create a new .env file:

```bash
cp .env.example .env

Open the .env file and configure the following variables based on your environment:

APP_NAME: Name of your application
APP_URL: The URL your application will run on
DB_CONNECTION: Database connection type (usually mysql)
DB_HOST: Database host (usually 127.0.0.1)
DB_PORT: Database port (usually 3306)
DB_DATABASE: The name of your database
DB_USERNAME: Your database username
DB_PASSWORD: Your database password

### 4. Generate application key

Run the following command to generate an application key:

```bash
php artisan key:generate

### 4. Generate application key

Run the following command to generate an application key:

```bash
php artisan key:generate

### 4. Generate application key

Run the following command to generate an application key:

```bash
php artisan key:generate

### 5. Run database migrations

To create the necessary database tables, run the migrations and db:seed (but dont forget change the credentials in app seeder):

```bash
php artisan migrate
php artisan db:seed

### 6. Set file permissions

Ensure the storage and bootstrap/cache directories have the correct permissions:

```bash
chmod -R 775 storage
chmod -R 775 bootstrap/cache

### 7. Start the development server

Run the following command to start the Laravel development server:
By default, the application will be available at http://localhost:8000.

```bash
php artisan serve

