<?php
include 'setting/conn_login.php';

if(isset($_POST['register'])){
	$username	= $_POST['username'];
	$password	= $_POST['password'];
	$email		= $_POST['email'];
	
	$stmt = $connection->prepare("INSERT INTO login (username, password, email, email_pass) VALUES (:username, :password, :email, :password)");
	$stmt->bindParam(':username', $username);
	$stmt->bindParam(':password', $password);
	$stmt->bindParam(':email', $email);
	$stmt->execute();
	
	if($stmt){
		echo '<script>alert("Registered")</script>';
		echo '<script>window.location="register.php"</script>';
	} else {
		echo '<script>alert("Failed")</script>';
		echo '<script>window.location="register.php"</script>';
	}
}
?>

<form method="post">
	<input name="username" style="width:175px" placeholder="Username" autocomplete="off"><br>
	<input name="password" style="width:175px" placeholder="Password" autocomplete="off"><br>
	<input type="email" name="email" style="width:175px" placeholder="Email" autocomplete="off"><br>
	<input type="submit" style="width:175px" name="register" value="REGISTER">
</form>