<?php declare(strict_types = 1);

// osfsl-/var/www/html/app/Models/Profile.php-PHPStan\BetterReflection\Reflection\ReflectionClass-App\Models\Profile
return \PHPStan\Cache\CacheItem::__set_state(array(
   'variableKey' => 'v2-22608a7cf813ab9879a40313302476c158b4915c4890e3e73d87935e35631cab-8.4.18-6.65.0.9',
   'data' => 
  array (
    'locatedSource' => 
    array (
      'class' => 'PHPStan\\BetterReflection\\SourceLocator\\Located\\LocatedSource',
      'data' => 
      array (
        'name' => 'App\\Models\\Profile',
        'filename' => '/var/www/html/app/Models/Profile.php',
      ),
    ),
    'namespace' => 'App\\Models',
    'name' => 'App\\Models\\Profile',
    'shortName' => 'Profile',
    'isInterface' => false,
    'isTrait' => false,
    'isEnum' => false,
    'isBackedEnum' => false,
    'modifiers' => 0,
    'docComment' => '/**
 * @property int $id
 * @property int $user_id
 * @property string|null $title
 * @property string $name
 * @property string $email
 * @property string $phone
 * @property string $address
 * @property string|null $comment
 * @property-read \\App\\Models\\User $user
 */',
    'attributes' => 
    array (
    ),
    'startLine' => 18,
    'endLine' => 38,
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
      'fillable' => 
      array (
        'declaringClassName' => 'App\\Models\\Profile',
        'implementingClassName' => 'App\\Models\\Profile',
        'name' => 'fillable',
        'modifiers' => 2,
        'type' => NULL,
        'default' => 
        array (
          'code' => '[\'title\', \'name\', \'email\', \'phone\', \'address\', \'comment\']',
          'attributes' => 
          array (
            'startLine' => 20,
            'endLine' => 27,
            'startTokenPos' => 30,
            'startFilePos' => 398,
            'endTokenPos' => 50,
            'endFilePos' => 509,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 20,
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
 * Связь «профиль принадлежит» таблицы `profiles` с таблицей `users`
 *
 * @return \\Illuminate\\Database\\Eloquent\\Relations\\BelongsTo
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
        'namespace' => 'App\\Models',
        'declaringClassName' => 'App\\Models\\Profile',
        'implementingClassName' => 'App\\Models\\Profile',
        'currentClassName' => 'App\\Models\\Profile',
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