<?php
include('dbconn.php');
?>

<form id="login_form1" class="form-signin" method="post">
	<h3 class="form-signin-heading">
		<i class="icon-lock"></i> Administrator Login
	</h3>
	<p style="color: red;"><?php
							session_start();

							if (isset($_SESSION['error_login'])) {
								echo $_SESSION['error_login'];
							} else {
								echo "";
							} ?></p>
	<p>
		<input type="text" class="input-block-level" id="username" name="username" placeholder="Username" required>
		<input type="password" class="input-block-level" id="password" name="password" placeholder="Password" required>

		<button data-placement="right" title="Click Here to Sign In" id="signin" name="login" class="btn btn-info" type="submit"><i class="icon-signin icon-large"></i> Sign in</button>
		<script type="text/javascript">
			$(document).ready(function() {
				$('#signin').tooltip('show');
				$('#signin').tooltip('hide');
			});
		</script>
</form>
</br>
<div class="error">
	<?php

	if (isset($_POST['login'])) {
		session_start();

		$username = $_POST['username'];
		$password = $_POST['password'];

		$login_query = mysqli_query($conn, "select * from admin where username='$username'");
		$count = mysqli_num_rows($login_query);
		$row = mysqli_fetch_array($login_query);


		if ($count > 0) {
			$_SESSION['id'] = $row['admin_id'];
			header('location:dashboard.php');

			if ($password == $row["password"]) {
				$_SESSION['id'] = $row['admin_id'];
				header('location:dashboard.php');
			} else {
				$_SESSION["error_login"] = "Credentials do not match our records";
				header('location:index.php');
			}
		} else {
			$_SESSION["error_login"] = "User not found";

			header('location:index.php');
		}
	}
	?>



</div>