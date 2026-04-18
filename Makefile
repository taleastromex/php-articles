.PHONY: setup up down build restart logs shell \
        install seed seed-fresh \
        phpstan cs-check cs-fix \
        css css-watch

# ── Setup ─────────────────────────────────────────────────────────────────────

setup: build install css seed
	@echo "\033[32m✓ App is ready at\033[32m http://localhost:8080"

# ── Docker ────────────────────────────────────────────────────────────────────

up:
	docker compose up -d

down:
	docker compose down

build:
	docker compose up -d --build

restart:
	docker compose restart

logs:
	docker compose logs -f php

shell:
	docker compose exec php sh

# ── PHP ───────────────────────────────────────────────────────────────────────

install:
	docker compose exec php composer install

seed:
	docker compose exec php php bin/seed.php

seed-fresh:
	docker compose exec php php bin/seed.php --fresh

# ── Static analysis ───────────────────────────────────────────────────────────

phpstan:
	docker compose exec php vendor/bin/phpstan analyse

cs-check:
	docker compose exec php vendor/bin/php-cs-fixer fix --dry-run

cs-fix:
	docker compose exec php vendor/bin/php-cs-fixer fix

# ── SCSS ──────────────────────────────────────────────────────────────────────

css:
	npm run build:css

css-watch:
	npm run dev:css
