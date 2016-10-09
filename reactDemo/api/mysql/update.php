<?php
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
	$name=isset($_REQUEST["name"]) ? $_REQUEST["name"] : "";
	$teacher=isset($_REQUEST["teacher"]) ? $_REQUEST["teacher"] : "";
	$num=isset($_REQUEST["num"]) ? $_REQUEST["num"] : 0;
	if (!is_numeric($num)){$num=0;}
	$time=isset($_REQUEST["time"]) ? $_REQUEST["time"] : 0;
	
	
	if (trim($name)=="" && !$hasError){
		$msg="名称不能为空！";
		$code=1;
		$hasError=true;
	}else if(trim($teacher)=="" && !$hasError){
		$msg="指导员不能为空！";
		$code=2;
		$hasError=true;
	}else if((trim($num)=="" || !is_numeric($num)) && !$hasError){
		$msg="数量不能为空！" . is_numeric($num);
		$code=3;
		
		$hasError=true;
	}else if ( (int) $num<1){
		$msg="数量必须是正整数";
		$code=301;
		$hasError=true;
	}
	function enc($c){return iconv('gbk','utf-8',$c);}
	function eng($c){return iconv('utf-8','gbk',$c);}
	if ($hasError){
		$content='"errors":[{"msg":"'.$msg.'","code":'. $code .'}]';
	}else{
		$objstr="";
		$name=eng($name);
		$teacher=eng($teacher);
		$num=eng($num);
		$time=eng($time);
		if($id>0){
		/*然后有ID值修改*/
			$sql="UPDATE `t_class` set `t_name`='".$name."',`t_teacher`='".$teacher."',`t_num`='".$num."',`t_time`='".$time."' where `id` = ".$id;
			$res=$conn->exec($sql);
			//echo '影响行数：'.$res;
			if ($res>0){
				$content='"msg":"'.$res.'条数据修改成功","code":0';
			}else{
				$hasError=true;
				$msg="未改动任何数据或记录不存在！";
				$code=1;
				$content='"errors":[{"msg":"'.$msg.'","code":'. $code .'}]';
			}
		}else{
			/*无ID就新增*/
		    $sql = "INSERT INTO t_class (t_name, t_teacher, t_num,t_time)
		    VALUES ('$name', '$teacher', '$num', '$time')";
		    $conn->exec($sql);
			$content='"msg":"数据新增成功","code":0';
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