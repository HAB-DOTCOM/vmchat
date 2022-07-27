<?php
namespace MyChatApp;
use PDO;
class DB{
	function connect(){
		$db =new PDO('mysql:host=localhost; dbname=insa','root','');
		return $db;
	}
}
$username = 'root';
$dns = 'mysql:host=localhost; dbname=insa';
$password ='';

try{

	$db =new PDO($dns,$username,$password);
	$db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

}catch(PDOException $ex){
	$ex->getMessage();
}



    
