<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------
| DATABASE CONNECTIVITY SETTINGS
| -------------------------------------------------------------------
| This file will contain the settings needed to access your database.
|
| For complete instructions please consult the 'Database Connection'
| page of the User Guide.
|
| -------------------------------------------------------------------
| EXPLANATION OF VARIABLES
| -------------------------------------------------------------------
|
|	['dsn']      The full DSN string describe a connection to the database.
|	['hostname'] The hostname of your database server.
|	['username'] The username used to connect to the database
|	['password'] The password used to connect to the database
|	['database'] The name of the database you want to connect to
|	['dbdriver'] The database driver. e.g.: mysqli.
|			Currently supported:
|				 cubrid, ibase, mssql, mysql, mysqli, oci8,
|				 odbc, pdo, postgre, sqlite, sqlite3, sqlsrv
|	['dbprefix'] You can add an optional prefix, which will be added
|				 to the table name when using the  Query Builder class
|	['pconnect'] TRUE/FALSE - Whether to use a persistent connection
|	['db_debug'] TRUE/FALSE - Whether database errors should be displayed.
|	['cache_on'] TRUE/FALSE - Enables/disables query caching
|	['cachedir'] The path to the folder where cache files should be stored
|	['char_set'] The character set used in communicating with the database
|	['dbcollat'] The character collation used in communicating with the database
|				 NOTE: For MySQL and MySQLi databases, this setting is only used
| 				 as a backup if your server is running PHP < 5.2.3 or MySQL < 5.0.7
|				 (and in table creation queries made with DB Forge).
| 				 There is an incompatibility in PHP with mysql_real_escape_string() which
| 				 can make your site vulnerable to SQL injection if you are using a
| 				 multi-byte character set and are running versions lower than these.
| 				 Sites using Latin-1 or UTF-8 database character set and collation are unaffected.
|	['swap_pre'] A default table prefix that should be swapped with the dbprefix
|	['encrypt']  Whether or not to use an encrypted connection.
|
|			'mysql' (deprecated), 'sqlsrv' and 'pdo/sqlsrv' drivers accept TRUE/FALSE
|			'mysqli' and 'pdo/mysql' drivers accept an array with the following options:
|
|				'ssl_key'    - Path to the private key file
|				'ssl_cert'   - Path to the public key certificate file
|				'ssl_ca'     - Path to the certificate authority file
|				'ssl_capath' - Path to a directory containing trusted CA certificates in PEM format
|				'ssl_cipher' - List of *allowed* ciphers to be used for the encryption, separated by colons (':')
|				'ssl_verify' - TRUE/FALSE; Whether verify the server certificate or not ('mysqli' only)
|
|	['compress'] Whether or not to use client compression (MySQL only)
|	['stricton'] TRUE/FALSE - forces 'Strict Mode' connections
|							- good for ensuring strict SQL while developing
|	['ssl_options']	Used to set various SSL options that can be used when making SSL connections.
|	['failover'] array - A array with 0 or more data for connections if the main should fail.
|	['save_queries'] TRUE/FALSE - Whether to "save" all executed queries.
| 				NOTE: Disabling this will also effectively disable both
| 				$this->db->last_query() and profiling of DB queries.
| 				When you run a query, with this setting set to TRUE (default),
| 				CodeIgniter will store the SQL statement for debugging purposes.
| 				However, this may cause high memory usage, especially if you run
| 				a lot of SQL queries ... disable this to avoid that problem.
|
| The $active_group variable lets you choose which connection group to
| make active.  By default there is only one group (the 'default' group).
|
| The $query_builder variables lets you determine whether or not to load
| the query builder class.
*/
$active_group = 'default';
$query_builder = TRUE;

