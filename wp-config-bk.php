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
define('DB_NAME', 'questis1_wor1');


/** MySQL database username */
define('DB_USER', 'questis1_wor1');


/** MySQL database password */
define('DB_PASSWORD', 'w75MsQCV');


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
define('AUTH_KEY',         '^5#B7?w6o+T+eeH`+(%l^@jYf9+p=,J0&__h|oLjdnZy]LdXV?na1zO!o}cu=0K.');

define('SECURE_AUTH_KEY',  '+}X-u@aOz&!ZE-WrfsX;pf&.bq.5Z^tNu*2Yu/00_A7L-LK`+}F|&P]q+5vN[64Q');

define('LOGGED_IN_KEY',    '|JzL<h)i&zSje=2Gf-pu:&-BzUI|FmI5!;al8aahxQA/!nV+EMu[b3uftW0U^HJ|');

define('NONCE_KEY',        ')ln2mHCMM>#V!}>5@|}KAS9+Us&8zRd;4ohQbsx M|8W2qcuDEpzO}u-(I4>FO_P');

define('AUTH_SALT',        'RESsQsTV_U8nvGhcrxD.8ZrCg|>I<gxjrl~ -hk{k{ekEX&DLG+8nDVIQ9##^$q*');

define('SECURE_AUTH_SALT', 'YY518kk$PEc94u~@,(Y}GS9-?t%U*-o%+g Y~+HD-tL1P7_QjVIF/xf,=AYi+iiG');

define('LOGGED_IN_SALT',   '54D4:-Amz!$z11qesG$!|GZuQ1uUHC?ys!!]?c7v(J2B 5GB4`TNlfE+GfJ4K%V2');

define('NONCE_SALT',       'KKd6hT7J&O4.ptv{Rxt>WTo@m*KfhC]&mt^kF^1`V|]ZC2?SQ_EY-7P}-bsdiC[B');


/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wkw_';


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
