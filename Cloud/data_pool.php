<?php
ini_set("display_errors", On);
error_reporting(E_ALL);
try{
// PDOクラスのオブジェクトを作成
$pdo = new PDO('mysql:host=host;dbname=dbname;charset=utf8', 'user', 'password', array(PDO::ATTR_EMULATE_PREPARES => false));
}catch(PDOException $e){
exit('キャッシュ用DB接続失敗。'.$e->getMessage());
}
try{
$send_pool = new PDO('mysql:host=host;dbname=dbname;charset=utf8', 'user', 'password', array(PDO::ATTR_EMULATE_PREPARES => false));
}catch(PDOException $e){
exit('データプールに接続失敗。'.$e->getMessage());
}
// DB処理
switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        $st = $send_pool->query("select ts, value from sensor_val order by ts desc");
        echo json_encode($st->fetchAll(PDO::FETCH_ASSOC));
        break;

    case 'POST':
        $cha = json_decode(file_get_contents('php://input'), true);
	echo $cha;
	break;
}
?>
