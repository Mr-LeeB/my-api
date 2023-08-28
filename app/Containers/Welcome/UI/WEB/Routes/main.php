<?php

$router->get('/', [
    'as'   => 'get_main_home_page',
    'uses' => 'Controller@sayWelcome',
]);

$router->get('/zns', [
    'as'   => 'get_zns_page',
    'uses' => 'Controller@getZnsPage',
]);