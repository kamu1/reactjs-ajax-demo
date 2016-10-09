<?php
header("Content-type: text/json; charset=utf-8");
$servername = "localhost";
$username = "root";
$password = "0123456789";
$dbname = "test";
$hasError=false;
$msg="";
$code=0;

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES'utf8';"));
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	//$conn = new PDO("odbc:driver={microsoft access driver (*.mdb)};dbq=".realpath("test.mdb")) or die("Connect Error");
	function jsonStr($status,$content){
		if ($status){
			$jsonStr='{"hasError":true,'. $content .'}';
		}else{
			$jsonStr='{"hasError":false,'. $content .'}';
		}
		return $jsonStr;
	}
	$parNum = count($_GET);/*判断参数个数*/
	if ($parNum<1) {$parNum=count($_POST);}
	/*处理逗号隔开的数值ID*/
	$id=isset($_REQUEST["id"]) ? $_REQUEST["id"] : 0;
	$id=str_replace(" ",",",$id);
	$did=array_filter(explode(",",$id));
	$id="0";
	foreach ($did as $var){
		if (is_numeric($var)){
			$id.= "," . $var;
		}
	}
	/*}*/
	
	if ($hasError){
		$content='"errors":[{"msg":"'.$msg.'","code":'. $code .'}]';
	}else{
		$objstr="";
		if ($id){
		/*再次有did删除*/
			$sql='delete from t_class where id in('. $id .')';
			$res=$conn->exec($sql);
			//echo '影响行数：'.$res;
			if ($res>0){
				$content='"msg":"'.$res.'条数据删除成功","code":0';
			}else{
				$hasError=true;
				$msg="无相关记录，未删除数据！";
				$code=1;
				$content='"errors":[{"msg":"'.$msg.'","code":'. $code .'}]';
			}
		}else{
			$content='"msg":"参数错误","code":1';
		}
	}
	die(jsonStr($hasError,$content));
}

catch(PDOException $e)
    {
    echo $sql . "<br>" . $e->getMessage();
    }

$conn = null;
?>