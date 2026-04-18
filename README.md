# Blogy

A simple blog with categories and articles built with native PHP, MySQL, and Smarty.

## Tech stack

- PHP 8.2
- MySQL 8.0
- Smarty (templating)
- SCSS (styles)
- Docker (PHP-FPM, Nginx, MySQL)

## Quick start

```bash
cp .env.example .env
make setup
```

App will be available at **http://localhost:8080**

## Make commands

### Setup & Docker

| Command | Description |
|---|---|
| `make setup` | Full setup: build, install, css, seed |
| `make up` | Start containers |
| `make down` | Stop containers |
| `make build` | Rebuild and start containers |
| `make restart` | Restart containers |
| `make logs` | PHP container logs |
| `make shell` | Open shell inside PHP container |

### Application

| Command | Description |
|---|---|
| `make install` | composer install |
| `make seed` | Run seeders |
| `make seed-fresh` | Truncate tables and re-seed |
| `make css` | Build SCSS once |
| `make css-watch` | Watch and rebuild SCSS on change |

### Code quality

| Command | Description |
|---|---|
| `make phpstan` | Static analysis |
| `make cs-check` | Check code style (dry-run) |
| `make cs-fix` | Fix code style |
