<?php declare(strict_types = 1);

// osfsl-/var/www/html/vendor/composer/../laravel/framework/src/Illuminate/Testing/TestResponse.php-PHPStan\BetterReflection\Reflection\ReflectionClass-Illuminate\Testing\TestResponse
return \PHPStan\Cache\CacheItem::__set_state(array(
   'variableKey' => 'v2-713657a846269312d527eeae872668dc0c5b3b347a07f72744035371188e39ea-8.4.18-6.65.0.9',
   'data' => 
  array (
    'locatedSource' => 
    array (
      'class' => 'PHPStan\\BetterReflection\\SourceLocator\\Located\\LocatedSource',
      'data' => 
      array (
        'name' => 'Illuminate\\Testing\\TestResponse',
        'filename' => '/var/www/html/vendor/composer/../laravel/framework/src/Illuminate/Testing/TestResponse.php',
      ),
    ),
    'namespace' => 'Illuminate\\Testing',
    'name' => 'Illuminate\\Testing\\TestResponse',
    'shortName' => 'TestResponse',
    'isInterface' => false,
    'isTrait' => false,
    'isEnum' => false,
    'isBackedEnum' => false,
    'modifiers' => 0,
    'docComment' => '/**
 * @template TResponse of \\Symfony\\Component\\HttpFoundation\\Response
 *
 * @mixin \\Illuminate\\Http\\Response
 */',
    'attributes' => 
    array (
    ),
    'startLine' => 35,
    'endLine' => 2018,
    'startColumn' => 1,
    'endColumn' => 1,
    'parentClassName' => NULL,
    'implementsClassNames' => 
    array (
      0 => 'ArrayAccess',
    ),
    'traitClassNames' => 
    array (
      0 => 'Illuminate\\Testing\\Concerns\\AssertsStatusCodes',
      1 => 'Illuminate\\Support\\Traits\\Conditionable',
      2 => 'Illuminate\\Support\\Traits\\Dumpable',
      3 => 'Illuminate\\Support\\Traits\\Tappable',
      4 => 'Illuminate\\Support\\Traits\\Macroable',
    ),
    'immediateConstants' => 
    array (
    ),
    'immediateProperties' => 
    array (
      'baseRequest' => 
      array (
        'declaringClassName' => 'Illuminate\\Testing\\TestResponse',
        'implementingClassName' => 'Illuminate\\Testing\\TestResponse',
        'name' => 'baseRequest',
        'modifiers' => 1,
        'type' => NULL,
        'default' => NULL,
        'docComment' => '/**
 * The original request.
 *
 * @var \\Illuminate\\Http\\Request|null
 */',
        'attributes' => 
        array (
        ),
        'startLine' => 46,
        'endLine' => 46,
        'startColumn' => 5,
        'endColumn' => 24,
        'isPromoted' => false,
        'declaredAtCompileTime' => true,
        'immediateVirtual' => false,
        'immediateHooks' => 
        array (
        ),
      ),
      'baseResponse' => 
      array (
        'declaringClassName' => 'Illuminate\\Testing\\TestResponse',
        'implementingClassName' => 'Illuminate\\Testing\\TestResponse',
        'name' => 'baseResponse',
        'modifiers' => 1,
        'type' => NULL,
        'default' => NULL,
        'docComment' => '/**
 * The response to delegate to.
 *
 * @var TResponse
 */',
        'attributes' => 
        array (
        ),
        'startLine' => 53,
        'endLine' => 53,
        'startColumn' => 5,
        'endColumn' => 25,
        'isPromoted' => false,
        'declaredAtCompileTime' => true,
        'immediateVirtual' => false,
        'immediateHooks' => 
        array (
        ),
      ),
      'exceptions' => 
      array (
        'declaringClassName' => 'Illuminate\\Testing\\TestResponse',
        'implementingClassName' => 'Illuminate\\Testing\\TestResponse',
        'name' => 'exceptions',
        'modifiers' => 1,
        'type' => NULL,
        'default' => NULL,
        'docComment' => '/**
 * The collection of logged exceptions for the request.
 *
 * @var \\Illuminate\\Support\\Collection
 */',
        'attributes' => 
        array (
        ),
        'startLine' => 60,
        'endLine' => 60,
        'startColumn' => 5,
        'endColumn' => 23,
        'isPromoted' => false,
        'declaredAtCompileTime' => true,
        'immediateVirtual' => false,
        'immediateHooks' => 
        array (
        ),
      ),
      'streamedContent' => 
      array (
        'declaringClassName' => 'Illuminate\\Testing\\TestResponse',
        'implementingClassName' => 'Illuminate\\Testing\\TestResponse',
        'name' => 'streamedContent',
        'modifiers' => 2,
        'type' => NULL,
        'default' => NULL,
        'docComment' => '/**
 * The streamed content of the response.
 *
 * @var string
 */',
        'attributes' => 
        array (
        ),
        'startLine' => 67,
        'endLine' => 67,
        'startColumn' => 5,
        'endColumn' => 31,
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
      '__construct' => 
      array (
        'name' => '__construct',
        'parameters' => 
        array (
          'response' => 
          array (
            'name' => 'response',
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
            'endColumn' => 41,
            'parameterIndex' => 0,
            'isOptional' => false,
          ),
          'request' => 
          array (
            'name' => 'request',
            'default' => 
            array (
              'code' => 'null',
              'attributes' => 
              array (
                'startLine' => 75,
                'endLine' => 75,
                'startTokenPos' => 217,
                'startFilePos' => 1969,
                'endTokenPos' => 217,
                'endFilePos' => 1972,
              ),
            ),
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 75,
            'endLine' => 75,
            'startColumn' => 44,
            'endColumn' => 58,
            'parameterIndex' => 1,
            'isOptional' => true,
          ),
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Create a new test response instance.
 *
 * @param  TResponse  $response
 * @param  \\Illuminate\\Http\\Request|null  $request
 */',
        'startLine' => 75,
        'endLine' => 80,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Illuminate\\Testing',
        'declaringClassName' => 'Illuminate\\Testing\\TestResponse',
        'implementingClassName' => 'Illuminate\\Testing\\TestResponse',
        'currentClassName' => 'Illuminate\\Testing\\TestResponse',
        'aliasName' => NULL,
      ),
      'fromBaseResponse' => 
      array (
        'name' => 'fromBaseResponse',
        'parameters' => 
        array (
          'response' => 
          array (
            'name' => 'response',
            'default' => NULL,
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 91,
            'endLine' => 91,
            'startColumn' => 45,
            'endColumn' => 53,
            'parameterIndex' => 0,
            'isOptional' => false,
          ),
          'request' => 
          array (
            'name' => 'request',
            'default' => 
            array (
              'code' => 'null',
              'attributes' => 
              array (
                'startLine' => 91,
                'endLine' => 91,
                'startTokenPos' => 270,
                'startFilePos' => 2404,
                'endTokenPos' => 270,
                'endFilePos' => 2407,
              ),
            ),
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 91,
            'endLine' => 91,
            'startColumn' => 56,
            'endColumn' => 70,
            'parameterIndex' => 1,
            'isOptional' => true,
          ),
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Create a new TestResponse from another response.
 *
 * @template R of TResponse
 *
 * @param  R  $response
 * @param  \\Illuminate\\Http\\Request|null  $request
 * @return static<R>
 */',
        'startLine' => 91,
        'endLine' => 94,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 17,
        'namespace' => 'Illuminate\\Testing',
        'declaringClassName' => 'Illuminate\\Testing\\TestResponse',
        'implementingClassName' => 'Illuminate\\Testing\\TestResponse',
        'currentClassName' => 'Illuminate\\Testing\\TestResponse',
        'aliasName' => NULL,
      ),
      'assertSuccessful' => 
      array (
        'name' => 'assertSuccessful',
        'parameters' => 
        array (
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Assert that the response has a successful status code.
 *
 * @return $this
 */',
        'startLine' => 101,
        'endLine' => 109,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Illuminate\\Testing',
        'declaringClassName' => 'Illuminate\\Testing\\TestResponse',
        'implementingClassName' => 'Illuminate\\Testing\\TestResponse',
        'currentClassName' => 'Illuminate\\Testing\\TestResponse',
        'aliasName' => NULL,
      ),
      'assertSuccessfulPrecognition' => 
      array (
        'name' => 'assertSuccessfulPrecognition',
        'parameters' => 
        array (
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Assert that the Precognition request was successful.
 *
 * @return $this
 */',
        'startLine' => 116,
        'endLine' => 132,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Illuminate\\Testing',
        'declaringClassName' => 'Illuminate\\Testing\\TestResponse',
        'implementingClassName' => 'Illuminate\\Testing\\TestResponse',
        'currentClassName' => 'Illuminate\\Testing\\TestResponse',
        'aliasName' => NULL,
      ),
      'assertClientError' => 
      array (
        'name' => 'assertClientError',
        'parameters' => 
        array (
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Assert that the response is a client error.
 *
 * @return $this
 */',
        'startLine' => 139,
        'endLine' => 147,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Illuminate\\Testing',
        'declaringClassName' => 'Illuminate\\Testing\\TestResponse',
        'implementingClassName' => 'Illuminate\\Testing\\TestResponse',
        'currentClassName' => 'Illuminate\\Testing\\TestResponse',
        'aliasName' => NULL,
      ),
      'assertServerError' => 
      array (
        'name' => 'assertServerError',
        'parameters' => 
        array (
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Assert that the response is a server error.
 *
 * @return $this
 */',
        'startLine' => 154,
        'endLine' => 162,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Illuminate\\Testing',
        'declaringClassName' => 'Illuminate\\Testing\\TestResponse',
        'implementingClassName' => 'Illuminate\\Testing\\TestResponse',
        'currentClassName' => 'Illuminate\\Testing\\TestResponse',
        'aliasName' => NULL,
      ),
      'assertStatus' => 
      array (
        'name' => 'assertStatus',
        'parameters' => 
        array (
          'status' => 
          array (
            'name' => 'status',
            'default' => NULL,
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 170,
            'endLine' => 170,
            'startColumn' => 34,
            'endColumn' => 40,
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
 * Assert that the response has the given status code.
 *
 * @param  int  $status
 * @return $this
 */',
        'startLine' => 170,
        'endLine' => 177,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Illuminate\\Testing',
        'declaringClassName' => 'Illuminate\\Testing\\TestResponse',
        'implementingClassName' => 'Illuminate\\Testing\\TestResponse',
        'currentClassName' => 'Illuminate\\Testing\\TestResponse',
        'aliasName' => NULL,
      ),
      'statusMessageWithDetails' => 
      array (
        'name' => 'statusMessageWithDetails',
        'parameters' => 
        array (
          'expected' => 
          array (
            'name' => 'expected',
            'default' => NULL,
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 186,
            'endLine' => 186,
            'startColumn' => 49,
            'endColumn' => 57,
            'parameterIndex' => 0,
            'isOptional' => false,
          ),
          'actual' => 
          array (
            'name' => 'actual',
            'default' => NULL,
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 186,
            'endLine' => 186,
            'startColumn' => 60,
            'endColumn' => 66,
            'parameterIndex' => 1,
            'isOptional' => false,
          ),
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Get an assertion message for a status assertion containing extra details when available.
 *
 * @param  string|int  $expected
 * @param  string|int  $actual
 * @return string
 */',
        'startLine' => 186,
        'endLine' => 189,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 2,
        'namespace' => 'Illuminate\\Testing',
        'declaringClassName' => 'Illuminate\\Testing\\TestResponse',
        'implementingClassName' => 'Illuminate\\Testing\\TestResponse',
        'currentClassName' => 'Illuminate\\Testing\\TestResponse',
        'aliasName' => NULL,
      ),
      'assertRedirect' => 
      array (
        'name' => 'assertRedirect',
        'parameters' => 
        array (
          'uri' => 
          array (
            'name' => 'uri',
            'default' => 
            array (
              'code' => 'null',
              'attributes' => 
              array (
                'startLine' => 197,
                'endLine' => 197,
                'startTokenPos' => 635,
                'startFilePos' => 5121,
                'endTokenPos' => 635,
                'endFilePos' => 5124,
              ),
            ),
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 197,
            'endLine' => 197,
            'startColumn' => 36,
            'endColumn' => 46,
            'parameterIndex' => 0,
            'isOptional' => true,
          ),
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Assert whether the response is redirecting to a given URI.
 *
 * @param  string|null  $uri
 * @return $this
 */',
        'startLine' => 197,
        'endLine' => 209,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Illuminate\\Testing',
        'declaringClassName' => 'Illuminate\\Testing\\TestResponse',
        'implementingClassName' => 'Illuminate\\Testing\\TestResponse',
        'currentClassName' => 'Illuminate\\Testing\\TestResponse',
        'aliasName' => NULL,
      ),
      'assertRedirectContains' => 
      array (
        'name' => 'assertRedirectContains',
        'parameters' => 
        array (
          'uri' => 
          array (
            'name' => 'uri',
            'default' => NULL,
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 217,
            'endLine' => 217,
            'startColumn' => 44,
            'endColumn' => 47,
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
 * Assert whether the response is redirecting to a URI that contains the given URI.
 *
 * @param  string  $uri
 * @return $this
 */',
        'startLine' => 217,
        'endLine' => 229,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Illuminate\\Testing',
        'declaringClassName' => 'Illuminate\\Testing\\TestResponse',
        'implementingClassName' => 'Illuminate\\Testing\\TestResponse',
        'currentClassName' => 'Illuminate\\Testing\\TestResponse',
        'aliasName' => NULL,
      ),
      'assertRedirectBack' => 
      array (
        'name' => 'assertRedirectBack',
        'parameters' => 
        array (
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Assert whether the response is redirecting back to the previous location.
 *
 * @return $this
 */',
        'startLine' => 236,
        'endLine' => 246,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Illuminate\\Testing',
        'declaringClassName' => 'Illuminate\\Testing\\TestResponse',
        'implementingClassName' => 'Illuminate\\Testing\\TestResponse',
        'currentClassName' => 'Illuminate\\Testing\\TestResponse',
        'aliasName' => NULL,
      ),
      'assertRedirectBackWithErrors' => 
      array (
        'name' => 'assertRedirectBackWithErrors',
        'parameters' => 
        array (
          'keys' => 
          array (
            'name' => 'keys',
            'default' => 
            array (
              'code' => '[]',
              'attributes' => 
              array (
                'startLine' => 256,
                'endLine' => 256,
                'startTokenPos' => 889,
                'startFilePos' => 6866,
                'endTokenPos' => 890,
                'endFilePos' => 6867,
              ),
            ),
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 256,
            'endLine' => 256,
            'startColumn' => 50,
            'endColumn' => 59,
            'parameterIndex' => 0,
            'isOptional' => true,
          ),
          'format' => 
          array (
            'name' => 'format',
            'default' => 
            array (
              'code' => 'null',
              'attributes' => 
              array (
                'startLine' => 256,
                'endLine' => 256,
                'startTokenPos' => 897,
                'startFilePos' => 6880,
                'endTokenPos' => 897,
                'endFilePos' => 6883,
              ),
            ),
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 256,
            'endLine' => 256,
            'startColumn' => 62,
            'endColumn' => 75,
            'parameterIndex' => 1,
            'isOptional' => true,
          ),
          'errorBag' => 
          array (
            'name' => 'errorBag',
            'default' => 
            array (
              'code' => '\'default\'',
              'attributes' => 
              array (
                'startLine' => 256,
                'endLine' => 256,
                'startTokenPos' => 904,
                'startFilePos' => 6898,
                'endTokenPos' => 904,
                'endFilePos' => 6906,
              ),
            ),
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 256,
            'endLine' => 256,
            'startColumn' => 78,
            'endColumn' => 98,
            'parameterIndex' => 2,
            'isOptional' => true,
          ),
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Assert whether the response is redirecting back to the previous location with the given errors in the session.
 *
 * @param  string|array  $keys
 * @param  mixed  $format
 * @param  string  $errorBag
 * @return $this
 */',
        'startLine' => 256,
        'endLine' => 263,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Illuminate\\Testing',
        'declaringClassName' => 'Illuminate\\Testing\\TestResponse',
        'implementingClassName' => 'Illuminate\\Testing\\TestResponse',
        'currentClassName' => 'Illuminate\\Testing\\TestResponse',
        'aliasName' => NULL,
      ),
      'assertRedirectBackWithoutErrors' => 
      array (
        'name' => 'assertRedirectBackWithoutErrors',
        'parameters' => 
        array (
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Assert whether the response is redirecting back to the previous location with no errors in the session.
 *
 * @return $this
 */',
        'startLine' => 270,
        'endLine' => 277,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Illuminate\\Testing',
        'declaringClassName' => 'Illuminate\\Testing\\TestResponse',
        'implementingClassName' => 'Illuminate\\Testing\\TestResponse',
        'currentClassName' => 'Illuminate\\Testing\\TestResponse',
        'aliasName' => NULL,
      ),
      'assertRedirectToRoute' => 
      array (
        'name' => 'assertRedirectToRoute',
        'parameters' => 
        array (
          'name' => 
          array (
            'name' => 'name',
            'default' => NULL,
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 286,
            'endLine' => 286,
            'startColumn' => 43,
            'endColumn' => 47,
            'parameterIndex' => 0,
            'isOptional' => false,
          ),
          'parameters' => 
          array (
            'name' => 'parameters',
            'default' => 
            array (
              'code' => '[]',
              'attributes' => 
              array (
                'startLine' => 286,
                'endLine' => 286,
                'startTokenPos' => 985,
                'startFilePos' => 7625,
                'endTokenPos' => 986,
                'endFilePos' => 7626,
              ),
            ),
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 286,
            'endLine' => 286,
            'startColumn' => 50,
            'endColumn' => 65,
            'parameterIndex' => 1,
            'isOptional' => true,
          ),
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Assert whether the response is redirecting to a given route.
 *
 * @param  \\BackedEnum|string  $name
 * @param  mixed  $parameters
 * @return $this
 */',
        'startLine' => 286,
        'endLine' => 298,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Illuminate\\Testing',
        'declaringClassName' => 'Illuminate\\Testing\\TestResponse',
        'implementingClassName' => 'Illuminate\\Testing\\TestResponse',
        'currentClassName' => 'Illuminate\\Testing\\TestResponse',
        'aliasName' => NULL,
      ),
      'assertRedirectToSignedRoute' => 
      array (
        'name' => 'assertRedirectToSignedRoute',
        'parameters' => 
        array (
          'name' => 
          array (
            'name' => 'name',
            'default' => 
            array (
              'code' => 'null',
              'attributes' => 
              array (
                'startLine' => 308,
                'endLine' => 308,
                'startTokenPos' => 1066,
                'startFilePos' => 8227,
                'endTokenPos' => 1066,
                'endFilePos' => 8230,
              ),
            ),
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 308,
            'endLine' => 308,
            'startColumn' => 49,
            'endColumn' => 60,
            'parameterIndex' => 0,
            'isOptional' => true,
          ),
          'parameters' => 
          array (
            'name' => 'parameters',
            'default' => 
            array (
              'code' => '[]',
              'attributes' => 
              array (
                'startLine' => 308,
                'endLine' => 308,
                'startTokenPos' => 1073,
                'startFilePos' => 8247,
                'endTokenPos' => 1074,
                'endFilePos' => 8248,
              ),
            ),
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 308,
            'endLine' => 308,
            'startColumn' => 63,
            'endColumn' => 78,
            'parameterIndex' => 1,
            'isOptional' => true,
          ),
          'absolute' => 
          array (
            'name' => 'absolute',
            'default' => 
            array (
              'code' => 'true',
              'attributes' => 
              array (
                'startLine' => 308,
                'endLine' => 308,
                'startTokenPos' => 1081,
                'startFilePos' => 8263,
                'endTokenPos' => 1081,
                'endFilePos' => 8266,
              ),
            ),
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 308,
            'endLine' => 308,
            'startColumn' => 81,
            'endColumn' => 96,
            'parameterIndex' => 2,
            'isOptional' => true,
          ),
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Assert whether the response is redirecting to a given signed route.
 *
 * @param  \\BackedEnum|string|null  $name
 * @param  mixed  $parameters
 * @param  bool  $absolute
 * @return $this
 */',
        'startLine' => 308,
        'endLine' => 337,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Illuminate\\Testing',
        'declaringClassName' => 'Illuminate\\Testing\\TestResponse',
        'implementingClassName' => 'Illuminate\\Testing\\TestResponse',
        'currentClassName' => 'Illuminate\\Testing\\TestResponse',
        'aliasName' => NULL,
      ),
      'assertRedirectToAction' => 
      array (
        'name' => 'assertRedirectToAction',
        'parameters' => 
        array (
          'name' => 
          array (
            'name' => 'name',
            'default' => NULL,
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 346,
            'endLine' => 346,
            'startColumn' => 44,
            'endColumn' => 48,
            'parameterIndex' => 0,
            'isOptional' => false,
          ),
          'parameters' => 
          array (
            'name' => 'parameters',
            'default' => 
            array (
              'code' => '[]',
              'attributes' => 
              array (
                'startLine' => 346,
                'endLine' => 346,
                'startTokenPos' => 1288,
                'startFilePos' => 9404,
                'endTokenPos' => 1289,
                'endFilePos' => 9405,
              ),
            ),
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 346,
            'endLine' => 346,
            'startColumn' => 51,
            'endColumn' => 66,
            'parameterIndex' => 1,
            'isOptional' => true,
          ),
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Assert whether the response is redirecting to a given controller action.
 *
 * @param  string|array  $name
 * @param  array  $parameters
 * @return $this
 */',
        'startLine' => 346,
        'endLine' => 358,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Illuminate\\Testing',
        'declaringClassName' => 'Illuminate\\Testing\\TestResponse',
        'implementingClassName' => 'Illuminate\\Testing\\TestResponse',
        'currentClassName' => 'Illuminate\\Testing\\TestResponse',
        'aliasName' => NULL,
      ),
      'assertHeader' => 
      array (
        'name' => 'assertHeader',
        'parameters' => 
        array (
          'headerName' => 
          array (
            'name' => 'headerName',
            'default' => NULL,
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 367,
            'endLine' => 367,
            'startColumn' => 34,
            'endColumn' => 44,
            'parameterIndex' => 0,
            'isOptional' => false,
          ),
          'value' => 
          array (
            'name' => 'value',
            'default' => 
            array (
              'code' => 'null',
              'attributes' => 
              array (
                'startLine' => 367,
                'endLine' => 367,
                'startTokenPos' => 1372,
                'startFilePos' => 9974,
                'endTokenPos' => 1372,
                'endFilePos' => 9977,
              ),
            ),
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 367,
            'endLine' => 367,
            'startColumn' => 47,
            'endColumn' => 59,
            'parameterIndex' => 1,
            'isOptional' => true,
          ),
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Asserts that the response contains the given header and equals the optional value.
 *
 * @param  string  $headerName
 * @param  mixed  $value
 * @return $this
 */',
        'startLine' => 367,
        'endLine' => 383,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Illuminate\\Testing',
        'declaringClassName' => 'Illuminate\\Testing\\TestResponse',
        'implementingClassName' => 'Illuminate\\Testing\\TestResponse',
        'currentClassName' => 'Illuminate\\Testing\\TestResponse',
        'aliasName' => NULL,
      ),
      'assertHeaderContains' => 
      array (
        'name' => 'assertHeaderContains',
        'parameters' => 
        array (
          'headerName' => 
          array (
            'name' => 'headerName',
            'default' => NULL,
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 392,
            'endLine' => 392,
            'startColumn' => 42,
            'endColumn' => 52,
            'parameterIndex' => 0,
            'isOptional' => false,
          ),
          'value' => 
          array (
            'name' => 'value',
            'default' => NULL,
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 392,
            'endLine' => 392,
            'startColumn' => 55,
            'endColumn' => 60,
            'parameterIndex' => 1,
            'isOptional' => false,
          ),
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Asserts that the response contains the given header and that its value contains the given string.
 *
 * @param  string  $headerName
 * @param  string  $value
 * @return $this
 */',
        'startLine' => 392,
        'endLine' => 406,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Illuminate\\Testing',
        'declaringClassName' => 'Illuminate\\Testing\\TestResponse',
        'implementingClassName' => 'Illuminate\\Testing\\TestResponse',
        'currentClassName' => 'Illuminate\\Testing\\TestResponse',
        'aliasName' => NULL,
      ),
      'assertHeaderMissing' => 
      array (
        'name' => 'assertHeaderMissing',
        'parameters' => 
        array (
          'headerName' => 
          array (
            'name' => 'headerName',
            'default' => NULL,
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 414,
            'endLine' => 414,
            'startColumn' => 41,
            'endColumn' => 51,
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
 * Asserts that the response does not contain the given header.
 *
 * @param  string  $headerName
 * @return $this
 */',
        'startLine' => 414,
        'endLine' => 421,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Illuminate\\Testing',
        'declaringClassName' => 'Illuminate\\Testing\\TestResponse',
        'implementingClassName' => 'Illuminate\\Testing\\TestResponse',
        'currentClassName' => 'Illuminate\\Testing\\TestResponse',
        'aliasName' => NULL,
      ),
      'assertLocation' => 
      array (
        'name' => 'assertLocation',
        'parameters' => 
        array (
          'uri' => 
          array (
            'name' => 'uri',
            'default' => NULL,
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 429,
            'endLine' => 429,
            'startColumn' => 36,
            'endColumn' => 39,
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
 * Assert that the current location header matches the given URI.
 *
 * @param  string  $uri
 * @return $this
 */',
        'startLine' => 429,
        'endLine' => 436,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Illuminate\\Testing',
        'declaringClassName' => 'Illuminate\\Testing\\TestResponse',
        'implementingClassName' => 'Illuminate\\Testing\\TestResponse',
        'currentClassName' => 'Illuminate\\Testing\\TestResponse',
        'aliasName' => NULL,
      ),
      'assertDownload' => 
      array (
        'name' => 'assertDownload',
        'parameters' => 
        array (
          'filename' => 
          array (
            'name' => 'filename',
            'default' => 
            array (
              'code' => 'null',
              'attributes' => 
              array (
                'startLine' => 444,
                'endLine' => 444,
                'startTokenPos' => 1724,
                'startFilePos' => 12194,
                'endTokenPos' => 1724,
                'endFilePos' => 12197,
              ),
            ),
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 444,
            'endLine' => 444,
            'startColumn' => 36,
            'endColumn' => 51,
            'parameterIndex' => 0,
            'isOptional' => true,
          ),
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Assert that the response offers a file download.
 *
 * @param  string|null  $filename
 * @return $this
 */',
        'startLine' => 444,
        'endLine' => 484,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Illuminate\\Testing',
        'declaringClassName' => 'Illuminate\\Testing\\TestResponse',
        'implementingClassName' => 'Illuminate\\Testing\\TestResponse',
        'currentClassName' => 'Illuminate\\Testing\\TestResponse',
        'aliasName' => NULL,
      ),
      'assertPlainCookie' => 
      array (
        'name' => 'assertPlainCookie',
        'parameters' => 
        array (
          'cookieName' => 
          array (
            'name' => 'cookieName',
            'default' => NULL,
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 493,
            'endLine' => 493,
            'startColumn' => 39,
            'endColumn' => 49,
            'parameterIndex' => 0,
            'isOptional' => false,
          ),
          'value' => 
          array (
            'name' => 'value',
            'default' => 
            array (
              'code' => 'null',
              'attributes' => 
              array (
                'startLine' => 493,
                'endLine' => 493,
                'startTokenPos' => 2053,
                'startFilePos' => 14035,
                'endTokenPos' => 2053,
                'endFilePos' => 14038,
              ),
            ),
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 493,
            'endLine' => 493,
            'startColumn' => 52,
            'endColumn' => 64,
            'parameterIndex' => 1,
            'isOptional' => true,
          ),
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Asserts that the response contains the given cookie and equals the optional value.
 *
 * @param  string  $cookieName
 * @param  mixed  $value
 * @return $this
 */',
        'startLine' => 493,
        'endLine' => 498,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Illuminate\\Testing',
        'declaringClassName' => 'Illuminate\\Testing\\TestResponse',
        'implementingClassName' => 'Illuminate\\Testing\\TestResponse',
        'currentClassName' => 'Illuminate\\Testing\\TestResponse',
        'aliasName' => NULL,
      ),
      'assertCookie' => 
      array (
        'name' => 'assertCookie',
        'parameters' => 
        array (
          'cookieName' => 
          array (
            'name' => 'cookieName',
            'default' => NULL,
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 509,
            'endLine' => 509,
            'startColumn' => 34,
            'endColumn' => 44,
            'parameterIndex' => 0,
            'isOptional' => false,
          ),
          'value' => 
          array (
            'name' => 'value',
            'default' => 
            array (
              'code' => 'null',
              'attributes' => 
              array (
                'startLine' => 509,
                'endLine' => 509,
                'startTokenPos' => 2094,
                'startFilePos' => 14453,
                'endTokenPos' => 2094,
                'endFilePos' => 14456,
              ),
            ),
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 509,
            'endLine' => 509,
            'startColumn' => 47,
            'endColumn' => 59,
            'parameterIndex' => 1,
            'isOptional' => true,
          ),
          'encrypted' => 
          array (
            'name' => 'encrypted',
            'default' => 
            array (
              'code' => 'true',
              'attributes' => 
              array (
                'startLine' => 509,
                'endLine' => 509,
                'startTokenPos' => 2101,
                'startFilePos' => 14472,
                'endTokenPos' => 2101,
                'endFilePos' => 14475,
              ),
            ),
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 509,
            'endLine' => 509,
            'startColumn' => 62,
            'endColumn' => 78,
            'parameterIndex' => 2,
            'isOptional' => true,
          ),
          'unserialize' => 
          array (
            'name' => 'unserialize',
            'default' => 
            array (
              'code' => 'false',
              'attributes' => 
              array (
                'startLine' => 509,
                'endLine' => 509,
                'startTokenPos' => 2108,
                'startFilePos' => 14493,
                'endTokenPos' => 2108,
                'endFilePos' => 14497,
              ),
            ),
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 509,
            'endLine' => 509,
            'startColumn' => 81,
            'endColumn' => 100,
            'parameterIndex' => 3,
            'isOptional' => true,
          ),
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Asserts that the response contains the given cookie and equals the optional value.
 *
 * @param  string  $cookieName
 * @param  mixed  $value
 * @param  bool  $encrypted
 * @param  bool  $unserialize
 * @return $this
 */',
        'startLine' => 509,
        'endLine' => 528,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Illuminate\\Testing',
        'declaringClassName' => 'Illuminate\\Testing\\TestResponse',
        'implementingClassName' => 'Illuminate\\Testing\\TestResponse',
        'currentClassName' => 'Illuminate\\Testing\\TestResponse',
        'aliasName' => NULL,
      ),
      'assertCookieExpired' => 
      array (
        'name' => 'assertCookieExpired',
        'parameters' => 
        array (
          'cookieName' => 
          array (
            'name' => 'cookieName',
            'default' => NULL,
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 536,
            'endLine' => 536,
            'startColumn' => 41,
            'endColumn' => 51,
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
 * Asserts that the response contains the given cookie and is expired.
 *
 * @param  string  $cookieName
 * @return $this
 */',
        'startLine' => 536,
        'endLine' => 551,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Illuminate\\Testing',
        'declaringClassName' => 'Illuminate\\Testing\\TestResponse',
        'implementingClassName' => 'Illuminate\\Testing\\TestResponse',
        'currentClassName' => 'Illuminate\\Testing\\TestResponse',
        'aliasName' => NULL,
      ),
      'assertCookieNotExpired' => 
      array (
        'name' => 'assertCookieNotExpired',
        'parameters' => 
        array (
          'cookieName' => 
          array (
            'name' => 'cookieName',
            'default' => NULL,
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 559,
            'endLine' => 559,
            'startColumn' => 44,
            'endColumn' => 54,
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
 * Asserts that the response contains the given cookie and is not expired.
 *
 * @param  string  $cookieName
 * @return $this
 */',
        'startLine' => 559,
        'endLine' => 574,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Illuminate\\Testing',
        'declaringClassName' => 'Illuminate\\Testing\\TestResponse',
        'implementingClassName' => 'Illuminate\\Testing\\TestResponse',
        'currentClassName' => 'Illuminate\\Testing\\TestResponse',
        'aliasName' => NULL,
      ),
      'assertCookieMissing' => 
      array (
        'name' => 'assertCookieMissing',
        'parameters' => 
        array (
          'cookieName' => 
          array (
            'name' => 'cookieName',
            'default' => NULL,
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 582,
            'endLine' => 582,
            'startColumn' => 41,
            'endColumn' => 51,
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
 * Asserts that the response does not contain the given cookie.
 *
 * @param  string  $cookieName
 * @return $this
 */',
        'startLine' => 582,
        'endLine' => 590,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Illuminate\\Testing',
        'declaringClassName' => 'Illuminate\\Testing\\TestResponse',
        'implementingClassName' => 'Illuminate\\Testing\\TestResponse',
        'currentClassName' => 'Illuminate\\Testing\\TestResponse',
        'aliasName' => NULL,
      ),
      'getCookie' => 
      array (
        'name' => 'getCookie',
        'parameters' => 
        array (
          'cookieName' => 
          array (
            'name' => 'cookieName',
            'default' => NULL,
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 600,
            'endLine' => 600,
            'startColumn' => 31,
            'endColumn' => 41,
            'parameterIndex' => 0,
            'isOptional' => false,
          ),
          'decrypt' => 
          array (
            'name' => 'decrypt',
            'default' => 
            array (
              'code' => 'true',
              'attributes' => 
              array (
                'startLine' => 600,
                'endLine' => 600,
                'startTokenPos' => 2557,
                'startFilePos' => 17316,
                'endTokenPos' => 2557,
                'endFilePos' => 17319,
              ),
            ),
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 600,
            'endLine' => 600,
            'startColumn' => 44,
            'endColumn' => 58,
            'parameterIndex' => 1,
            'isOptional' => true,
          ),
          'unserialize' => 
          array (
            'name' => 'unserialize',
            'default' => 
            array (
              'code' => 'false',
              'attributes' => 
              array (
                'startLine' => 600,
                'endLine' => 600,
                'startTokenPos' => 2564,
                'startFilePos' => 17337,
                'endTokenPos' => 2564,
                'endFilePos' => 17341,
              ),
            ),
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 600,
            'endLine' => 600,
            'startColumn' => 61,
            'endColumn' => 80,
            'parameterIndex' => 2,
            'isOptional' => true,
          ),
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Get the given cookie from the response.
 *
 * @param  string  $cookieName
 * @param  bool  $decrypt
 * @param  bool  $unserialize
 * @return \\Symfony\\Component\\HttpFoundation\\Cookie|null
 */',
        'startLine' => 600,
        'endLine' => 626,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Illuminate\\Testing',
        'declaringClassName' => 'Illuminate\\Testing\\TestResponse',
        'implementingClassName' => 'Illuminate\\Testing\\TestResponse',
        'currentClassName' => 'Illuminate\\Testing\\TestResponse',
        'aliasName' => NULL,
      ),
      'assertContent' => 
      array (
        'name' => 'assertContent',
        'parameters' => 
        array (
          'value' => 
          array (
            'name' => 'value',
            'default' => NULL,
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 634,
            'endLine' => 634,
            'startColumn' => 35,
            'endColumn' => 40,
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
 * Assert that the given string matches the response content.
 *
 * @param  string  $value
 * @return $this
 */',
        'startLine' => 634,
        'endLine' => 639,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Illuminate\\Testing',
        'declaringClassName' => 'Illuminate\\Testing\\TestResponse',
        'implementingClassName' => 'Illuminate\\Testing\\TestResponse',
        'currentClassName' => 'Illuminate\\Testing\\TestResponse',
        'aliasName' => NULL,
      ),
      'assertStreamed' => 
      array (
        'name' => 'assertStreamed',
        'parameters' => 
        array (
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Assert that the response was streamed.
 *
 * @return $this
 */',
        'startLine' => 646,
        'endLine' => 654,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Illuminate\\Testing',
        'declaringClassName' => 'Illuminate\\Testing\\TestResponse',
        'implementingClassName' => 'Illuminate\\Testing\\TestResponse',
        'currentClassName' => 'Illuminate\\Testing\\TestResponse',
        'aliasName' => NULL,
      ),
      'assertNotStreamed' => 
      array (
        'name' => 'assertNotStreamed',
        'parameters' => 
        array (
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Assert that the response was not streamed.
 *
 * @return $this
 */',
        'startLine' => 661,
        'endLine' => 669,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Illuminate\\Testing',
        'declaringClassName' => 'Illuminate\\Testing\\TestResponse',
        'implementingClassName' => 'Illuminate\\Testing\\TestResponse',
        'currentClassName' => 'Illuminate\\Testing\\TestResponse',
        'aliasName' => NULL,
      ),
      'assertStreamedContent' => 
      array (
        'name' => 'assertStreamedContent',
        'parameters' => 
        array (
          'value' => 
          array (
            'name' => 'value',
            'default' => NULL,
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 677,
            'endLine' => 677,
            'startColumn' => 43,
            'endColumn' => 48,
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
 * Assert that the given string matches the streamed response content.
 *
 * @param  string  $value
 * @return $this
 */',
        'startLine' => 677,
        'endLine' => 682,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Illuminate\\Testing',
        'declaringClassName' => 'Illuminate\\Testing\\TestResponse',
        'implementingClassName' => 'Illuminate\\Testing\\TestResponse',
        'currentClassName' => 'Illuminate\\Testing\\TestResponse',
        'aliasName' => NULL,
      ),
      'assertStreamedJsonContent' => 
      array (
        'name' => 'assertStreamedJsonContent',
        'parameters' => 
        array (
          'value' => 
          array (
            'name' => 'value',
            'default' => NULL,
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 690,
            'endLine' => 690,
            'startColumn' => 47,
            'endColumn' => 52,
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
 * Assert that the given array matches the streamed JSON response content.
 *
 * @param  array  $value
 * @return $this
 */',
        'startLine' => 690,
        'endLine' => 693,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Illuminate\\Testing',
        'declaringClassName' => 'Illuminate\\Testing\\TestResponse',
        'implementingClassName' => 'Illuminate\\Testing\\TestResponse',
        'currentClassName' => 'Illuminate\\Testing\\TestResponse',
        'aliasName' => NULL,
      ),
      'assertSee' => 
      array (
        'name' => 'assertSee',
        'parameters' => 
        array (
          'value' => 
          array (
            'name' => 'value',
            'default' => NULL,
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 702,
            'endLine' => 702,
            'startColumn' => 31,
            'endColumn' => 36,
            'parameterIndex' => 0,
            'isOptional' => false,
          ),
          'escape' => 
          array (
            'name' => 'escape',
            'default' => 
            array (
              'code' => 'true',
              'attributes' => 
              array (
                'startLine' => 702,
                'endLine' => 702,
                'startTokenPos' => 2966,
                'startFilePos' => 20196,
                'endTokenPos' => 2966,
                'endFilePos' => 20199,
              ),
            ),
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 702,
            'endLine' => 702,
            'startColumn' => 39,
            'endColumn' => 52,
            'parameterIndex' => 1,
            'isOptional' => true,
          ),
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Assert that the given string or array of strings are contained within the response.
 *
 * @param  string|array  $value
 * @param  bool  $escape
 * @return $this
 */',
        'startLine' => 702,
        'endLine' => 713,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Illuminate\\Testing',
        'declaringClassName' => 'Illuminate\\Testing\\TestResponse',
        'implementingClassName' => 'Illuminate\\Testing\\TestResponse',
        'currentClassName' => 'Illuminate\\Testing\\TestResponse',
        'aliasName' => NULL,
      ),
      'assertSeeHtml' => 
      array (
        'name' => 'assertSeeHtml',
        'parameters' => 
        array (
          'value' => 
          array (
            'name' => 'value',
            'default' => NULL,
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 721,
            'endLine' => 721,
            'startColumn' => 35,
            'endColumn' => 40,
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
 * Assert that the given HTML string or array of HTML strings are contained within the response.
 *
 * @param  array|string  $value
 * @return $this
 */',
        'startLine' => 721,
        'endLine' => 724,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Illuminate\\Testing',
        'declaringClassName' => 'Illuminate\\Testing\\TestResponse',
        'implementingClassName' => 'Illuminate\\Testing\\TestResponse',
        'currentClassName' => 'Illuminate\\Testing\\TestResponse',
        'aliasName' => NULL,
      ),
      'assertSeeInOrder' => 
      array (
        'name' => 'assertSeeInOrder',
        'parameters' => 
        array (
          'values' => 
          array (
            'name' => 'values',
            'default' => NULL,
            'type' => 
            array (
              'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
              'data' => 
              array (
                'name' => 'array',
                'isIdentifier' => true,
              ),
            ),
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 733,
            'endLine' => 733,
            'startColumn' => 38,
            'endColumn' => 50,
            'parameterIndex' => 0,
            'isOptional' => false,
          ),
          'escape' => 
          array (
            'name' => 'escape',
            'default' => 
            array (
              'code' => 'true',
              'attributes' => 
              array (
                'startLine' => 733,
                'endLine' => 733,
                'startTokenPos' => 3095,
                'startFilePos' => 21026,
                'endTokenPos' => 3095,
                'endFilePos' => 21029,
              ),
            ),
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 733,
            'endLine' => 733,
            'startColumn' => 53,
            'endColumn' => 66,
            'parameterIndex' => 1,
            'isOptional' => true,
          ),
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Assert that the given strings are contained in order within the response.
 *
 * @param  array  $values
 * @param  bool  $escape
 * @return $this
 */',
        'startLine' => 733,
        'endLine' => 740,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Illuminate\\Testing',
        'declaringClassName' => 'Illuminate\\Testing\\TestResponse',
        'implementingClassName' => 'Illuminate\\Testing\\TestResponse',
        'currentClassName' => 'Illuminate\\Testing\\TestResponse',
        'aliasName' => NULL,
      ),
      'assertSeeHtmlInOrder' => 
      array (
        'name' => 'assertSeeHtmlInOrder',
        'parameters' => 
        array (
          'values' => 
          array (
            'name' => 'values',
            'default' => NULL,
            'type' => 
            array (
              'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
              'data' => 
              array (
                'name' => 'array',
                'isIdentifier' => true,
              ),
            ),
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 748,
            'endLine' => 748,
            'startColumn' => 42,
            'endColumn' => 54,
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
 * Assert that the given HTML strings are contained in order within the response.
 *
 * @param  array  $values
 * @return $this
 */',
        'startLine' => 748,
        'endLine' => 751,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Illuminate\\Testing',
        'declaringClassName' => 'Illuminate\\Testing\\TestResponse',
        'implementingClassName' => 'Illuminate\\Testing\\TestResponse',
        'currentClassName' => 'Illuminate\\Testing\\TestResponse',
        'aliasName' => NULL,
      ),
      'assertSeeText' => 
      array (
        'name' => 'assertSeeText',
        'parameters' => 
        array (
          'value' => 
          array (
            'name' => 'value',
            'default' => NULL,
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 760,
            'endLine' => 760,
            'startColumn' => 35,
            'endColumn' => 40,
            'parameterIndex' => 0,
            'isOptional' => false,
          ),
          'escape' => 
          array (
            'name' => 'escape',
            'default' => 
            array (
              'code' => 'true',
              'attributes' => 
              array (
                'startLine' => 760,
                'endLine' => 760,
                'startTokenPos' => 3201,
                'startFilePos' => 21773,
                'endTokenPos' => 3201,
                'endFilePos' => 21776,
              ),
            ),
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 760,
            'endLine' => 760,
            'startColumn' => 43,
            'endColumn' => 56,
            'parameterIndex' => 1,
            'isOptional' => true,
          ),
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Assert that the given string or array of strings are contained within the response text.
 *
 * @param  string|array  $value
 * @param  bool  $escape
 * @return $this
 */',
        'startLine' => 760,
        'endLine' => 773,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Illuminate\\Testing',
        'declaringClassName' => 'Illuminate\\Testing\\TestResponse',
        'implementingClassName' => 'Illuminate\\Testing\\TestResponse',
        'currentClassName' => 'Illuminate\\Testing\\TestResponse',
        'aliasName' => NULL,
      ),
      'assertSeeTextInOrder' => 
      array (
        'name' => 'assertSeeTextInOrder',
        'parameters' => 
        array (
          'values' => 
          array (
            'name' => 'values',
            'default' => NULL,
            'type' => 
            array (
              'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
              'data' => 
              array (
                'name' => 'array',
                'isIdentifier' => true,
              ),
            ),
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 782,
            'endLine' => 782,
            'startColumn' => 42,
            'endColumn' => 54,
            'parameterIndex' => 0,
            'isOptional' => false,
          ),
          'escape' => 
          array (
            'name' => 'escape',
            'default' => 
            array (
              'code' => 'true',
              'attributes' => 
              array (
                'startLine' => 782,
                'endLine' => 782,
                'startTokenPos' => 3312,
                'startFilePos' => 22370,
                'endTokenPos' => 3312,
                'endFilePos' => 22373,
              ),
            ),
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 782,
            'endLine' => 782,
            'startColumn' => 57,
            'endColumn' => 70,
            'parameterIndex' => 1,
            'isOptional' => true,
          ),
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Assert that the given strings are contained in order within the response text.
 *
 * @param  array  $values
 * @param  bool  $escape
 * @return $this
 */',
        'startLine' => 782,
        'endLine' => 789,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Illuminate\\Testing',
        'declaringClassName' => 'Illuminate\\Testing\\TestResponse',
        'implementingClassName' => 'Illuminate\\Testing\\TestResponse',
        'currentClassName' => 'Illuminate\\Testing\\TestResponse',
        'aliasName' => NULL,
      ),
      'assertDontSee' => 
      array (
        'name' => 'assertDontSee',
        'parameters' => 
        array (
          'value' => 
          array (
            'name' => 'value',
            'default' => NULL,
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 798,
            'endLine' => 798,
            'startColumn' => 35,
            'endColumn' => 40,
            'parameterIndex' => 0,
            'isOptional' => false,
          ),
          'escape' => 
          array (
            'name' => 'escape',
            'default' => 
            array (
              'code' => 'true',
              'attributes' => 
              array (
                'startLine' => 798,
                'endLine' => 798,
                'startTokenPos' => 3391,
                'startFilePos' => 22843,
                'endTokenPos' => 3391,
                'endFilePos' => 22846,
              ),
            ),
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 798,
            'endLine' => 798,
            'startColumn' => 43,
            'endColumn' => 56,
            'parameterIndex' => 1,
            'isOptional' => true,
          ),
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Assert that the given string or array of strings are not contained within the response.
 *
 * @param  string|array  $value
 * @param  bool  $escape
 * @return $this
 */',
        'startLine' => 798,
        'endLine' => 809,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Illuminate\\Testing',
        'declaringClassName' => 'Illuminate\\Testing\\TestResponse',
        'implementingClassName' => 'Illuminate\\Testing\\TestResponse',
        'currentClassName' => 'Illuminate\\Testing\\TestResponse',
        'aliasName' => NULL,
      ),
      'assertDontSeeHtml' => 
      array (
        'name' => 'assertDontSeeHtml',
        'parameters' => 
        array (
          'value' => 
          array (
            'name' => 'value',
            'default' => NULL,
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 817,
            'endLine' => 817,
            'startColumn' => 39,
            'endColumn' => 44,
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
 * Assert that the given HTML string or array of HTML strings are not contained within the response.
 *
 * @param  array|string  $value
 * @return $this
 */',
        'startLine' => 817,
        'endLine' => 820,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Illuminate\\Testing',
        'declaringClassName' => 'Illuminate\\Testing\\TestResponse',
        'implementingClassName' => 'Illuminate\\Testing\\TestResponse',
        'currentClassName' => 'Illuminate\\Testing\\TestResponse',
        'aliasName' => NULL,
      ),
      'assertDontSeeText' => 
      array (
        'name' => 'assertDontSeeText',
        'parameters' => 
        array (
          'value' => 
          array (
            'name' => 'value',
            'default' => NULL,
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 829,
            'endLine' => 829,
            'startColumn' => 39,
            'endColumn' => 44,
            'parameterIndex' => 0,
            'isOptional' => false,
          ),
          'escape' => 
          array (
            'name' => 'escape',
            'default' => 
            array (
              'code' => 'true',
              'attributes' => 
              array (
                'startLine' => 829,
                'endLine' => 829,
                'startTokenPos' => 3518,
                'startFilePos' => 23707,
                'endTokenPos' => 3518,
                'endFilePos' => 23710,
              ),
            ),
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 829,
            'endLine' => 829,
            'startColumn' => 47,
            'endColumn' => 60,
            'parameterIndex' => 1,
            'isOptional' => true,
          ),
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Assert that the given string or array of strings are not contained within the response text.
 *
 * @param  string|array  $value
 * @param  bool  $escape
 * @return $this
 */',
        'startLine' => 829,
        'endLine' => 842,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Illuminate\\Testing',
        'declaringClassName' => 'Illuminate\\Testing\\TestResponse',
        'implementingClassName' => 'Illuminate\\Testing\\TestResponse',
        'currentClassName' => 'Illuminate\\Testing\\TestResponse',
        'aliasName' => NULL,
      ),
      'assertJson' => 
      array (
        'name' => 'assertJson',
        'parameters' => 
        array (
          'value' => 
          array (
            'name' => 'value',
            'default' => NULL,
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 851,
            'endLine' => 851,
            'startColumn' => 32,
            'endColumn' => 37,
            'parameterIndex' => 0,
            'isOptional' => false,
          ),
          'strict' => 
          array (
            'name' => 'strict',
            'default' => 
            array (
              'code' => 'false',
              'attributes' => 
              array (
                'startLine' => 851,
                'endLine' => 851,
                'startTokenPos' => 3627,
                'startFilePos' => 24277,
                'endTokenPos' => 3627,
                'endFilePos' => 24281,
              ),
            ),
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 851,
            'endLine' => 851,
            'startColumn' => 40,
            'endColumn' => 54,
            'parameterIndex' => 1,
            'isOptional' => true,
          ),
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Assert that the response is a superset of the given JSON.
 *
 * @param  array|callable  $value
 * @param  bool  $strict
 * @return $this
 */',
        'startLine' => 851,
        'endLine' => 868,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Illuminate\\Testing',
        'declaringClassName' => 'Illuminate\\Testing\\TestResponse',
        'implementingClassName' => 'Illuminate\\Testing\\TestResponse',
        'currentClassName' => 'Illuminate\\Testing\\TestResponse',
        'aliasName' => NULL,
      ),
      'assertJsonPath' => 
      array (
        'name' => 'assertJsonPath',
        'parameters' => 
        array (
          'path' => 
          array (
            'name' => 'path',
            'default' => NULL,
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 877,
            'endLine' => 877,
            'startColumn' => 36,
            'endColumn' => 40,
            'parameterIndex' => 0,
            'isOptional' => false,
          ),
          'expect' => 
          array (
            'name' => 'expect',
            'default' => NULL,
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 877,
            'endLine' => 877,
            'startColumn' => 43,
            'endColumn' => 49,
            'parameterIndex' => 1,
            'isOptional' => false,
          ),
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Assert that the expected value and type exists at the given path in the response.
 *
 * @param  string  $path
 * @param  mixed  $expect
 * @return $this
 */',
        'startLine' => 877,
        'endLine' => 882,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Illuminate\\Testing',
        'declaringClassName' => 'Illuminate\\Testing\\TestResponse',
        'implementingClassName' => 'Illuminate\\Testing\\TestResponse',
        'currentClassName' => 'Illuminate\\Testing\\TestResponse',
        'aliasName' => NULL,
      ),
      'assertJsonPathCanonicalizing' => 
      array (
        'name' => 'assertJsonPathCanonicalizing',
        'parameters' => 
        array (
          'path' => 
          array (
            'name' => 'path',
            'default' => NULL,
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 891,
            'endLine' => 891,
            'startColumn' => 50,
            'endColumn' => 54,
            'parameterIndex' => 0,
            'isOptional' => false,
          ),
          'expect' => 
          array (
            'name' => 'expect',
            'default' => NULL,
            'type' => 
            array (
              'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
              'data' => 
              array (
                'name' => 'array',
                'isIdentifier' => true,
              ),
            ),
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 891,
            'endLine' => 891,
            'startColumn' => 57,
            'endColumn' => 69,
            'parameterIndex' => 1,
            'isOptional' => false,
          ),
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Assert that the given path in the response contains all of the expected values without looking at the order.
 *
 * @param  string  $path
 * @param  array  $expect
 * @return $this
 */',
        'startLine' => 891,
        'endLine' => 896,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Illuminate\\Testing',
        'declaringClassName' => 'Illuminate\\Testing\\TestResponse',
        'implementingClassName' => 'Illuminate\\Testing\\TestResponse',
        'currentClassName' => 'Illuminate\\Testing\\TestResponse',
        'aliasName' => NULL,
      ),
      'assertExactJson' => 
      array (
        'name' => 'assertExactJson',
        'parameters' => 
        array (
          'data' => 
          array (
            'name' => 'data',
            'default' => NULL,
            'type' => 
            array (
              'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
              'data' => 
              array (
                'name' => 'array',
                'isIdentifier' => true,
              ),
            ),
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 904,
            'endLine' => 904,
            'startColumn' => 37,
            'endColumn' => 47,
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
 * Assert that the response has the exact given JSON.
 *
 * @param  array  $data
 * @return $this
 */',
        'startLine' => 904,
        'endLine' => 909,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Illuminate\\Testing',
        'declaringClassName' => 'Illuminate\\Testing\\TestResponse',
        'implementingClassName' => 'Illuminate\\Testing\\TestResponse',
        'currentClassName' => 'Illuminate\\Testing\\TestResponse',
        'aliasName' => NULL,
      ),
      'assertSimilarJson' => 
      array (
        'name' => 'assertSimilarJson',
        'parameters' => 
        array (
          'data' => 
          array (
            'name' => 'data',
            'default' => NULL,
            'type' => 
            array (
              'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
              'data' => 
              array (
                'name' => 'array',
                'isIdentifier' => true,
              ),
            ),
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 917,
            'endLine' => 917,
            'startColumn' => 39,
            'endColumn' => 49,
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
 * Assert that the response has the similar JSON as given.
 *
 * @param  array  $data
 * @return $this
 */',
        'startLine' => 917,
        'endLine' => 922,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Illuminate\\Testing',
        'declaringClassName' => 'Illuminate\\Testing\\TestResponse',
        'implementingClassName' => 'Illuminate\\Testing\\TestResponse',
        'currentClassName' => 'Illuminate\\Testing\\TestResponse',
        'aliasName' => NULL,
      ),
      'assertJsonFragments' => 
      array (
        'name' => 'assertJsonFragments',
        'parameters' => 
        array (
          'data' => 
          array (
            'name' => 'data',
            'default' => NULL,
            'type' => 
            array (
              'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
              'data' => 
              array (
                'name' => 'array',
                'isIdentifier' => true,
              ),
            ),
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 930,
            'endLine' => 930,
            'startColumn' => 41,
            'endColumn' => 51,
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
 * Assert that the response contains the given JSON fragments.
 *
 * @param  array  $data
 * @return $this
 */',
        'startLine' => 930,
        'endLine' => 937,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Illuminate\\Testing',
        'declaringClassName' => 'Illuminate\\Testing\\TestResponse',
        'implementingClassName' => 'Illuminate\\Testing\\TestResponse',
        'currentClassName' => 'Illuminate\\Testing\\TestResponse',
        'aliasName' => NULL,
      ),
      'assertJsonFragment' => 
      array (
        'name' => 'assertJsonFragment',
        'parameters' => 
        array (
          'data' => 
          array (
            'name' => 'data',
            'default' => NULL,
            'type' => 
            array (
              'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
              'data' => 
              array (
                'name' => 'array',
                'isIdentifier' => true,
              ),
            ),
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 945,
            'endLine' => 945,
            'startColumn' => 40,
            'endColumn' => 50,
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
 * Assert that the response contains the given JSON fragment.
 *
 * @param  array  $data
 * @return $this
 */',
        'startLine' => 945,
        'endLine' => 950,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Illuminate\\Testing',
        'declaringClassName' => 'Illuminate\\Testing\\TestResponse',
        'implementingClassName' => 'Illuminate\\Testing\\TestResponse',
        'currentClassName' => 'Illuminate\\Testing\\TestResponse',
        'aliasName' => NULL,
      ),
      'assertJsonMissing' => 
      array (
        'name' => 'assertJsonMissing',
        'parameters' => 
        array (
          'data' => 
          array (
            'name' => 'data',
            'default' => NULL,
            'type' => 
            array (
              'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
              'data' => 
              array (
                'name' => 'array',
                'isIdentifier' => true,
              ),
            ),
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 959,
            'endLine' => 959,
            'startColumn' => 39,
            'endColumn' => 49,
            'parameterIndex' => 0,
            'isOptional' => false,
          ),
          'exact' => 
          array (
            'name' => 'exact',
            'default' => 
            array (
              'code' => 'false',
              'attributes' => 
              array (
                'startLine' => 959,
                'endLine' => 959,
                'startTokenPos' => 3965,
                'startFilePos' => 26831,
                'endTokenPos' => 3965,
                'endFilePos' => 26835,
              ),
            ),
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 959,
            'endLine' => 959,
            'startColumn' => 52,
            'endColumn' => 65,
            'parameterIndex' => 1,
            'isOptional' => true,
          ),
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Assert that the response does not contain the given JSON fragment.
 *
 * @param  array  $data
 * @param  bool  $exact
 * @return $this
 */',
        'startLine' => 959,
        'endLine' => 964,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Illuminate\\Testing',
        'declaringClassName' => 'Illuminate\\Testing\\TestResponse',
        'implementingClassName' => 'Illuminate\\Testing\\TestResponse',
        'currentClassName' => 'Illuminate\\Testing\\TestResponse',
        'aliasName' => NULL,
      ),
      'assertJsonMissingExact' => 
      array (
        'name' => 'assertJsonMissingExact',
        'parameters' => 
        array (
          'data' => 
          array (
            'name' => 'data',
            'default' => NULL,
            'type' => 
            array (
              'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
              'data' => 
              array (
                'name' => 'array',
                'isIdentifier' => true,
              ),
            ),
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 972,
            'endLine' => 972,
            'startColumn' => 44,
            'endColumn' => 54,
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
 * Assert that the response does not contain the exact JSON fragment.
 *
 * @param  array  $data
 * @return $this
 */',
        'startLine' => 972,
        'endLine' => 977,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Illuminate\\Testing',
        'declaringClassName' => 'Illuminate\\Testing\\TestResponse',
        'implementingClassName' => 'Illuminate\\Testing\\TestResponse',
        'currentClassName' => 'Illuminate\\Testing\\TestResponse',
        'aliasName' => NULL,
      ),
      'assertJsonMissingPath' => 
      array (
        'name' => 'assertJsonMissingPath',
        'parameters' => 
        array (
          'path' => 
          array (
            'name' => 'path',
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
            'startLine' => 985,
            'endLine' => 985,
            'startColumn' => 43,
            'endColumn' => 54,
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
 * Assert that the response does not contain the given path.
 *
 * @param  string  $path
 * @return $this
 */',
        'startLine' => 985,
        'endLine' => 990,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Illuminate\\Testing',
        'declaringClassName' => 'Illuminate\\Testing\\TestResponse',
        'implementingClassName' => 'Illuminate\\Testing\\TestResponse',
        'currentClassName' => 'Illuminate\\Testing\\TestResponse',
        'aliasName' => NULL,
      ),
      'assertJsonStructure' => 
      array (
        'name' => 'assertJsonStructure',
        'parameters' => 
        array (
          'structure' => 
          array (
            'name' => 'structure',
            'default' => 
            array (
              'code' => 'null',
              'attributes' => 
              array (
                'startLine' => 999,
                'endLine' => 999,
                'startTokenPos' => 4075,
                'startFilePos' => 27779,
                'endTokenPos' => 4075,
                'endFilePos' => 27782,
              ),
            ),
            'type' => 
            array (
              'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionUnionType',
              'data' => 
              array (
                'types' => 
                array (
                  0 => 
                  array (
                    'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
                    'data' => 
                    array (
                      'name' => 'array',
                      'isIdentifier' => true,
                    ),
                  ),
                  1 => 
                  array (
                    'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
                    'data' => 
                    array (
                      'name' => 'null',
                      'isIdentifier' => true,
                    ),
                  ),
                ),
              ),
            ),
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 999,
            'endLine' => 999,
            'startColumn' => 41,
            'endColumn' => 64,
            'parameterIndex' => 0,
            'isOptional' => true,
          ),
          'responseData' => 
          array (
            'name' => 'responseData',
            'default' => 
            array (
              'code' => 'null',
              'attributes' => 
              array (
                'startLine' => 999,
                'endLine' => 999,
                'startTokenPos' => 4085,
                'startFilePos' => 27808,
                'endTokenPos' => 4085,
                'endFilePos' => 27811,
              ),
            ),
            'type' => 
            array (
              'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionUnionType',
              'data' => 
              array (
                'types' => 
                array (
                  0 => 
                  array (
                    'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
                    'data' => 
                    array (
                      'name' => 'array',
                      'isIdentifier' => true,
                    ),
                  ),
                  1 => 
                  array (
                    'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
                    'data' => 
                    array (
                      'name' => 'null',
                      'isIdentifier' => true,
                    ),
                  ),
                ),
              ),
            ),
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 999,
            'endLine' => 999,
            'startColumn' => 67,
            'endColumn' => 93,
            'parameterIndex' => 1,
            'isOptional' => true,
          ),
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Assert that the response has a given JSON structure.
 *
 * @param  array|null  $structure
 * @param  array|null  $responseData
 * @return $this
 */',
        'startLine' => 999,
        'endLine' => 1004,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Illuminate\\Testing',
        'declaringClassName' => 'Illuminate\\Testing\\TestResponse',
        'implementingClassName' => 'Illuminate\\Testing\\TestResponse',
        'currentClassName' => 'Illuminate\\Testing\\TestResponse',
        'aliasName' => NULL,
      ),
      'assertExactJsonStructure' => 
      array (
        'name' => 'assertExactJsonStructure',
        'parameters' => 
        array (
          'structure' => 
          array (
            'name' => 'structure',
            'default' => 
            array (
              'code' => 'null',
              'attributes' => 
              array (
                'startLine' => 1013,
                'endLine' => 1013,
                'startTokenPos' => 4127,
                'startFilePos' => 28181,
                'endTokenPos' => 4127,
                'endFilePos' => 28184,
              ),
            ),
            'type' => 
            array (
              'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionUnionType',
              'data' => 
              array (
                'types' => 
                array (
                  0 => 
                  array (
                    'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
                    'data' => 
                    array (
                      'name' => 'array',
                      'isIdentifier' => true,
                    ),
                  ),
                  1 => 
                  array (
                    'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
                    'data' => 
                    array (
                      'name' => 'null',
                      'isIdentifier' => true,
                    ),
                  ),
                ),
              ),
            ),
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 1013,
            'endLine' => 1013,
            'startColumn' => 46,
            'endColumn' => 69,
            'parameterIndex' => 0,
            'isOptional' => true,
          ),
          'responseData' => 
          array (
            'name' => 'responseData',
            'default' => 
            array (
              'code' => 'null',
              'attributes' => 
              array (
                'startLine' => 1013,
                'endLine' => 1013,
                'startTokenPos' => 4137,
                'startFilePos' => 28210,
                'endTokenPos' => 4137,
                'endFilePos' => 28213,
              ),
            ),
            'type' => 
            array (
              'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionUnionType',
              'data' => 
              array (
                'types' => 
                array (
                  0 => 
                  array (
                    'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
                    'data' => 
                    array (
                      'name' => 'array',
                      'isIdentifier' => true,
                    ),
                  ),
                  1 => 
                  array (
                    'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
                    'data' => 
                    array (
                      'name' => 'null',
                      'isIdentifier' => true,
                    ),
                  ),
                ),
              ),
            ),
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 1013,
            'endLine' => 1013,
            'startColumn' => 72,
            'endColumn' => 98,
            'parameterIndex' => 1,
            'isOptional' => true,
          ),
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Assert that the response has the exact JSON structure.
 *
 * @param  array|null  $structure
 * @param  array|null  $responseData
 * @return $this
 */',
        'startLine' => 1013,
        'endLine' => 1018,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Illuminate\\Testing',
        'declaringClassName' => 'Illuminate\\Testing\\TestResponse',
        'implementingClassName' => 'Illuminate\\Testing\\TestResponse',
        'currentClassName' => 'Illuminate\\Testing\\TestResponse',
        'aliasName' => NULL,
      ),
      'assertJsonCount' => 
      array (
        'name' => 'assertJsonCount',
        'parameters' => 
        array (
          'count' => 
          array (
            'name' => 'count',
            'default' => NULL,
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
            'startLine' => 1027,
            'endLine' => 1027,
            'startColumn' => 37,
            'endColumn' => 46,
            'parameterIndex' => 0,
            'isOptional' => false,
          ),
          'key' => 
          array (
            'name' => 'key',
            'default' => 
            array (
              'code' => 'null',
              'attributes' => 
              array (
                'startLine' => 1027,
                'endLine' => 1027,
                'startTokenPos' => 4184,
                'startFilePos' => 28585,
                'endTokenPos' => 4184,
                'endFilePos' => 28588,
              ),
            ),
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 1027,
            'endLine' => 1027,
            'startColumn' => 49,
            'endColumn' => 59,
            'parameterIndex' => 1,
            'isOptional' => true,
          ),
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Assert that the response JSON has the expected count of items at the given key.
 *
 * @param  int  $count
 * @param  string|null  $key
 * @return $this
 */',
        'startLine' => 1027,
        'endLine' => 1032,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Illuminate\\Testing',
        'declaringClassName' => 'Illuminate\\Testing\\TestResponse',
        'implementingClassName' => 'Illuminate\\Testing\\TestResponse',
        'currentClassName' => 'Illuminate\\Testing\\TestResponse',
        'aliasName' => NULL,
      ),
      'assertJsonValidationErrors' => 
      array (
        'name' => 'assertJsonValidationErrors',
        'parameters' => 
        array (
          'errors' => 
          array (
            'name' => 'errors',
            'default' => NULL,
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 1041,
            'endLine' => 1041,
            'startColumn' => 48,
            'endColumn' => 54,
            'parameterIndex' => 0,
            'isOptional' => false,
          ),
          'responseKey' => 
          array (
            'name' => 'responseKey',
            'default' => 
            array (
              'code' => '\'errors\'',
              'attributes' => 
              array (
                'startLine' => 1041,
                'endLine' => 1041,
                'startTokenPos' => 4226,
                'startFilePos' => 28949,
                'endTokenPos' => 4226,
                'endFilePos' => 28956,
              ),
            ),
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 1041,
            'endLine' => 1041,
            'startColumn' => 57,
            'endColumn' => 79,
            'parameterIndex' => 1,
            'isOptional' => true,
          ),
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Assert that the response has the given JSON validation errors.
 *
 * @param  string|array  $errors
 * @param  string  $responseKey
 * @return $this
 */',
        'startLine' => 1041,
        'endLine' => 1083,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Illuminate\\Testing',
        'declaringClassName' => 'Illuminate\\Testing\\TestResponse',
        'implementingClassName' => 'Illuminate\\Testing\\TestResponse',
        'currentClassName' => 'Illuminate\\Testing\\TestResponse',
        'aliasName' => NULL,
      ),
      'assertOnlyJsonValidationErrors' => 
      array (
        'name' => 'assertOnlyJsonValidationErrors',
        'parameters' => 
        array (
          'errors' => 
          array (
            'name' => 'errors',
            'default' => NULL,
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 1092,
            'endLine' => 1092,
            'startColumn' => 52,
            'endColumn' => 58,
            'parameterIndex' => 0,
            'isOptional' => false,
          ),
          'responseKey' => 
          array (
            'name' => 'responseKey',
            'default' => 
            array (
              'code' => '\'errors\'',
              'attributes' => 
              array (
                'startLine' => 1092,
                'endLine' => 1092,
                'startTokenPos' => 4512,
                'startFilePos' => 30781,
                'endTokenPos' => 4512,
                'endFilePos' => 30788,
              ),
            ),
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 1092,
            'endLine' => 1092,
            'startColumn' => 61,
            'endColumn' => 83,
            'parameterIndex' => 1,
            'isOptional' => true,
          ),
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Assert that the response has the given JSON validation errors but does not have any other JSON validation errors.
 *
 * @param  string|array  $errors
 * @param  string  $responseKey
 * @return $this
 */',
        'startLine' => 1092,
        'endLine' => 1110,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Illuminate\\Testing',
        'declaringClassName' => 'Illuminate\\Testing\\TestResponse',
        'implementingClassName' => 'Illuminate\\Testing\\TestResponse',
        'currentClassName' => 'Illuminate\\Testing\\TestResponse',
        'aliasName' => NULL,
      ),
      'assertJsonValidationErrorFor' => 
      array (
        'name' => 'assertJsonValidationErrorFor',
        'parameters' => 
        array (
          'key' => 
          array (
            'name' => 'key',
            'default' => NULL,
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 1119,
            'endLine' => 1119,
            'startColumn' => 50,
            'endColumn' => 53,
            'parameterIndex' => 0,
            'isOptional' => false,
          ),
          'responseKey' => 
          array (
            'name' => 'responseKey',
            'default' => 
            array (
              'code' => '\'errors\'',
              'attributes' => 
              array (
                'startLine' => 1119,
                'endLine' => 1119,
                'startTokenPos' => 4698,
                'startFilePos' => 31696,
                'endTokenPos' => 4698,
                'endFilePos' => 31703,
              ),
            ),
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 1119,
            'endLine' => 1119,
            'startColumn' => 56,
            'endColumn' => 78,
            'parameterIndex' => 1,
            'isOptional' => true,
          ),
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Assert the response has any JSON validation errors for the given key.
 *
 * @param  string  $key
 * @param  string  $responseKey
 * @return $this
 */',
        'startLine' => 1119,
        'endLine' => 1135,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Illuminate\\Testing',
        'declaringClassName' => 'Illuminate\\Testing\\TestResponse',
        'implementingClassName' => 'Illuminate\\Testing\\TestResponse',
        'currentClassName' => 'Illuminate\\Testing\\TestResponse',
        'aliasName' => NULL,
      ),
      'assertJsonMissingValidationErrors' => 
      array (
        'name' => 'assertJsonMissingValidationErrors',
        'parameters' => 
        array (
          'keys' => 
          array (
            'name' => 'keys',
            'default' => 
            array (
              'code' => 'null',
              'attributes' => 
              array (
                'startLine' => 1144,
                'endLine' => 1144,
                'startTokenPos' => 4817,
                'startFilePos' => 32596,
                'endTokenPos' => 4817,
                'endFilePos' => 32599,
              ),
            ),
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 1144,
            'endLine' => 1144,
            'startColumn' => 55,
            'endColumn' => 66,
            'parameterIndex' => 0,
            'isOptional' => true,
          ),
          'responseKey' => 
          array (
            'name' => 'responseKey',
            'default' => 
            array (
              'code' => '\'errors\'',
              'attributes' => 
              array (
                'startLine' => 1144,
                'endLine' => 1144,
                'startTokenPos' => 4824,
                'startFilePos' => 32617,
                'endTokenPos' => 4824,
                'endFilePos' => 32624,
              ),
            ),
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 1144,
            'endLine' => 1144,
            'startColumn' => 69,
            'endColumn' => 91,
            'parameterIndex' => 1,
            'isOptional' => true,
          ),
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Assert that the response has no JSON validation errors for the given keys.
 *
 * @param  string|array|null  $keys
 * @param  string  $responseKey
 * @return $this
 */',
        'startLine' => 1144,
        'endLine' => 1177,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Illuminate\\Testing',
        'declaringClassName' => 'Illuminate\\Testing\\TestResponse',
        'implementingClassName' => 'Illuminate\\Testing\\TestResponse',
        'currentClassName' => 'Illuminate\\Testing\\TestResponse',
        'aliasName' => NULL,
      ),
      'assertJsonIsArray' => 
      array (
        'name' => 'assertJsonIsArray',
        'parameters' => 
        array (
          'key' => 
          array (
            'name' => 'key',
            'default' => 
            array (
              'code' => 'null',
              'attributes' => 
              array (
                'startLine' => 1185,
                'endLine' => 1185,
                'startTokenPos' => 5061,
                'startFilePos' => 33750,
                'endTokenPos' => 5061,
                'endFilePos' => 33753,
              ),
            ),
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 1185,
            'endLine' => 1185,
            'startColumn' => 39,
            'endColumn' => 49,
            'parameterIndex' => 0,
            'isOptional' => true,
          ),
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Assert that the given key is a JSON array.
 *
 * @param  string|null  $key
 * @return $this
 */',
        'startLine' => 1185,
        'endLine' => 1198,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Illuminate\\Testing',
        'declaringClassName' => 'Illuminate\\Testing\\TestResponse',
        'implementingClassName' => 'Illuminate\\Testing\\TestResponse',
        'currentClassName' => 'Illuminate\\Testing\\TestResponse',
        'aliasName' => NULL,
      ),
      'assertJsonIsObject' => 
      array (
        'name' => 'assertJsonIsObject',
        'parameters' => 
        array (
          'key' => 
          array (
            'name' => 'key',
            'default' => 
            array (
              'code' => 'null',
              'attributes' => 
              array (
                'startLine' => 1206,
                'endLine' => 1206,
                'startTokenPos' => 5145,
                'startFilePos' => 34233,
                'endTokenPos' => 5145,
                'endFilePos' => 34236,
              ),
            ),
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 1206,
            'endLine' => 1206,
            'startColumn' => 40,
            'endColumn' => 50,
            'parameterIndex' => 0,
            'isOptional' => true,
          ),
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Assert that the given key is a JSON object.
 *
 * @param  string|null  $key
 * @return $this
 */',
        'startLine' => 1206,
        'endLine' => 1219,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Illuminate\\Testing',
        'declaringClassName' => 'Illuminate\\Testing\\TestResponse',
        'implementingClassName' => 'Illuminate\\Testing\\TestResponse',
        'currentClassName' => 'Illuminate\\Testing\\TestResponse',
        'aliasName' => NULL,
      ),
      'decodeResponseJson' => 
      array (
        'name' => 'decodeResponseJson',
        'parameters' => 
        array (
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Validate the decoded response JSON.
 *
 * @return \\Illuminate\\Testing\\AssertableJsonString
 *
 * @throws \\Throwable
 */',
        'startLine' => 1228,
        'endLine' => 1248,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Illuminate\\Testing',
        'declaringClassName' => 'Illuminate\\Testing\\TestResponse',
        'implementingClassName' => 'Illuminate\\Testing\\TestResponse',
        'currentClassName' => 'Illuminate\\Testing\\TestResponse',
        'aliasName' => NULL,
      ),
      'json' => 
      array (
        'name' => 'json',
        'parameters' => 
        array (
          'key' => 
          array (
            'name' => 'key',
            'default' => 
            array (
              'code' => 'null',
              'attributes' => 
              array (
                'startLine' => 1256,
                'endLine' => 1256,
                'startTokenPos' => 5382,
                'startFilePos' => 35569,
                'endTokenPos' => 5382,
                'endFilePos' => 35572,
              ),
            ),
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 1256,
            'endLine' => 1256,
            'startColumn' => 26,
            'endColumn' => 36,
            'parameterIndex' => 0,
            'isOptional' => true,
          ),
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Return the decoded response JSON.
 *
 * @param  string|null  $key
 * @return mixed
 */',
        'startLine' => 1256,
        'endLine' => 1259,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Illuminate\\Testing',
        'declaringClassName' => 'Illuminate\\Testing\\TestResponse',
        'implementingClassName' => 'Illuminate\\Testing\\TestResponse',
        'currentClassName' => 'Illuminate\\Testing\\TestResponse',
        'aliasName' => NULL,
      ),
      'collect' => 
      array (
        'name' => 'collect',
        'parameters' => 
        array (
          'key' => 
          array (
            'name' => 'key',
            'default' => 
            array (
              'code' => 'null',
              'attributes' => 
              array (
                'startLine' => 1267,
                'endLine' => 1267,
                'startTokenPos' => 5415,
                'startFilePos' => 35847,
                'endTokenPos' => 5415,
                'endFilePos' => 35850,
              ),
            ),
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 1267,
            'endLine' => 1267,
            'startColumn' => 29,
            'endColumn' => 39,
            'parameterIndex' => 0,
            'isOptional' => true,
          ),
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Get the decoded JSON body of the response as a collection.
 *
 * @param  string|null  $key
 * @return \\Illuminate\\Support\\Collection
 */',
        'startLine' => 1267,
        'endLine' => 1270,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Illuminate\\Testing',
        'declaringClassName' => 'Illuminate\\Testing\\TestResponse',
        'implementingClassName' => 'Illuminate\\Testing\\TestResponse',
        'currentClassName' => 'Illuminate\\Testing\\TestResponse',
        'aliasName' => NULL,
      ),
      'assertViewIs' => 
      array (
        'name' => 'assertViewIs',
        'parameters' => 
        array (
          'value' => 
          array (
            'name' => 'value',
            'default' => NULL,
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 1278,
            'endLine' => 1278,
            'startColumn' => 34,
            'endColumn' => 39,
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
 * Assert that the response view equals the given value.
 *
 * @param  string  $value
 * @return $this
 */',
        'startLine' => 1278,
        'endLine' => 1285,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Illuminate\\Testing',
        'declaringClassName' => 'Illuminate\\Testing\\TestResponse',
        'implementingClassName' => 'Illuminate\\Testing\\TestResponse',
        'currentClassName' => 'Illuminate\\Testing\\TestResponse',
        'aliasName' => NULL,
      ),
      'assertViewHas' => 
      array (
        'name' => 'assertViewHas',
        'parameters' => 
        array (
          'key' => 
          array (
            'name' => 'key',
            'default' => NULL,
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 1294,
            'endLine' => 1294,
            'startColumn' => 35,
            'endColumn' => 38,
            'parameterIndex' => 0,
            'isOptional' => false,
          ),
          'value' => 
          array (
            'name' => 'value',
            'default' => 
            array (
              'code' => 'null',
              'attributes' => 
              array (
                'startLine' => 1294,
                'endLine' => 1294,
                'startTokenPos' => 5501,
                'startFilePos' => 36480,
                'endTokenPos' => 5501,
                'endFilePos' => 36483,
              ),
            ),
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 1294,
            'endLine' => 1294,
            'startColumn' => 41,
            'endColumn' => 53,
            'parameterIndex' => 1,
            'isOptional' => true,
          ),
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Assert that the response view has a given piece of bound data.
 *
 * @param  string|array  $key
 * @param  mixed  $value
 * @return $this
 */',
        'startLine' => 1294,
        'endLine' => 1320,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Illuminate\\Testing',
        'declaringClassName' => 'Illuminate\\Testing\\TestResponse',
        'implementingClassName' => 'Illuminate\\Testing\\TestResponse',
        'currentClassName' => 'Illuminate\\Testing\\TestResponse',
        'aliasName' => NULL,
      ),
      'assertViewHasAll' => 
      array (
        'name' => 'assertViewHasAll',
        'parameters' => 
        array (
          'bindings' => 
          array (
            'name' => 'bindings',
            'default' => NULL,
            'type' => 
            array (
              'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
              'data' => 
              array (
                'name' => 'array',
                'isIdentifier' => true,
              ),
            ),
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 1328,
            'endLine' => 1328,
            'startColumn' => 38,
            'endColumn' => 52,
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
 * Assert that the response view has a given list of bound data.
 *
 * @param  array  $bindings
 * @return $this
 */',
        'startLine' => 1328,
        'endLine' => 1339,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Illuminate\\Testing',
        'declaringClassName' => 'Illuminate\\Testing\\TestResponse',
        'implementingClassName' => 'Illuminate\\Testing\\TestResponse',
        'currentClassName' => 'Illuminate\\Testing\\TestResponse',
        'aliasName' => NULL,
      ),
      'viewData' => 
      array (
        'name' => 'viewData',
        'parameters' => 
        array (
          'key' => 
          array (
            'name' => 'key',
            'default' => 
            array (
              'code' => 'null',
              'attributes' => 
              array (
                'startLine' => 1347,
                'endLine' => 1347,
                'startTokenPos' => 5914,
                'startFilePos' => 38551,
                'endTokenPos' => 5914,
                'endFilePos' => 38554,
              ),
            ),
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 1347,
            'endLine' => 1347,
            'startColumn' => 30,
            'endColumn' => 40,
            'parameterIndex' => 0,
            'isOptional' => true,
          ),
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Get a piece of data from the original view.
 *
 * @param  string|null  $key
 * @return mixed
 */',
        'startLine' => 1347,
        'endLine' => 1358,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Illuminate\\Testing',
        'declaringClassName' => 'Illuminate\\Testing\\TestResponse',
        'implementingClassName' => 'Illuminate\\Testing\\TestResponse',
        'currentClassName' => 'Illuminate\\Testing\\TestResponse',
        'aliasName' => NULL,
      ),
      'assertViewMissing' => 
      array (
        'name' => 'assertViewMissing',
        'parameters' => 
        array (
          'key' => 
          array (
            'name' => 'key',
            'default' => NULL,
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 1366,
            'endLine' => 1366,
            'startColumn' => 39,
            'endColumn' => 42,
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
 * Assert that the response view is missing a piece of bound data.
 *
 * @param  string  $key
 * @return $this
 */',
        'startLine' => 1366,
        'endLine' => 1373,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Illuminate\\Testing',
        'declaringClassName' => 'Illuminate\\Testing\\TestResponse',
        'implementingClassName' => 'Illuminate\\Testing\\TestResponse',
        'currentClassName' => 'Illuminate\\Testing\\TestResponse',
        'aliasName' => NULL,
      ),
      'ensureResponseHasView' => 
      array (
        'name' => 'ensureResponseHasView',
        'parameters' => 
        array (
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Ensure that the response has a view as its original content.
 *
 * @return $this
 */',
        'startLine' => 1380,
        'endLine' => 1387,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 2,
        'namespace' => 'Illuminate\\Testing',
        'declaringClassName' => 'Illuminate\\Testing\\TestResponse',
        'implementingClassName' => 'Illuminate\\Testing\\TestResponse',
        'currentClassName' => 'Illuminate\\Testing\\TestResponse',
        'aliasName' => NULL,
      ),
      'responseHasView' => 
      array (
        'name' => 'responseHasView',
        'parameters' => 
        array (
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Determine if the original response is a view.
 *
 * @return bool
 */',
        'startLine' => 1394,
        'endLine' => 1397,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 2,
        'namespace' => 'Illuminate\\Testing',
        'declaringClassName' => 'Illuminate\\Testing\\TestResponse',
        'implementingClassName' => 'Illuminate\\Testing\\TestResponse',
        'currentClassName' => 'Illuminate\\Testing\\TestResponse',
        'aliasName' => NULL,
      ),
      'assertValid' => 
      array (
        'name' => 'assertValid',
        'parameters' => 
        array (
          'keys' => 
          array (
            'name' => 'keys',
            'default' => 
            array (
              'code' => 'null',
              'attributes' => 
              array (
                'startLine' => 1407,
                'endLine' => 1407,
                'startTokenPos' => 6117,
                'startFilePos' => 39930,
                'endTokenPos' => 6117,
                'endFilePos' => 39933,
              ),
            ),
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 1407,
            'endLine' => 1407,
            'startColumn' => 33,
            'endColumn' => 44,
            'parameterIndex' => 0,
            'isOptional' => true,
          ),
          'errorBag' => 
          array (
            'name' => 'errorBag',
            'default' => 
            array (
              'code' => '\'default\'',
              'attributes' => 
              array (
                'startLine' => 1407,
                'endLine' => 1407,
                'startTokenPos' => 6124,
                'startFilePos' => 39948,
                'endTokenPos' => 6124,
                'endFilePos' => 39956,
              ),
            ),
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 1407,
            'endLine' => 1407,
            'startColumn' => 47,
            'endColumn' => 67,
            'parameterIndex' => 1,
            'isOptional' => true,
          ),
          'responseKey' => 
          array (
            'name' => 'responseKey',
            'default' => 
            array (
              'code' => '\'errors\'',
              'attributes' => 
              array (
                'startLine' => 1407,
                'endLine' => 1407,
                'startTokenPos' => 6131,
                'startFilePos' => 39974,
                'endTokenPos' => 6131,
                'endFilePos' => 39981,
              ),
            ),
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 1407,
            'endLine' => 1407,
            'startColumn' => 70,
            'endColumn' => 92,
            'parameterIndex' => 2,
            'isOptional' => true,
          ),
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Assert that the given keys do not have validation errors.
 *
 * @param  string|array|null  $keys
 * @param  string  $errorBag
 * @param  string  $responseKey
 * @return $this
 */',
        'startLine' => 1407,
        'endLine' => 1440,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Illuminate\\Testing',
        'declaringClassName' => 'Illuminate\\Testing\\TestResponse',
        'implementingClassName' => 'Illuminate\\Testing\\TestResponse',
        'currentClassName' => 'Illuminate\\Testing\\TestResponse',
        'aliasName' => NULL,
      ),
      'assertInvalid' => 
      array (
        'name' => 'assertInvalid',
        'parameters' => 
        array (
          'errors' => 
          array (
            'name' => 'errors',
            'default' => 
            array (
              'code' => 'null',
              'attributes' => 
              array (
                'startLine' => 1450,
                'endLine' => 1450,
                'startTokenPos' => 6389,
                'startFilePos' => 41327,
                'endTokenPos' => 6389,
                'endFilePos' => 41330,
              ),
            ),
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 1450,
            'endLine' => 1450,
            'startColumn' => 35,
            'endColumn' => 48,
            'parameterIndex' => 0,
            'isOptional' => true,
          ),
          'errorBag' => 
          array (
            'name' => 'errorBag',
            'default' => 
            array (
              'code' => '\'default\'',
              'attributes' => 
              array (
                'startLine' => 1451,
                'endLine' => 1451,
                'startTokenPos' => 6396,
                'startFilePos' => 41379,
                'endTokenPos' => 6396,
                'endFilePos' => 41387,
              ),
            ),
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 1451,
            'endLine' => 1451,
            'startColumn' => 35,
            'endColumn' => 55,
            'parameterIndex' => 1,
            'isOptional' => true,
          ),
          'responseKey' => 
          array (
            'name' => 'responseKey',
            'default' => 
            array (
              'code' => '\'errors\'',
              'attributes' => 
              array (
                'startLine' => 1452,
                'endLine' => 1452,
                'startTokenPos' => 6403,
                'startFilePos' => 41439,
                'endTokenPos' => 6403,
                'endFilePos' => 41446,
              ),
            ),
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 1452,
            'endLine' => 1452,
            'startColumn' => 35,
            'endColumn' => 57,
            'parameterIndex' => 2,
            'isOptional' => true,
          ),
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Assert that the response has the given validation errors.
 *
 * @param  string|array|null  $errors
 * @param  string  $errorBag
 * @param  string  $responseKey
 * @return $this
 */',
        'startLine' => 1450,
        'endLine' => 1496,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Illuminate\\Testing',
        'declaringClassName' => 'Illuminate\\Testing\\TestResponse',
        'implementingClassName' => 'Illuminate\\Testing\\TestResponse',
        'currentClassName' => 'Illuminate\\Testing\\TestResponse',
        'aliasName' => NULL,
      ),
      'assertOnlyInvalid' => 
      array (
        'name' => 'assertOnlyInvalid',
        'parameters' => 
        array (
          'errors' => 
          array (
            'name' => 'errors',
            'default' => 
            array (
              'code' => 'null',
              'attributes' => 
              array (
                'startLine' => 1506,
                'endLine' => 1506,
                'startTokenPos' => 6737,
                'startFilePos' => 43547,
                'endTokenPos' => 6737,
                'endFilePos' => 43550,
              ),
            ),
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 1506,
            'endLine' => 1506,
            'startColumn' => 39,
            'endColumn' => 52,
            'parameterIndex' => 0,
            'isOptional' => true,
          ),
          'errorBag' => 
          array (
            'name' => 'errorBag',
            'default' => 
            array (
              'code' => '\'default\'',
              'attributes' => 
              array (
                'startLine' => 1506,
                'endLine' => 1506,
                'startTokenPos' => 6744,
                'startFilePos' => 43565,
                'endTokenPos' => 6744,
                'endFilePos' => 43573,
              ),
            ),
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 1506,
            'endLine' => 1506,
            'startColumn' => 55,
            'endColumn' => 75,
            'parameterIndex' => 1,
            'isOptional' => true,
          ),
          'responseKey' => 
          array (
            'name' => 'responseKey',
            'default' => 
            array (
              'code' => '\'errors\'',
              'attributes' => 
              array (
                'startLine' => 1506,
                'endLine' => 1506,
                'startTokenPos' => 6751,
                'startFilePos' => 43591,
                'endTokenPos' => 6751,
                'endFilePos' => 43598,
              ),
            ),
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 1506,
            'endLine' => 1506,
            'startColumn' => 78,
            'endColumn' => 100,
            'parameterIndex' => 2,
            'isOptional' => true,
          ),
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Assert that the response has the given validation errors but does not have any other validation errors.
 *
 * @param  string|array|null  $errors
 * @param  string  $errorBag
 * @param  string  $responseKey
 * @return $this
 */',
        'startLine' => 1506,
        'endLine' => 1530,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Illuminate\\Testing',
        'declaringClassName' => 'Illuminate\\Testing\\TestResponse',
        'implementingClassName' => 'Illuminate\\Testing\\TestResponse',
        'currentClassName' => 'Illuminate\\Testing\\TestResponse',
        'aliasName' => NULL,
      ),
      'assertSessionHas' => 
      array (
        'name' => 'assertSessionHas',
        'parameters' => 
        array (
          'key' => 
          array (
            'name' => 'key',
            'default' => NULL,
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 1539,
            'endLine' => 1539,
            'startColumn' => 38,
            'endColumn' => 41,
            'parameterIndex' => 0,
            'isOptional' => false,
          ),
          'value' => 
          array (
            'name' => 'value',
            'default' => 
            array (
              'code' => 'null',
              'attributes' => 
              array (
                'startLine' => 1539,
                'endLine' => 1539,
                'startTokenPos' => 6973,
                'startFilePos' => 44671,
                'endTokenPos' => 6973,
                'endFilePos' => 44674,
              ),
            ),
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 1539,
            'endLine' => 1539,
            'startColumn' => 44,
            'endColumn' => 56,
            'parameterIndex' => 1,
            'isOptional' => true,
          ),
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Assert that the session has a given value.
 *
 * @param  string|array  $key
 * @param  mixed  $value
 * @return $this
 */',
        'startLine' => 1539,
        'endLine' => 1557,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Illuminate\\Testing',
        'declaringClassName' => 'Illuminate\\Testing\\TestResponse',
        'implementingClassName' => 'Illuminate\\Testing\\TestResponse',
        'currentClassName' => 'Illuminate\\Testing\\TestResponse',
        'aliasName' => NULL,
      ),
      'assertSessionHasAll' => 
      array (
        'name' => 'assertSessionHasAll',
        'parameters' => 
        array (
          'bindings' => 
          array (
            'name' => 'bindings',
            'default' => NULL,
            'type' => 
            array (
              'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
              'data' => 
              array (
                'name' => 'array',
                'isIdentifier' => true,
              ),
            ),
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 1565,
            'endLine' => 1565,
            'startColumn' => 41,
            'endColumn' => 55,
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
 * Assert that the session has a given list of values.
 *
 * @param  array  $bindings
 * @return $this
 */',
        'startLine' => 1565,
        'endLine' => 1586,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Illuminate\\Testing',
        'declaringClassName' => 'Illuminate\\Testing\\TestResponse',
        'implementingClassName' => 'Illuminate\\Testing\\TestResponse',
        'currentClassName' => 'Illuminate\\Testing\\TestResponse',
        'aliasName' => NULL,
      ),
      'assertSessionHasInput' => 
      array (
        'name' => 'assertSessionHasInput',
        'parameters' => 
        array (
          'key' => 
          array (
            'name' => 'key',
            'default' => NULL,
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 1595,
            'endLine' => 1595,
            'startColumn' => 43,
            'endColumn' => 46,
            'parameterIndex' => 0,
            'isOptional' => false,
          ),
          'value' => 
          array (
            'name' => 'value',
            'default' => 
            array (
              'code' => 'null',
              'attributes' => 
              array (
                'startLine' => 1595,
                'endLine' => 1595,
                'startTokenPos' => 7307,
                'startFilePos' => 46290,
                'endTokenPos' => 7307,
                'endFilePos' => 46293,
              ),
            ),
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 1595,
            'endLine' => 1595,
            'startColumn' => 49,
            'endColumn' => 61,
            'parameterIndex' => 1,
            'isOptional' => true,
          ),
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Assert that the session has a given value in the flashed input array.
 *
 * @param  string|array  $key
 * @param  mixed  $value
 * @return $this
 */',
        'startLine' => 1595,
        'endLine' => 1621,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Illuminate\\Testing',
        'declaringClassName' => 'Illuminate\\Testing\\TestResponse',
        'implementingClassName' => 'Illuminate\\Testing\\TestResponse',
        'currentClassName' => 'Illuminate\\Testing\\TestResponse',
        'aliasName' => NULL,
      ),
      'assertSessionHasErrors' => 
      array (
        'name' => 'assertSessionHasErrors',
        'parameters' => 
        array (
          'keys' => 
          array (
            'name' => 'keys',
            'default' => 
            array (
              'code' => '[]',
              'attributes' => 
              array (
                'startLine' => 1631,
                'endLine' => 1631,
                'startTokenPos' => 7521,
                'startFilePos' => 47377,
                'endTokenPos' => 7522,
                'endFilePos' => 47378,
              ),
            ),
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 1631,
            'endLine' => 1631,
            'startColumn' => 44,
            'endColumn' => 53,
            'parameterIndex' => 0,
            'isOptional' => true,
          ),
          'format' => 
          array (
            'name' => 'format',
            'default' => 
            array (
              'code' => 'null',
              'attributes' => 
              array (
                'startLine' => 1631,
                'endLine' => 1631,
                'startTokenPos' => 7529,
                'startFilePos' => 47391,
                'endTokenPos' => 7529,
                'endFilePos' => 47394,
              ),
            ),
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 1631,
            'endLine' => 1631,
            'startColumn' => 56,
            'endColumn' => 69,
            'parameterIndex' => 1,
            'isOptional' => true,
          ),
          'errorBag' => 
          array (
            'name' => 'errorBag',
            'default' => 
            array (
              'code' => '\'default\'',
              'attributes' => 
              array (
                'startLine' => 1631,
                'endLine' => 1631,
                'startTokenPos' => 7536,
                'startFilePos' => 47409,
                'endTokenPos' => 7536,
                'endFilePos' => 47417,
              ),
            ),
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 1631,
            'endLine' => 1631,
            'startColumn' => 72,
            'endColumn' => 92,
            'parameterIndex' => 2,
            'isOptional' => true,
          ),
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Assert that the session has the given errors.
 *
 * @param  string|array  $keys
 * @param  mixed  $format
 * @param  string  $errorBag
 * @return $this
 */',
        'startLine' => 1631,
        'endLine' => 1648,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Illuminate\\Testing',
        'declaringClassName' => 'Illuminate\\Testing\\TestResponse',
        'implementingClassName' => 'Illuminate\\Testing\\TestResponse',
        'currentClassName' => 'Illuminate\\Testing\\TestResponse',
        'aliasName' => NULL,
      ),
      'assertSessionDoesntHaveErrors' => 
      array (
        'name' => 'assertSessionDoesntHaveErrors',
        'parameters' => 
        array (
          'keys' => 
          array (
            'name' => 'keys',
            'default' => 
            array (
              'code' => '[]',
              'attributes' => 
              array (
                'startLine' => 1658,
                'endLine' => 1658,
                'startTokenPos' => 7696,
                'startFilePos' => 48238,
                'endTokenPos' => 7697,
                'endFilePos' => 48239,
              ),
            ),
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 1658,
            'endLine' => 1658,
            'startColumn' => 51,
            'endColumn' => 60,
            'parameterIndex' => 0,
            'isOptional' => true,
          ),
          'format' => 
          array (
            'name' => 'format',
            'default' => 
            array (
              'code' => 'null',
              'attributes' => 
              array (
                'startLine' => 1658,
                'endLine' => 1658,
                'startTokenPos' => 7704,
                'startFilePos' => 48252,
                'endTokenPos' => 7704,
                'endFilePos' => 48255,
              ),
            ),
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 1658,
            'endLine' => 1658,
            'startColumn' => 63,
            'endColumn' => 76,
            'parameterIndex' => 1,
            'isOptional' => true,
          ),
          'errorBag' => 
          array (
            'name' => 'errorBag',
            'default' => 
            array (
              'code' => '\'default\'',
              'attributes' => 
              array (
                'startLine' => 1658,
                'endLine' => 1658,
                'startTokenPos' => 7711,
                'startFilePos' => 48270,
                'endTokenPos' => 7711,
                'endFilePos' => 48278,
              ),
            ),
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 1658,
            'endLine' => 1658,
            'startColumn' => 79,
            'endColumn' => 99,
            'parameterIndex' => 2,
            'isOptional' => true,
          ),
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Assert that the session is missing the given errors.
 *
 * @param  string|array  $keys
 * @param  string|null  $format
 * @param  string  $errorBag
 * @return $this
 */',
        'startLine' => 1658,
        'endLine' => 1683,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Illuminate\\Testing',
        'declaringClassName' => 'Illuminate\\Testing\\TestResponse',
        'implementingClassName' => 'Illuminate\\Testing\\TestResponse',
        'currentClassName' => 'Illuminate\\Testing\\TestResponse',
        'aliasName' => NULL,
      ),
      'assertSessionHasNoErrors' => 
      array (
        'name' => 'assertSessionHasNoErrors',
        'parameters' => 
        array (
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Assert that the session has no errors.
 *
 * @return $this
 */',
        'startLine' => 1690,
        'endLine' => 1715,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Illuminate\\Testing',
        'declaringClassName' => 'Illuminate\\Testing\\TestResponse',
        'implementingClassName' => 'Illuminate\\Testing\\TestResponse',
        'currentClassName' => 'Illuminate\\Testing\\TestResponse',
        'aliasName' => NULL,
      ),
      'assertSessionHasErrorsIn' => 
      array (
        'name' => 'assertSessionHasErrorsIn',
        'parameters' => 
        array (
          'errorBag' => 
          array (
            'name' => 'errorBag',
            'default' => NULL,
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 1725,
            'endLine' => 1725,
            'startColumn' => 46,
            'endColumn' => 54,
            'parameterIndex' => 0,
            'isOptional' => false,
          ),
          'keys' => 
          array (
            'name' => 'keys',
            'default' => 
            array (
              'code' => '[]',
              'attributes' => 
              array (
                'startLine' => 1725,
                'endLine' => 1725,
                'startTokenPos' => 8116,
                'startFilePos' => 50296,
                'endTokenPos' => 8117,
                'endFilePos' => 50297,
              ),
            ),
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 1725,
            'endLine' => 1725,
            'startColumn' => 57,
            'endColumn' => 66,
            'parameterIndex' => 1,
            'isOptional' => true,
          ),
          'format' => 
          array (
            'name' => 'format',
            'default' => 
            array (
              'code' => 'null',
              'attributes' => 
              array (
                'startLine' => 1725,
                'endLine' => 1725,
                'startTokenPos' => 8124,
                'startFilePos' => 50310,
                'endTokenPos' => 8124,
                'endFilePos' => 50313,
              ),
            ),
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 1725,
            'endLine' => 1725,
            'startColumn' => 69,
            'endColumn' => 82,
            'parameterIndex' => 2,
            'isOptional' => true,
          ),
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Assert that the session has the given errors.
 *
 * @param  string  $errorBag
 * @param  string|array  $keys
 * @param  mixed  $format
 * @return $this
 */',
        'startLine' => 1725,
        'endLine' => 1728,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Illuminate\\Testing',
        'declaringClassName' => 'Illuminate\\Testing\\TestResponse',
        'implementingClassName' => 'Illuminate\\Testing\\TestResponse',
        'currentClassName' => 'Illuminate\\Testing\\TestResponse',
        'aliasName' => NULL,
      ),
      'assertSessionMissing' => 
      array (
        'name' => 'assertSessionMissing',
        'parameters' => 
        array (
          'key' => 
          array (
            'name' => 'key',
            'default' => NULL,
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 1737,
            'endLine' => 1737,
            'startColumn' => 42,
            'endColumn' => 45,
            'parameterIndex' => 0,
            'isOptional' => false,
          ),
          'value' => 
          array (
            'name' => 'value',
            'default' => 
            array (
              'code' => 'null',
              'attributes' => 
              array (
                'startLine' => 1737,
                'endLine' => 1737,
                'startTokenPos' => 8162,
                'startFilePos' => 50623,
                'endTokenPos' => 8162,
                'endFilePos' => 50626,
              ),
            ),
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 1737,
            'endLine' => 1737,
            'startColumn' => 48,
            'endColumn' => 60,
            'parameterIndex' => 1,
            'isOptional' => true,
          ),
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Assert that the session does not have a given key.
 *
 * @param  string|array  $key
 * @param  mixed  $value
 * @return $this
 */',
        'startLine' => 1737,
        'endLine' => 1759,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Illuminate\\Testing',
        'declaringClassName' => 'Illuminate\\Testing\\TestResponse',
        'implementingClassName' => 'Illuminate\\Testing\\TestResponse',
        'currentClassName' => 'Illuminate\\Testing\\TestResponse',
        'aliasName' => NULL,
      ),
      'session' => 
      array (
        'name' => 'session',
        'parameters' => 
        array (
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Get the current session store.
 *
 * @return \\Illuminate\\Session\\Store
 */',
        'startLine' => 1766,
        'endLine' => 1775,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 2,
        'namespace' => 'Illuminate\\Testing',
        'declaringClassName' => 'Illuminate\\Testing\\TestResponse',
        'implementingClassName' => 'Illuminate\\Testing\\TestResponse',
        'currentClassName' => 'Illuminate\\Testing\\TestResponse',
        'aliasName' => NULL,
      ),
      'ddHeaders' => 
      array (
        'name' => 'ddHeaders',
        'parameters' => 
        array (
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Dump the headers from the response and end the script.
 *
 * @return never
 */',
        'startLine' => 1782,
        'endLine' => 1787,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Illuminate\\Testing',
        'declaringClassName' => 'Illuminate\\Testing\\TestResponse',
        'implementingClassName' => 'Illuminate\\Testing\\TestResponse',
        'currentClassName' => 'Illuminate\\Testing\\TestResponse',
        'aliasName' => NULL,
      ),
      'ddBody' => 
      array (
        'name' => 'ddBody',
        'parameters' => 
        array (
          'key' => 
          array (
            'name' => 'key',
            'default' => 
            array (
              'code' => 'null',
              'attributes' => 
              array (
                'startLine' => 1795,
                'endLine' => 1795,
                'startTokenPos' => 8421,
                'startFilePos' => 51965,
                'endTokenPos' => 8421,
                'endFilePos' => 51968,
              ),
            ),
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 1795,
            'endLine' => 1795,
            'startColumn' => 28,
            'endColumn' => 38,
            'parameterIndex' => 0,
            'isOptional' => true,
          ),
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Dump the body of the response and end the script.
 *
 * @param  string|null  $key
 * @return never
 */',
        'startLine' => 1795,
        'endLine' => 1804,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Illuminate\\Testing',
        'declaringClassName' => 'Illuminate\\Testing\\TestResponse',
        'implementingClassName' => 'Illuminate\\Testing\\TestResponse',
        'currentClassName' => 'Illuminate\\Testing\\TestResponse',
        'aliasName' => NULL,
      ),
      'ddJson' => 
      array (
        'name' => 'ddJson',
        'parameters' => 
        array (
          'key' => 
          array (
            'name' => 'key',
            'default' => 
            array (
              'code' => 'null',
              'attributes' => 
              array (
                'startLine' => 1812,
                'endLine' => 1812,
                'startTokenPos' => 8478,
                'startFilePos' => 52305,
                'endTokenPos' => 8478,
                'endFilePos' => 52308,
              ),
            ),
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 1812,
            'endLine' => 1812,
            'startColumn' => 28,
            'endColumn' => 38,
            'parameterIndex' => 0,
            'isOptional' => true,
          ),
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Dump the JSON payload from the response and end the script.
 *
 * @param  string|null  $key
 * @return never
 */',
        'startLine' => 1812,
        'endLine' => 1815,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Illuminate\\Testing',
        'declaringClassName' => 'Illuminate\\Testing\\TestResponse',
        'implementingClassName' => 'Illuminate\\Testing\\TestResponse',
        'currentClassName' => 'Illuminate\\Testing\\TestResponse',
        'aliasName' => NULL,
      ),
      'ddSession' => 
      array (
        'name' => 'ddSession',
        'parameters' => 
        array (
          'keys' => 
          array (
            'name' => 'keys',
            'default' => 
            array (
              'code' => '[]',
              'attributes' => 
              array (
                'startLine' => 1823,
                'endLine' => 1823,
                'startTokenPos' => 8508,
                'startFilePos' => 52534,
                'endTokenPos' => 8509,
                'endFilePos' => 52535,
              ),
            ),
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 1823,
            'endLine' => 1823,
            'startColumn' => 31,
            'endColumn' => 40,
            'parameterIndex' => 0,
            'isOptional' => true,
          ),
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Dump the session from the response and end the script.
 *
 * @param  string|array  $keys
 * @return never
 */',
        'startLine' => 1823,
        'endLine' => 1828,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Illuminate\\Testing',
        'declaringClassName' => 'Illuminate\\Testing\\TestResponse',
        'implementingClassName' => 'Illuminate\\Testing\\TestResponse',
        'currentClassName' => 'Illuminate\\Testing\\TestResponse',
        'aliasName' => NULL,
      ),
      'dump' => 
      array (
        'name' => 'dump',
        'parameters' => 
        array (
          'key' => 
          array (
            'name' => 'key',
            'default' => 
            array (
              'code' => 'null',
              'attributes' => 
              array (
                'startLine' => 1836,
                'endLine' => 1836,
                'startTokenPos' => 8542,
                'startFilePos' => 52756,
                'endTokenPos' => 8542,
                'endFilePos' => 52759,
              ),
            ),
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 1836,
            'endLine' => 1836,
            'startColumn' => 26,
            'endColumn' => 36,
            'parameterIndex' => 0,
            'isOptional' => true,
          ),
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Dump the content from the response.
 *
 * @param  string|null  $key
 * @return $this
 */',
        'startLine' => 1836,
        'endLine' => 1853,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Illuminate\\Testing',
        'declaringClassName' => 'Illuminate\\Testing\\TestResponse',
        'implementingClassName' => 'Illuminate\\Testing\\TestResponse',
        'currentClassName' => 'Illuminate\\Testing\\TestResponse',
        'aliasName' => NULL,
      ),
      'dumpHeaders' => 
      array (
        'name' => 'dumpHeaders',
        'parameters' => 
        array (
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Dump the headers from the response.
 *
 * @return $this
 */',
        'startLine' => 1860,
        'endLine' => 1865,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Illuminate\\Testing',
        'declaringClassName' => 'Illuminate\\Testing\\TestResponse',
        'implementingClassName' => 'Illuminate\\Testing\\TestResponse',
        'currentClassName' => 'Illuminate\\Testing\\TestResponse',
        'aliasName' => NULL,
      ),
      'dumpSession' => 
      array (
        'name' => 'dumpSession',
        'parameters' => 
        array (
          'keys' => 
          array (
            'name' => 'keys',
            'default' => 
            array (
              'code' => '[]',
              'attributes' => 
              array (
                'startLine' => 1873,
                'endLine' => 1873,
                'startTokenPos' => 8680,
                'startFilePos' => 53459,
                'endTokenPos' => 8681,
                'endFilePos' => 53460,
              ),
            ),
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 1873,
            'endLine' => 1873,
            'startColumn' => 33,
            'endColumn' => 42,
            'parameterIndex' => 0,
            'isOptional' => true,
          ),
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Dump the session from the response.
 *
 * @param  string|array  $keys
 * @return $this
 */',
        'startLine' => 1873,
        'endLine' => 1884,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Illuminate\\Testing',
        'declaringClassName' => 'Illuminate\\Testing\\TestResponse',
        'implementingClassName' => 'Illuminate\\Testing\\TestResponse',
        'currentClassName' => 'Illuminate\\Testing\\TestResponse',
        'aliasName' => NULL,
      ),
      'streamedContent' => 
      array (
        'name' => 'streamedContent',
        'parameters' => 
        array (
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Get the streamed content from the response.
 *
 * @return string
 */',
        'startLine' => 1891,
        'endLine' => 1913,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Illuminate\\Testing',
        'declaringClassName' => 'Illuminate\\Testing\\TestResponse',
        'implementingClassName' => 'Illuminate\\Testing\\TestResponse',
        'currentClassName' => 'Illuminate\\Testing\\TestResponse',
        'aliasName' => NULL,
      ),
      'withExceptions' => 
      array (
        'name' => 'withExceptions',
        'parameters' => 
        array (
          'exceptions' => 
          array (
            'name' => 'exceptions',
            'default' => NULL,
            'type' => 
            array (
              'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
              'data' => 
              array (
                'name' => 'Illuminate\\Support\\Collection',
                'isIdentifier' => false,
              ),
            ),
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 1921,
            'endLine' => 1921,
            'startColumn' => 36,
            'endColumn' => 57,
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
 * Set the previous exceptions on the response.
 *
 * @param  \\Illuminate\\Support\\Collection  $exceptions
 * @return $this
 */',
        'startLine' => 1921,
        'endLine' => 1926,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Illuminate\\Testing',
        'declaringClassName' => 'Illuminate\\Testing\\TestResponse',
        'implementingClassName' => 'Illuminate\\Testing\\TestResponse',
        'currentClassName' => 'Illuminate\\Testing\\TestResponse',
        'aliasName' => NULL,
      ),
      '__get' => 
      array (
        'name' => '__get',
        'parameters' => 
        array (
          'key' => 
          array (
            'name' => 'key',
            'default' => NULL,
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 1934,
            'endLine' => 1934,
            'startColumn' => 27,
            'endColumn' => 30,
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
 * Dynamically access base response parameters.
 *
 * @param  string  $key
 * @return mixed
 */',
        'startLine' => 1934,
        'endLine' => 1937,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Illuminate\\Testing',
        'declaringClassName' => 'Illuminate\\Testing\\TestResponse',
        'implementingClassName' => 'Illuminate\\Testing\\TestResponse',
        'currentClassName' => 'Illuminate\\Testing\\TestResponse',
        'aliasName' => NULL,
      ),
      '__isset' => 
      array (
        'name' => '__isset',
        'parameters' => 
        array (
          'key' => 
          array (
            'name' => 'key',
            'default' => NULL,
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 1945,
            'endLine' => 1945,
            'startColumn' => 29,
            'endColumn' => 32,
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
 * Proxy isset() checks to the underlying base response.
 *
 * @param  string  $key
 * @return bool
 */',
        'startLine' => 1945,
        'endLine' => 1948,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Illuminate\\Testing',
        'declaringClassName' => 'Illuminate\\Testing\\TestResponse',
        'implementingClassName' => 'Illuminate\\Testing\\TestResponse',
        'currentClassName' => 'Illuminate\\Testing\\TestResponse',
        'aliasName' => NULL,
      ),
      'offsetExists' => 
      array (
        'name' => 'offsetExists',
        'parameters' => 
        array (
          'offset' => 
          array (
            'name' => 'offset',
            'default' => NULL,
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 1956,
            'endLine' => 1956,
            'startColumn' => 34,
            'endColumn' => 40,
            'parameterIndex' => 0,
            'isOptional' => false,
          ),
        ),
        'returnsReference' => false,
        'returnType' => 
        array (
          'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
          'data' => 
          array (
            'name' => 'bool',
            'isIdentifier' => true,
          ),
        ),
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Determine if the given offset exists.
 *
 * @param  string  $offset
 * @return bool
 */',
        'startLine' => 1956,
        'endLine' => 1961,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Illuminate\\Testing',
        'declaringClassName' => 'Illuminate\\Testing\\TestResponse',
        'implementingClassName' => 'Illuminate\\Testing\\TestResponse',
        'currentClassName' => 'Illuminate\\Testing\\TestResponse',
        'aliasName' => NULL,
      ),
      'offsetGet' => 
      array (
        'name' => 'offsetGet',
        'parameters' => 
        array (
          'offset' => 
          array (
            'name' => 'offset',
            'default' => NULL,
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 1969,
            'endLine' => 1969,
            'startColumn' => 31,
            'endColumn' => 37,
            'parameterIndex' => 0,
            'isOptional' => false,
          ),
        ),
        'returnsReference' => false,
        'returnType' => 
        array (
          'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
          'data' => 
          array (
            'name' => 'mixed',
            'isIdentifier' => true,
          ),
        ),
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Get the value for a given offset.
 *
 * @param  string  $offset
 * @return mixed
 */',
        'startLine' => 1969,
        'endLine' => 1974,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Illuminate\\Testing',
        'declaringClassName' => 'Illuminate\\Testing\\TestResponse',
        'implementingClassName' => 'Illuminate\\Testing\\TestResponse',
        'currentClassName' => 'Illuminate\\Testing\\TestResponse',
        'aliasName' => NULL,
      ),
      'offsetSet' => 
      array (
        'name' => 'offsetSet',
        'parameters' => 
        array (
          'offset' => 
          array (
            'name' => 'offset',
            'default' => NULL,
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 1985,
            'endLine' => 1985,
            'startColumn' => 31,
            'endColumn' => 37,
            'parameterIndex' => 0,
            'isOptional' => false,
          ),
          'value' => 
          array (
            'name' => 'value',
            'default' => NULL,
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 1985,
            'endLine' => 1985,
            'startColumn' => 40,
            'endColumn' => 45,
            'parameterIndex' => 1,
            'isOptional' => false,
          ),
        ),
        'returnsReference' => false,
        'returnType' => 
        array (
          'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
          'data' => 
          array (
            'name' => 'void',
            'isIdentifier' => true,
          ),
        ),
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Set the value at the given offset.
 *
 * @param  string  $offset
 * @param  mixed  $value
 * @return void
 *
 * @throws \\LogicException
 */',
        'startLine' => 1985,
        'endLine' => 1988,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Illuminate\\Testing',
        'declaringClassName' => 'Illuminate\\Testing\\TestResponse',
        'implementingClassName' => 'Illuminate\\Testing\\TestResponse',
        'currentClassName' => 'Illuminate\\Testing\\TestResponse',
        'aliasName' => NULL,
      ),
      'offsetUnset' => 
      array (
        'name' => 'offsetUnset',
        'parameters' => 
        array (
          'offset' => 
          array (
            'name' => 'offset',
            'default' => NULL,
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 1998,
            'endLine' => 1998,
            'startColumn' => 33,
            'endColumn' => 39,
            'parameterIndex' => 0,
            'isOptional' => false,
          ),
        ),
        'returnsReference' => false,
        'returnType' => 
        array (
          'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
          'data' => 
          array (
            'name' => 'void',
            'isIdentifier' => true,
          ),
        ),
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Unset the value at the given offset.
 *
 * @param  string  $offset
 * @return void
 *
 * @throws \\LogicException
 */',
        'startLine' => 1998,
        'endLine' => 2001,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Illuminate\\Testing',
        'declaringClassName' => 'Illuminate\\Testing\\TestResponse',
        'implementingClassName' => 'Illuminate\\Testing\\TestResponse',
        'currentClassName' => 'Illuminate\\Testing\\TestResponse',
        'aliasName' => NULL,
      ),
      '__call' => 
      array (
        'name' => '__call',
        'parameters' => 
        array (
          'method' => 
          array (
            'name' => 'method',
            'default' => NULL,
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 2010,
            'endLine' => 2010,
            'startColumn' => 28,
            'endColumn' => 34,
            'parameterIndex' => 0,
            'isOptional' => false,
          ),
          'args' => 
          array (
            'name' => 'args',
            'default' => NULL,
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 2010,
            'endLine' => 2010,
            'startColumn' => 37,
            'endColumn' => 41,
            'parameterIndex' => 1,
            'isOptional' => false,
          ),
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Handle dynamic calls into macros or pass missing methods to the base response.
 *
 * @param  string  $method
 * @param  array  $args
 * @return mixed
 */',
        'startLine' => 2010,
        'endLine' => 2017,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Illuminate\\Testing',
        'declaringClassName' => 'Illuminate\\Testing\\TestResponse',
        'implementingClassName' => 'Illuminate\\Testing\\TestResponse',
        'currentClassName' => 'Illuminate\\Testing\\TestResponse',
        'aliasName' => NULL,
      ),
    ),
    'traitsData' => 
    array (
      'aliases' => 
      array (
        'Illuminate\\Testing\\Concerns\\AssertsStatusCodes' => 
        array (
          0 => 
          array (
            'alias' => 'macroCall',
            'method' => '__call',
            'hash' => 'illuminate\\testing\\concerns\\assertsstatuscodes::__call',
          ),
        ),
        'Illuminate\\Support\\Traits\\Conditionable' => 
        array (
          0 => 
          array (
            'alias' => 'macroCall',
            'method' => '__call',
            'hash' => 'illuminate\\support\\traits\\conditionable::__call',
          ),
        ),
        'Illuminate\\Support\\Traits\\Dumpable' => 
        array (
          0 => 
          array (
            'alias' => 'macroCall',
            'method' => '__call',
            'hash' => 'illuminate\\support\\traits\\dumpable::__call',
          ),
        ),
        'Illuminate\\Support\\Traits\\Tappable' => 
        array (
          0 => 
          array (
            'alias' => 'macroCall',
            'method' => '__call',
            'hash' => 'illuminate\\support\\traits\\tappable::__call',
          ),
        ),
        'Illuminate\\Support\\Traits\\Macroable' => 
        array (
          0 => 
          array (
            'alias' => 'macroCall',
            'method' => '__call',
            'hash' => 'illuminate\\support\\traits\\macroable::__call',
          ),
        ),
      ),
      'modifiers' => 
      array (
      ),
      'precedences' => 
      array (
      ),
      'hashes' => 
      array (
        'illuminate\\testing\\concerns\\assertsstatuscodes::__call' => 'Illuminate\\Testing\\Concerns\\AssertsStatusCodes::__call',
        'illuminate\\support\\traits\\conditionable::__call' => 'Illuminate\\Support\\Traits\\Conditionable::__call',
        'illuminate\\support\\traits\\dumpable::__call' => 'Illuminate\\Support\\Traits\\Dumpable::__call',
        'illuminate\\support\\traits\\tappable::__call' => 'Illuminate\\Support\\Traits\\Tappable::__call',
        'illuminate\\support\\traits\\macroable::__call' => 'Illuminate\\Support\\Traits\\Macroable::__call',
      ),
    ),
  ),
));