<?php
session_start();
require_once 'config.php';

if(isset($_SESSION['tentativas']) && $_SESSION['tentativas'] > 5 ){
	?>
	<script>
	javascript:alert('Bloqueado por muitas tentativas.');
	javascript:window.location='../login.html';
	</script>
	<?php

if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 60)) {
	// last request was more than 30 minutes ago
	session_unset();     // unset $_SESSION variable for the run-time 
	session_destroy();   // destroy session data in storage
	header('Location: login.html');
  }
  $_SESSION['LAST_ACTIVITY'] = time(); // update last activity time stamp



}else{
	if ($stmt = $conn->prepare('SELECT id, password FROM users WHERE email = ?')) {
		$stmt->bind_param('s', $_POST['email']);
		$stmt->execute();
		$stmt->store_result();
	
		if ($stmt->num_rows > 0) {
			$stmt->bind_result($id, $password);
			$stmt->fetch();
	
			if (password_verify($_POST['password'], $password)) {
				session_regenerate_id();
				$_SESSION['loggedin'] = TRUE;
				$_SESSION['name'] = $_POST['email'];
				$_SESSION['id'] = $id;
				?>
				<script>
				javascript:alert('Logado!');
				javascript:window.location='../session.php';
				</script>
				<?php
	
				
			} else {
				if(!isset($_SESSION['tentativas'])){
					$_SESSION['tentativas']=0;
				}
				$_SESSION['tentativas']++;
				// Incorrect password
				?>
				<script>
				javascript:alert('Senha errada!');
				javascript:window.location='../login.html';
				</script>
				<?php
			}
		} else {
			if(!isset($_SESSION['tentativas'])){
				$_SESSION['tentativas']=0;
			}
			$_SESSION['tentativas']++;
			// Incorrect email
			?>
			<script>
			javascript:alert('Email errado!');
			javascript:window.location='../login.html';
			</script>
			<?php
		}
		$stmt->close();
		}	
}

