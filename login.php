<?php
$host = "localhost";
$uname = "root";
$pas = "";
$db_name = "cman";
$tbl_name = "members";

$conn = mysqli_connect("$host", "$uname", "$pas") or die("cannot connect");
mysqli_select_db($conn, "$db_name") or die("cannot select db");
?>
<?php
if (isset($_POST['login'])) {
	session_start();

	$username = $_POST['username'];
	$password = $_POST['password'];

	$login_query = mysqli_query($conn, "select * from members where mobile='$username'");
	$count = mysqli_num_rows($login_query);
	$row = mysqli_fetch_array($login_query);


	if ($count > 0) {

		if ($password == $row["password"]) {
			$_SESSION['id'] = $row['id'];
			header('location:members/dashboard.php');
		} else {
			$_SESSION["error_login"] = "Credentials do not match our records";
			header('location:index.php');
		}
	} else {
		$_SESSION["error_login"] = "Member not found";

		header('location:index.php');
	}
}
?>