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
|	https://codeigniter.com/userguide3/general/routing.html
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
$route['default_controller'] = 'dashboard';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['login']                         = 'Login/index';
$route['login/proses']                  = 'Login/proses';
$route['login/register']                = 'Login/register';
$route['login/proses_register']         = 'Login/proses_register';
$route['logout']                        = 'Login/logout';

$route['proposal']                      = 'Proposal/index';
$route['proposal/buat']                 = 'Proposal/buat';
$route['proposal/edit/(:num)']          = 'Proposal/edit/$1';
$route['proposal/detail/(:num)']        = 'Proposal/detail/$1';
$route['proposal/hapus/(:num)']         = 'Proposal/hapus/$1';
$route['proposal/pdf/(:num)']           = 'Proposal/pdf/$1';

$route['proposal/simpan_draft']         = 'Proposal/simpan_draft';
$route['proposal/submit']               = 'Proposal/submit';
$route['proposal/upload_file']          = 'Proposal/upload_file';
$route['proposal/get_data_json']        = 'Proposal/get_data_json';

$route['proposal/setujui/(:num)']       = 'Proposal/setujui/$1';
$route['proposal/tolak/(:num)']         = 'Proposal/tolak/$1';
$route['proposal/pdf/(:num)']          = 'Proposal/pdf/$1';
$route['proposal/download_pdf/(:num)'] = 'Proposal/download_pdf/$1';
$route['admin']                       = 'admin/proposal';
$route['admin/dashboard']             = 'admin/dashboard';
// Admin routes
$route['admin/proposal'] = 'admin/proposal';
$route['admin/detail/(:num)'] = 'admin/detail/$1';
$route['admin/get_proposal_detail/(:num)'] = 'admin/get_proposal_detail/$1';
$route['admin/setujui/(:num)'] = 'admin/setujui/$1';
$route['admin/tolak/(:num)'] = 'admin/tolak/$1';

$route['berita'] = 'berita/index';
$route['berita/kategori/(:any)'] = 'berita/kategori/$1';
$route['berita/detail/(:any)'] = 'berita/detail/$1';
$route['berita/search'] = 'berita/search';
$route['berita/archive/([0-9]{4})/([0-9]{2})'] = 'berita/archive/$1/$2';
$route['berita/add_komentar'] = 'berita/add_komentar';
$route['berita/admin'] = 'berita/admin';
$route['berita/admin_list'] = 'berita/admin_list';
$route['berita/create'] = 'berita/create';
$route['berita/edit/(:num)'] = 'berita/edit/$1';
$route['berita/delete/(:num)'] = 'berita/delete/$1';
$route['berita/toggle_featured/(:num)'] = 'berita/toggle_featured/$1';
$route['berita/komentar'] = 'berita/komentar';
$route['berita/update_komentar/(:num)'] = 'berita/update_komentar/$1';
$route['berita/delete_komentar/(:num)'] = 'berita/delete_komentar/$1';

$route['beasiswa'] = 'beasiswa/index';
$route['beasiswa/submit'] = 'beasiswa/submit';
$route['beasiswa/status'] = 'beasiswa/status';
$route['beasiswa/cek_status'] = 'beasiswa/cek_status';
$route['beasiswa/download/(:num)'] = 'beasiswa/download/$1';

$route['login/register'] = 'Login/register';
$route['login/proses_register'] = 'Login/proses_register';

// Forum Routes
$route['forum_alumni'] = 'forum_alumni/index';
$route['forum_alumni/create_post'] = 'forum_alumni/create_post';
$route['forum_alumni/delete_post/(:num)'] = 'forum_alumni/delete_post/$1';
$route['forum_alumni/toggle_like'] = 'forum_alumni/toggle_like';
$route['forum_alumni/add_comment'] = 'forum_alumni/add_comment';
$route['forum_alumni/delete_comment'] = 'forum_alumni/delete_comment';
$route['forum_alumni/get_comments'] = 'forum_alumni/get_comments';
$route['forum_alumni/create'] = 'forum_alumni/create';
$route['forum_alumni/store'] = 'forum_alumni/store';
$route['forum_alumni/get_likes'] = 'forum_alumni/get_likes';

// Profile routes
$route['profile'] = 'profile/index';
$route['profile/edit'] = 'profile/edit';
$route['profile/update'] = 'profile/update';
$route['profile/update_ajax'] = 'profile/update_ajax';
$route['profile/update_photo'] = 'profile/update_photo';
$route['profile/update_photo_ajax'] = 'profile/update_photo_ajax';
$route['profile/change_password'] = 'profile/change_password';
$route['profile/change_password_ajax'] = 'profile/change_password_ajax';
$route['profile/delete_account'] = 'profile/delete_account';
$route['profile/get_activities'] = 'profile/get_activities';