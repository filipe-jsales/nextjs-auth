<?php

define( 'DB_NAME', 'teste' );
define( 'DB_USER', 'root' );
define( 'DB_PASSWORD', '' );
define( 'DB_HOST', 'localhost' );
define( 'DB_CHARSET', 'utf8mb4' );
define( 'DB_COLLATE', '' );


define('AUTH_KEY',         'cBYBplRP%L2KoUY*`+OD7<M(Gr0v2.n<|i&#td3+m#0`#%{:{.uAeIDRRC784GjN');
define('SECURE_AUTH_KEY',  'AcGF|,.Vs@ZT*]p|SD5 |tG<;3TnK<5=oFh}mGQuF2;frd(0b_V! fH|UjpWvJmn');
define('LOGGED_IN_KEY',    'LJ_&~&7Gl3V)Cd|#195z<2=ca-57Zh:6E5:6-e}C`={wK}U:31bZTmI|++i&xvyG');
define('NONCE_KEY',        'gG0b``_Mib?6px{Lw4R*sa>o#qmp`5_5pi)LX?FhmB[|%#z-|nWMwryLK$l3trqB');
define('AUTH_SALT',        'q>7&2qQ%!)3*JBn^(tCTfx4tSG5;tZUF<PC,^#@c:61`z}xx<mi$J+}+7B}*U<a0');
define('SECURE_AUTH_SALT', 'TvrfH^|[)^?w.]||pJ==ammPghh*w>lHI!bJS9>af6~j+#^+-|hIPPYRWNMyuGhy');
define('LOGGED_IN_SALT',   '0W[h1c=sYt>KnI}Dlw,9qX$O<Mfqf:IG--mOr6G%^VgHzE+(T1?LUhL|IYRG3EnM');
define('NONCE_SALT',       '}0V-*%- q#|[+Kp-kV!r6%eU$nyCV3Wdm?qcC{Q;@.$&7Lan@ow~Qr:#B.AR2[ +');


$table_prefix = 'wp_';

define( 'WP_DEBUG', false );

if ( ! defined( 'ABSPATH' ) ) {
   define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

require_once( ABSPATH . 'wp-settings.php' );?>