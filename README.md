# Dungeon-aas

Dungeon-aas — это проект из серии работ '-aas'. Является простым рогаликом на Laravel. На данный момент реализована backend-часть. Игрок путешествует по бесконечному подземелью, каждый раз выбирая одну из двух дверей. За дверью может оказаться монстр, сундук с золотом, лекарь, броня или пустая комната. Игра продолжается до гибели персонажа. Вся статистика сохраняется в профиль игрока.

---

## Технологии

- **Backend:**
    - PHP 8.3
    - Laravel 13
    - MySQL
- **Архитектура Laravel:**
    - Eloquent ORM
    - API Resources
    - FormRequest (валидация)
    - Middleware (throttle)
- **Дополнительно:**
    - Sanctum (API-аутентификация)
    - Cache (лидерборды)
    - REST API

---

## Структура проекта:

- **app/** — основная директория
    - **Constants/** — константы игры (вероятности и лимиты)
    - **Http/**
        - **Controllers/** — контроллеры авторизации, меню и игры
        - **Requests/** — реквесты для валидации
        - **Resources/** — API ресурсы для фронтенда
    - **Models/** — модели игрока и сессии
    - **Services/**
        - **GameProcess/** — сервисы управления игрой и генерации комнат (фабрика + интерфейс)
        - **RoomType/** — сервисы комнат (монстр, лекарь, броня, сундук, пустая)

---

## API Эндпоинты

| Метод | Эндпоинт | Описание |
|---|---|---|
| POST | `/auth/login` | Войти в профиль |
| POST | `/auth/register` | Регистрация профиля |
| POST | `/menu/game` | Начать новую игру |
| GET | `/menu/game` | Продолжить текущую игру |
| DELETE | `/menu/logout` | Выйти из профиля |
| GET | `/menu/stats` | Показать статистику игрока |
| GET | `/menu/leaderboard/kolgold` | Показать таблицу лидеров по золоту |
| GET | `/menu/leaderboard/maxrooms` | Показать таблицу лидеров по комнатам |
| POST | `/game/step` | Выбор комнаты |

---

## Установка Dungeon-aas

Клонировать репозиторий:

```bash
git clone https://github.com/AleksandrSadouski/Dungeon-aas.git
cd Dungeon-aas
```

Установить зависимости:

```bash
composer install
```

Настроить окружение:

```bash
cp .env.example .env
```

В файле .env указать настройки базы данных:

```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=dungeon
DB_USERNAME=root
DB_PASSWORD=
```

Сгенерировать ключ и запустить миграции:

```bash
php artisan key:generate
php artisan migrate
```

Запустить сервер:

```bash
php artisan serve
```

Сервер будет доступен по адресу: http://127.0.0.1:8000

---

## Тестирование через Postman

1. Регистрация:
   POST /api/auth/register
   Body: { 
    "name": "Sashok", 
    "password": "XXXXXXXX",
    "password_confirmation": "XXXXXXXX"}
   → сохранить token из ответа

   или

   Вход:
   POST /api/auth/login
   Body (JSON): {
    "name": "Sashok",
    "password": "XXXXXXXX"}
   → сохранить token из ответа

2. Создать игру:
   POST /api/menu/game
   Header: Authorization: Bearer {token}
   → сохранить session_id из ответа

3. Открыть комнату:
   POST /api/game/step
   Header: Authorization: Bearer {token}
   Body: { "choice": "left" } или Body: { "choice": "right" }

4. Продолжить игру (если уже есть сессия, иначе вернёт ошибку 400):
   GET /api/menu/game
   Header: Authorization: Bearer {token}

5. Показать статистику игрока:
   GET /api/menu/stats
   Header: Authorization: Bearer {token}

6. Лидерборд по золоту:
   GET /api/menu/leaderboard/kolgold
   Header: Authorization: Bearer {token}

7. Лидерборд по комнатам:
   GET /api/menu/leaderboard/maxrooms
   Header: Authorization: Bearer {token}

8. Выйти:
   DELETE /api/menu/logout
   Header: Authorization: Bearer {token}

При смерти игрока is_active становится 0, статистика обновляется.

---

## Примеры ответов API

Успешный ответ:

```bash
{
    "status": "success",
    "message": "Player continues step",
    "data": {
        "session_id": 1,
        "health": 100,
        "armor": 25
    }
}
```

Ошибка:

```bash
{
    "status": "error",
    "message": "Session is not active"
}
```

## Автор: 

Aleksandr Sadouski