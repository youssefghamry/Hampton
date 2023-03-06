<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'Hampton' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         ';O~y0rQq<z1t#|ry$X^R<|Ah`?&{pjC):2vwf3Jr#bmgyD|>*<f8%Feo=RyEMZ8w' );
define( 'SECURE_AUTH_KEY',  ' luyWG$$;4*9)~~NE!+Fg3RVh:F$/1]NT`#5n9eo^U-!#,^=%ej%H+k0ci%bWhB|' );
define( 'LOGGED_IN_KEY',    '3Gt+!&E#aTwV8C4~`/AmYfGtD=22^Xt~aP%fOKkaQ-zDzstw<lSt-Xk(k 2uF?1u' );
define( 'NONCE_KEY',        '@tbS*ypgYP/g9a9X7/$[W&.KdhrH}>qul}w}yDGLjS6w|D(A9613r{@blle6x$f!' );
define( 'AUTH_SALT',        'c8^foN1PV`-.GA8<^eKs5N4;uI!:*0*k&uiG!YoSM{.:LlP(^(jZr !Wz9v+b{8*' );
define( 'SECURE_AUTH_SALT', '2[Y_O2DiBt])[.SrDhxNQU=WL6?HGDc@^?O=%,0+Epg7HxhjJl5@nHt,9=TE:@8D' );
define( 'LOGGED_IN_SALT',   'E5+)ok_R^Vk6l?z1Ds[fjc<VfEvL1k?u;/H7wVR6?KR96iWSD]XE~&|tM%w9=n*D' );
define( 'NONCE_SALT',       '4KE1~0~~D7l-mg;d+z$r5h{+{w:iu4d[d`-bivzfXUbXdS#Ff:[6iP4bu7grV(&;' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_Hampton';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
