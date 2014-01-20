<?php


function get_day(){
	$bdd = DataBase::getInstance()->getConnexion();
	
	$start = mktime (0, 0, 0, date("n"), date("j"), date("Y")); 	
	$end = mktime (0, 0, 0, date("n"), date("j")+1, date("Y")); 	
	$query = "SELECT * FROM 'ping' WHERE point > $start AND point < $end ORDER BY point DESC"; 
	try{
		$req = $bdd->query($query);
		$result_ping = $req->fetchAll();
	}
	catch(Exception $e){
	   die('Erreur : '.$e->getMessage());
	}
	$query = "SELECT * FROM 'download' WHERE point > $start AND point < $end ORDER BY point DESC";
	try{ 
		 $req = $bdd->query($query);
		 $result_download = $req->fetchAll();
	}
	catch(Exception $e){
	   die('Erreur : '.$e->getMessage());
	}
	$query = "SELECT * FROM 'upload' WHERE point > $start AND point < $end ORDER BY point DESC";
	try{
	         $req = $bdd->query($query);
	         $result_upload = $req->fetchAll();
	}
	catch(Exception $e){
	   die('Erreur : '.$e->getMessage());
	}
	sort($result_ping);
	foreach($result_ping as $tmp)
		$result_ping_hour[] = array("point" => date("H:i", $tmp['point']), "value" => $tmp['value']);

	sort($result_download);
	sort($result_upload);
	return array($result_ping_hour, $result_download, $result_upload);
}

function get_week(){
	$bdd = DataBase::getInstance()->getConnexion();

	for ($i = time(); $i > time() - 7*86400; $i -= 86400){
		//Ping
		$query = "SELECT AVG(value) FROM 'ping' WHERE point < $i AND point > $i - 86400"; 
		try{
			$req = $bdd->query($query);
			$result = $req->fetch();
		}
		catch(Exception $e){
		   die('Erreur : '.$e->getMessage());
		}
		if ($result[0] != null)
			$result_ping[] = array("point" => $i, "value" => round($result[0], 2));

		//Download
		$query = "SELECT AVG(value) FROM 'download' WHERE point < $i AND point > $i - 86400"; 
		try{
			$req = $bdd->query($query);
			$result = $req->fetch();
		}
		catch(Exception $e){
		   die('Erreur : '.$e->getMessage());
		}
		if ($result[0] != null)
			$result_download[] = array("point" => $i, "value" => round($result[0], 2));
		
		//Upload
		$query = "SELECT AVG(value) FROM 'upload' WHERE point < $i AND point > $i - 86400"; 
		try{
			$req = $bdd->query($query);
			$result = $req->fetch();
		}
		catch(Exception $e){
		   die('Erreur : '.$e->getMessage());
		}
		if ($result[0] != null)
			$result_upload[] = array("point" => $i, "value" => round($result[0], 2));
	}

	sort($result_ping);
	sort($result_download);
	sort($result_upload);
	$result_ping = transform_date($result_ping);
	return array($result_ping, $result_download, $result_upload);
}

function transform_date($array){

	foreach ($array as $tmp)
		$array_tmp[] = array("point" => date("d/m",$tmp['point']) , "value" => $tmp['value']);

	return $array_tmp;
}

function get_month(){
	$bdd = DataBase::getInstance()->getConnexion();

	for ($i = time(); $i > time() - 31*86400; $i -= 86400){
		//Ping
		$query = "SELECT AVG(value) FROM 'ping' WHERE point < $i AND point > $i - 86400"; 
		try{
			$req = $bdd->query($query);
			$result = $req->fetch();
		}
		catch(Exception $e){
		   die('Erreur : '.$e->getMessage());
		}
		if ($result[0] != null)
			$result_ping[] = array("point" => $i, "value" => round($result[0], 2));

		//Download
		$query = "SELECT AVG(value) FROM 'download' WHERE point < $i AND point > $i - 86400"; 
		try{
			$req = $bdd->query($query);
			$result = $req->fetch();
		}
		catch(Exception $e){
		   die('Erreur : '.$e->getMessage());
		}
		if ($result[0] != null)
			$result_download[] = array("point" => $i, "value" => round($result[0], 2));
		
		//Upload
		$query = "SELECT AVG(value) FROM 'upload' WHERE point < $i AND point > $i - 86400"; 
		try{
			$req = $bdd->query($query);
			$result = $req->fetch();
		}
		catch(Exception $e){
		   die('Erreur : '.$e->getMessage());
		}
		if ($result[0] != null)
			$result_upload[] = array("point" => $i, "value" => round($result[0], 2));
	}

	sort($result_ping);
	sort($result_download);
	sort($result_upload);
	$result_ping = transform_date($result_ping);
	return array($result_ping, $result_download, $result_upload);
}

