<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, and ABSPATH. You can find more information by visiting
 * {@link http://codex.wordpress.org/Editing_wp-config.php Editing wp-config.php}
 * Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'wp_emfour');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'root');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'T&wL.%|+&sB19p~[E]l+~<BC-Wxgcp5%v(BFesq9Sx<u_;Q2%d#-|l;hu|pmrbxI');
define('SECURE_AUTH_KEY',  '99|QbA:_sS>MP6.[sfR)Aa]^|i4qDF u:0nMjJ2<wls1;_6)oSvyHx8Q,`&%}xZ-');
define('LOGGED_IN_KEY',    'o#ZI}{{tug+1XC!A0=j0l68-;kj<g-y:|p|k4 )G^,5+?U#v</>OU+>|e5%H@%ZX');
define('NONCE_KEY',        'FC+d#9-P=6H~+D<HKo_bjOF,S@2/iX03z1>?xwGY8(4s/qyr-fU<_(6087i&x`Ve');
define('AUTH_SALT',        'Ib[-;CX3qyK4GW)ealhdp?^l}te&+InhI0sY?l<l>{6HNnz@)dgm!>jjH^3o/+_u');
define('SECURE_AUTH_SALT', '|{j.j[>etnP#++]A+7D<m55L8|8{$&ML-C-+|`#RrG=8,+ DU9^rZbgqD+UnVPaZ');
define('LOGGED_IN_SALT',   'Y7AR[Gco|D+msNQfiuH~UHQgZX^y)-I/]YNJ1^YDru[aWAtz3<$&* ,iNbl~J1Y:');
define('NONCE_SALT',       '|xUA1)|B&C3`5:)7x::]vb9G92:z^E.3edB|B*<-Nbfbtl](ra[QejIWYikpW}WH');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
