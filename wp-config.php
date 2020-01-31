<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'medieval' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost:3308' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'p%Fuv-n %(Kj4o %RPZ%xpa-7!:g#jz~hUQ>t~6vCdFzEx},$.s3VEf}Y:b{WZB$' );
define( 'SECURE_AUTH_KEY',  '!Y2ja2N!Ijk_=4.<[4T^}b6`=oJKD;Ssto{(L. ^RKl_p*.qcZ%W{N<|ez$w2Zw_' );
define( 'LOGGED_IN_KEY',    '^8FpVVihEVa~v9zO*eoCHR*N^*U>}(h_RqvCkJKorG,;QW&~sjqj{Lw}|u+{M5RI' );
define( 'NONCE_KEY',        '-zd+`KY_>[YdSbAnpxs{U(pobtq7&+c)rG_3UA?`A?-Z{:hjTBPv$(}:7K,U$@j=' );
define( 'AUTH_SALT',        'SV<(C~fYRi.K#Te>$+SN:MJv{<P=U5M}?;_yZ[K25<0(o?p`Y]-&5G~#=>5so.KF' );
define( 'SECURE_AUTH_SALT', 'vEt$Q[$-kR5#2yg{J(nv|[3%!mm^reiLI5#FFNdm&oUchL;8_gj9R+ t{U!%A9`Z' );
define( 'LOGGED_IN_SALT',   'cEIMB:s|0#h1_Iv3,LG+Ls09k}3>Y](Yfy!Mi+.yPZew*/[IikqqUo4DUKe U_P(' );
define( 'NONCE_SALT',       '}yfz>o:/s+DG>1yyK7??EP1#lx^*~oH KD+9yrpPadVrZcDl:!5mgT0;eo?l?0>Q' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define( 'WP_DEBUG', false );

define('WP_ALLOW_MULTISITE', true);

//Multisite

define('MULTISITE', true);
define('SUBDOMAIN_INSTALL', false);
define('DOMAIN_CURRENT_SITE', 'localhost');
define('PATH_CURRENT_SITE', '/medieval/');
define('SITE_ID_CURRENT_SITE', 1);
define('BLOG_ID_CURRENT_SITE', 1);

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once( ABSPATH . 'wp-settings.php' );


