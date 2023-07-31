<?php

defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'login';

// Load default conrtoller when have only currency from multilanguage
$route['^(\w{2})$'] = $route['default_controller'];

/*
 * Admin Controllers Routes
 */
$route['admin'] = "admin/home/login";
$route['admin/home'] = "admin/home/home";
$route['admin/publish'] = "admin/manage_product/publish";
$route['admin/publish/(:num)'] = "admin/manage_product/publish/index/$1";
$route['admin/products'] = "admin/manage_product/products";
$route['admin/products/(:num)'] = "admin/manage_product/products/index/$1";
$route['admin/categories'] = "admin/manage_product/Categories";
$route['admin/categories/(:num)'] = "admin/manage_product/Categories/index/$1";
$route['admin/orders'] = "admin/manage_order/orders";
$route['admin/orders/(:num)'] = "admin/manage_order/orders/index/$1";
$route['admin/addattach'] = "admin/manage_attach/addattach";
$route['admin/addattach/(:num)'] = "admin/manage_attach/addattach/index/$1";
$route['admin/attachs'] = "admin/manage_attach/attachs";
$route['admin/attachs/(:num)'] = "admin/manage_attach/attachs/index/$1";
$route['admin/attachStatusChange'] = "admin/manage_attach/attachs/attachStatusChange";
$route['admin/attachCategories'] = "admin/manage_attach/attachCategories";
$route['admin/attachCategories/(:num)'] = "admin/manage_attach/attachCategories/index/$1";
$route['admin/editAttachCategorie'] = "admin/manage_attach/attachCategories/editCategorie";
$route['admin/settings'] = "admin/settings/settings";
$route['admin/adminusers'] = "admin/manage_user/adminusers";
$route['admin/questionlist'] = "admin/manage_question/questionlist";
$route['admin/chat/(:num)'] = "admin/manage_question/chat/index/$1";
$route['admin/chat/insertNewMessage'] = "admin/manage_question/chat/insertNewMessage";
$route['admin/users'] = "admin/manage_user/users";
$route['admin/repairs'] = "admin/manage_order/repairs";
$route['admin/questions'] = "admin/manage_repeat/questions";
$route['admin/addquestion'] = "admin/manage_repeat/addquestion";
$route['admin/addquestion/(:num)'] = "admin/manage_repeat/addquestion/index/$1";
$route['admin/guides'] = "admin/manage_guide/guides";
$route['admin/addguide'] = "admin/manage_guide/addguide";
$route['admin/addguide/(:num)'] = "admin/manage_guide/addguide/index/$1";
$route['admin/uploadfile'] = "admin/manage_guide/addguide/uploadfile";
$route['admin/logout'] = "admin/home/home/logout";
$route['admin/changePass'] = "admin/home/home/changePass";

/*
  | -------------------------------------------------------------------------
  | REST API Routes
  | -------------------------------------------------------------------------
 */
$route['api/attachs/all_attachs/(:num)'] = 'Api/Attachs/all/$1';
$route['api/attachs/one_attach'] = 'Api/Attachs/one';
$route['api/attachs/create_attach'] = 'Api/Attachs/create';
$route['api/attachs/update_attach/(:num)'] = 'Api/Attachs/update/$1';
$route['api/attachs/delete_attach/(:num)'] = 'Api/Attachs/attachDel/$1';

$route['api/products/all_products/(:num)'] = 'Api/Products/all/$1';
$route['api/products/one_product'] = 'Api/Products/one';
$route['api/products/create_product'] = 'Api/Products/create';
$route['api/products/update_product/(:num)'] = 'Api/Products/update/$1';
$route['api/products/delete_product/(:num)'] = 'Api/Products/productDel/$1';

$route['api/guides/all_guides/(:num)'] = 'Api/Guides/all/$1';
$route['api/guides/one_guide'] = 'Api/Guides/one';
$route['api/guides/create_guide'] = 'Api/Guides/create';
$route['api/guides/update_guide/(:num)'] = 'Api/Guides/update/$1';
$route['api/guides/delete_guide/(:num)'] = 'Api/Guides/guideDel/$1';
$route['api/uploadfile'] = 'Api/Guides/uploadfile';

$route['api/categories/all_categories/(:num)'] = 'Api/Categories/all/$1';
$route['api/categories/create_category'] = 'Api/Categories/create';
$route['api/categories/delete_category/(:num)'] = 'Api/Categories/categoryDel/$1';

$route['api/attachs/all_categories/(:num)'] = 'Api/AttachCategories/all/$1';
$route['api/attachs/create_category'] = 'Api/AttachCategories/create';
$route['api/attachs/delete_category/(:num)'] = 'Api/AttachCategories/categoryDel/$1';

$route['api/questions/all_questions/(:num)'] = 'Api/Questions/all/$1';
$route['api/questions/one_question'] = 'Api/Questions/one';
$route['api/questions/create_question'] = 'Api/Questions/create';
$route['api/questions/update_question/(:num)'] = 'Api/Questions/update/$1';
$route['api/questions/delete_question/(:num)'] = 'Api/Questions/questionDel/$1';

$route['api/repeats/all_repeats/(:num)'] = 'Api/Repeats/all/$1';
$route['api/repeats/one_repeat'] = 'Api/Repeats/one';
$route['api/repeats/create_repeat'] = 'Api/Repeats/create';
$route['api/repeats/update_repeat/(:num)'] = 'Api/Repeats/update/$1';
$route['api/repeats/delete_repeat/(:num)'] = 'Api/Repeats/repeatDel/$1';

$route['api/users/all_users/(:num)'] = 'Api/Users/all/$1';
$route['api/users/one_user'] = 'Api/Users/one';
$route['api/users/create_user'] = 'Api/Users/create';
$route['api/users/update_user/(:num)'] = 'Api/Users/update/$1';
$route['api/users/delete_user/(:num)'] = 'Api/Users/userDel/$1';
$route['api/users/login'] = 'Api/Users/login';
$route['api/users/register'] = 'Api/Users/register';

$route['api/admin/login'] = 'Api/Admins/login';

$route['api/settings/all_settings'] = 'Api/Settings/all';
$route['api/settings/update_settings'] = 'Api/Settings/update';

$route['api/orders/all_orders/(:num)'] = 'Api/Orders/all/$1';
$route['api/orders/one_order'] = 'Api/Orders/one';
$route['api/orders/user_order'] = 'Api/Orders/user';
$route['api/orders/create_order'] = 'Api/Orders/create';
$route['api/orders/update_order/(:num)'] = 'Api/Orders/update/$1';
$route['api/orders/delete_order/(:num)'] = 'Api/Orders/orderDel/$1';

$route['api/repairs/all_repairs/(:num)'] = 'Api/Repairs/all/$1';
$route['api/repairs/one_repair'] = 'Api/Repairs/one';
$route['api/repairs/create_repair'] = 'Api/Repairs/create';
$route['api/repairs/update_repair/(:num)'] = 'Api/Repairs/update/$1';
$route['api/repairs/delete_repair/(:num)'] = 'Api/Repairs/repairDel/$1';

$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
