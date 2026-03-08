<?php declare(strict_types = 1);

// odsl-/var/www/html/app/Http/Requests/CategoryCatalogRequest.php-PHPStan\BetterReflection\Reflection\ReflectionClass-App\Http\Requests\CategoryCatalogRequest
return \PHPStan\Cache\CacheItem::__set_state(array(
   'variableKey' => 'v2-6.65.0.9-8.4.18-bca701135243356c18db5dfb1390c79b589a53cffa8a2d63c3c4bf3d968e75ba',
   'data' => 
  array (
    'locatedSource' => 
    array (
      'class' => 'PHPStan\\BetterReflection\\SourceLocator\\Located\\LocatedSource',
      'data' => 
      array (
        'name' => 'App\\Http\\Requests\\CategoryCatalogRequest',
        'filename' => '/var/www/html/app/Http/Requests/CategoryCatalogRequest.php',
      ),
    ),
    'namespace' => 'App\\Http\\Requests',
    'name' => 'App\\Http\\Requests\\CategoryCatalogRequest',
    'shortName' => 'CategoryCatalogRequest',
    'isInterface' => false,
    'isTrait' => false,
    'isEnum' => false,
    'isBackedEnum' => false,
    'modifiers' => 0,
    'docComment' => NULL,
    'attributes' => 
    array (
    ),
    'startLine' => 7,
    'endLine' => 74,
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
        'declaringClassName' => 'App\\Http\\Requests\\CategoryCatalogRequest',
        'implementingClassName' => 'App\\Http\\Requests\\CategoryCatalogRequest',
        'name' => 'entity',
        'modifiers' => 2,
        'type' => NULL,
        'default' => 
        array (
          'code' => '[\'name\' => \'category\', \'table\' => \'categories\']',
          'attributes' => 
          array (
            'startLine' => 14,
            'endLine' => 17,
            'startTokenPos' => 30,
            'startFilePos' => 295,
            'endTokenPos' => 46,
            'endFilePos' => 364,
          ),
        ),
        'docComment' => '/**
 * С какой сущностью сейчас работаем (категория каталога)
 *
 * @var array
 */',
        'attributes' => 
        array (
        ),
        'startLine' => 14,
        'endLine' => 17,
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
        'startLine' => 24,
        'endLine' => 27,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'App\\Http\\Requests',
        'declaringClassName' => 'App\\Http\\Requests\\CategoryCatalogRequest',
        'implementingClassName' => 'App\\Http\\Requests\\CategoryCatalogRequest',
        'currentClassName' => 'App\\Http\\Requests\\CategoryCatalogRequest',
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
        'startLine' => 34,
        'endLine' => 37,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'App\\Http\\Requests',
        'declaringClassName' => 'App\\Http\\Requests\\CategoryCatalogRequest',
        'implementingClassName' => 'App\\Http\\Requests\\CategoryCatalogRequest',
        'currentClassName' => 'App\\Http\\Requests\\CategoryCatalogRequest',
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
 * Объединяет дефолтные правила и правила, специфичные для категории
 * для проверки данных при добавлении новой категории
 */',
        'startLine' => 43,
        'endLine' => 53,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 2,
        'namespace' => 'App\\Http\\Requests',
        'declaringClassName' => 'App\\Http\\Requests\\CategoryCatalogRequest',
        'implementingClassName' => 'App\\Http\\Requests\\CategoryCatalogRequest',
        'currentClassName' => 'App\\Http\\Requests\\CategoryCatalogRequest',
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
 * Объединяет дефолтные правила и правила, специфичные для категории
 * для проверки данных при обновлении существующей категории
 */',
        'startLine' => 59,
        'endLine' => 73,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 2,
        'namespace' => 'App\\Http\\Requests',
        'declaringClassName' => 'App\\Http\\Requests\\CategoryCatalogRequest',
        'implementingClassName' => 'App\\Http\\Requests\\CategoryCatalogRequest',
        'currentClassName' => 'App\\Http\\Requests\\CategoryCatalogRequest',
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