<?php defined('SYSPATH') or die('No direct access allowed.');

return array
(
	'default' => array
	(
		'type'       => 'pdo',
		'connection' => array(
			/**
			 * The following options are available for PDO:
			 *
			 * string   dsn         PDO data source identifier
			 * string   username    Database username
			 * string   password    Database password
			 * boolean  persistent  Persistent connections
			 *
			 * Ports and sockets may be appended to the hostname.
			 */
			'dsn' => "",
			'username' => "",
			'password' => "",
			'persistant' => false,
		),
		'table_prefix' => '',
		'charset'      => 'utf8',
		'caching'      => FALSE,
		'profiling'    => TRUE,
	)
);
