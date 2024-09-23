# Laravel - Prex challenge
This is a Laravel project that uses Sail to simplify the development environment.


## Installation

Follow these steps to set up the project:

1. **Clone the repository:**

   ```bash
   git clone https://github.com/giancarlobianchi12/prex-challenge
   cd tu_proyecto

2. **Settings:**

  ```bash
  Option 1:
  composer install
  vendor/bin/sail up -d
  vendor/bin/sail shell

  Option 2:
  docker-compose up -d
  docker ps # Get the app image ID
  docker exec -it [image_id] bash

  cp .env.example .env
  Make sure to set:

  GIPHY_API_KEY=
  DB_DATABASE=prex-challenge
  DB_USERNAME=root
  DB_PASSWORD=

  composer install
  php artisan key:generate
  php artisan migrate --seed
  php artisan passport:client --personal
  Name: "Laravel Personal Access Client"
  php artisan test
  ```
3. **Additional Notes:**

- The GIF ID is handled as a string due to the API response.
- PDF with Use Case Diagram, Sequence Diagram, and Entity-Relationship Diagram: https://drive.google.com/file/d/1bHKXkgMEfujFmanakOd__hJmKIH6P-IT/view
- To run the tests:
```
php artisan test
