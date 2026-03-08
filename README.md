# internetMyShop

`internetMyShop` — это кодовая база интернет-магазина, которая мигрирует с legacy-витрины на Laravel Blade к API-first архитектуре с отдельным frontend на Nuxt.

Сейчас репозиторий объединяет три слоя:

- рабочий backend на `Laravel 12` и `PHP 8.4`;
- версионированный REST API под `api/v1`;
- отдельный frontend на `Nuxt 4` в `apps/web` с BFF-слоем для browser auth.

Старый Blade storefront всё ещё присутствует и полезен на переходном этапе, но новую разработку нужно ориентировать на API-first границу.

## Кратко о проекте

- backend runtime: `Laravel 12.53` + `PHP 8.4`;
- frontend runtime: `Nuxt 4.3` + `Node 24`;
- auth: `Laravel Sanctum`;
- документация API: `docs/openapi.yaml` и `/swagger`;
- backend tests: `PHPUnit`;
- frontend tests: `Vitest` и `Playwright`;
- локальная разработка изолирована от Docker по окружению и базе данных.

## Что делает проект

Проект реализует классический сценарий интернет-магазина:

- просмотр категорий, брендов и карточек товаров;
- поиск товаров;
- добавление товаров в корзину и изменение количества;
- оформление заказа как гостем, так и авторизованным пользователем;
- управление сохранёнными профилями доставки;
- просмотр истории заказов;
- управление каталогом, пользователями, заказами и статическими страницами в админке.

## Текущая архитектура

Проект находится в переходном, но контролируемом состоянии.

```text
Browser
  -> Nuxt 4 frontend in apps/web
      -> Nuxt BFF /bff
          -> Laravel API /api/v1
          -> Actions / Requests / Resources / Eloquent models
          -> sqlite locally or MySQL in Docker

Browser
  -> Legacy Laravel Blade routes
      -> Same Laravel backend and domain models

Swagger UI
  -> /swagger
      -> docs/openapi.yaml
```

### Архитектурное направление

- backend остаётся единственным источником истины для бизнес-правил;
- публичные и клиентские сценарии постепенно переносятся в версионированные API-контракты;
- browser-клиент должен ходить в backend через `Nuxt BFF`, а не хранить bearer token в JavaScript-доступном состоянии;
- frontend-логика должна жить внутри `apps/web`;
- legacy Blade storefront рассматривается как слой совместимости на время миграции, а не как целевая архитектура.

## Бизнес-домены

### Каталог

Домен каталога включает:

- навигацию по дереву категорий;
- страницы брендов;
- списки товаров и карточки товаров;
- поиск товаров с поддержкой русского stemming;
- публичные read API для frontend-клиента.

### Корзина и checkout

Домен корзины включает:

- создание корзины и изменение количества позиций;
- guest-friendly сценарий корзины;
- checkout на основе валидированных данных запроса;
- защищённое создание заказа, где сумма рассчитывается на сервере, а не передаётся клиентом.

### Аккаунты

Домен аккаунтов включает:

- регистрацию и вход;
- API-аутентификацию через `Sanctum`;
- browser auth через `Nuxt BFF` и `HttpOnly` cookie;
- CRUD профилей доставки;
- историю заказов и доступ к деталям заказа только владельцу.

### Админка

Домен админки включает:

- управление категориями, брендами, товарами, страницами, пользователями и заказами;
- сценарии загрузки и удаления изображений;
- legacy admin UI, который всё ещё работает через Laravel web routes.

## Структура проекта

```text
app/                Laravel application code
  Actions/          focused business actions
  Domain/           query, policy and module-oriented domain code
  Enums/            explicit state and code enums
  Helpers/          infrastructure and utility helpers
  Http/             controllers, requests, middleware, resources
  Models/           core domain models
  Providers/        application bootstrapping
  Seeders/          deterministic demo and e2e seeders

apps/web/           separate Nuxt frontend
  components/       reusable UI pieces
  composables/      shared API and state logic
  layouts/          frontend shells
  middleware/       route guards
  pages/            route-level pages
  server/           BFF routes and backend proxy utilities
  tests/            Vitest and Playwright tests
  types/            shared frontend payload types

routes/             Laravel web and API route definitions
database/           migrations, factories, framework seeders
docker/             Docker runtime definitions
docs/               architecture, standards, review, OpenAPI
tests/              Laravel feature and unit tests
```

