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
 * * Localized language
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'local' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', 'root' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

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
define( 'AUTH_KEY',          '5k,EQ,-(^M^l6|n0%o0c$T#:u$-f3^:WcMpHf$wKo99u}YB>PNWR-i(Xwmm1R(+p' );
define( 'SECURE_AUTH_KEY',   ')hY}O3UmgoX=lqAbM~WT>I&)g!yDdW6Q bas :Ol@-mQhVDC@2*@i+^c?$3x*EIO' );
define( 'LOGGED_IN_KEY',     'AFcKI-scj?:^m30t0U<^9?!c+L#qP3CEu@*kUJW+lw_{whYLiDUhLo?-}[+?Tdu6' );
define( 'NONCE_KEY',         ']YTy+2?;;_uJ9+(W?X/q3+-)D9Nvg=!ZrYY`EYeR:#~`KPX3aYKs~Kc 4wHjwPQ7' );
define( 'AUTH_SALT',         '}I19PQdDq[4s%F6YL^0x_9FNlocw$~f SB`Q6LNSUupf=p/oKR/%wWhs1:%kAWH/' );
define( 'SECURE_AUTH_SALT',  'S9Ah#U&^|c9mVjE3W<j7ME:KeV;0Rnc}I|M?c+1t4Hy,eV5|ZoE}/XC5ltB3L$SE' );
define( 'LOGGED_IN_SALT',    '9#ZgW>IcUX!Vg*d//wS{,0S=_ucE[Ko@Fpkrp(?J+=X=^)^yzZI$?n0[x$+$39U[' );
define( 'NONCE_SALT',        '3Q~&b20SqBF!H#o%];sqEK|>wDWQrRjfjHVHkT5yD~^3cQBl:_zc31o0bFvYxz1l' );
define( 'WP_CACHE_KEY_SALT', '~TBM~;2Fg5K$vf5D.yL4^|nn5H?+8h5,.GD5)%0Z@z`kcrR}a*KyA+nRV5B`:a =' );


/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';


/* Add any custom values between this line and the "stop editing" line. */



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
if ( ! defined( 'WP_DEBUG' ) ) {
	define( 'WP_DEBUG', false );
}

define( 'WP_ENVIRONMENT_TYPE', 'local' );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
