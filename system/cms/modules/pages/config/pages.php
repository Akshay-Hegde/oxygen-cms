<?php defined('BASEPATH') OR exit('No direct script access allowed');

//@deprecated
$config['pages:button_mode']	= 'simple'; /*advanced|simple*/


//
// Fields to add to the pages pool of fields
//
$config['pages:default_fields']	= 
[
	[
		'name'          => 'lang:pages:page_ref_id',
		'slug'          => 'page_ref_id',
		'namespace'     => 'pages',
		'type'          => 'integer',
		'extra'			=> ['max_length'=>11,'readonly'=>true,'uihidden'=>1],
		'locked'		=> true,
	],
	[
		'name'          => 'lang:pages:body_label',
		'slug'          => 'body',
		'namespace'     => 'pages',
		'type'          => 'wysiwyg',
		'extra'			=> ['editor_type' => 'simple', 'allow_tags' => 'y'],
		//'locked'		=> true,
		//'assign'        => 'page_type_standard'
	],
	[
		'name'          => 'lang:pages:success_send',
		'slug'          => 'success_send',
		'namespace'     => 'pages',
		'type'          => 'text',
		'extra'			=> array('max_length' => 255, 'allow_tags' => 'y'),
		//'locked'		=> true,
		//'assign'        => 'page_type_standard'
	],
	[
		'name'          => 'lang:pages:error_send',
		'slug'          => 'error_send',
		'namespace'     => 'pages',
		'type'          => 'text',
		'extra'			=> array('max_length' => 255, 'allow_tags' => 'y'),
		//'locked'		=> true,
		//'assign'        => 'page_type_standard'
	],	
];

// Some default data for the first pages
$config['pages:page_content'] = 
[
		/* The home page data. */
		'home' => 
		[
			'created' => date('Y-m-d H:i:s'),
			'body' => '<p>Welcome to our homepage. We have not quite finished setting up our website yet, but please add us to your bookmarks and come back soon.</p>',
			'created_by' => 1
		],
		'about' => 
		[
			'created' => date('Y-m-d H:i:s'),
			'body' => '<p>This is our about us page.</p>',
			'created_by' => 1
		],		
		/* The contact page data. */
		'contact' => 
		[
			'created' => date('Y-m-d H:i:s'),
			'body' => '<p>To contact us please fill out the form below.</p>',
			'error_send' => 'Something went wrong in sending the message.',
			'success_send' => 'Thankyou for contacting us.',
			'created_by' => 1
		],
		'fourohfour' => 
		[
			'created' => date('Y-m-d H:i:s'),
			'body' => '<p>oops! how embarrassing. It seems we cant find that page.</p>',
			'created_by' => 1
		],	
];

//
// List of default page streams
//
$config['pages:page_stream'] = 
[
	'home' 			=> 'page_type_standard',
	'about' 		=> 'page_type_standard',		
	'contact' 		=> 'page_type_contact',		 
	'fourohfour' 	=> 'page_type_404',		
];