## Структура backend

Backend следует стандартным Laravel-конвенциям, но с несколькими явными паттернами для поддерживаемости.

- `app/Http/Requests` содержит границы валидации.
- `app/Http/Resources/Api/V1` определяет JSON-формат ответов API.
- `app/Actions/Orders/CreateOrderFromBasket.php` изолирует бизнес-логику создания заказа из корзины.
- `app/Domain/*` содержит query-layer и policy-layer для постепенного перехода к modular monolith.
- `app/Enums/OrderStatus.php` задаёт явный контракт статусов заказа вместо магических чисел.
- `app/Models` содержит доменные модели `User`, `Profile`, `Product`, `Category`, `Brand`, `Basket`, `Order` и связанные сущности.
- `routes/api.php` содержит публичный версионированный API.
- `routes/web.php` содержит legacy web storefront, admin routes и маршруты Swagger UI.

## Структура frontend

Отдельный frontend живёт в `apps/web` и работает с Laravel API через BFF-слой.

- `composables/useApiClient.ts` централизует доступ к API через `Nuxt BFF`;
- `composables/useAuth.ts` управляет auth-state;
- `composables/useBasket.ts` управляет состоянием корзины;
- `server/routes/bff/*` проксирует frontend-запросы в Laravel API и хранит backend token в `HttpOnly` cookie;
- `pages/` содержит route-level сценарии: каталог, бренд, товар, корзина, checkout, login, profile и orders;
- `tests/unit` покрывает чистую frontend-логику через `Vitest`;
- `tests/e2e` покрывает пользовательские сценарии через `Playwright`.

## API surface

Активный API-контракт живёт под `/api/v1`.

### Auth

- `POST /api/v1/auth/register`
- `POST /api/v1/auth/login`
- `GET /api/v1/auth/me`
- `POST /api/v1/auth/logout`

### Каталог

- `GET /api/v1/catalog`
- `GET /api/v1/categories/{category}`
- `GET /api/v1/brands/{brand}`
- `GET /api/v1/products/{product}`

### Корзина

- `GET /api/v1/basket`
- `POST /api/v1/basket/items`
- `PATCH /api/v1/basket/items/{product}`
- `DELETE /api/v1/basket/items/{product}`
- `DELETE /api/v1/basket`
- `POST /api/v1/basket/checkout`

### Профили и заказы

- `GET /api/v1/profiles`
- `POST /api/v1/profiles`
- `GET /api/v1/profiles/{profile}`
- `PATCH /api/v1/profiles/{profile}`
- `DELETE /api/v1/profiles/{profile}`
- `GET /api/v1/orders`
- `GET /api/v1/orders/{order}`

Внешние API-клиенты используют `Authorization: Bearer <token>`.
Nuxt browser-клиент ходит в backend через `Nuxt BFF`, поэтому bearer token не хранится в JavaScript-доступном cookie.

## Бизнес-логика и поток данных

### Сценарий каталога

1. Категории, бренды и списки товаров отдаются через `api/v1`.
2. Nuxt frontend читает эти endpoints через общие composables.
3. Поиск товаров применяет stemming перед построением relevance-запроса.
4. Query-layer каталога вынесен в `app/Domain/Catalog/Queries` и `app/Domain/Catalog/Filters`.

### Сценарий checkout

1. Состояние корзины создаётся и изменяется через выделенные endpoints.
2. Checkout валидирует данные клиента через request-классы.
3. Сумма заказа и привязка владельца определяются на стороне сервера.
4. После успешного checkout корзина очищается, а позиции заказа сохраняются.

### Владение профилями и заказами

1. Профили принадлежат одному аутентифицированному пользователю.
2. Заказы доступны только их владельцу.
3. Защищённые поля вроде `user_id`, `status` и `amount` не принимаются от клиента как источник истины.
4. Ownership и admin access централизуются через `Policies` и `Gates`.

## Поддерживаемость

