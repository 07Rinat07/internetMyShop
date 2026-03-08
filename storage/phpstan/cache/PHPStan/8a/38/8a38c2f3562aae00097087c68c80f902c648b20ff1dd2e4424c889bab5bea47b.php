<?php declare(strict_types = 1);

// osfsl-/var/www/html/app/Models/Category.php-PHPStan\BetterReflection\Reflection\ReflectionClass-App\Models\Category
return \PHPStan\Cache\CacheItem::__set_state(array(
   'variableKey' => 'v2-9b866b74ff420f1967ffd31b55b6fbca2bcab37ebdfc0b1a56264d4ef1cf8cea-8.4.18-6.65.0.9',
   'data' => 
  array (
    'locatedSource' => 
    array (
      'class' => 'PHPStan\\BetterReflection\\SourceLocator\\Located\\LocatedSource',
      'data' => 
      array (
        'name' => 'App\\Models\\Category',
        'filename' => '/var/www/html/app/Models/Category.php',
      ),
    ),
    'namespace' => 'App\\Models',
    'name' => 'App\\Models\\Category',
    'shortName' => 'Category',
    'isInterface' => false,
    'isTrait' => false,
    'isEnum' => false,
    'isBackedEnum' => false,
    'modifiers' => 0,
    'docComment' => '/**
 * @property int $id
 * @property int $parent_id
 * @property string $name
 * @property string $slug
 * @property string|null $content
 * @property string|null $image
 * @property-read \\Illuminate\\Database\\Eloquent\\Collection<int, \\App\\Models\\Category> $children
 * @property-read \\Illuminate\\Database\\Eloquent\\Collection<int, \\App\\Models\\Product> $products
 */',
    'attributes' => 
    array (
    ),
    'startLine' => 18,
    'endLine' => 99,
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
        'declaringClassName' => 'App\\Models\\Category',
        'implementingClassName' => 'App\\Models\\Category',
        'name' => 'fillable',
        'modifiers' => 2,
        'type' => NULL,
        'default' => 
        array (
          'code' => '[\'parent_id\', \'name\', \'slug\', \'content\', \'image\']',
          'attributes' => 
          array (
            'startLine' => 21,
            'endLine' => 27,
            'startTokenPos' => 40,
            'startFilePos' => 573,
            'endTokenPos' => 57,
            'endFilePos' => 674,
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
 * Связь «один ко многим» таблицы `categories` с таблицей `products`
 *
 * @return \\Illuminate\\Database\\Eloquent\\Relations\\HasMany
 */',
        'startLine' => 34,
        'endLine' => 36,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'App\\Models',
        'declaringClassName' => 'App\\Models\\Category',
        'implementingClassName' => 'App\\Models\\Category',
        'currentClassName' => 'App\\Models\\Category',
        'aliasName' => NULL,
      ),
      'children' => 
      array (
        'name' => 'children',
        'parameters' => 
        array (
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Связь «один ко многим» таблицы `categories` с таблицей `categories`
 *
 * @return \\Illuminate\\Database\\Eloquent\\Relations\\HasMany
 */',
        'startLine' => 43,
        'endLine' => 45,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'App\\Models',
        'declaringClassName' => 'App\\Models\\Category',
        'implementingClassName' => 'App\\Models\\Category',
        'currentClassName' => 'App\\Models\\Category',
        'aliasName' => NULL,
      ),
      'descendants' => 
      array (
        'name' => 'descendants',
        'parameters' => 
        array (
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Связь «один ко многим» таблицы `categories` с таблицей `categories`,но
 * позволяет получить не только дочерние категории, но и дочерние-дочерние
 *
 * @return \\Illuminate\\Database\\Eloquent\\Relations\\HasMany
 */',
        'startLine' => 53,
        'endLine' => 55,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'App\\Models',
        'declaringClassName' => 'App\\Models\\Category',
        'implementingClassName' => 'App\\Models\\Category',
        'currentClassName' => 'App\\Models\\Category',
        'aliasName' => NULL,
      ),
      'roots' => 
      array (
        'name' => 'roots',
        'parameters' => 
        array (
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Возвращает список корневых категорий каталога товаров
 */',
        'startLine' => 60,
        'endLine' => 62,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 17,
        'namespace' => 'App\\Models',
        'declaringClassName' => 'App\\Models\\Category',
        'implementingClassName' => 'App\\Models\\Category',
        'currentClassName' => 'App\\Models\\Category',
        'aliasName' => NULL,
      ),
      'hierarchy' => 
      array (
        'name' => 'hierarchy',
        'parameters' => 
        array (
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Возвращает список всех категорий каталога в виде дерева
 */',
        'startLine' => 67,
        'endLine' => 69,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 17,
        'namespace' => 'App\\Models',
        'declaringClassName' => 'App\\Models\\Category',
        'implementingClassName' => 'App\\Models\\Category',
        'currentClassName' => 'App\\Models\\Category',
        'aliasName' => NULL,
      ),
      'validParent' => 
      array (
        'name' => 'validParent',
        'parameters' => 
        array (
          'id' => 
          array (
            'name' => 'id',
            'default' => NULL,
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 75,
            'endLine' => 75,
            'startColumn' => 33,
            'endColumn' => 35,
            'parameterIndex' => 0,
            'isOptional' => false,
          ),
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Проверяет, что переданный идентификатор id может быть родителем
 * этой категории; что категорию не пытаются поместить внутрь себя
 */',
        'startLine' => 75,
        'endLine' => 81,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'App\\Models',
        'declaringClassName' => 'App\\Models\\Category',
        'implementingClassName' => 'App\\Models\\Category',
        'currentClassName' => 'App\\Models\\Category',
        'aliasName' => NULL,
      ),
      'getAllChildren' => 
      array (
        'name' => 'getAllChildren',
        'parameters' => 
        array (
          'id' => 
          array (
            'name' => 'id',
            'default' => NULL,
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 86,
            'endLine' => 86,
            'startColumn' => 43,
            'endColumn' => 45,
            'parameterIndex' => 0,
            'isOptional' => false,
          ),
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Возвращает всех потомков категории с идентификатором $id
 */',
        'startLine' => 86,
        'endLine' => 98,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 17,
        'namespace' => 'App\\Models',
        'declaringClassName' => 'App\\Models\\Category',
        'implementingClassName' => 'App\\Models\\Category',
        'currentClassName' => 'App\\Models\\Category',
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