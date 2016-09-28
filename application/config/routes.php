<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/

$route['default_controller'] = 'home';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

//News routes
$route['news/create'] = 'news/create';
$route['news/(:any)'] = 'news/view/$1';
$route['news'] = 'news';

//Product routes
$route['product/create']        = 'product/create';
$route['product/edit/(:num)']   = 'product/edit/$1';
$route['product/delete/(:num)'] = 'product/delete/$1';
$route['product/datatable']     = 'product/datatable';
$route['product/(:any)']        = 'product/view/$1';
$route['product']               = 'product';

//Course routes
$route['course/create']        = 'course/create';
$route['course/edit/(:num)']   = 'course/edit/$1';
$route['course/delete/(:num)'] = 'course/delete/$1';
$route['course/(:any)']        = 'course/view/$1';
$route['course']               = 'course';

//Reward Program routes
$route['rewardprogram/create']        = 'rewardprogram/create';
$route['rewardprogram/edit/(:num)']   = 'rewardprogram/edit/$1';
$route['rewardprogram/delete/(:num)'] = 'rewardprogram/delete/$1';
$route['rewardprogram/programtype/(:num)']   = 'rewardprogram/programtype/$1'; //ajax route
$route['rewardprogram/programdesc/(:num)']   = 'rewardprogram/programdesc/$1'; //ajax route
$route['rewardprogram/programitem/(:num)']   = 'rewardprogram/programitem/$1'; //ajax route
$route['rewardprogram/programItemamount/(:num)/(:num)/(:num)']   = 'rewardprogram/programItemamount/$1/$2/$3'; //ajax route
$route['rewardprogram/programTotal/(:num)/(:num)/(:num)']   = 'rewardprogram/programTotal/$1/$2/$3'; //ajax route
$route['rewardprogram/(:any)']        = 'rewardprogram/view/$1';
$route['rewardprogram']               = 'rewardprogram';

//Users routes
$route['user/create']        = 'user/create';
$route['user/edit/(:num)']   = 'user/edit/$1';
$route['user/delete/(:num)'] = 'user/delete/$1';
$route['user/profile'] 		 = 'user/profile';
$route['user/(:any)']        = 'user/view/$1';
$route['user']               = 'user';

//User authentication routes
$route['login']        		  = 'userauth/index';
$route['login/(:any)']        = 'userauth/index';
$route['logout']   	   		  = 'userauth/logout';
$route['logout/(:any)']   	  = 'userauth/logout';

//Reward Request routes
$route['rewardrequest/create']        = 'rewardrequest/create';
$route['rewardrequest/edit/(:num)']   = 'rewardrequest/edit/$1';
$route['rewardrequest/delete/(:num)/(:num)'] = 'rewardrequest/delete/$1/$2';
$route['rewardrequest/approve/(:num)/(:num)'] = 'rewardrequest/approve/$1/$2';
$route['rewardrequest/deny/(:num)/(:num)'] = 'rewardrequest/deny/$1/$2';
$route['rewardrequest/destroy/(:num)/(:num)'] = 'rewardrequest/destroy/$1/$2';
$route['rewardrequest/reset/(:num)/(:num)'] = 'rewardrequest/reset/$1/$2';
$route['rewardrequest/(:any)']        = 'rewardrequest/view/$1';
$route['rewardrequest']               = 'rewardrequest';

//default 
$route['(:any)'] = 'home';