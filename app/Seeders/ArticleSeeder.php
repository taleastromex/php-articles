<?php

declare(strict_types=1);

namespace App\Seeders;

use App\Entities\Category;
use App\Repositories\ArticleRepository;

final class ArticleSeeder
{
    public function __construct(private readonly ArticleRepository $articles) {}

    /**
     * @param Category[] $categories
     */
    public function run(array $categories): void
    {
        $bySlug = [];
        foreach ($categories as $category) {
            $bySlug[$category->slug] = $category->id;
        }

        $articles = [
            [
                'title' => 'Introduction to PHP 8.1: New Features',
                'slug' => 'php-81-new-features',
                'description' => 'A look at the key additions in PHP 8.1: enums, fibers, readonly properties, and more.',
                'content' => 'PHP 8.1 brought many long-awaited features. Enums allow declaring type-safe enumerations at the language level. Fibers enable cooperative multitasking. Readonly properties simplify the creation of value objects and make immutability explicit...',
                'categories' => ['php'],
            ],
            [
                'title' => 'SOLID Principles with PHP Examples',
                'slug' => 'solid-principles-php',
                'description' => 'A practical breakdown of all five SOLID principles illustrated with real PHP code.',
                'content' => 'SOLID is an acronym for five object-oriented design principles. Single Responsibility: a class should have only one reason to change. Open/Closed: classes should be open for extension but closed for modification. These principles lead to more maintainable codebases...',
                'categories' => ['php', 'architecture'],
            ],
            [
                'title' => 'The Repository Pattern in PHP',
                'slug' => 'repository-pattern-php',
                'description' => 'How to implement the Repository pattern correctly for database access in PHP projects.',
                'content' => 'The Repository pattern separates data-access logic from business logic. Instead of writing SQL directly in controllers, you create a repository class that encapsulates all database queries. This makes the code easier to test and swap out persistence layers...',
                'categories' => ['php', 'architecture', 'databases'],
            ],
            [
                'title' => 'Docker for PHP Developers',
                'slug' => 'docker-for-php-developer',
                'description' => 'A step-by-step guide to setting up a Docker environment for a PHP project with Nginx and MySQL.',
                'content' => 'Docker lets you run your application inside an isolated container. A typical PHP project needs three services: php-fpm to execute code, nginx as the web server, and mysql for data storage. Docker Compose ties them all together with a single config file...',
                'categories' => ['docker', 'php'],
            ],
            [
                'title' => 'Docker Compose: The Complete Guide',
                'slug' => 'docker-compose-guide',
                'description' => 'How to use docker-compose to manage multi-container applications.',
                'content' => 'Docker Compose lets you describe your entire application infrastructure in a single YAML file. You define services, networks, and volumes, and Compose manages their lifecycle. Commands like up, down, and logs make day-to-day operations straightforward...',
                'categories' => ['docker'],
            ],
            [
                'title' => 'MySQL Indexes: How They Work and When to Use Them',
                'slug' => 'mysql-indexes',
                'description' => 'A deep dive into MySQL indexes: B-Tree, composite indexes, EXPLAIN, and query optimisation.',
                'content' => 'An index in MySQL is a data structure that speeds up row lookups. Without an index, MySQL must scan every row in the table (full table scan). With an index, lookups take O(log n) instead of O(n). Composite indexes can cover multiple columns and eliminate sorting...',
                'categories' => ['databases'],
            ],
            [
                'title' => 'Relational Database Schema Design',
                'slug' => 'database-schema-design',
                'description' => 'Principles of relational database design: normalisation, foreign keys, and data types.',
                'content' => 'A well-designed schema is the foundation of any application. Normalisation prevents data duplication and update anomalies. First normal form requires atomic values in each column. Foreign keys enforce referential integrity and keep your data consistent...',
                'categories' => ['databases', 'architecture'],
            ],
            [
                'title' => 'Async JavaScript: Promises and async/await',
                'slug' => 'js-async-await',
                'description' => 'Understanding asynchronous JavaScript: callbacks, Promises, and async/await.',
                'content' => 'JavaScript is single-threaded, but that does not prevent it from working asynchronously. The event loop processes a queue of tasks, allowing the program to avoid blocking while waiting for I/O. Promises provide a cleaner alternative to callbacks, and async/await makes the code read like synchronous code...',
                'categories' => ['javascript'],
            ],
            [
                'title' => 'Clean Architecture: Theory and Practice',
                'slug' => 'clean-architecture',
                'description' => 'What Clean Architecture is and how to apply it in real PHP projects.',
                'content' => 'Clean Architecture, proposed by Robert C. Martin, organises code into layers with strict dependency rules. Business logic does not depend on frameworks, databases, or UI. This makes every component easy to test and replace independently...',
                'categories' => ['architecture', 'php'],
            ],
            [
                'title' => 'Working with the DOM in JavaScript',
                'slug' => 'js-dom',
                'description' => 'A complete guide to DOM manipulation in vanilla JavaScript without any frameworks.',
                'content' => 'The Document Object Model is a programming interface for HTML documents. The browser parses HTML and builds a tree of nodes that JavaScript can read and modify. Understanding the DOM is essential for building interactive web pages without relying on libraries...',
                'categories' => ['javascript'],
            ],
            [
                'title' => 'Python Type Hints: Writing Safer Code',
                'slug' => 'python-type-hints',
                'description' => 'How to use type annotations in Python to catch bugs earlier and improve code readability.',
                'content' => 'Type hints, introduced in PEP 484, let you annotate variables, function parameters, and return values with expected types. The runtime ignores them, but tools like mypy and pyright use them for static analysis. Combined with dataclasses or Pydantic, type hints make large Python codebases significantly easier to navigate and refactor...',
                'categories' => ['python'],
            ],
            [
                'title'       => 'Python and Databases: SQLAlchemy vs Raw SQL',
                'slug'        => 'python-sqlalchemy-vs-raw-sql',
                'description' => 'When to use an ORM like SQLAlchemy and when plain SQL is the better choice in Python projects.',
                'content'     => 'SQLAlchemy provides two interfaces: the ORM layer for working with Python objects, and the Core layer for composing SQL expressions programmatically. Raw SQL through psycopg2 or similar drivers offers maximum control and predictability. Choosing between them depends on query complexity, team familiarity, and how much abstraction you actually need...',
                'categories'  => ['python', 'databases'],
            ],
            [
                'title'       => 'PHP Dependency Injection from Scratch',
                'slug'        => 'php-dependency-injection',
                'description' => 'Building a simple DI container in pure PHP using reflection — no frameworks needed.',
                'content'     => 'Dependency Injection is a technique where a class receives its dependencies from the outside rather than creating them internally. A DI container automates this process using PHP Reflection to inspect constructor parameters and resolve them recursively. This decouples classes from their collaborators and makes unit testing straightforward...',
                'categories'  => ['php', 'architecture'],
            ],
            [
                'title'       => 'Value Objects in PHP',
                'slug'        => 'php-value-objects',
                'description' => 'What value objects are, why they matter, and how to implement them with readonly classes in PHP 8.2.',
                'content'     => 'A value object is an immutable object whose equality is based on its data, not its identity. Examples include Money, Email, or DateRange. PHP 8.2 readonly classes make implementing them concise and safe. Value objects eliminate primitive obsession, centralise validation, and make domain models more expressive...',
                'categories'  => ['php', 'architecture'],
            ],
            [
                'title'       => 'PHP Enums: Replacing Class Constants',
                'slug'        => 'php-enums',
                'description' => 'How PHP 8.1 enums improve on class constants and make state modelling safer.',
                'content'     => 'Before enums, PHP developers used class constants or pseudo-enum patterns with private constructors. PHP 8.1 native enums are first-class types: they can implement interfaces, have methods, and be used in match expressions. Backed enums map to scalar values for easy database storage and serialisation...',
                'categories'  => ['php'],
            ],
            [
                'title'       => 'Understanding PHP Attributes',
                'slug'        => 'php-attributes',
                'description' => 'A practical guide to PHP 8 attributes: how to declare, read, and use them in real projects.',
                'content'     => 'Attributes replace docblock annotations with a native, structured syntax. You declare an attribute class, apply it with #[MyAttribute], and read it at runtime via Reflection. Common use cases include routing metadata, validation rules, and ORM column mappings — all without parsing strings...',
                'categories'  => ['php'],
            ],
            [
                'title'       => 'Query Builder Pattern in PHP',
                'slug'        => 'php-query-builder',
                'description' => 'How to design a fluent query builder in PHP that generates safe parameterised SQL.',
                'content'     => 'A query builder provides a programmatic, chainable interface for constructing SQL queries. Each method — select(), where(), orderBy(), limit() — returns the builder itself, enabling a fluent API. Internally it accumulates clauses and bindings, then renders them into a prepared statement. This balances the flexibility of raw SQL with protection against injection...',
                'categories'  => ['php', 'databases'],
            ],
            [
                'title'       => 'PHP Sessions and Authentication Basics',
                'slug'        => 'php-sessions-auth',
                'description' => 'How PHP sessions work under the hood and how to build a simple cookie-based auth system.',
                'content'     => 'PHP sessions store data server-side and identify the client via a session cookie. For authentication, you hash the password with password_hash(), verify it with password_verify(), and store the user ID in $_SESSION. Regenerating the session ID after login prevents session fixation attacks. For stateless APIs, signed tokens are a better fit...',
                'categories'  => ['php'],
            ],
            [
                'title'       => 'Domain Events in PHP Applications',
                'slug'        => 'php-domain-events',
                'description' => 'How to implement a lightweight domain event system in PHP without an event bus library.',
                'content'     => 'Domain events represent something meaningful that happened in your system — OrderPlaced, UserRegistered. A simple implementation collects events on the entity, dispatches them after the transaction commits, and routes them to listeners. This decouples side effects like sending emails or updating read models from the core domain logic...',
                'categories'  => ['php', 'architecture'],
            ],
            [
                'title'       => 'Optimistic Locking in MySQL with PHP',
                'slug'        => 'php-mysql-optimistic-locking',
                'description' => 'Preventing lost updates in concurrent PHP applications using a version column strategy.',
                'content'     => 'Optimistic locking assumes conflicts are rare. Each row carries a version column. When updating, you include WHERE id = :id AND version = :version in the query. If another process already updated the row, the affected row count is zero, and you retry or notify the user. This avoids holding database locks for the duration of a request...',
                'categories'  => ['php', 'databases', 'architecture'],
            ],
            [
                'title'       => 'PHP Generators: Lazy Iteration Over Large Datasets',
                'slug'        => 'php-generators',
                'description' => 'Using PHP generators to process large database result sets without loading everything into memory.',
                'content'     => 'A generator function uses yield instead of return, pausing execution and handing a value to the caller. This is ideal for streaming large query results: instead of fetchAll() loading ten thousand rows at once, you yield one row at a time. Memory usage stays constant regardless of dataset size, making generators a simple alternative to cursor-based pagination for batch processing...',
                'categories'  => ['php', 'databases'],
            ],
        ];

        $count = 0;

        foreach ($articles as $data) {
            $id = $this->articles->create(
                title: $data['title'],
                slug: $data['slug'],
                description: $data['description'],
                content: $data['content'],
            );

            foreach ($data['categories'] as $categorySlug) {
                if (isset($bySlug[$categorySlug])) {
                    $this->articles->attachCategory($id, $bySlug[$categorySlug]);
                }
            }

            $count++;
        }

        echo 'Articles seeded: ' . $count . PHP_EOL;
    }
}
