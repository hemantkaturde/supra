<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
$dbname = $_GET['db'];
$table  = $_GET['table'];
if($_SERVER['HTTP_HOST']=='localhost'){
    $base  = "http://".$_SERVER['HTTP_HOST'];
    $base .= str_replace(basename($_SERVER['SCRIPT_NAME']),"",$_SERVER['SCRIPT_NAME']);
    $config['base_url'] = $base;
    $host = 'localhost';
    $dbname = $dbname;
    $username ='root';
    $password = '';
}else{
    $base  = "https://".$_SERVER['HTTP_HOST'];
    $base .= str_replace(basename($_SERVER['SCRIPT_NAME']),"",$_SERVER['SCRIPT_NAME']);
    $config['base_url'] = $base;
    $host = 'localhost';
    $dbname =$dbname;
    $username ='supraexp_supra';
    $password = 'supra@123';
}
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die(json_encode(['status' => 'error', 'message' => $e->getMessage()]));
}
// ============================================================
if (!isset($_GET['table'])) {
    echo json_encode(["status" => "error", "message" => "Missing parameter: table"]);
    exit;
}
$table = $_GET['table'];
$stmt = $pdo->prepare("SHOW TABLES LIKE ?");
$stmt->execute([$table]);
if ($stmt->rowCount() == 0) {
    echo json_encode(["status" => "error", "message" => "Table '$table' not found"]);
    exit;
}
$stmt = $pdo->query("SELECT * FROM `$table`");
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (empty($rows)) {
    echo json_encode(["status" => "warning", "message" => "No data found"]);
    exit;
}
$pkStmt = $pdo->prepare("SHOW KEYS FROM `$table` WHERE Key_name = 'PRIMARY'");
$pkStmt->execute();
$pkRow = $pkStmt->fetch(PDO::FETCH_ASSOC);

if (!$pkRow) {
    echo json_encode(["status" => "error", "message" => "No primary key found"]);
    exit;
}
$primary_key = $pkRow['Column_name'];
function enc_value($string)
{
    $key = "MY_SECRET_KEY_123";
    $out = "";

    for ($i = 0; $i < strlen($string); $i++) {
        $out .= chr(ord($string[$i]) ^ ord($key[$i % strlen($key)]));
    }

    return base64_encode($out);
}
$updated = 0;
foreach ($rows as $r) {
    $updateFields = [];
    $updateValues = [];
    foreach ($r as $col => $val) {
        if ($col == $primary_key) continue;
        if ($val !== null && $val !== "") {
            $updateFields[] = "`$col` = ?";
            $updateValues[] = enc_value($val);
        }
    }
    if (!empty($updateFields)) {
        $updateValues[] = $r[$primary_key];

        $sql = "UPDATE `$table` SET ".implode(", ", $updateFields)." WHERE `$primary_key` = ?";
        $pdo->prepare($sql)->execute($updateValues);

        $updated++;
    }
}
echo json_encode([
    "status" => "success",
    "database" => $dbname,
    "table" => $table,
    "updated_rows" => $updated,
    "message" => "Encryption completed successfully"
]);

?>