$db['default'] = array(
    'dsn' => '',
    'hostname' => getenv('DB_HOST'),
    'username' => getenv('DB_USERNAME'),
    'password' => getenv('DB_PASSWORD'),
    'database' => getenv('DB_DATABASE'),
    'dbdriver' => getenv('DB_DRIVER'),
    'port' => getenv('DB_PORT'),
    'dbprefix' => '',
    'pconnect' => FALSE,
    'db_debug' => (ENVIRONMENT !== 'production'),
    'cache_on' => FALSE,
    'cachedir' => '',
    'char_set' => 'utf8',
    'dbcollat' => 'utf8_general_ci',
    'swap_pre' => '',
    'encrypt' => FALSE,
    'compress' => FALSE,
    'stricton' => FALSE,
    'failover' => array(),
    'save_queries' => TRUE
);


$db['warehouse'] = array(
    'dsn' => '',
    'hostname' => getenv('DB_HOST_WH'),
    'username' => getenv('DB_USERNAME_WH'),
    'password' => getenv('DB_PASSWORD_WH'),
    'database' => getenv('DB_DATABASE_WH'),
    'dbdriver' => getenv('DB_DRIVER_WH'),
    'port' => getenv('DB_PORT_WH'),
    'dbprefix' => '',
    'pconnect' => TRUE,
    'db_debug' => TRUE,
    'cache_on' => FALSE,
    'cachedir' => '',
    'char_set' => 'utf8',
    'dbcollat' => 'utf8_general_ci',
    'swap_pre' => '',
    'compress' => FALSE,
    'encrypt' => FALSE,
    'stricton' => FALSE,
    'failover' => array()
);


$db['purchasing'] = array(
    'dsn' => '',
    'hostname' => getenv('DB_HOST_PCH'),
    'username' => getenv('DB_USERNAME_PCH'),
    'password' => getenv('DB_PASSWORD_PCH'),
    'database' => getenv('DB_DATABASE_PCH'),
    'dbdriver' => getenv('DB_DRIVER_PCH'),
    'port' => getenv('DB_PORT_PCH'),
    'dbprefix' => '',
    'pconnect' => TRUE,
    'db_debug' => TRUE,
    'cache_on' => FALSE,
    'cachedir' => '',
    'char_set' => 'utf8',
    'dbcollat' => 'utf8_general_ci',
    'swap_pre' => '',
    'compress' => FALSE,
    'encrypt' => FALSE,
    'stricton' => FALSE,
    'failover' => array()
);


$db['absent'] = array(
    'dsn' => '',
    'hostname' => getenv('DB_HOST_ABS'),
    'username' => getenv('DB_USERNAME_ABS'),
    'password' => getenv('DB_PASSWORD_ABS'),
    'database' => getenv('DB_DATABASE_ABS'),
    'dbdriver' => getenv('DB_DRIVER_ABS'),
    'port' => getenv('DB_PORT_ABS'),
    'dbprefix' => '',
    'pconnect' => TRUE,
    'db_debug' => TRUE,
    'cache_on' => FALSE,
    'cachedir' => '',
    'char_set' => 'utf8',
    'dbcollat' => 'utf8_general_ci',
    'swap_pre' => '',
    'compress' => FALSE,
    'encrypt' => FALSE,
    'stricton' => FALSE,
    'failover' => array()
);

$db['hr'] = array(
    'dsn' => '',
    'hostname' => getenv('DB_HOST_HR'),
    'username' => getenv('DB_USERNAME_HR'),
    'password' => getenv('DB_PASSWORD_HR'),
    'database' => getenv('DB_DATABASE_HR'),
    'dbdriver' => getenv('DB_DRIVER_HR'),
    'port' => getenv('DB_PORT_HR'),
    'dbprefix' => '',
    'pconnect' => FALSE,
    'db_debug' => (ENVIRONMENT !== 'production'),
    'cache_on' => FALSE,
    'cachedir' => '',
    'char_set' => 'utf8',
    'dbcollat' => 'utf8_general_ci',
    'swap_pre' => '',
    'encrypt' => FALSE,
    'compress' => FALSE,
    'stricton' => FALSE,
    'failover' => array(),
    'save_queries' => TRUE
);

