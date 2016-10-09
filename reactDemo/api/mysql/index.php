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
	$did=isset($_REQUEST["did"]) ? $_REQUEST["did"] : 0;
	$did=str_replace(" ",",",$did);
	$did1=array_filter(explode(",",$did));
	$did="0";
	foreach ($did1 as $var){
		if (is_numeric($var)){
			$did.= "," . $var;
		}
	}
	//die($did);
	/*}*/
	$id=isset($_REQUEST["id"]) ? $_REQUEST["id"] : 0;
	if (!is_numeric($id)){$id=0;}
	$rid=isset($_REQUEST["rid"]) ? $_REQUEST["rid"] : 0;
	if (!is_numeric($rid)){$rid=0;}
	$name=isset($_REQUEST["name"]) ? $_REQUEST["name"] : "";
	$teacher=isset($_REQUEST["teacher"]) ? $_REQUEST["teacher"] : "";
	$num=isset($_REQUEST["num"]) ? $_REQUEST["num"] : 0;
	if (!is_numeric($num)){$num=0;}
	$time=isset($_REQUEST["time"]) ? $_REQUEST["time"] : 0;
	
	/*{分页查询*/
	$pageNumber=isset($_REQUEST["pageNumber"]) ? $_REQUEST["pageNumber"] : 1;
	if (!is_numeric($pageNumber)){$pageNumber=1;}
	if (!$pageNumber && $parNum<1){$pageNumber=1;}/*没有传参，page未传 用作满足执行查询*/
	$pageSize=isset($_REQUEST["pageSize"]) ? $_REQUEST["pageSize"] : 10;
	$pagea=($pageNumber-1)*$pageSize;
	$order =isset($_REQUEST["order"]) ? $_REQUEST["order"] : "id desc";
	$sort="";
	if ($order!="id desc"){
		if ($order!="id"){
			$order="t_" . $order;
		}
		$sort =isset($_REQUEST["sort"])=="desc" ? $_REQUEST["sort"] : "asc";
	}
	$orderBy="";
	$field=Array("t_name","t_teacher","t_num","id","id desc");
	if (in_array($order, $field)){
		$orderBy=' order by ' . $order . ' ' . $sort;
	}
	/*}*/
	if ($hasError){
		$content='"errors":[{"msg":"'.$msg.'","code":'. $code .'}]';
	}else{
		$objstr="";
		if (isset($_REQUEST["id"])){
			/*请求一条数据*/
			$res = $conn->query("SELECT * FROM t_class where id=".$id,PDO::FETCH_ASSOC);
			$recordNumber = $res->rowCount();
			if ($recordNumber==1){
				$obj=new stdClass();
				foreach ($res as $row) {
				$obj->id = $row['Id'];
				$obj->name = $row['t_name'];
				$obj->teacher = $row['t_teacher'];
				$obj->num = $row['t_num'];
				$objstr.=json_encode($obj,JSON_UNESCAPED_UNICODE);
				$content='"list":' . $objstr;
				}
			}else{
				$content='"errors":[{"msg":"数据异常或不存在","code":1}]';
			}
		}else{
			function enc($c){return iconv('gbk','utf-8',$c);}
		/*分页查询*/
			$res = $conn->query("SELECT * FROM t_class $orderBy Limit $pagea,$pageSize",PDO::FETCH_ASSOC);
			//$res = $conn->query("SELECT TOP $pageSize * FROM (SELECT TOP ".$pageSize * $pageNumber." * FROM t_class ORDER BY id DESC) ORDER BY id ASC",PDO::FETCH_ASSOC);
			$recordNumber = $res->rowCount();
			$recordCount = $conn->query("select COUNT(*) from t_class")->fetchColumn();    //取得数据总数
			$pageCount=ceil($recordCount/$pageSize);
			
			$obj=new stdClass();
			/*
			echo '每页'.$pageSize."条<hr>";
			echo '当'.$pageCount."页<hr>";
			echo '共'.$recordCount.'条<hr>';
			echo '第'.$pageNumber.'页<hr>';
			echo '共'.$pagenum.'页<hr>';
			*/
			$k=0;
			$objstr="";
			foreach ($res as $row) {
				// $row是一个关联数组，可以直接显示，如$row['id']
				$obj->id = intval($row['Id']);
				$obj->name = $row['t_name'];
				$obj->teacher = $row['t_teacher'];
				$obj->num = $row['t_num'];
				$obj->time = $row['t_time']?$row['t_time']:"";
				
				if ($k>0) {$objstr.=",";}
				$k++;
				$objstr.=json_encode($obj,JSON_UNESCAPED_UNICODE);
			}
			$content='"list":[' . $objstr . ']';
			$content.=',"page":{';
			$content.='"pageNumber":'.$pageNumber;
			$content.=',"pageSize":'.$pageSize;
			$content.=',"pageCount":'.$pageCount;
			$content.=',"recordNumber":'.$recordNumber;
			$content.=',"recordCount":'.$recordCount;
			$content.='}';
			if ($recordCount<1){
				$content.=',"msg":"未找到相关数据！"';
			}
		
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