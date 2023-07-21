<?php

$router->get('/userdashboard', [
  'as' => 'get_user_dashboard_page',
  'uses' => 'Controller@viewDashboardPage',
  'middleware' => [
    'auth:web',
  ],
]);