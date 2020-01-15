<?php
ini_set("display_errors", On);
error_reporting(E_ALL);
try{
// PDOクラスのオブジェクトを作成
$pdo = new PDO('mysql:host=host;dbname=dbname;charset=utf8', 'user', 'password', array(PDO::ATTR_EMULATE_PREPARES => false));
}catch(PDOException $e){
exit('キャッシュ用DB接続失敗。'.$e->getMessage());
}
// DB処理
switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        $st = $pdo->query("select ts, value from sensor_val order by ts desc");
        echo json_encode($st->fetchAll(PDO::FETCH_ASSOC));
        break;

    case 'POST':
	$flag = 1;
        $cha = json_decode(file_get_contents('php://input'), true);
        if(array_key_exists('temp', $cha)){ //temperature
            $tgt = $cha['temp'];
            $st = $pdo->query("select max_val, min_val from threshold where id=0;");
            $val = $st->fetchAll(PDO::FETCH_ASSOC);
            $max = (float)$val[0]['max_val'];
            $min = (float)$val[0]['min_val'];
            if($min > $tgt || $tgt > $max){
                $flag = 0;
            }
	    try{
		$pdo = new PDO('mysql:host=host;dbname=dbname;charset=utf8', 'user', 'password', array(PDO::ATTR_EMULATE_PREPARES => false));
	    }catch(PDOException $e){
		exit('データプールに接続失敗。'.$e->getMessage());
	    }
            $sql1 = "insert into temp_val(ts,temp) values (:datetime, :temp);";
	    $sql2 = "insert into sensor_val(ts,value) values (:datetime, :temp);";
            $sql_warn = "insert into warn_val(ts,temp) values (:datetime,:temp);";
        }else if(array_key_exists('humid', $cha)){ //humidity
            $tgt = $cha['humid'];
	    try{
		$pdo = new PDO('mysql:host=host;dbname=dbname;charset=utf8', 'user', 'password', array(PDO::ATTR_EMULATE_PREPARES => false));
	    }catch(PDOException $e){
		exit('データプールに接続失敗。'.$e->getMessage());
	    }
	    $sql1 = "insert into temp_val(ts,temp) values (:datetime, :humid);";
            $sql2 = "insert into sensor_val(ts,value) values (:datetime, :humid);";
            $sql_warn = "insert into warn_val(ts,temp) values (:datetime,:humid);";
        }else if(array_key_exists('alt', $cha)){ //altitude
            $tgt = $cha['alt'];
	    try{
		$pdo = new PDO('mysql:host=host;dbname=dbname;charset=utf8', 'user', 'password', array(PDO::ATTR_EMULATE_PREPARES => false));
	    }catch(PDOException $e){
		exit('データプールに接続失敗。'.$e->getMessage());
	    }
	    $sql1 = "insert into temp_val(ts,temp) values (:datetime, :alt);";
            $sql2 = "insert into sensor_val(ts,value) values (:datetime, :alt);";
            $sql_warn = "insert into warn_val(ts,temp) values (:datetime,:alt);";
        }else if(array_key_exists('pres', $cha)){ //barometric pressure
            $tgt = $cha['pres'];
	    try{
		$pdo = new PDO('mysql:host=host;dbname=dbname;charset=utf8', 'user', 'password', array(PDO::ATTR_EMULATE_PREPARES => false));
	    }catch(PDOException $e){
		exit('データプールに接続失敗。'.$e->getMessage());
	    }
	    $sql1 = "insert into temp_val(ts,temp) values (:datetime, :pres);";
            $sql2 = "insert into sensor_val(ts,value) values (:datetime, :pres);";
            $sql_warn = "insert into temp_val(ts,temp) values (:datetime,:pres);";
        }else{ //others
            $tgt = $cha['other'];
            $flag = 0;
	    $sql_warn = "insert into warn_val(ts,temp) values (:datetime,:other);";
        }

        if($flag){
            try{
                $st1 = $pdo->prepare($sql1);
	        $st1->execute($cha);
            }catch(Exception $e){
                break;
            }
	    $st2 = $send_db->prepare($sql2);
	    $st2->execute($cha);
        }else{
            $st3 = $pdo->prepare($sql_warn);
            $st3->execute($cha);
            header('Content-Type: application/json');
            echo json_encode("warning : ".$tgt);
            break;
        }
        header('Content-Type: application/json');
        echo json_encode("insert success : ".$tgt);
        break;
}
?>
