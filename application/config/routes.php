<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'Barang/index';


$route['barang'] = 'Barang/index';

$route['(:any)'] = 'gagal/index/$1';
$route['404_override'] = 'Gagal/index';
$route['translate_uri_dashes'] = FALSE;