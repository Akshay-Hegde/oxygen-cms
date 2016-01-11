<?php defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Number of Links
|--------------------------------------------------------------------------
|
| How many links should be output for pagination.
|
*/
$config['num_links'] = 8;

/*
|--------------------------------------------------------------------------
| Tags
|--------------------------------------------------------------------------
|
| Control the HTML that gets wrapped around pagination.
|
*/
 
 



$config['full_tag_open'] = '<div class="pagination"><ul class="pagination">';
$config['full_tag_close'] = '</ul></div>';

$config['first_link'] = '&lt;&lt;';
$config['first_tag_open'] = '<li class="first">';
$config['first_tag_close'] = '</li>';

$config['prev_link'] = '&larr;';
$config['prev_tag_open'] = '<li id="" class="paginate_button previous">';
$config['prev_tag_close'] = '</li>';

$config['cur_tag_open'] = '<li class="paginate_button active"><a name="a">';
$config['cur_tag_close'] = '</a></li>';

$config['num_tag_open'] = '<li class="paginate_button">';
$config['num_tag_close'] = '</li>';

$config['next_link'] = '&rarr;';
$config['next_tag_open'] = '<li id="example2_next" class="paginate_button next">';
$config['next_tag_close'] = '</li>';

$config['last_link'] = '&gt;&gt;';
$config['last_tag_open'] = '<li class="last">';
$config['last_tag_close'] = '</li>';

/* End of file pagination.php */