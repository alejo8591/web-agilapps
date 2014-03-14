<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'agilapps');

/** MySQL database username */
define('DB_USER', 'Agil_apps_db');

/** MySQL database password */
define('DB_PASSWORD', '');

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
define('AUTH_KEY',         'qAti+44|&Qf}0KW=l;RS/iuZe=.juL5Kt_(^Do?Up&`%TY<4O^=-!?k:FiI1x&,#');
define('SECURE_AUTH_KEY',  '-6[]i-s%cXEu&8>D;W|T.#dR)@vAws=GdZ^r{+J4eD-RgQGmC8EHOcaKyvxq(Zp,');
define('LOGGED_IN_KEY',    '=-ksfNvoN:5i$=Y)e*9D%m;RVnB-7#mv`GdbEA1xebJ8lHP_dtVLS#}vzII>$xoC');
define('NONCE_KEY',        '&mg^@h$!Z9.f7aAwKU|!Y*5V pZpZE9QNn0+7D,Lo!)(pBrmfD#V6txE9{dEN*k}');
define('AUTH_SALT',        'B]a`Gh6wZ~)u0M>`r=+%UH v7_~kf%p$FmY)LFo<TU|W@+mhA*|Z5EUKj:~0|+67');
define('SECURE_AUTH_SALT', 'Sx+pXx,Q^c+L|gO!N5f>zg2q]|wkIg;<m6?KjBooTfI.pL[B{J&ASbe>cBR32W8C');
define('LOGGED_IN_SALT',   'Xv@q^K(Dk&`r(C5oV8,Y)V5r-=MD<kn[^h|=VwU`_NyCIStcqjj*m!gGC5e>d<q:');
define('NONCE_SALT',       'ee8Q$@MLZwr,3Xy*oP/|>$rNtF1@q3r4jY*p,K&+2sm-|g>rll2qj0@5=FR![[1M');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', '');

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
