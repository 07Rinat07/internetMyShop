<?php declare(strict_types = 1);

// osfsl-/var/www/html/app/Models/OrderItem.php-PHPStan\BetterReflection\Reflection\ReflectionClass-App\Models\OrderItem
return \PHPStan\Cache\CacheItem::__set_state(array(
   'variableKey' => 'v2-0b84a8309751ffb8aaaad7519fd302c737e11ec054e2bfd59ff0166411462654-8.4.18-6.65.0.9',
   'data' => 
  array (
    'locatedSource' => 
    array (
      'class' => 'PHPStan\\BetterReflection\\SourceLocator\\Located\\LocatedSource',
      'data' => 
      array (
        'name' => 'App\\Models\\OrderItem',
        'filename' => '/var/www/html/app/Models/OrderItem.php',
      ),
    ),
    'namespace' => 'App\\Models',
    'name' => 'App\\Models\\OrderItem',
    'shortName' => 'OrderItem',
    'isInterface' => false,
    'isTrait' => false,
    'isEnum' => false,
    'isBackedEnum' => false,
    'modifiers' => 0,
    'docComment' => '/**
 * @property int $id
 * @property int|null $product_id
 * @property string $name
 * @property float $price
 * @property int $quantity
 * @property float $cost
 * @property-read \\App\\Models\\Product|null $product
 */',
    'attributes' => 
    array (
    ),
    'startLine' => 17,
    'endLine' => 35,
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
    ),
    'immediateProperties' => 
    array (
      'timestamps' => 
      array (
        'declaringClassName' => 'App\\Models\\OrderItem',
        'implementingClassName' => 'App\\Models\\OrderItem',
        'name' => 'timestamps',
        'modifiers' => 1,
        'type' => NULL,
        'default' => 
        array (
          'code' => 'false',
          'attributes' => 
          array (
            'startLine' => 19,
            'endLine' => 19,
            'startTokenPos' => 35,
            'startFilePos' => 374,
            'endTokenPos' => 35,
            'endFilePos' => 378,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 19,
        'endLine' => 19,
        'startColumn' => 5,
        'endColumn' => 31,
        'isPromoted' => false,
        'declaredAtCompileTime' => true,
        'immediateVirtual' => false,
        'immediateHooks' => 
        array (
        ),
      ),
      'fillable' => 
      array (
        'declaringClassName' => 'App\\Models\\OrderItem',
        'implementingClassName' => 'App\\Models\\OrderItem',
        'name' => 'fillable',
        'modifiers' => 2,
        'type' => NULL,
        'default' => 
        array (
          'code' => '[\'product_id\', \'name\', \'price\', \'quantity\', \'cost\']',
          'attributes' => 
          array (
            'startLine' => 21,
            'endLine' => 27,
            'startTokenPos' => 44,
            'startFilePos' => 410,
            'endTokenPos' => 61,
            'endFilePos' => 513,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 21,
        'endLine' => 27,
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
      'product' => 
      array (
        'name' => 'product',
        'parameters' => 
        array (
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Связь «элемент принадлежит» таблицы `order_item` с таблицей `products`
 */',
        'startLine' => 32,
        'endLine' => 34,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'App\\Models',
        'declaringClassName' => 'App\\Models\\OrderItem',
        'implementingClassName' => 'App\\Models\\OrderItem',
        'currentClassName' => 'App\\Models\\OrderItem',
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