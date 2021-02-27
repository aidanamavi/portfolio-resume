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
define( 'DB_NAME', 'damngoodbusiness-demo_cms' );

/** MySQL database username */
define( 'DB_USER', 'admin.aidanamavi' );

/** MySQL database password */
define( 'DB_PASSWORD', '()TZ67]WL.YQTF]Pf933iG' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link xx WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         ';=wU!lBY&S`(6KjF-3:ER9yN2?c<r)Ej_OC`+bs;q{x:1TkTzdg[/2},e^Y/4uvz');
define('SECURE_AUTH_KEY',  'd/)|+iHVF7NVHH[gc9UX=[l{u71#oG`O`|Y{G c`6oz|)y3WQNu@O.l{Y+||i7uy');
define('LOGGED_IN_KEY',    'I!wD8q*Qp8~2g-Z0QO{maQZ)y)g|k2,ra%w#Zj.9PFiRO%]+YN-{t5%e}:]J$5jS');
define('NONCE_KEY',        'xC~?16jU!5%qtW6/zsi946:L2iLR4p9`@;3b%$NuX A)3n8+!5{-XCi;IBw+my`+');
define('AUTH_SALT',        'h(rmnUC+681Ac{9-V:x~m/BIH&3+|E]`=iCnCm||zE)EH[e+8dDJJcq2-AO<d,r-');
define('SECURE_AUTH_SALT', ',%$|vk@tMTGC,W/!g5-6I5c0^A%;-H1FoFoghTiD<X^Q:%f.+_C-1|C[r^Qd{RFq');
define('LOGGED_IN_SALT',   '?{vy|DZ2AGce+U)%LbneC;u+movEH+v3^eonM!xgNf=9a/{hhKpw|Md&qEN.H[U,');
define('NONCE_SALT',       'bC(P:Q5D7ch+/*O+1 GlxlC 8H ht+l28>X%9I`o`e9{8`xwU_J+=seY8%q`S-9s');

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

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once( ABSPATH . 'wp-settings.php' );
