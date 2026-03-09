# Payments

## Purpose

Этот документ описывает:

- текущую платёжную архитектуру проекта;
- как локально запускать sandbox checkout;
- как подключить реальный платёжный провайдер без переписывания checkout целиком;
- какие файлы менять, что писать и где;
- какие тесты и документы обязаны обновляться при каждой платёжной интеграции.

## Current Payment Model

В проекте есть два способа оформления:

- `online_card` — заказ создаётся и сразу запускается онлайн-оплата;
- `manager_confirmation` — заказ создаётся без мгновенного списания, оплату подтверждают позже.

Текущие провайдеры:

- `paypal` — dev/sandbox hosted card fields;
- `fake` — полностью локальный deterministic provider для feature/e2e тестов.

Важно:

- витрина магазина живёт в `KZT`;
- реальное списание у sandbox-провайдера может идти в другой валюте;
- backend хранит и магазинную сумму, и провайдерскую сумму отдельно;
- frontend не должен хранить сырой PAN/CVV/PIN и не должен решать, что заказ оплачен.

## Non-Negotiable Rules

- backend всегда сам считает сумму заказа;
- `order.status = Paid` выставляется только backend-ом;
- browser return URL сам по себе не означает успешную оплату;
- webhook должен быть верифицирован подписью или секретом провайдера;
- секреты провайдера хранятся только на backend;
- данные карты должны вводиться в hosted fields или hosted checkout провайдера;
- CVV и PIN хранить нельзя.

## Architecture

### Stable backend orchestration

Эти точки остаются общими для любого провайдера:

```text
app/Actions/Orders/CheckoutBasket.php
app/Actions/Orders/CreateOrderFromBasket.php

app/Services/Payments/PaymentService.php
app/Services/Payments/PaymentManager.php

app/Http/Controllers/Api/V1/BasketController.php
app/Http/Controllers/Api/V1/PaymentController.php
app/Http/Controllers/Api/V1/PaymentWebhookController.php
app/Http/Controllers/PaymentProviderReturnController.php
app/Http/Controllers/PaymentStatusController.php
```

### Provider extension points

Новый провайдер встраивается через:

```text
config/payments.php
app/Enums/PaymentProvider.php
app/Contracts/Payments/PaymentProviderDriver.php
app/Services/Payments/Providers/<ProviderName>Provider.php
```

### Storefront files that may need changes

Если меняется пользовательский flow оплаты, смотрите:

```text
resources/views/basket/checkout.blade.php
resources/views/payments/show.blade.php
public/js/site.js

apps/web/pages/checkout.vue
apps/web/pages/payments/[publicId].vue
apps/web/types/api.ts
```

Backend integration без UI changes обычно возможна только если новый провайдер повторяет уже существующий `hosted_fields` flow.

Контракт провайдера:

```php
interface PaymentProviderDriver
{
    public function code(): string;

    public function createPayment(Payment $payment, Order $order): PaymentCreationResult;

    public function finalizePayment(Payment $payment, array $parameters = []): PaymentResolutionResult;

    public function checkoutConfiguration(Payment $payment): array;

    public function verifyWebhook(array $headers, array $payload): bool;

    public function resolveWebhook(array $payload): PaymentResolutionResult;
}
```

### What each method is responsible for

- `createPayment()` — создать payment intent/order/session у провайдера и вернуть provider id, redirect URL или ошибку;
- `finalizePayment()` — server-to-server завершение оплаты после hosted form submit или browser return;
- `checkoutConfiguration()` — отдать hosted checkout config для storefront;
- `verifyWebhook()` — проверить подпись/секрет/сертификат webhook;
- `resolveWebhook()` — превратить payload провайдера в единый `PaymentResolutionResult`.

### DTOs returned by drivers

`PaymentCreationResult`:

- `status`
- `providerPaymentId`
- `redirectUrl`
- `requestPayload`
- `responsePayload`
- `failureReason`

`PaymentResolutionResult`:

- `status`
- `providerPaymentId`
- `providerOperationId`
- `failureReason`
- `payload`

## Current Frontend Support

### What already works

- Blade storefront checkout;
- Nuxt checkout;
- публичная страница статуса платежа;
- hosted card fields flow для `paypal` и `fake`.

