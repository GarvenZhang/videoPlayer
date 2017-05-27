<?php 
	header('Content-type: application/json'); 
	$s=!empty($_POST['s']) ? $_POST['s'] : null;
	$j=!empty($_POST['j']) ? $_POST['j'] : null;
	$pat=!empty($_POST['path']) ? $_POST['path'] : null;
	$patharr=explode('/',$pat);
	$patz='';
	for($i=0;$i<count($patharr)-1;$i++){
		$patz.=$patharr[$i].'/';
	}
	create_folders($patz);
	$con='';
	$newcon=array(array(),array());
	$newObj = new stdClass();
	if($pat){
		$pat.='.json';
		$con=@file_get_contents($pat);
		if($con){
			$newObj=json_decode($con);
			$newcon=$newObj->ckplayer;
		}
	}
	if(!$j) $j=0;
	if($j<0) $j=0;
	if($s){
		if($newcon){
			array_push($newcon[0], intval(trim($j), 10));
			array_push($newcon[1], $s);
		}
		$newObj->ckplayer = $newcon;
		@file_put_contents($pat,json_encode($newObj));
	}
	if($newObj){
		print_r(json_encode($newObj));
	}
	function create_folders($dir){
		return is_dir($dir) or (create_folders(dirname($dir)) and mkdir($dir, 0777));
	}
?>