<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Base Site URL
|--------------------------------------------------------------------------
|
| URL to your CodeIgniter root. Typically this will be your base URL,
| WITH a trailing slash:
|
|       http://example.com/
|
*/

$config['recaptcha'] = array(
  'public'=>'6LfAEwsAAAAAAGUXvw4hCkTVtGk9COlu2mR1eUyv',
  'private'=>'6LfAEwsAAAAAAPa5Jxpoxn4Od2yROp03CLd6Pwak',
  'RECAPTCHA_API_SERVER' =>'http://api.recaptcha.net',
  'RECAPTCHA_API_SECURE_SERVER'=>'https://api-secure.recaptcha.net',
  'RECAPTCHA_VERIFY_SERVER' =>'api-verify.recaptcha.net',
  'theme' => 'red'
); 

/* End of file config.php */
/* Location: ./system/application/config/config.php */
