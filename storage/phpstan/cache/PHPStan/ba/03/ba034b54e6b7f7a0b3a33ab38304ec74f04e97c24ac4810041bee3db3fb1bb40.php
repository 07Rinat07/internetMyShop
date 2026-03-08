<?php declare(strict_types = 1);

// odsl-/var/www/html/tests/Feature/Api/BasketApiTest.php-PHPStan\BetterReflection\Reflection\ReflectionClass-Tests\Feature\Api\BasketApiTest
return \PHPStan\Cache\CacheItem::__set_state(array(
   'variableKey' => 'v2-6.65.0.9-8.4.18-996839868a29a1b566d2199b71052b395f932faed8f93e73ec4abed737b9e86d',
   'data' => 
  array (
    'locatedSource' => 
    array (
      'class' => 'PHPStan\\BetterReflection\\SourceLocator\\Located\\LocatedSource',
      'data' => 
      array (
        'name' => 'Tests\\Feature\\Api\\BasketApiTest',
        'filename' => '/var/www/html/tests/Feature/Api/BasketApiTest.php',
      ),
    ),
    'namespace' => 'Tests\\Feature\\Api',
    'name' => 'Tests\\Feature\\Api\\BasketApiTest',
    'shortName' => 'BasketApiTest',
    'isInterface' => false,
    'isTrait' => false,
    'isEnum' => false,
    'isBackedEnum' => false,
    'modifiers' => 0,
    'docComment' => NULL,
    'attributes' => 
    array (
    ),
    'startLine' => 14,
    'endLine' => 126,
    'startColumn' => 1,
    'endColumn' => 1,
    'parentClassName' => 'Tests\\TestCase',
    'implementsClassNames' => 
    array (
    ),
    'traitClassNames' => 
    array (
      0 => 'Illuminate\\Foundation\\Testing\\RefreshDatabase',
    ),
    'immediateConstants' => 
    array (
    ),
    'immediateProperties' => 
    array (
    ),
    'immediateMethods' => 
    array (
      'test_add_item_endpoint_creates_basket_and_returns_payload' => 
      array (
        'name' => 'test_add_item_endpoint_creates_basket_and_returns_payload',
        'parameters' => 
        array (
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => NULL,
        'startLine' => 18,
        'endLine' => 35,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Tests\\Feature\\Api',
        'declaringClassName' => 'Tests\\Feature\\Api\\BasketApiTest',
        'implementingClassName' => 'Tests\\Feature\\Api\\BasketApiTest',
        'currentClassName' => 'Tests\\Feature\\Api\\BasketApiTest',
        'aliasName' => NULL,
      ),
      'test_show_update_and_remove_basket_item' => 
      array (
        'name' => 'test_show_update_and_remove_basket_item',
        'parameters' => 
        array (
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => NULL,
        'startLine' => 37,
        'endLine' => 71,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Tests\\Feature\\Api',
        'declaringClassName' => 'Tests\\Feature\\Api\\BasketApiTest',
        'implementingClassName' => 'Tests\\Feature\\Api\\BasketApiTest',
        'currentClassName' => 'Tests\\Feature\\Api\\BasketApiTest',
        'aliasName' => NULL,
      ),
      'test_checkout_endpoint_creates_order_and_clears_basket' => 
      array (
        'name' => 'test_checkout_endpoint_creates_order_and_clears_basket',
        'parameters' => 
        array (
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => NULL,
        'startLine' => 73,
        'endLine' => 104,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Tests\\Feature\\Api',
        'declaringClassName' => 'Tests\\Feature\\Api\\BasketApiTest',
        'implementingClassName' => 'Tests\\Feature\\Api\\BasketApiTest',
        'currentClassName' => 'Tests\\Feature\\Api\\BasketApiTest',
        'aliasName' => NULL,
      ),
      'createProduct' => 
      array (
        'name' => 'createProduct',
        'parameters' => 
        array (
          'slug' => 
          array (
            'name' => 'slug',
            'default' => NULL,
            'type' => 
            array (
              'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
              'data' => 
              array (
                'name' => 'string',
                'isIdentifier' => true,
              ),
            ),
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 106,
            'endLine' => 106,
            'startColumn' => 36,
            'endColumn' => 47,
            'parameterIndex' => 0,
            'isOptional' => false,
          ),
          'price' => 
          array (
            'name' => 'price',
            'default' => 
            array (
              'code' => '1200',
              'attributes' => 
              array (
                'startLine' => 106,
                'endLine' => 106,
                'startTokenPos' => 692,
                'startFilePos' => 3577,
                'endTokenPos' => 692,
                'endFilePos' => 3580,
              ),
            ),
            'type' => 
            array (
              'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
              'data' => 
              array (
                'name' => 'int',
                'isIdentifier' => true,
              ),
            ),
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 106,
            'endLine' => 106,
            'startColumn' => 50,
            'endColumn' => 66,
            'parameterIndex' => 1,
            'isOptional' => true,
          ),
        ),
        'returnsReference' => false,
        'returnType' => 
        array (
          'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
          'data' => 
          array (
            'name' => 'App\\Models\\Product',
            'isIdentifier' => false,
          ),
        ),
        'attributes' => 
        array (
        ),
        'docComment' => NULL,
        'startLine' => 106,
        'endLine' => 125,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 4,
        'namespace' => 'Tests\\Feature\\Api',
        'declaringClassName' => 'Tests\\Feature\\Api\\BasketApiTest',
        'implementingClassName' => 'Tests\\Feature\\Api\\BasketApiTest',
        'currentClassName' => 'Tests\\Feature\\Api\\BasketApiTest',
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