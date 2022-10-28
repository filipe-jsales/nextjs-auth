<?php

$file = "wp-config.php";
$current = "";
$current .= "<?php\n";

//setting up the database base configuration
$current .= setupDataBaseConfigs();

// getting credentials and adding salts to wp-config file
$current .= getSaltsLocally();

$current .= setupDataBasePrefix();

//end of wp-config file
file_put_contents($file, $current);

// //creating a file that stores password
// $random_pass = "";
// fopen("random-password.txt", "w"); 

// //get the recently created file
// $random_pass_file = "random-password.txt";
// $random_pass .= randomPassword(20);

// //write random password inside the random-password.txt file
// file_put_contents($random_pass_file, $random_pass);
storeRandomPassword();

$random_pass = file_get_contents("random-password.txt");

define( 'WP_INSTALLING', true );

require_once("wp-load.php" );
require_once("wp-admin/includes/upgrade.php" );
require_once("wp-includes/wp-db.php" );

wp_install( 'site-teste', 'filipe', 'filipe@gmail.com', "1", '', $random_pass, "en_GB");


wp_redirect('wp-login.php' );
exit;



function setupDataBaseConfigs() {
    $str_dbsetup = "";
    $str_dbsetup .= "\ndefine( 'DB_NAME', 'teste' );";
    $str_dbsetup .= "\ndefine( 'DB_USER', 'root' );";
    $str_dbsetup .= "\ndefine( 'DB_PASSWORD', '' );";
    $str_dbsetup .= "\ndefine( 'DB_HOST', 'localhost' );";
    $str_dbsetup .= "\ndefine( 'DB_CHARSET', 'utf8mb4' );";
    $str_dbsetup .= "\ndefine( 'DB_COLLATE', '' );\n\n\n";
    return $str_dbsetup;
}

function setupDataBasePrefix() {
    $current = "";
    $current .= "\n\n\n\$table_prefix = 'wp_';";
    $current .= "\n\ndefine( 'WP_DEBUG', false );";
    $current .= "\n\nif ( ! defined( 'ABSPATH' ) ) {";
    $current .= "\n   define( 'ABSPATH', dirname( __FILE__ ) . '/' );";
    $current .= "\n}\n\nrequire_once( ABSPATH . 'wp-settings.php' );\n";
    return $current;
}


function getSaltsLocally(): string {
    $auth_keys = "auth-keys.txt";
    $secret_keys = file_get_contents($auth_keys);
    return $secret_keys;
}


function getSalts() {
    require_once("wp-load.php" );
    $http_salts     = wp_remote_get('https://api.wordpress.org/secret-key/1.1/salt/');
    $returned_salts  = wp_remote_retrieve_body($http_salts);
    $new_salts = explode("\n", $returned_salts);
    var_dump($new_salts);
    die;
    return $new_salts;
}

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

function storeRandomPassword() {
    //creating a file that stores password
    $random_pass = "";
    fopen("random-password.txt", "w"); 

    //get the recently created file
    $random_pass_file = "random-password.txt";
    $random_pass .= randomPassword(20);

    //write random password inside the random-password.txt file
    file_put_contents($random_pass_file, $random_pass);
}