<?php
namespace MyChatApp;
use PDO;
include_once 'login.php';
include_once 'session.php';
class User{
	public $db,$id,$sessionID;

	public function __construct(){
		$db = new \MyChatApp\DB;

		$this->db =  $db->connect();
		$this->id = $this->ID();
		$this->sessionID = $this->getSessionID();
	}
	public function ID(){
		if($this->isLoggedIn()){
			return $_SESSION['id'];
		}
	}

	public function getSessionID(){
		$ss = session_id();
		//var_dump($ss);
		return $ss;
	}

	public function emailExist($email){
		$stmt = $this->db->prepare("SELECT *FROM `users` WHERE `email`=:email ");
		$stmt->bindParam(":email",$email,PDO::PARAM_STR);
		$stmt->execute();
		$user = $stmt->fetch(PDO::FETCH_OBJ);
		if (!empty($user)) {
			return $user;
		}else{
			return false;

		}


	}
	public function userData($id=''){
		$id = ((!empty($id)) ? '$id' : $this->id);
		$stmt = $this->db->prepare("SELECT *FROM `users` WHERE `id`=:id ");
		$stmt->bindParam(":id",$id,PDO::PARAM_STR);
		//var_dump($id);
		$stmt->execute();
		 return $stmt->fetch(PDO::FETCH_OBJ);
	}

	public function isLoggedIn(){
		return ((isset($_SESSION['id'])) ? true : false);
	}

	public function redirect($location){
		header("Location: ".BASE_URL.$location);
	}

	public function getUsers(){
		$stmt = $this->db->prepare("SELECT * FROM `users` WHERE `id` != :id");
		$stmt->bindParam(":id",$this->id,PDO::PARAM_INT);
		$stmt->execute();

		$users = $stmt->fetchAll(PDO::FETCH_OBJ);

		foreach($users as $user){

			echo '<li class="select-none transition hover:bg-green-50 p-4 cursor-pointer select-none">
	<a href="'.BASE_URL.$user->username. '">
		<div class="user-box flex items-center flex-wrap">
		<div class="flex-shrink-0 user-img w-14 h-14 rounded-full border overflow-hidden">
		    <img class="w-full h-full" src= "'.BASE_URL.$user->profileimage.'">
		</div>
		<div class="user-name ml-2">
		    <div><span class="flex font-medium">'.$user->username.'</span></div>
		    <div></div>
		</div>
		</div>
	</a>
</li>';
		}

		
	}
	public function getUserByUsername($username){
		$stmt = $this->db->prepare("SELECT * FROM `users` WHERE `username`=:username");
		$stmt->bindParam(":username",$username,PDO::PARAM_STR);
		//var_dump($username);
		$stmt->execute();
		 return $stmt->fetch(PDO::FETCH_OBJ);
	}
	  public function updateSession(){
	  	$stmt = $this->db->prepare("UPDATE `users` SET `sessionID` = :sessionID WHERE `id` =:id");
	  	$stmt->bindParam(":sessionID",$this->sessionID,PDO::PARAM_STR);
	  	$stmt->bindParam(":id",$this->id,PDO::PARAM_INT);
	  	//var_dump($this->id);
	  	$stmt->execute();
	  	

	  }

	  public function getUserBySession($sessionID){
	  	$stmt = $this->db->prepare("SELECT * FROM `users` WHERE `sessionID`=:sessionID");
		$stmt->bindParam(":sessionID",$sessionID,PDO::PARAM_STR);
		
		$stmt->execute();
		 return $stmt->fetch(PDO::FETCH_OBJ);
	  }

}