Проект поддерживается за счёт явных границ и предсказуемой структуры.

- API-контракты версионируются под `/api/v1`.
- Валидация вынесена в request-классы.
- JSON-контракты вынесены в resource-классы.
- Основная логика checkout изолирована в action-классе.
- Policy-layer и Gate-layer задают единый подход к ownership и admin access.
- Query-layer каталога отделён от presentation и контроллеров.
- Demo seeders создают детерминированные данные для ручного и автоматического тестирования.
- Локальная и Docker-среды изолированы, чтобы избежать drift в конфигурации.
- Инженерные стандарты и review-checklists лежат в репозитории, а не живут в устных договорённостях.

## Расширяемость

Новые фичи стоит добавлять по уже заданному пути расширения.

### Как добавлять backend-фичу

1. Описать или обновить API-контракт в `docs/openapi.yaml`.
2. Добавить валидацию в `app/Http/Requests`.
3. Добавить или изменить `Action`, `Query`, `Policy`, `Enum` или model-логику.
4. Возвращать ответы API через resource-классы.
5. Покрыть поведение PHPUnit feature-тестами.
6. Убедиться, что `tests/Feature/OpenApiContractTest.php` остаётся зелёным после изменения маршрутов.
7. Обновить `README.md` или `docs/architecture.md`, если изменение влияет на поведение проекта или архитектурные границы.

### Как добавлять frontend-фичу

1. Переиспользовать или расширить общий API client и composables.
2. Держать route-level поведение в `pages/`.
3. Выносить переиспользуемый UI в `components/`.
4. Добавлять `Vitest`-покрытие для чистой логики.
5. Добавлять или расширять `Playwright`-сценарии для пользовательских флоу.

## Модель безопасности

Безопасность рассматривается в первую очередь как ответственность backend.

- защищённый доступ к API реализован через `Laravel Sanctum`;
- browser auth реализован через `Nuxt BFF` и `HttpOnly` cookies;
- валидация выполняется явно через form requests;
- ownership checks и admin access централизованы через `Policies` и `Gates`;
- checkout игнорирует защищённые поля, переданные клиентом;
- запись корзины и заказа строится на серверных вычислениях, а не на доверии к клиенту;
- локальная и Docker-базы данных изолированы друг от друга;
- Swagger делает публичные контракты видимыми и проверяемыми, а не неявными;
- `OpenApiContractTest` следит, чтобы зарегистрированные API-маршруты не дрейфовали от документации.

### Текущий security follow-up

Текущий browser auth уже переведён на `Nuxt BFF` и `HttpOnly` cookies, что убирает прямое хранение bearer token в JavaScript-доступном состоянии.
Следующий возможный шаг — полный first-party session/CSRF flow без proxy-managed bearer token.

## Карта документации

- `README.md`: точка входа в проект, setup, структура и общее описание;
- `docs/architecture.md`: архитектурное направление и стадия миграции;
- `docs/openapi.yaml`: API-контракт;
- `/swagger`: визуализация OpenAPI через Swagger UI;
- `CONTRIBUTING.md`: инженерные требования и правила внесения изменений;
- `docs/development-standards.md`: стандарты кода, тестов и документации;
- `docs/review-checklist.md`: чеклист для review и self-review.

## Стратегия тестирования

Проект покрыт тестами на трёх уровнях.

### Backend

Laravel-тесты покрывают:

- auth flows;
- catalog API;
- basket API;
- checkout safety rules;
- profile ownership;
- order ownership;
- admin order authorization и защита служебных полей;
- search behavior;
- Swagger route availability;
- OpenAPI contract consistency.

Запуск backend-тестов:

```powershell
C:\OSPanel\modules\PHP-8.4\php.exe artisan test
```

### Frontend unit tests

Vitest покрывает frontend-утилиты и checkout-related логику.

Запуск frontend unit tests:

```powershell
npm run web:test:unit
```

### Frontend end-to-end tests

Playwright покрывает сценарий `login -> add to basket -> checkout` через изолированные Laravel и Nuxt test servers.

Установка браузера для тестов:

```powershell
npm run web:test:e2e:install
```

Запуск e2e tests:

```powershell
npm run web:test:e2e
```

