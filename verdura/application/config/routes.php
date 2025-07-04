<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'dashboard';
$route['login'] = 'auth/login';
$route['logout'] = 'auth/logout';
$route['register'] = 'auth/register';
$route['products'] = 'products/index';
$route['products/create'] = 'products/create';
$route['products/edit/(:num)'] = 'products/edit/$1';
$route['products/delete/(:num)'] = 'products/delete/$1';
$route['orders'] = 'orders/index';
$route['orders/create'] = 'orders/create';
$route['orders/history'] = 'orders/history';
$route['admin'] = 'admin/index';
$route['settings'] = 'settings/index';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
