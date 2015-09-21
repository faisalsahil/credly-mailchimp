<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);
define('X_Api_Key', '27ba0bd3569d0589bb157b515482135b');
define('X_Api_Secret', 'vsBHtrqXCN1yoyjiSvMBHRKz5g2O4kg1xU5jBEAKZ42GoCGctE8JTzxZU2r2/U0F42FobEWnbRplrFIoMqPRnOncYjHVWXfack2kGe1mM/VVN+dEDS4B7GtG9lwbfPZVOrnZPfxnZJXVu+pj9NGvYpmQxqGg1Q+4LVn3LS568Ew=');


if ( !defined( 'BADGEOS_CREDLY_API_URL' ) )
	define( 'BADGEOS_CREDLY_API_URL', 'https://api.credly.com/v1.1/' );

// if ( !defined( 'BADGEOS_CREDLY_API_URL' ) )
// 	define( 'BADGEOS_CREDLY_API_URL', 'https://apistaging.credly.com/v0.2/' );

// if ( !defined( 'BASE_URL' ) )
// 	define( 'BASE_URL', 'http://clients.chimpchamp.com/credly/');

if ( !defined( 'BASE_URL' ) )
	define( 'BASE_URL', 'http://clients.chimpchamp.com/credly/' );

if ( !defined( 'IMAGETAG' ) )
	define( 'IMAGETAG', '<img width="180" height="180" alt="Save and Share" src="https://credly.com/addons/shared_addons/themes/credly/img/blank-badge-image.png"/>');


if ( !defined( 'SAVEANDSHAREURL' ) )
	define( 'SAVEANDSHAREURL', '<a target="_blank" href='.BASE_URL.'/acceptbadge"><img src="http://credlystatic.s3.amazonaws.com/emails/save_and_share.jpg" width="178" height="54" alt="Save and Share" border="0" style="display:block"></a>');



define('FOPEN_READ',							'rb');
define('FOPEN_READ_WRITE',						'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE',		'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE',	'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE',					'ab');
define('FOPEN_READ_WRITE_CREATE',				'a+b');
define('FOPEN_WRITE_CREATE_STRICT',				'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',		'x+b');


/* End of file constants.php */
/* Location: ./application/config/constants.php */