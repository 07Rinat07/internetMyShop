<?php declare(strict_types = 1);

// osfsl-/var/www/html/app/Models/Brand.php-PHPStan\BetterReflection\Reflection\ReflectionClass-App\Models\Brand
return \PHPStan\Cache\CacheItem::__set_state(array(
   'variableKey' => 'v2-efc1f28a491c589b3ae5618d689579f50561cb52ec561e900971e03a44629c17-8.4.18-6.65.0.9',
   'data' => 
  array (
    'locatedSource' => 
    array (
      'class' => 'PHPStan\\BetterReflection\\SourceLocator\\Located\\LocatedSource',
      'data' => 
      array (
        'name' => 'App\\Models\\Brand',
        'filename' => '/var/www/html/app/Models/Brand.php',
      ),
    ),
    'namespace' => 'App\\Models',
    'name' => 'App\\Models\\Brand',
    'shortName' => 'Brand',
    'isInterface' => false,
    'isTrait' => false,
    'isEnum' => false,
    'isBackedEnum' => false,
    'modifiers' => 0,
    'docComment' => '/**
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string|null $content
 * @property string|null $image
 * @property int|null $products_count
 * @property-read \\Illuminate\\Database\\Eloquent\\Collection<int, \\App\\Models\\Product> $products
 */',
    'attributes' => 
    array (
    ),
    'startLine' => 17,
    'endLine' => 45,
    'startColumn' => 1,
    'endColumn' => 1,
    'parentClassName' => 'Illuminate\\Database\\Eloquent\\Model',
    'implementsClassNames' => 
    array (
    ),
    'traitClassNames' => 
    array (
      0 => 'Illuminate\\Database\\Eloquent\\Factories\\HasFactory',
    ),
    'immediateConstants' => 
    array (
    ),
    'immediateProperties' => 
    array (
      'fillable' => 
      array (
        'declaringClassName' => 'App\\Models\\Brand',
        'implementingClassName' => 'App\\Models\\Brand',
        'name' => 'fillable',
        'modifiers' => 2,
        'type' => NULL,
        'default' => 
        array (
          'code' => '[\'name\', \'slug\', \'content\', \'image\']',
          'attributes' => 
          array (
            'startLine' => 20,
            'endLine' => 25,
            'startTokenPos' => 40,
            'startFilePos' => 484,
            'endTokenPos' => 54,
            'endFilePos' => 563,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 20,
        'endLine' => 25,
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
      'products' => 
      array (
        'name' => 'products',
        'parameters' => 
        array (
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Связь «один ко многим» таблицы `brands` с таблицей `products`
 *
 * @return \\Illuminate\\Database\\Eloquent\\Relations\\HasMany
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
        'declaringClassName' => 'App\\Models\\Brand',
        'implementingClassName' => 'App\\Models\\Brand',
        'currentClassName' => 'App\\Models\\Brand',
        'aliasName' => NULL,
      ),
      'popular' => 
      array (
        'name' => 'popular',
        'parameters' => 
        array (
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Возвращает список популярных брендов каталога товаров.
 * Следовало бы отобрать бренды, товары которых продаются
 * чаще всего. Но поскольку таких данных у нас еще нет,
 * просто получаем 5 брендов с наибольшим кол-вом товаров
 */',
        'startLine' => 42,
        'endLine' => 44,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 17,
        'namespace' => 'App\\Models',
        'declaringClassName' => 'App\\Models\\Brand',
        'implementingClassName' => 'App\\Models\\Brand',
        'currentClassName' => 'App\\Models\\Brand',
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