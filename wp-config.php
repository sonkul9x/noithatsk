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
define('DB_NAME', 'noithat');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

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
define('AUTH_KEY',         '*I:)3)g=L@v{>4@.>rN%oRJlcVF^)6NGR=ZjK),*!l3E+^&Z#VWVEcte2F?4,&T/');
define('SECURE_AUTH_KEY',  'FCRwE4<Qd5:]rNB9`%i@fw[td`H7YvKTS>xz{vR6nL/aOhE4--|C[x2R0z8Yb0!0');
define('LOGGED_IN_KEY',    'BBOqQf9iD#LKG!mM?gol-=TNUxfolb2R9yq05ElSUjt4%GjsC]xI.P!F&g3 *xzA');
define('NONCE_KEY',        '@*iy95WZ<$i$2F%.uVV&t#|nTQw=<ZY#[G0RW?*9Ec%n#mFJQ_K,iekYK0}y710f');
define('AUTH_SALT',        'O^BIVv9Lup@2w(sS@k{M >&M*~ ^{Gwa.S@v[ zFLbc&|rP*Or~0/,VR>{4L)}?A');
define('SECURE_AUTH_SALT', '13I%JWCL=n+x)_G)J_kceC(rFrj?;i4p4fv%)3Qv@ueSfPP@Z?IDryD/M7~^Wf=l');
define('LOGGED_IN_SALT',   '25D(>$2c95zvZG}1qMt,vwX@LFK7D6I/=enODyb>#eHUsBb:LEGj+K|By#l>_{O2');
define('NONCE_SALT',       '*4fbF2B5|JT~Hj-{rHWZ#t*~g-hk:l0!$O-Jj6;c[>GBvU=3b`Vu`rxZY hRRp.p');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'nt_';

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
