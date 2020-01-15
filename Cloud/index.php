<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Sensor Information Page</title>

  <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css" />
  <link rel="stylesheet" href="css/clean.css">
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.12.1/jquery.min.js"></script>
  <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
  <script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
  <script src="./jquery.columns.min.js"></script>
</head>
<body>
<nav class="navbar navbar-default navbar-static-top navbar-inverse">
<div class="container">
  <div class="navbar-header">
    <a href="#" class="navbar-brand">
     <?php
      echo 'Sensor Data　';
      echo '（Your External IP : ';
      echo $_SERVER['REMOTE_ADDR'];
      echo '）';
     ?>
    </a>
  </div>
</div><!-- container -->
</nav>
  <div class="container">
  <h3>Every 5 days Data (Cache)</h3>
    <div id="columns0">
    <script type="text/javascript">
        //画面構築完了後
        $(function() {
            //データを取得し、jsonというオブジェクトに入れる
            $.getJSON("http://34.83.195.250/temp.php",function(json0){
                $('#columns0').columns({
	            data:json0,
		    size:10,
		    schema:[
			{"header":"取得時間", "key":"ts"},
			{"header":"データ", "key":"temp"}
		    ]
                });
            });
        });
    </script>
  </div><!-- /container -->
<br />
<hr>
<br />
  <div class="container">
  <h3>Data Base (Temperature)</h3>
    <div id="columns1">
    <script type="text/javascript">
        //画面構築完了後
        $(function() {
            //データを取得し、jsonというオブジェクトに入れる
            $.getJSON("http://34.83.195.250/temp_pool.php",function(json1){
                $('#columns1').columns({
                    data:json1,
                    size:10,
                    schema:[
                        {"header":"取得時間", "key":"ts"},
                        {"header":"気温", "key":"value"}
                    ]
                });
            });
        });
    </script>
  </div><!-- /container -->
<br />
<hr>
<br />
  <div class="container">
  <h3>Data Base(Humidity)</h3>
    <div id="columns2">
    <script type="text/javascript">
        //画面構築完了後
        $(function() {
            //データを取得し、jsonというオブジェクトに入れる
            $.getJSON("http://34.83.195.250/hum_pool.php",function(json2){
                $('#columns2').columns({
                    data:json2,
                    size:10,
                    schema:[
                        {"header":"取得時間", "key":"ts"},
                        {"header":"湿度", "key":"value"}
                    ]
                });
            });
        });
    </script>
  </div><!-- /container -->
<br />
<hr>
<br />
  <div class="container">
  <h3>Data Base(Altitude)</h3>
    <div id="columns3">
    <script type="text/javascript">
        //画面構築完了後
        $(function() {
            //データを取得し、jsonというオブジェクトに入れる
            $.getJSON("http://34.83.195.250/alt_pool.php",function(json3){
                $('#columns3').columns({
                    data:json3,
                    size:10,
                    schema:[
                        {"header":"取得時間", "key":"ts"},
                        {"header":"気圧", "key":"value"}
                    ]
                });
            });
        });
    </script>
  </div><!-- /container -->
<br />
<hr>
<br />
  <div class="container">
  <h3>Data Base(Barometric Pressure)</h3>
    <div id="columns4">
    <script type="text/javascript">
        //画面構築完了後
        $(function() {
            //データを取得し、jsonというオブジェクトに入れる
            $.getJSON("http://34.83.195.250/pres_pool.php",function(json4){
                $('#columns4').columns({
                    data:json4,
                    size:10,
                    schema:[
                        {"header":"取得時間", "key":"ts"},
                        {"header":"高度", "key":"value"}
                    ]
                });
            });
        });
    </script>
  </div><!-- /container -->
</body>
</html>
