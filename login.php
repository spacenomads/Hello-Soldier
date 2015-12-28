<?php
session_start();
include 'incl/_config.php';

if ( $_POST['ac'] == 'log' ) {
	if ( $user['pass'] == $_POST['ph_password'] ) {
		$_SESSION["logged"] = 'pass';
		$error_class = '';
	} else {
		$error_class = ' error';
	};
};

if (array_key_exists($_SESSION["logged"],$user)) { //// check if user is logged or not
	header("Location: editor.php");

} else { //// if not logged show login form



?>

<?php $page = 'login'; ?>
<!DOCTYPE html>
<?php include 'incl/_cc.php'; ?>
	<head>
		<meta charset="utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<title><?php echo 'Login - ' . $client; ?></title>
		<?php include 'incl/_head.php'; ?>
	</head>
	<body class="<?php echo $page; ?> ">
		<div class="page_container">

			<!-- Main content -->
			<section class="project_login">
				<div class="wrapper">
					<form action="" class="form" method="post" novalidate>

						<input type="hidden" name="ac" value="log">

						<div class="row<?php echo $error_class; ?>">
							<label class="label" for="ph_password">Type password and hit enter</label>
							<input type="password" class="field field_password" name="ph_password" id="ph_password" data-new-placeholder="Type password and hit enter" placeholder="Type password and hit enter" />
							<p class="error_mssg">Incorrect password!</p>
						</div>
						<div class="row client">
							<h2 class="title"><?php echo $client; ?></h2>
							<a href="" class="request_access">Request access</a>
						</div>
					</form>
				</div>
			</section>

			<?php include 'incl/_footer.php'; ?>

		</div>


		<?php include 'incl/_js.php'; ?>
		<?php include 'incl/_tag.php'; ?>

	</body>
</html>

<?php
};
?>
