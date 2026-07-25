# Dungeon-aas

Dungeon-aas — это проект из серии работ '-aas'. Является простым рогаликом на Laravel. На данный момент реализована backend-часть. Игрок путешествует по бесконечному подземелью, каждый раз выбирая одну из двух дверей. За дверью может оказаться монстр, сундук с золотом, лекарь, броня или пустая комната. Игра продолжается до гибели персонажа. Вся статистика сохраняется в профиль игрока.

---

## Технологии

- PHP 8.3
- Laravel 13
- MySQL
- Sanctum (API-аутентификация)
- Eloquent ORM
- API Resources
- FormRequest (валидация)
- Middleware (throttle)
- Cache (лидерборды)
- REST API

---

## Структура проекта:

app/
├── Constants/ # константы игры (вероятности и лимиты)
├── Http/
│ ├── Controllers/ # AuthController, GameController, MenuController
│ ├── Requests/ # AuthRequest, GameRequest
│ └── Resources/ # PlayerResource, SessionResource, LeaderboardResource
├── Models/ # Player, GameSession
└── Services/
├── GameProcess/ # GameService, GenerateService, RoomFactory
└── RoomType/ # MonsterService, ChestService, HealerService, ArmorService, EmptyService

---

## API Эндпоинты

| Метод | Эндпоинт | Описание |
|---|---|---|
| POST | `/auth` | Войти / регистрация профиля |
| POST | `/menu/game` | Начать новую игру |
| GET | `/menu/game` | Продолжить текущую игру |
| POST | `/menu/logout` | Выйти из профиля |
| GET | `/menu/leaderboard/kolgold` | Показать таблицу лидеров по золоту |
| GET | `/menu/leaderboard/maxrooms` | Показать таблицу лидеров по комнатам |
| POST | `/game/{session}/step` | Выбор комнаты |

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

1. Авторизация:
   POST /api/auth
   Body: { "name": "Vasya" }
   → сохранить token из ответа

2. Создать игру:
   POST /api/menu/game
   Header: Authorization: Bearer {token}
   → сохранить session_id из ответа

3. Открыть комнату:
   POST /api/game/{session_id}/step
   Header: Authorization: Bearer {token}
   Body: { "choice": "left" }

4. Продолжить игру:
   GET /api/menu/game
   Header: Authorization: Bearer {token}

5. Лидерборд по золоту:
   GET /api/menu/leaderboard/kolgold
   Header: Authorization: Bearer {token}

6. Лидерборд по комнатам:
   GET /api/menu/leaderboard/maxrooms
   Header: Authorization: Bearer {token}

7. Выйти:
   POST /api/menu/logout
   Header: Authorization: Bearer {token}

При смерти игрока is_active становится 0, статистика обновляется.

---

Автор: Aleksandr Sadouski