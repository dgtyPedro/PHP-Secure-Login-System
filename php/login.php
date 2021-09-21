<?php
session_start();
require_once 'config.php';


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
			</script>
			<?php

			
		} else {
			// Incorrect password
			?>
			<script>
			javascript:alert('Senha errada!');
			</script>
			<?php
		}
	} else {
		// Incorrect email
		?>
		<script>
		javascript:alert('Email errado!');
		</script>
		<?php
	}
	$stmt->close();
}	