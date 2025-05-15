<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

---

# ProjectController API Endpunkte

Diese Dokumentation beschreibt die verfügbaren Endpunkte des `ProjectController` in deinem Laravel-Backend.

## Übersicht der Endpunkte

### 1. Alle Projekte auflisten
- **Methode:** GET
- **Pfad:** `/api/projects`
- **Beschreibung:** Gibt eine Liste aller Projekte als Collection von `ProjectResource` zurück.
- **Response:**
  ```json
  [
    {
      "id": 1,
      "name": "..."
      // weitere Felder
    },
    ...
  ]
  ```

### 2. Einzelnes Projekt anzeigen
- **Methode:** GET
- **Pfad:** `/api/projects/{project}`
- **Beschreibung:** Gibt ein einzelnes Projekt als `ProjectResource` zurück.
- **Response:**
  ```json
  {
    "id": 1,
    "name": "..."
    // weitere Felder
  }
  ```

### 3. Neues Projekt anlegen
- **Methode:** POST
- **Pfad:** `/api/projects`
- **Body:** JSON entsprechend `MakeProjectRequest`
- **Beschreibung:** Erstellt ein neues Projekt und gibt das erstellte Projekt als `ProjectResource` zurück.
- **Response:**
  ```json
  {
    "id": 2,
    "name": "..."
    // weitere Felder
  }
  ```

### 4. Projekt aktualisieren
- **Methode:** PUT/PATCH
- **Pfad:** `/api/projects/{project}`
- **Body:** JSON entsprechend `UpdateProjectRequest`
- **Beschreibung:** Aktualisiert ein bestehendes Projekt und gibt das aktualisierte Projekt als `ProjectResource` zurück.
- **Response:**
  ```json
  {
    "id": 1,
    "name": "Neuer Name"
    // weitere Felder
  }
  ```

### 5. Projekt löschen
- **Methode:** DELETE
- **Pfad:** `/api/projects/{project}`
- **Beschreibung:** Löscht das angegebene Projekt.
- **Response:**
  ```json
  {
    "message": "Project deleted successfully"
  }
  ```

## Hinweise
- Alle Endpunkte geben standardmäßig JSON zurück.
- Die Felder im Response richten sich nach dem `ProjectResource`.
- Für POST und PUT/PATCH müssen die Daten den jeweiligen Request-Validation-Klassen entsprechen (`MakeProjectRequest`, `UpdateProjectRequest`).

---

## Setup & Entwicklung

1. **Abhängigkeiten installieren**
   ```bash
   composer install
   npm install
   ```
2. **.env anpassen**
   - Kopiere `.env.example` zu `.env` und passe die Werte für SQLite und Mailer an:
     ```env
     DB_CONNECTION=sqlite
     DB_DATABASE=/absolute/path/to/database/database.sqlite
     MAIL_MAILER=log
     ```
3. **App Key generieren**
   ```bash
   php artisan key:generate
   ```
4. **Migrationen & Seeder ausführen**
   ```bash
   php artisan migrate --seed
   ```
5. **Entwicklungsserver starten**
   ```bash
   php artisan serve
   ```
6. **Vite-Dev-Server für Frontend starten** (optional)
   ```bash
   npm run dev
   ```

---

## OpenAPI/Swagger Dokumentation

Die API ist mit OpenAPI/Swagger dokumentiert. Du kannst z.B. [ma-d-z/swagger-generator](https://github.com/ma-d-z/swagger-generator) nutzen, um automatisch eine Swagger-Dokumentation zu generieren:

```bash
composer require --dev ma-d-z/swagger-generator
php artisan swagger:generate
```

Das generierte Swagger-UI findest du dann unter `/swagger` (sofern entsprechend konfiguriert).

---

> Stand: 15.05.2025
