<?php
define('CRLF', "\n");

$sapi_type = php_sapi_name();
if($sapi_type != 'cli')
{
	header("Content-Type: text/plain");
	usage();
	error("Call me from command line only.", -1);
}

if(!isset($argv))
{
	$argv = array();
}

$wp_config_file = isset($argv[1])?$argv[1]:'wp-config.php';

if(empty($wp_config_file))
{
	usage();
	error("Pass Full Path to WP Config.", -2);
}

if(!is_file($wp_config_file))
{
	usage();
	error("WP config file not found.", -3);
}

function usage()
{
	echo "
Usage:
php -f config.php ./wp-config.php
wp /home/USER/PROJECT/public_html/wp-config.php
";
}

function error($message="", $code=0)
{
	echo CRLF, $message, CRLF;
	exit($code);
}

function grab($wp_config_file='./wp-config.php')
{
	$grabbed = array();
	
	$fc = file_get_contents($wp_config_file);
	$fc = str_replace('<?php', '', $fc);
	$fc = str_replace('require', '#require', $fc);
	$fc = str_replace('include', '#include', $fc);

	# @todo Use PHP Tokenizer
	# @todo Or Try by disabling require functions

	eval($fc);
	$defined = get_defined_constants(true);
	
	$grabbed[] = "mysql -h{$defined['user']['DB_HOST']} -u{$defined['user']['DB_USER']} -p{$defined['user']['DB_PASSWORD']} {$defined['user']['DB_NAME']}";
	$grabbed[] = "mysqldump -h{$defined['user']['DB_HOST']} -u{$defined['user']['DB_USER']} -p{$defined['user']['DB_PASSWORD']} {$defined['user']['DB_NAME']} > {$defined['user']['DB_NAME']}.dmp";
	$grabbed[] = "gzip -9 {$defined['user']['DB_NAME']}.dmp";

	return $grabbed;
}

$grabbed = grab($wp_config_file);
echo CRLF, implode(CRLF, $grabbed), CRLF;
