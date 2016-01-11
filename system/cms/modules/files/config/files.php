<?php

// Provision for the installer
//if ( ! defined('SITE_DIR')) define('SITE_DIR', null);

$config['files:path'] = SITE_DIR.'files/';

$config['files:encrypt_filename'] = true;
/*
$config['files:allowed_file_ext'] = 
[
	'a'	=> ['mpga', 'mp2', 'mp3', 'ra', 'rv', 'wav'],
	'v'	=> ['mpeg', 'mpg', 'mpe', 'mp4', 'flv', 'qt', 'mov', 'avi', 'movie'],
	'd'	=> ['pdf', 'ppt', 'pptx', 'txt', 'text', 'log', 'rtx', 'rtf', 'word', 'csv', 'pages', 'numbers'],
	'i'	=> ['bmp', 'gif', 'jpeg', 'jpg', 'jpe', 'png', 'tiff', 'tif'],
	'o'	=> ['gtar', 'swf', 'tar', 'tgz', 'xhtml', 'zip', 'css', 'html', 'htm', 'shtml', 'svg'],
	'doc'=> ['doc', 'docx', 'dot'],
	'xl'=> ['xlsx', 'xl','xls'], 
	'xml'=> ['xml', 'xsl'], 
	'php'=> ['php', 'php5'],
	'psd'=> ['psd']
];
*/

$config['files:allowed_file_ext'] = array(
	'a'	=> array('mpga', 'mp2', 'mp3', 'ra', 'rv', 'wav'),
	'v'	=> array('mpeg', 'mpg', 'mpe', 'mp4', 'flv', 'qt', 'mov', 'avi', 'movie'),
	'd'	=> array('pdf', 'xls', 'ppt', 'pptx', 'txt', 'text', 'log', 'rtx', 'rtf', 'xml', 'xsl', 'doc', 'docx', 'xlsx', 'word', 'xl', 'csv', 'pages', 'numbers'),
	'i'	=> array('bmp', 'gif', 'jpeg', 'jpg', 'jpe', 'png', 'tiff', 'tif'),
	'o'	=> array('psd', 'gtar', 'swf', 'tar', 'tgz', 'xhtml', 'zip', 'css', 'html', 'htm', 'shtml', 'svg'),
);
