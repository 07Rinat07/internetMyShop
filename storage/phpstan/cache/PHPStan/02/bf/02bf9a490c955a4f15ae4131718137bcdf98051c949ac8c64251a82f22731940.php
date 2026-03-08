<?php declare(strict_types = 1);

// odsl-/var/www/html/app/Http/Requests/ProductCatalogRequest.php-PHPStan\BetterReflection\Reflection\ReflectionClass-App\Http\Requests\ProductCatalogRequest
return \PHPStan\Cache\CacheItem::__set_state(array(
   'variableKey' => 'v2-6.65.0.9-8.4.18-87969403d509836d769de277b3b1a61c903bcc4e14874e639f3511f54da401fb',
   'data' => 
  array (
    'locatedSource' => 
    array (
      'class' => 'PHPStan\\BetterReflection\\SourceLocator\\Located\\LocatedSource',
      'data' => 
      array (
        'name' => 'App\\Http\\Requests\\ProductCatalogRequest',
        'filename' => '/var/www/html/app/Http/Requests/ProductCatalogRequest.php',
      ),
    ),
    'namespace' => 'App\\Http\\Requests',
    'name' => 'App\\Http\\Requests\\ProductCatalogRequest',
    'shortName' => 'ProductCatalogRequest',
    'isInterface' => false,
    'isTrait' => false,
    'isEnum' => false,
    'isBackedEnum' => false,
    'modifiers' => 0,
    'docComment' => NULL,
    'attributes' => 
    array (
    ),
    'startLine' => 5,
    'endLine' => 90,
    'startColumn' => 1,
    'endColumn' => 1,
    'parentClassName' => 'App\\Http\\Requests\\CatalogRequest',
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
      'entity' => 
      array (
        'declaringClassName' => 'App\\Http\\Requests\\ProductCatalogRequest',
        'implementingClassName' => 'App\\Http\\Requests\\ProductCatalogRequest',
        'name' => 'entity',
        'modifiers' => 2,
        'type' => NULL,
        'default' => 
        array (
          'code' => '[\'name\' => \'product\', \'table\' => \'products\']',
          'attributes' => 
          array (
            'startLine' => 12,
            'endLine' => 15,
            'startTokenPos' => 25,
            'startFilePos' => 255,
            'endTokenPos' => 41,
            'endFilePos' => 321,
          ),
        ),
        'docComment' => '/**
 * С какой сущностью сейчас работаем (товар каталога)
 *
 * @var array
 */',
        'attributes' => 
        array (
        ),
        'startLine' => 12,
        'endLine' => 15,
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
      'authorize' => 
      array (
        'name' => 'authorize',
        'parameters' => 
        array (
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Determine if the user is authorized to make this request.
 *
 * @return bool
 */',
        'startLine' => 22,
        'endLine' => 25,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'App\\Http\\Requests',
        'declaringClassName' => 'App\\Http\\Requests\\ProductCatalogRequest',
        'implementingClassName' => 'App\\Http\\Requests\\ProductCatalogRequest',
        'currentClassName' => 'App\\Http\\Requests\\ProductCatalogRequest',
        'aliasName' => NULL,
      ),
      'rules' => 
      array (
        'name' => 'rules',
        'parameters' => 
        array (
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Get the validation rules that apply to the request.
 *
 * @return array
 */',
        'startLine' => 32,
        'endLine' => 35,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'App\\Http\\Requests',
        'declaringClassName' => 'App\\Http\\Requests\\ProductCatalogRequest',
        'implementingClassName' => 'App\\Http\\Requests\\ProductCatalogRequest',
        'currentClassName' => 'App\\Http\\Requests\\ProductCatalogRequest',
        'aliasName' => NULL,
      ),
      'createItem' => 
      array (
        'name' => 'createItem',
        'parameters' => 
        array (
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Объединяет дефолтные правила и правила, специфичные для товара
 * для проверки данных при добавлении нового товара
 */',
        'startLine' => 41,
        'endLine' => 62,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 2,
        'namespace' => 'App\\Http\\Requests',
        'declaringClassName' => 'App\\Http\\Requests\\ProductCatalogRequest',
        'implementingClassName' => 'App\\Http\\Requests\\ProductCatalogRequest',
        'currentClassName' => 'App\\Http\\Requests\\ProductCatalogRequest',
        'aliasName' => NULL,
      ),
      'updateItem' => 
      array (
        'name' => 'updateItem',
        'parameters' => 
        array (
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Объединяет дефолтные правила и правила, специфичные для товара
 * для проверки данных при обновлении существующего товара
 */',
        'startLine' => 68,
        'endLine' => 89,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 2,
        'namespace' => 'App\\Http\\Requests',
        'declaringClassName' => 'App\\Http\\Requests\\ProductCatalogRequest',
        'implementingClassName' => 'App\\Http\\Requests\\ProductCatalogRequest',
        'currentClassName' => 'App\\Http\\Requests\\ProductCatalogRequest',
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