function get_all(){
	$bdd = DataBase::getInstance()->getConnexion();
	$query = "SELECT point FROM 'ping' ORDER BY point ASC LIMIT 1"; 
		try{
			$req = $bdd->query($query);
			$limit = $req->fetch();
		}
		catch(Exception $e){
		   die('Erreur : '.$e->getMessage());
		}
		
	for ($i = time(); $i > $limit[0]; $i -= 86400){
		//Ping
		$query = "SELECT AVG(value) FROM 'ping' WHERE point < $i AND point > $i - 86400"; 
		try{
			$req = $bdd->query($query);
			$result = $req->fetch();
		}
		catch(Exception $e){
		   die('Erreur : '.$e->getMessage());
		}
		if ($result[0] != null)
			$result_ping[] = array("point" => $i, "value" => round($result[0], 2));

		//Download
		$query = "SELECT AVG(value) FROM 'download' WHERE point < $i AND point > $i - 86400"; 
		try{
			$req = $bdd->query($query);
			$result = $req->fetch();
		}
		catch(Exception $e){
		   die('Erreur : '.$e->getMessage());
		}
		if ($result[0] != null)
			$result_download[] = array("point" => $i, "value" => round($result[0], 2));

		//Upload
		$query = "SELECT AVG(value) FROM 'upload' WHERE point < $i AND point > $i - 86400"; 
		try{
			$req = $bdd->query($query);
			$result = $req->fetch();
		}
		catch(Exception $e){
		   die('Erreur : '.$e->getMessage());
		}
		if ($result[0] != null)
			$result_upload[] = array("point" => $i, "value" => round($result[0], 2));
	}

	sort($result_ping);
	sort($result_download);
	sort($result_upload);
	$result_ping = transform_date($result_ping);
	return array($result_ping, $result_download, $result_upload);
}

function get_interval($start, $end){
	$bdd = DataBase::getInstance()->getConnexion();
	for ($i = $end; $i > $start; $i -= 86400){
		//Ping
		$query = "SELECT AVG(value) FROM 'ping' WHERE point < $i AND point > $i - 86400"; 
		try{
			$req = $bdd->query($query);
			$result = $req->fetch();
		}
		catch(Exception $e){
		   die('Erreur : '.$e->getMessage());
		}
		if ($result[0] != null)
			$result_ping[] = array("point" => $i, "value" => round($result[0], 2));

		//Download
		$query = "SELECT AVG(value) FROM 'download' WHERE point < $i AND point > $i - 86400"; 
		try{
			$req = $bdd->query($query);
			$result = $req->fetch();
		}
		catch(Exception $e){
		   die('Erreur : '.$e->getMessage());
		}
		if ($result[0] != null)
			$result_download[] = array("point" => $i, "value" => round($result[0], 2));

		//Upload
		$query = "SELECT AVG(value) FROM 'upload' WHERE point < $i AND point > $i - 86400"; 
		try{
			$req = $bdd->query($query);
			$result = $req->fetch();
		}
		catch(Exception $e){
		   die('Erreur : '.$e->getMessage());
		}
		if ($result[0] != null)
			$result_upload[] = array("point" => $i, "value" => round($result[0], 2));
	}

	sort($result_ping);
	sort($result_download);
	sort($result_upload);
	$result_ping = transform_date($result_ping);
	return array($result_ping, $result_download, $result_upload);
}

?>
