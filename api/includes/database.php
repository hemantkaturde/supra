<?php
// database.php
if($_SERVER['HTTP_HOST']=='localhost'){
    $base  = "http://".$_SERVER['HTTP_HOST'];
    $base .= str_replace(basename($_SERVER['SCRIPT_NAME']),"",$_SERVER['SCRIPT_NAME']);
    $config['base_url'] = $base;

    $host = 'localhost';
    $dbname ='supra_1';
    $username ='root';
    $password = '';

}else{
    $base  = "https://".$_SERVER['HTTP_HOST'];
    $base .= str_replace(basename($_SERVER['SCRIPT_NAME']),"",$_SERVER['SCRIPT_NAME']);
    $config['base_url'] = $base;

    $host = 'localhost';
    $dbname ='supraexp_supraexports';
    $username ='supraexp_supra';
    $password = 'supra@123';
}



try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die(json_encode(['status' => 'error', 'message' => $e->getMessage()]));
}