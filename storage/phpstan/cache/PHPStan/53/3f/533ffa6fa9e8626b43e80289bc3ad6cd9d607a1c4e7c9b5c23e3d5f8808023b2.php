<?php declare(strict_types = 1);

// osfsl-/var/www/html/app/Models/Order.php-PHPStan\BetterReflection\Reflection\ReflectionClass-App\Models\Order
return \PHPStan\Cache\CacheItem::__set_state(array(
   'variableKey' => 'v2-a450e90171019e2892cf98b1cd7e327e7c0f06a6cc35098e58debfe19b063964-8.4.18-6.65.0.9',
   'data' => 
  array (
    'locatedSource' => 
    array (
      'class' => 'PHPStan\\BetterReflection\\SourceLocator\\Located\\LocatedSource',
      'data' => 
      array (
        'name' => 'App\\Models\\Order',
        'filename' => '/var/www/html/app/Models/Order.php',
      ),
    ),
    'namespace' => 'App\\Models',
    'name' => 'App\\Models\\Order',
    'shortName' => 'Order',
    'isInterface' => false,
    'isTrait' => false,
    'isEnum' => false,
    'isBackedEnum' => false,
    'modifiers' => 0,
    'docComment' => '/**
 * @property int $id
 * @property int|null $user_id
 * @property string $name
 * @property string $email
 * @property string $phone
 * @property string $address
 * @property string|null $comment
 * @property float $amount
 * @property int $status
 * @property \\Illuminate\\Support\\Carbon|null $created_at
 * @property \\Illuminate\\Support\\Carbon|null $updated_at
 * @property int|null $items_count
 * @property-read \\Illuminate\\Database\\Eloquent\\Collection<int, \\App\\Models\\OrderItem> $items
 * @property-read \\App\\Models\\User|null $user
 */',
    'attributes' => 
    array (
    ),
    'startLine' => 24,
    'endLine' => 71,
    'startColumn' => 1,
    'endColumn' => 1,
    'parentClassName' => 'Illuminate\\Database\\Eloquent\\Model',
    'implementsClassNames' => 
    array (
    ),
    'traitClassNames' => 
    array (
    ),
    'immediateConstants' => 
    array (
      'STATUSES' => 
      array (
        'declaringClassName' => 'App\\Models\\Order',
        'implementingClassName' => 'App\\Models\\Order',
        'name' => 'STATUSES',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '[\\App\\Enums\\OrderStatus::New->value => \'Новый\', \\App\\Enums\\OrderStatus::Processed->value => \'Обработан\', \\App\\Enums\\OrderStatus::Paid->value => \'Оплачен\', \\App\\Enums\\OrderStatus::Delivered->value => \'Доставлен\', \\App\\Enums\\OrderStatus::Completed->value => \'Завершен\']',
          'attributes' => 
          array (
            'startLine' => 35,
            'endLine' => 41,
            'startTokenPos' => 66,
            'startFilePos' => 840,
            'endTokenPos' => 123,
            'endFilePos' => 1136,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 35,
        'endLine' => 41,
        'startColumn' => 5,
        'endColumn' => 6,
      ),
    ),
    'immediateProperties' => 
    array (
      'fillable' => 
      array (
        'declaringClassName' => 'App\\Models\\Order',
        'implementingClassName' => 'App\\Models\\Order',
        'name' => 'fillable',
        'modifiers' => 2,
        'type' => NULL,
        'default' => 
        array (
          'code' => '[\'name\', \'email\', \'phone\', \'address\', \'comment\', \'status\']',
          'attributes' => 
          array (
            'startLine' => 26,
            'endLine' => 33,
            'startTokenPos' => 35,
            'startFilePos' => 696,
            'endTokenPos' => 55,
            'endFilePos' => 808,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 26,
        'endLine' => 33,
        'startColumn' => 5,
        'endColumn' => 6,
        'isPromoted' => false,
        'declaredAtCompileTime' => true,
        'immediateVirtual' => false,
        'immediateHooks' => 
        array (
        ),
      ),
      'casts' => 
      array (
        'declaringClassName' => 'App\\Models\\Order',
        'implementingClassName' => 'App\\Models\\Order',
        'name' => 'casts',
        'modifiers' => 2,
        'type' => NULL,
        'default' => 
        array (
          'code' => '[\'status\' => \'integer\']',
          'attributes' => 
          array (
            'startLine' => 43,
            'endLine' => 45,
            'startTokenPos' => 132,
            'startFilePos' => 1163,
            'endTokenPos' => 141,
            'endFilePos' => 1200,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 43,
        'endLine' => 45,
        'startColumn' => 5,
        'endColumn' => 6,
        'isPromoted' => false,
        'declaredAtCompileTime' => true,
        'immediateVirtual' => false,
        'immediateHooks' => 
        array (
        ),
      ),
    ),
    'immediateMethods' => 
    array (
      'items' => 
      array (
        'name' => 'items',
        'parameters' => 
        array (
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Связь «один ко многим» таблицы `orders` с таблицей `order_items`
 *
 * @return \\Illuminate\\Database\\Eloquent\\Relations\\HasMany
 */',
        'startLine' => 52,
        'endLine' => 55,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'App\\Models',
        'declaringClassName' => 'App\\Models\\Order',
        'implementingClassName' => 'App\\Models\\Order',
        'currentClassName' => 'App\\Models\\Order',
        'aliasName' => NULL,
      ),
      'user' => 
      array (
        'name' => 'user',
        'parameters' => 
        array (
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Связь «заказ принадлежит» таблицы `orders` с таблицей `users`
 *
 * @return \\Illuminate\\Database\\Eloquent\\Relations\\BelongsTo
 */',
        'startLine' => 62,
        'endLine' => 65,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'App\\Models',
        'declaringClassName' => 'App\\Models\\Order',
        'implementingClassName' => 'App\\Models\\Order',
        'currentClassName' => 'App\\Models\\Order',
        'aliasName' => NULL,
      ),
      'statusEnum' => 
      array (
        'name' => 'statusEnum',
        'parameters' => 
        array (
        ),
        'returnsReference' => false,
        'returnType' => 
        array (
          'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
          'data' => 
          array (
            'name' => 'App\\Enums\\OrderStatus',
            'isIdentifier' => false,
          ),
        ),
        'attributes' => 
        array (
        ),
        'docComment' => NULL,
        'startLine' => 67,
        'endLine' => 70,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'App\\Models',
        'declaringClassName' => 'App\\Models\\Order',
        'implementingClassName' => 'App\\Models\\Order',
        'currentClassName' => 'App\\Models\\Order',
        'aliasName' => NULL,
      ),
    ),
    'traitsData' => 
    array (
      'aliases' => 
      array (
      ),
      'modifiers' => 
      array (
      ),
      'precedences' => 
      array (
      ),
      'hashes' => 
      array (
      ),
    ),
  ),
));