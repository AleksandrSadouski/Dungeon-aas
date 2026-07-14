# Dungeon-aas

Dungeon-aas — это простая игра-рогалик на Laravel. На данный момент реализована backend-часть.

Игрок путешествует по бесконечному подземелью, каждый раз выбирая одну из двух дверей. За дверью может оказаться монстр, сундук с золотом, лекарь, броня или пустая комната. Игра продолжается до гибели персонажа. Вся статистика сохраняется в профиль игрока.

Стек: PHP 8.3, Laravel 13, MySQL, REST API.

## Установка

Клонировать репозиторий:

> git clone https://github.com/AleksandrSadouski/Dungeon-aas.git
> cd Dungeon-aas

Установить зависимости:

> composer install

Настроить окружение:

> cp .env.example .env

В файле .env указать настройки базы данных:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=dungeon
DB_USERNAME=root
DB_PASSWORD=```

Сгенерировать ключ и запустить миграции:

> php artisan key:generate
> php artisan migrate

Запустить сервер:

> php artisan serve

Сервер будет доступен по адресу: http://127.0.0.1:8000


## API Эндпоинты

POST /api/auth
POST /api/menu/{player}/game
GET  /api/menu/{player}/game
POST /api/game/{session}/step


## Тестирование через Postman

1. Авторизация:
   POST /api/auth
   Body: { "name": "Vasya" }

2. Создать игру:
   POST /api/menu/Vasya/game

3. Открыть комнату:
   POST /api/game/1/step
   Body: { "choice": "left" }

4. Проверить сессию:
   GET /api/menu/Vasya/game

При смерти игрока is_active становится 0, статистика обновляется.


Автор: Aleksandr Sadouski
GitHub: https://github.com/AleksandrSadouski