### Important limitation

Текущий storefront UI полноценно поддерживает именно `hosted_fields`.

Если новый реальный провайдер работает через `redirect`:

1. backend уже умеет хранить `redirect_url` и `checkout_flow`;
2. но storefront UI нужно дополнительно доработать, чтобы после checkout он делал redirect на страницу провайдера;
3. только после этого redirect-провайдер станет first-class flow в обеих витринах.

То есть сегодня safest path для нового production-провайдера:

- либо hosted fields / hosted page через `checkoutConfiguration()`;
- либо отдельная небольшая доработка Blade и Nuxt checkout под `redirect_url`.

## Currency Model

В проекте намеренно разделены:

- `orders.amount` + `orders.currency` — магазинная сумма и валюта витрины;
- `payments.amount` + `payments.currency` — сумма и валюта провайдера;
- `payments.store_amount` + `payments.store_currency` — исходная магазинная сумма;
- `payments.conversion_rate` — курс, использованный при создании платежа.

Это нужно, чтобы не допустить ситуации вида:

- на сайте пользователь видит `24 990 KZT`;
- в sandbox-платёжке создаётся `24 990 USD`.

Для production-провайдера с прямой поддержкой `KZT` рекомендован режим:

- `STORE_CURRENCY=KZT`
- `PROVIDER_CURRENCY=KZT`
- `exchange_rate = 1`

## Local Sandbox Setup

### PayPal Sandbox

`.env`:

```dotenv
PAYMENT_PROVIDER=paypal
STORE_CURRENCY=KZT
PAYPAL_SANDBOX=true
PAYPAL_BASE_URL=https://api-m.sandbox.paypal.com
PAYPAL_CURRENCY=USD
PAYPAL_EXCHANGE_RATE=510
PAYPAL_CLIENT_ID=your_sandbox_client_id
PAYPAL_CLIENT_SECRET=your_sandbox_client_secret
PAYPAL_MERCHANT_ID=
PAYPAL_WEBHOOK_ID=your_sandbox_webhook_id
PAYMENT_STATUS_BASE_URL=http://localhost:3000/payments
```

Порядок:

1. создайте sandbox app в PayPal Developer Dashboard;
2. пропишите webhook на backend URL `POST /api/v1/payments/webhook/paypal`;
3. если backend не публичный, поднимите туннель;
4. очистите config cache;
5. проверьте hosted checkout вручную.

### Fake provider

Для локального deterministic flow:

```dotenv
PAYMENT_PROVIDER=fake
STORE_CURRENCY=KZT
FAKE_PAYMENT_CURRENCY=KZT
FAKE_PAYMENT_EXCHANGE_RATE=1
PAYMENT_STATUS_BASE_URL=http://localhost:3000/payments
```

`fake` нужен для:

- локальных ручных проверок без внешнего API;
- PHPUnit feature tests;
- Playwright checkout flow.

## How To Integrate A Real Payment Provider

Ниже описан production-safe порядок для любого эквайринга: Freedom Pay, Halyk ePay, CloudPayments, Stripe, PayPal Live, Braintree, YooKassa или любого внутреннего банковского шлюза.

### 1. Decide the flow before writing code

Зафиксируйте заранее:

- провайдер поддерживает `hosted_fields`, `hosted_page` или только `redirect`;
- есть ли серверный `capture` или только webhook-confirmed final state;
- поддерживает ли провайдер `KZT`;
- как проверяется webhook: подпись, сертификат, secret key, IP allowlist;
- какие URL обязательны: `return`, `fail`, `cancel`, `webhook`.

Если этих ответов нет, адаптер писать рано.

### 2. Add provider code to enum

Файл:

```text
app/Enums/PaymentProvider.php
```

Добавьте новый case и label:

```php
case FreedomPay = 'freedompay';
```

И обязательно добавьте локализованный label в `label()`.

### 3. Add provider config

Файл:

```text
config/payments.php
```

Добавьте секцию:

```php
'freedompay' => [
    'base_url' => env('FREEDOMPAY_BASE_URL'),
    'merchant_id' => env('FREEDOMPAY_MERCHANT_ID'),
    'secret_key' => env('FREEDOMPAY_SECRET_KEY'),
    'currency' => env('FREEDOMPAY_CURRENCY', 'KZT'),
    'exchange_rate' => (float) env('FREEDOMPAY_EXCHANGE_RATE', 1),
    'checkout_flow' => 'redirect',
],
```