$db['crm'] = array(
    'dsn' => '',
    'hostname' => getenv('DB_HOST_CRM'),
    'username' => getenv('DB_USERNAME_CRM'),
    'password' => getenv('DB_PASSWORD_CRM'),
    'database' => getenv('DB_DATABASE_CRM'),
    'dbdriver' => getenv('DB_DRIVER_CRM'),
    'port' => getenv('DB_PORT_CRM'),
    'dbprefix' => '',
    'pconnect' => TRUE,
    'db_debug' => TRUE,
    'cache_on' => FALSE,
    'cachedir' => '',
    'char_set' => 'utf8',
    'dbcollat' => 'utf8_general_ci',
    'swap_pre' => '',
    'compress' => FALSE,
    'encrypt' => FALSE,
    'stricton' => FALSE,
    'failover' => array()
);

$db['vms'] = array(
    'dsn' => '',
    'hostname' => getenv('DB_HOST_VMS'),
    'username' => getenv('DB_USERNAME_VMS'),
    'password' => getenv('DB_PASSWORD_VMS'),
    'database' => getenv('DB_DATABASE_VMS'),
    'dbdriver' => getenv('DB_DRIVER_VMS'),
    'port' => getenv('DB_PORT_VMS'),
    'dbprefix' => '',
    'pconnect' => TRUE,
    'db_debug' => TRUE,
    'cache_on' => FALSE,
    'cachedir' => '',
    'char_set' => 'utf8',
    'dbcollat' => 'utf8_general_ci',
    'swap_pre' => '',
    'compress' => FALSE,
    'encrypt' => FALSE,
    'stricton' => FALSE,
    'failover' => array()
);

$db['ticket'] = array(
    'dsn' => '',
    'hostname' => getenv('DB_HOST_TCK'),
    'username' => getenv('DB_USERNAME_TCK'),
    'password' => getenv('DB_PASSWORD_TCK'),
    'database' => getenv('DB_DATABASE_TCK'),
    'dbdriver' => getenv('DB_DRIVER_TCK'),
    'port' => getenv('DB_PORT_TCK'),
    'dbprefix' => '',
    'pconnect' => TRUE,
    'db_debug' => TRUE,
    'cache_on' => FALSE,
    'cachedir' => '',
    'char_set' => 'utf8',
    'dbcollat' => 'utf8_general_ci',
    'swap_pre' => '',
    'compress' => FALSE,
    'encrypt' => FALSE,
    'stricton' => FALSE,
    'failover' => array()
);

$db['training'] = array(
    'dsn' => '',
    'hostname' => getenv('DB_HOST_TRN'),
    'username' => getenv('DB_USERNAME_TRN'),
    'password' => getenv('DB_PASSWORD_TRN'),
    'database' => getenv('DB_DATABASE_TRN'),
    'dbdriver' => getenv('DB_DRIVER_TRN'),
    'port' => getenv('DB_PORT_TRN'),
    'dbprefix' => '',
    'pconnect' => TRUE,
    'db_debug' => TRUE,
    'cache_on' => FALSE,
    'cachedir' => '',
    'char_set' => 'utf8',
    'dbcollat' => 'utf8_general_ci',
    'swap_pre' => '',
    'compress' => FALSE,
    'encrypt' => FALSE,
    'stricton' => FALSE,
    'failover' => array()
);

$db['evaluation'] = array(
    'dsn' => '',
    'hostname' => getenv('DB_HOST_EVA'),
    'username' => getenv('DB_USERNAME_EVA'),
    'password' => getenv('DB_PASSWORD_EVA'),
    'database' => getenv('DB_DATABASE_EVA'),
    'dbdriver' => getenv('DB_DRIVER_EVA'),
    'port' => getenv('DB_PORT_EVA'),
    'dbprefix' => '',
    'pconnect' => TRUE,
    'db_debug' => TRUE,
    'cache_on' => FALSE,
    'cachedir' => '',
    'char_set' => 'utf8',
    'dbcollat' => 'utf8_general_ci',
    'swap_pre' => '',
    'compress' => FALSE,
    'encrypt' => FALSE,
    'stricton' => FALSE,
    'failover' => array()
);
