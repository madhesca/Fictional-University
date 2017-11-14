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

// ** MySQL settings ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'local' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', 'root' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'JLzHg5aQG+CBoSGshaxJYJpTgBVvk5E3I7hq0NJY4u6EY/egcGVRLxFVRBUHPRpJlmKjdtyNiJygHhyKpAxFig==');
define('SECURE_AUTH_KEY',  'MzsNLlY8jPZmHYB4uc5ry+Lp547g+91FZVHgqxrpZZR4uY1lR2cL9Ovh8QlOcyCFQctp23hlrRvxYAXXHsjT3w==');
define('LOGGED_IN_KEY',    'HFM4wVMXl9bWgR8tSbjzRIhQ59ZolzjRlFEHmth553uExlLDpil4/VzlCf3rRAN24AG8MnU9MDwBJwJqm2h3Uw==');
define('NONCE_KEY',        '7HvGd2vsTrzmw4UPr4tXvtxWgY7aI5/nom2RN95vcfSJP2PZyeN63Ex4jNXVIsOLDQaN5eCIxQLKfibxCQnd7w==');
define('AUTH_SALT',        'OVPuYX/rzMmqrbNbvrPoaV6kNwY3+RAw31rDuglaNj2nmizVMj7aVL+u8gArKFCP+yNE4FGXbKF47JJJmAiq4g==');
define('SECURE_AUTH_SALT', 'ypHp+8GyL8A7ePwLU5BolPkCDKLfOUnp6MTW7KaAwdqWkoq4nuV4+Dk8uf0CmlSQBmn9WDkkq2H9UI+0kQjIZg==');
define('LOGGED_IN_SALT',   '9mLIK1HTcK5AkgU/tdpjOfQk5tsVaDkmg3c6iarC02MhgRBrXtydVwnjwTSfUXRW96KKMJJiDYmIAJMSWx0BEA==');
define('NONCE_SALT',       'n3TSNyHaUaSLLEPauK2lh1yIVY5CAHIB2bdgpGZV+DUTLW3XDOiKjmOr52IMr3NtYBnimqigXs1F8bmlPyJfNQ==');

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';





/* Inserted by Local by Flywheel. See: http://codex.wordpress.org/Administration_Over_SSL#Using_a_Reverse_Proxy */
if (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') {
	$_SERVER['HTTPS'] = 'on';
}
/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) )
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
