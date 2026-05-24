<?php
define('WP_CACHE', true); // Added by SpeedyCache

/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'grabdisc_wp526' );

/** Database username */
define( 'DB_USER', 'grabdisc_wp526' );

/** Database password */
define( 'DB_PASSWORD', 'p1o[6D(9zS' );

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
define( 'AUTH_KEY',         'lpixyzwyjclatmobbjowq73di923ywxmims3d7ksgmphkues0fy6uimldg0pa5cg' );
define( 'SECURE_AUTH_KEY',  '8gqryiypqzckqqpcnbqryloggna6nvtjpd93qiy6ijbaznmfhjekplhhbwjqgo4d' );
define( 'LOGGED_IN_KEY',    'g1dndkiuha9tsff06jyznzcclcftkb7ke6fln8vabiht3eivtnl2fvifbiwrbpei' );
define( 'NONCE_KEY',        'zbrwysclzyvbaxr9ajis79osnd59p61qrqahcupkl0sojsv8ibe0fenhxq7etlfo' );
define( 'AUTH_SALT',        'b9nkgv83xvc8vmcn1csh42itxssgj2pjzcbgwinvhdnsq9afrzptkqg2hyk2mdje' );
define( 'SECURE_AUTH_SALT', '4lzyy62lvajehftajxyc27fg4xyqg5qgkr77r1l9vyd3nn8jp6ic9kiga0uecft0' );
define( 'LOGGED_IN_SALT',   'vvqkt0buputsiqzrq6q3u8v7p73qrq443ih9uu05ozsk8fcmdm770w0jm9xyzrm8' );
define( 'NONCE_SALT',       'hbeaqryladpcirt3yhnldxnyfwcos6vp5nx6ysafcwoqescwcjrjkugbcnamyxww' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 *
 * At the installation time, database tables are created with the specified prefix.
 * Changing this value after WordPress is installed will make your site think
 * it has not been installed.
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/#table-prefix
 */
$table_prefix = 'wpn6_';

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
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
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
