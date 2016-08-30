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
define('DB_NAME', 'wordpress');

/** MySQL database username */
define('DB_USER', 'kenna');

/** MySQL database password */
define('DB_PASSWORD', 'amantequus');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

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
define('AUTH_KEY',         '[]y~Zh)%=.wGy3iz >(xury}UvWg$7k_6#l69Vun+Gd&+r;j|+q58kU[|mDw@,W/');
define('SECURE_AUTH_KEY',  ']q:Ci)xbs#AQQvmcTyCf}a%+?a`48fv&drFI(IFAW;(yT8iEKUhPK#ig-4/(N-Bm');
define('LOGGED_IN_KEY',    'DIsxBOef(7HS(0-S0o{#l^^S6)=(IP|fvfeOaV=w ]x[P`R8+.p{jUwMy>$=@_8U');
define('NONCE_KEY',        'q`N0{JL~p6KfkxlmfpO/J+ER1f:$_S!}B)yN.a2-&!/CXCyDz5t~0-8c?lueCz`M');
define('AUTH_SALT',        '^3f]c*]AVB5{Fxe,L73&W5Kz#Ys-U<rG]@J+3|]ae@fV3|p-X<bR4cAs]Dm@.W`r');
define('SECURE_AUTH_SALT', '3LQ=Sj@GB2yef>sW6UYnuOj$S|9NNKV]wC/3dC~@@eyQk{1_4:~ri|N3h*Q]QPu/');
define('LOGGED_IN_SALT',   'gh~11t|+9<(Em8sWm5PLbML>KvHL-T]u`|Kos9^UV!gp|8_/i1 yRG&!lYo>a`cZ');
define('NONCE_SALT',       'Aw2eW#Ic;JFz|3.05%$y~VA6QmeCOx-(Q.:I-:6.~~JqRIbN_vGa6tEygkiNgI:{');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

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
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');

define('WP_HOME','http://52.26.126.43');
define('WP_SITEURL','http://52.26.126.43');

/**
define('WP_HOME','http://www.maligatork9.com');
define('WP_SITEURL','http://www.maligatork9.com');
*/
