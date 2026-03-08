<?php declare(strict_types = 1);

// odsl-/var/www/html/app/Http/Requests/BrandCatalogRequest.php-PHPStan\BetterReflection\Reflection\ReflectionClass-App\Http\Requests\BrandCatalogRequest
return \PHPStan\Cache\CacheItem::__set_state(array(
   'variableKey' => 'v2-6.65.0.9-8.4.18-a98488326f58250c01fb2cd173399b14ae1590e8c23c54c67b2716d0386ec8ae',
   'data' => 
  array (
    'locatedSource' => 
    array (
      'class' => 'PHPStan\\BetterReflection\\SourceLocator\\Located\\LocatedSource',
      'data' => 
      array (
        'name' => 'App\\Http\\Requests\\BrandCatalogRequest',
        'filename' => '/var/www/html/app/Http/Requests/BrandCatalogRequest.php',
      ),
    ),
    'namespace' => 'App\\Http\\Requests',
    'name' => 'App\\Http\\Requests\\BrandCatalogRequest',
    'shortName' => 'BrandCatalogRequest',
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
    'endLine' => 53,
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
        'declaringClassName' => 'App\\Http\\Requests\\BrandCatalogRequest',
        'implementingClassName' => 'App\\Http\\Requests\\BrandCatalogRequest',
        'name' => 'entity',
        'modifiers' => 2,
        'type' => NULL,
        'default' => 
        array (
          'code' => '[\'name\' => \'brand\', \'table\' => \'brands\']',
          'attributes' => 
          array (
            'startLine' => 12,
            'endLine' => 15,
            'startTokenPos' => 25,
            'startFilePos' => 253,
            'endTokenPos' => 41,
            'endFilePos' => 315,
          ),
        ),
        'docComment' => '/**
 * С какой сущностью сейчас работаем (бренд каталога)
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
        'declaringClassName' => 'App\\Http\\Requests\\BrandCatalogRequest',
        'implementingClassName' => 'App\\Http\\Requests\\BrandCatalogRequest',
        'currentClassName' => 'App\\Http\\Requests\\BrandCatalogRequest',
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
        'docComment' => NULL,
        'startLine' => 27,
        'endLine' => 30,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'App\\Http\\Requests',
        'declaringClassName' => 'App\\Http\\Requests\\BrandCatalogRequest',
        'implementingClassName' => 'App\\Http\\Requests\\BrandCatalogRequest',
        'currentClassName' => 'App\\Http\\Requests\\BrandCatalogRequest',
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
 * Объединяет дефолтные правила и правила, специфичные для бренда
 * для проверки данных при добавлении нового бренда
 */',
        'startLine' => 36,
        'endLine' => 41,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 2,
        'namespace' => 'App\\Http\\Requests',
        'declaringClassName' => 'App\\Http\\Requests\\BrandCatalogRequest',
        'implementingClassName' => 'App\\Http\\Requests\\BrandCatalogRequest',
        'currentClassName' => 'App\\Http\\Requests\\BrandCatalogRequest',
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
 * Объединяет дефолтные правила и правила, специфичные для бренда
 * для проверки данных при обновлении существующего бренда
 */',
        'startLine' => 47,
        'endLine' => 52,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 2,
        'namespace' => 'App\\Http\\Requests',
        'declaringClassName' => 'App\\Http\\Requests\\BrandCatalogRequest',
        'implementingClassName' => 'App\\Http\\Requests\\BrandCatalogRequest',
        'currentClassName' => 'App\\Http\\Requests\\BrandCatalogRequest',
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