## Demo seed data

Базовый seed детерминирован и предназначен для ручного тестирования.

Создаются следующие аккаунты:

- admin: `admin@example.test` / `Password123!`
- user: `user@example.test` / `Password123!`

Дополнительно базовый seed создаёт:

- корневые и дочерние категории;
- demo brands со стабильными slug;
- demo products для проверки каталога и корзины;
- один сохранённый профиль доставки для demo user.

Обновление локальной базы demo-данными:

```powershell
C:\OSPanel\modules\PHP-8.4\php.exe artisan migrate:fresh --seed
```

## Локальная разработка

### Требования

- `PHP 8.4`
- `Node 24`
- `Composer 2`
- опционально: `Docker` для контейнерного запуска

### Локальный backend

1. Используйте `C:\OSPanel\modules\PHP-8.4\php.exe`.
2. Храните локальные настройки в `.env`.
3. По умолчанию локальная разработка использует `database/database.sqlite`.
4. При необходимости создайте sqlite-файл:

```powershell
New-Item database/database.sqlite -ItemType File
```

5. При необходимости установите PHP-зависимости:

```powershell
composer install
```

Если локальный Composer не настроен, используйте:

```powershell
docker compose run --rm app composer install
```

6. Выполните миграции и сиды:

```powershell
C:\OSPanel\modules\PHP-8.4\php.exe artisan migrate:fresh --seed
```

7. При необходимости запустите backend:

```powershell
C:\OSPanel\modules\PHP-8.4\php.exe artisan serve
```

### Локальный frontend

Используйте root scripts, чтобы активный frontend оставался изолированным в `apps/web`.

```powershell
npm run web:install
npm run web:dev
```

Если API работает на нестандартном хосте, задайте:

```powershell
$env:NUXT_BACKEND_API_BASE="http://localhost:8000/api/v1"
```

Проверка production build:

```powershell
npm run web:build
```

## Docker development

Docker изолирован от локальной разработки.
Он не использует локальную sqlite-базу и не читает локальные значения из `.env`.

### Правила изоляции

- локальная среда использует `.env`;
- Docker использует `.env.docker`;
- локальная база по умолчанию работает на sqlite;
- Docker использует собственную MySQL-инстанцию;
- Docker MySQL хранит данные в отдельном named volume;
- Docker-порты не конфликтуют с локальными портами по умолчанию.

### Запуск Docker

1. Скопируйте `.env.docker.example` в `.env.docker`.
2. Поднимите стек:

```powershell
docker compose up -d --build
```

3. Выполните миграции и сиды:

```powershell
docker compose exec app php artisan migrate:fresh --seed
```

### Docker endpoints

- Laravel app: `http://localhost:8080`
- Nuxt frontend: `http://localhost:3001`
- Docker MySQL only: `127.0.0.1:3307`
- Swagger UI: `http://localhost:8080/swagger`

## Поддерживаемый workflow разработки

Для каждого нетривиального изменения:

1. реализовать код;
2. добавить или обновить тесты;
3. обновить документацию, если изменились поведение, setup или контракты;
4. выполнить self-review по корректности, безопасности, регрессиям и остаточным рискам.

Актуальные стандарты описаны в:

- `CONTRIBUTING.md`
- `docs/development-standards.md`
- `docs/review-checklist.md`

## Quality gates

Backend quality:

```powershell
composer lint
composer analyse
composer test
composer quality
```

Frontend quality:

```powershell
npm run web:lint
npm run web:typecheck
npm run web:test:unit
npm run web:build
npm run web:test:e2e
```

CI workflow лежит в `.github/workflows/quality.yml` и повторяет этот базовый quality-pass.

## Известные архитектурные ограничения

- в репозитории всё ещё присутствует legacy Blade storefront, потому что миграция идёт поэтапно;
- часть admin и CMS flows ещё не вынесена во внешний API;
- admin, CMS и upload flows ещё покрыты слабее, чем customer API;
- текущий BFF auth безопаснее прошлого варианта, но всё ещё опирается на proxy-managed bearer token;
- OpenAPI пока поддерживается вручную и в будущем должен генерироваться напрямую из backend-кода.
