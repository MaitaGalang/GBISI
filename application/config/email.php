<?php defined('BASEPATH') OR exit('No direct script access allowed');

		$config['protocol'] = 'smtp'; // 'mail', 'sendmail', or 'smtp'
		$config['smtp_host'] = 'smtp.gmail.com'; 
		$config['smtp_port'] = 587;
		$config['smtp_user'] = 'myxwebportal@gmail.com';			
		$config['smtp_pass'] = 'hctdksdfqleixvtf';
		$config['smtp_auth'] = TRUE;
		$config['smtp_crypto'] = 'tls'; //can be 'ssl' or 'tls' for example
		$config['mailtype'] = 'html'; //plaintext 'text' mails or 'html'
		$config['smtp_timeout'] = '600'; //in seconds
		$config['charset'] = 'utf-8'; //iso-8859-1
		$config['wordwrap'] = TRUE;
