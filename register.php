<?php 
	include_once 'connection.php';
   include_once 'utilities.php';

 if(isset($_POST['signupBtn'])){
   //initialize an array to store any error message from the form
   $form_errors = array();

   //Form validation
   $required_fields = array('name','username', 'email', 'password');

   //call the function to check empty field and merge the return data into form_error array
   $form_errors = array_merge($form_errors, check_empty_fields($required_fields));

   //Fields that requires checking for minimum length
   $fields_to_check_length = array('username' => 4, 'password' => 6);
   //call the function to check minimum required length and merge the return data into form_error array
   $form_errors = array_merge($form_errors, check_min_length($fields_to_check_length));
   //email validation / merge the return data into form_error array
   $form_errors = array_merge($form_errors, check_email($_POST));

   //check if error array is empty, if yes process form data and insert record
   if(empty($form_errors)){
      //collect form data and store in variables

 	$name = $_POST['name'];
 	$username = $_POST['username'];
 	$email = $_POST['email'];
 	$password = $_POST['password'];
   $hashed_password = password_hash($password, PASSWORD_DEFAULT);

 	try{
 		$sqlInsert = "INSERT INTO users(name,username,email,password) VALUES(:name,:username,:email,:password)";

 	$statement = $db->prepare($sqlInsert);
 	$statement->execute(array(':name'=>$name,':username'=>$username,':email'=>$email,':password'=>$hashed_password)); 

 	if($statement->rowCount()==1){
 		 $result = "<p style='padding:20px; border: 1px solid gray; color: green;'> Registration Successful</p>";
       header("location: index.php");
 	}

 	}catch(PDOException $ex){
 		 $result = "<p style='padding:20px; border: 1px solid gray; color: red;'> An error occurred: ".$ex->getMessage()."</p>";
 	}

 }else{
        if(count($form_errors) == 1){
             $result = "<p style='color: red;'> There was 1 error in the form<br>";
            
        }else{
            $result = "<p style='color: red;'> There were " .count($form_errors). " errors in the form <br>";
           
        }
    }

}


?>
<!DOCTYPE html>
<html>
   <head>
      <meta charset="utf-8">
      <title>Register</title>
      <link href="assets/style.css" rel="stylesheet" type="text/css">
      <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
   </head>
   <body>
      <div class="register">
         <h1>Register</h1>
         <?php if(isset($result)) echo $result; ?>
         <?php if(!empty($form_errors)) echo show_errors($form_errors); ?>
         <form action="register.php" method="post">
            <label for="name">
               <i class="fas fa-user"></i>
            </label>
            <input type="text" name="name" placeholder="name" id="name" >
            <label for="username">
               <i class="fas fa-user"></i>
            </label>
            <input type="text" name="username" placeholder="Username" id="username" >
            <label for="email">
               <i class="fas fa-envelope"></i>
            </label>
            <input type="email" name="email" placeholder="Email" id="email" >
            <label for="password">
               <i class="fas fa-lock"></i>
            </label>
            <input type="password" name="password" placeholder="Password" id="password" >
            
            <input type="submit" value="Register" name="signupBtn">
         </form>
      </div>
   </body>
</html>