Если провайдер работает в `KZT`, используйте `exchange_rate = 1`.

### 4. Implement provider adapter

Файл:

```text
app/Services/Payments/Providers/FreedomPayProvider.php
```

Минимальный каркас:

```php
<?php

namespace App\Services\Payments\Providers;

use App\Contracts\Payments\PaymentProviderDriver;
use App\DTO\Payments\PaymentCreationResult;
use App\DTO\Payments\PaymentResolutionResult;
use App\Enums\PaymentStatus;
use App\Models\Order;
use App\Models\Payment;

class FreedomPayProvider implements PaymentProviderDriver
{
    public function code(): string
    {
        return 'freedompay';
    }

    public function createPayment(Payment $payment, Order $order): PaymentCreationResult
    {
        // 1. build provider request
        // 2. call provider API
        // 3. map response to local payment session

        return new PaymentCreationResult(
            status: PaymentStatus::Pending,
            providerPaymentId: 'provider-order-id',
            redirectUrl: 'https://provider.example/checkout/123',
            requestPayload: [],
            responsePayload: [],
        );
    }

    public function finalizePayment(Payment $payment, array $parameters = []): PaymentResolutionResult
    {
        // for hosted fields or provider return capture/finalize

        return new PaymentResolutionResult(
            status: PaymentStatus::Succeeded,
            providerPaymentId: $payment->provider_payment_id,
            providerOperationId: 'provider-operation-id',
        );
    }

    public function checkoutConfiguration(Payment $payment): array
    {
        return [
            'payment_id' => $payment->public_id,
            'flow' => 'redirect',
            'provider_payment_id' => $payment->provider_payment_id,
            'status_url' => app(\App\Services\Payments\PaymentService::class)->statusPageUrl($payment),
        ];
    }

    public function verifyWebhook(array $headers, array $payload): bool
    {
        return true;
    }

    public function resolveWebhook(array $payload): PaymentResolutionResult
    {
        return new PaymentResolutionResult(
            status: PaymentStatus::Succeeded,
            providerPaymentId: 'provider-order-id',
            providerOperationId: 'provider-operation-id',
            payload: $payload,
        );
    }
}
```

### 5. Register adapter in PaymentManager

Файл:

```text
app/Services/Payments/PaymentManager.php
```

Добавьте новый `match` case:

```php
PaymentProvider::FreedomPay->value => app(FreedomPayProvider::class),
```

Без этого `PAYMENT_PROVIDER=freedompay` не заработает.

### 6. Update env templates and deployment docs

Обновить:

```text
.env.example
.env.docker.example
README.md
docs/hosting-deployment.md
docs/payments.md
```

Добавьте:

- provider credentials;
- public webhook URL;
- public return URL strategy;
- currency and exchange settings.

### 7. Decide how storefront should continue after checkout

#### Hosted fields / hosted widget

Если провайдер встраивается на странице checkout:

- используйте `checkoutConfiguration()` для выдачи JS config;
- не кладите secret keys в ответ;
- frontend рендерит только provider-owned fields/widget;
- после submit frontend вызывает backend `capture` или ждёт return/webhook, в зависимости от API провайдера.

#### Redirect flow

Если провайдер требует уходить на внешнюю страницу:

- `createPayment()` должен вернуть `redirectUrl`;
- storefront после checkout должен перенаправить пользователя на него;
- по return URL backend или storefront не должны безусловно ставить оплату как успешную;
- final truth всё равно должен дать backend через server-side finalize и/или verified webhook.

### 8. Implement webhook verification before release

Файлы:

```text
app/Http/Controllers/Api/V1/PaymentWebhookController.php
app/Services/Payments/PaymentService.php
app/Services/Payments/Providers/<ProviderName>Provider.php
```

Нужно обеспечить:

- подпись webhook действительно проверяется;
- из webhook можно получить provider payment id;
- webhook идемпотентен;
- повторный webhook не ломает уже успешный платёж;
- невалидная подпись возвращает `422`.

### 9. Do not rewrite shared order logic

