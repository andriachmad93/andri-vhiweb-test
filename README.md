This Repository is VhiWeb Company Test for Candidate who name Andri

## Requirements
- PHP Latest
- Composer Latest
- Laravel 10
- Postgres

## Tutorial for this repository
- composer install
- php artisan optimize
- php artisan serve

## Tutorial For Postman and Env Collection
Get from Vhiweb.postman_collection.json and import at postman
Get from Test Link.postman_collection.json and import at postman

## Routes
| Action               | Method        | Path                    |
| ------------------   | ------------- | ----------------------- |
| Get Photos           | GET           | /api/photos             |
| Get Photo by ID      | Get           | /api/photos/1           |
| Create Photo         | POST          | /api/photos             |
| Patch Photo (Upload) | POST          | /api/photos/:id         |
| Delete Photo         | DELETE        | /api/photos/:id         |
| Like/Unlike Photo    | POST          | /api/photos/:id/:type   |
