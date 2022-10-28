<?php


$file = "wp-config.php";
fopen("random-password.php", "w"); //creates a file random-password
$current = "";
$random_pass = "";
$current .= "<?php\n";

//setting up the database configuration
$current .= "\ndefine( 'DB_NAME', 'teste' );";
$current .= "\ndefine( 'DB_USER', 'root' );";
$current .= "\ndefine( 'DB_PASSWORD', '' );";
$current .= "\ndefine( 'DB_HOST', 'localhost' );";
$current .= "\ndefine( 'DB_CHARSET', 'utf8mb4' );";
$current .= "\ndefine( 'DB_COLLATE', '' );\n\n\n";

//getting credentials 
$auth_keys = "auth-keys.txt";
$secret_keys = file_get_contents($auth_keys);

// wp_remote_get("https://api.wordpress.org/secret-key/1.1/salt/");



//adding salts to wp-config file
$current .= $secret_keys;

$current .= "\n\n\n\$table_prefix = 'wp_';";
$current .= "\n\ndefine( 'WP_DEBUG', false );";

$current .= "\n\nif ( ! defined( 'ABSPATH' ) ) {";
$current .= "\n   define( 'ABSPATH', dirname( __FILE__ ) . '/' );";
$current .= "\n}\n\nrequire_once( ABSPATH . 'wp-settings.php' );";

$current .= "?>";

file_put_contents($file, $current);


$random_pass_file = "random-password.php";
$random_pass .= randomPassword(20);
file_put_contents($random_pass_file, $random_pass);

define( 'WP_INSTALLING', true );

require_once("wp-load.php" );
require_once("wp-admin/includes/upgrade.php" );
require_once("wp-includes/wp-db.php" );

wp_install( 'site-teste', 'filipe', 'filipe@gmail.com', "1", '', $random_pass, "en_GB");


wp_redirect('wp-login.php' );
exit;






function randomPassword($length) {
    $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < $length; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass); //turn the array into a string
}


//ao chamar o setup.php vai também criar um arquivo e armazenar as salts