При правильной интеграции не нужно переписывать:

- `CheckoutBasket`;
- `CreateOrderFromBasket`;
- `BasketController`;
- `Order` модель;
- публичную страницу статуса заказа.

Обычно меняются только:

- provider enum;
- provider config;
- provider adapter;
- manager registration;
- frontend hosted/redirect branch;
- env и документация;
- тесты.

## Real Provider Rollout Checklist

Перед first live payment должны быть готовы:

1. production merchant account;
2. backend public URL;
3. production webhook URL на backend, не на Nuxt host;
4. production return/cancel URLs;
5. keys/secrets в production secret storage;
6. currency strategy;
7. ручной staging smoke test;
8. regression tests;
9. обновлённый Swagger/OpenAPI;
10. обновлённые `README`, `payments`, `hosting`, `architecture`.

## What To Write Where

### Backend provider credentials

Писать в:

- `.env`
- `.env.example`
- production secret storage

Не писать в:

- frontend runtime config с `public` доступом;
- Vue/Nuxt pages;
- Blade templates;
- JS файлы.

### Provider JS keys

Если провайдер требует public JS key:

- он может попасть в storefront config;
- но secret key, signing secret и webhook secret туда попадать не должны.

### Webhook URL

Всегда должен указывать на backend:

```text
https://app.example.com/api/v1/payments/webhook/{provider}
```

Не на:

```text
https://shop.example.com/payments/...
```

### Return URL

Должен приводить пользователя обратно на storefront/payment status page, но не использоваться как единственный источник истины по оплате.

## Tests You Must Update

### Backend feature tests

Уже существующие точки:

```text
tests/Feature/Api/BasketApiTest.php
tests/Feature/Api/PaymentApiTest.php
tests/Feature/BasketCheckoutTest.php
tests/Feature/OpenApiContractTest.php
```

Минимальный test matrix для нового провайдера:

- checkout с `online_card` создаёт `order` и `payment`;
- checkout с `manager_confirmation` не создаёт `payment`;
- provider create session корректно сохраняет `provider_payment_id`;
- checkout-config отдаёт hosted/redirect config;
- capture/finalize переводит платёж в `succeeded`, если это поддерживается flow;
- verified webhook переводит заказ в `Paid`;
- invalid webhook signature отклоняется;
- повторный webhook идемпотентен;
- mismatch суммы/валюты отклоняется, если API провайдера это позволяет.

### Frontend tests

Текущие точки:

```text
apps/web/tests/unit/checkout.test.ts
apps/web/tests/e2e/login-basket-checkout.spec.ts
```

Если меняется checkout UI:

- обновите unit tests для checkout helpers;
- обновите Playwright flow;
- если добавлен redirect flow, добавьте e2e на сценарий redirect-return-status.

## Verification Commands

После каждой платёжной доработки или замены провайдера должны быть зелёными:

```bash
php scripts/app.php backend:lint
php scripts/app.php backend:analyse
php scripts/app.php backend:test
php scripts/app.php web:lint
php scripts/app.php web:typecheck
php scripts/app.php web:test:unit
php scripts/app.php web:build
php scripts/app.php web:test:e2e
```

Или shortcuts:

```bash
php scripts/app.php verify:all
php scripts/app.php verify:e2e
```

## Swagger And Documentation Rules

При любой реальной интеграции нужно обновить:

- `docs/openapi.yaml`
- `README.md`
- `docs/payments.md`
- `docs/hosting-deployment.md`
- `docs/architecture.md`

Что именно должно попасть в Swagger/OpenAPI:

- если изменились payment endpoints;
- если изменился payload checkout;
- если changed `PaymentDetail`;
- если changed `PaymentCheckoutConfig`;
- если появились новые обязательные request fields;
- если появились provider-specific response flags, которые реально читает storefront.

## Final Recommendation

Если подключается реальный провайдер:

- сначала реализуйте backend adapter и webhook verification;
- потом подключайте storefront branch для hosted/redirect flow;
- затем обновляйте OpenAPI и документы;
- и только после этого включайте provider в production через `PAYMENT_PROVIDER=<new-code>`.

Именно такой порядок позволяет заменить sandbox-провайдер на production-провайдера без переписывания заказа, корзины и общих payment endpoints.
