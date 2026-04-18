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
                'title' => 'Введение в PHP 8.1: новые возможности',
                'slug' => 'php-81-new-features',
                'description' => 'Обзор ключевых нововведений PHP 8.1: enums, fibers, readonly свойства и многое другое.',
                'content' => 'PHP 8.1 принёс множество долгожданных возможностей. Enums позволяют объявлять перечисления на уровне языка. Fibers дают возможность писать кооперативную многозадачность. Readonly-свойства упрощают создание value objects...',
                'categories' => ['php'],
            ],
            [
                'title' => 'SOLID принципы на примерах PHP',
                'slug' => 'solid-principles-php',
                'description' => 'Разбираем каждый из пяти принципов SOLID на реальных примерах кода на PHP.',
                'content' => 'SOLID — это аббревиатура пяти принципов объектно-ориентированного проектирования. Single Responsibility: каждый класс должен иметь только одну причину для изменения. Open/Closed: классы открыты для расширения, но закрыты для модификации...',
                'categories' => ['php', 'architecture'],
            ],
            [
                'title' => 'Паттерн Repository в PHP',
                'slug' => 'repository-pattern-php',
                'description' => 'Как правильно реализовать паттерн Repository для работы с базой данных в PHP-проектах.',
                'content' => 'Паттерн Repository отделяет логику работы с данными от бизнес-логики. Вместо того чтобы писать SQL прямо в контроллере, мы создаём класс-репозиторий, который инкапсулирует все запросы к БД...',
                'categories' => ['php', 'architecture', 'databases'],
            ],
            [
                'title' => 'Docker для PHP-разработчика',
                'slug' => 'docker-for-php-developer',
                'description' => 'Пошаговое руководство по настройке Docker-окружения для PHP-проекта с Nginx и MySQL.',
                'content' => 'Docker позволяет запустить приложение в изолированном контейнере. Для PHP-проекта обычно нужны три сервиса: php-fpm для выполнения кода, nginx как веб-сервер, и mysql для хранения данных...',
                'categories' => ['docker', 'php'],
            ],
            [
                'title' => 'Docker Compose: полное руководство',
                'slug' => 'docker-compose-guide',
                'description' => 'Как использовать docker-compose для управления многоконтейнерными приложениями.',
                'content' => 'Docker Compose позволяет описать всю инфраструктуру приложения в одном yaml-файле. Вы определяете сервисы, сети и volumes, а compose управляет их жизненным циклом...',
                'categories' => ['docker'],
            ],
            [
                'title' => 'MySQL индексы: как работают и когда нужны',
                'slug' => 'mysql-indexes',
                'description' => 'Глубокое погружение в индексы MySQL: B-Tree, составные индексы, EXPLAIN и оптимизация запросов.',
                'content' => 'Индекс в MySQL — это структура данных, которая ускоряет поиск строк. Без индекса MySQL вынужден просматривать каждую строку таблицы (full table scan). С индексом поиск занимает O(log n) вместо O(n)...',
                'categories' => ['databases'],
            ],
            [
                'title' => 'Проектирование схемы базы данных',
                'slug' => 'database-schema-design',
                'description' => 'Принципы проектирования реляционных баз данных: нормализация, foreign keys, типы данных.',
                'content' => 'Хорошая схема базы данных — фундамент приложения. Нормализация помогает избежать дублирования данных и аномалий при обновлении. Первая нормальная форма требует атомарности значений...',
                'categories' => ['databases', 'architecture'],
            ],
            [
                'title' => 'Асинхронный JavaScript: Promise и async/await',
                'slug' => 'js-async-await',
                'description' => 'Разбираемся с асинхронностью в JavaScript: callbacks, Promises, async/await.',
                'content' => 'JavaScript однопоточный язык, но это не мешает ему работать асинхронно. Event loop обрабатывает очередь задач, что позволяет не блокировать выполнение программы во время ожидания IO-операций...',
                'categories' => ['javascript'],
            ],
            [
                'title' => 'Чистая архитектура: теория и практика',
                'slug' => 'clean-architecture',
                'description' => 'Что такое Clean Architecture и как применять её в реальных проектах на PHP.',
                'content' => 'Чистая архитектура, предложенная Робертом Мартином, разделяет код на слои с чёткими зависимостями. Бизнес-логика не зависит от фреймворков, БД или UI. Это позволяет легко тестировать и заменять любой компонент...',
                'categories' => ['architecture', 'php'],
            ],
            [
                'title' => 'JavaScript: работа с DOM',
                'slug' => 'js-dom',
                'description' => 'Полное руководство по работе с DOM в нативном JavaScript без фреймворков.',
                'content' => 'Document Object Model — это программный интерфейс для HTML-документов. Браузер парсит HTML и строит дерево узлов, которым можно управлять через JavaScript...',
                'categories' => ['javascript'],
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
