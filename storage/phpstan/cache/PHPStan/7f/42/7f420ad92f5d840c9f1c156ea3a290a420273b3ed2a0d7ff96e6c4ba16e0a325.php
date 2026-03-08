<?php declare(strict_types = 1);

// odsl-/var/www/html/tests/Feature/Api
return \PHPStan\Cache\CacheItem::__set_state(array(
   'variableKey' => 'v1-enums',
   'data' => 
  array (
    '/var/www/html/tests/Feature/Api/AuthApiTest.php' => 
    array (
      0 => 'dfcf7a5cc56d12af63cb151c8cf4006c39af791f7c921df85aaefc1394a8c6e4',
      1 => 
      array (
        0 => 'tests\\feature\\api\\authapitest',
      ),
      2 => 
      array (
        0 => 'tests\\feature\\api\\test_register_returns_token_and_user_payload',
        1 => 'tests\\feature\\api\\test_login_me_and_logout_work_with_sanctum_token',
        2 => 'tests\\feature\\api\\test_login_rejects_invalid_credentials',
      ),
      3 => 
      array (
      ),
    ),
    '/var/www/html/tests/Feature/Api/BasketApiTest.php' => 
    array (
      0 => '996839868a29a1b566d2199b71052b395f932faed8f93e73ec4abed737b9e86d',
      1 => 
      array (
        0 => 'tests\\feature\\api\\basketapitest',
      ),
      2 => 
      array (
        0 => 'tests\\feature\\api\\test_add_item_endpoint_creates_basket_and_returns_payload',
        1 => 'tests\\feature\\api\\test_show_update_and_remove_basket_item',
        2 => 'tests\\feature\\api\\test_checkout_endpoint_creates_order_and_clears_basket',
        3 => 'tests\\feature\\api\\createproduct',
      ),
      3 => 
      array (
      ),
    ),
    '/var/www/html/tests/Feature/Api/CatalogApiTest.php' => 
    array (
      0 => 'ceebf351b80fba0aa610910e3528f58783ce5a8f26274dbc1a69f3758381733b',
      1 => 
      array (
        0 => 'tests\\feature\\api\\catalogapitest',
      ),
      2 => 
      array (
        0 => 'tests\\feature\\api\\test_catalog_index_returns_categories_and_brands',
        1 => 'tests\\feature\\api\\test_category_endpoint_returns_paginated_products',
        2 => 'tests\\feature\\api\\test_brand_endpoint_returns_paginated_products',
        3 => 'tests\\feature\\api\\test_product_endpoint_returns_product_detail',
      ),
      3 => 
      array (
      ),
    ),
    '/var/www/html/tests/Feature/Api/OrderApiTest.php' => 
    array (
      0 => '27a1e7ea5f8f85610d727317578684e72459f77970dd093ab446f8a413a81019',
      1 => 
      array (
        0 => 'tests\\feature\\api\\orderapitest',
      ),
      2 => 
      array (
        0 => 'tests\\feature\\api\\test_unauthenticated_user_cannot_access_orders',
        1 => 'tests\\feature\\api\\test_index_returns_only_authenticated_users_orders',
        2 => 'tests\\feature\\api\\test_show_returns_only_owned_order_details',
        3 => 'tests\\feature\\api\\createorderforuser',
      ),
      3 => 
      array (
      ),
    ),
    '/var/www/html/tests/Feature/Api/ProfileApiTest.php' => 
    array (
      0 => 'ff9394cdf15b57f252fd5eb4d2566873090447de5117510a4a6271d886294abe',
      1 => 
      array (
        0 => 'tests\\feature\\api\\profileapitest',
      ),
      2 => 
      array (
        0 => 'tests\\feature\\api\\test_unauthenticated_user_cannot_access_profiles',
        1 => 'tests\\feature\\api\\test_index_returns_only_authenticated_users_profiles',
        2 => 'tests\\feature\\api\\test_store_ignores_client_side_user_id',
        3 => 'tests\\feature\\api\\test_foreign_profile_is_not_accessible',
      ),
      3 => 
      array (
      ),
    ),
  ),
));