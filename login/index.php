<?php
session_start();
include "../koneksi.php";

?>

<!DOCTYPE html>
<html lang="en">


<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
	<meta name="description" content="" />
	<meta name="author" content="" />
	<title>Apothecary | Login</title>
	<link href="../assets/css/styles.css" rel="stylesheet" />
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700;800&display=swap" rel="stylesheet">
	<style>
		body {
			font-family: 'Poppins', sans-serif;
			background: linear-gradient(90deg, #e0f7fa 0%, #5459AC 100%) !important;
			min-height: 100vh;
		}
		.login-container {
			min-height: 100vh;
			display: flex;
			align-items: center;
			justify-content: center;
		}
		.login-card {
			background: #fff;
			border-radius: 18px;
			box-shadow: 0 4px 32px rgba(84,89,172,0.13);
			padding: 40px 32px 32px 32px;
			max-width: 400px;
			width: 100%;
			margin: 32px 0;
		}
		.login-brand {
			font-size: 2rem;
			font-weight: 800;
			color: #5459AC;
			letter-spacing: 1px;
			text-align: center;
			margin-bottom: 18px;
			text-shadow: 0 2px 8px rgba(84,89,172,0.10);
		}
		.login-title {
			font-size: 1.3rem;
			font-weight: 700;
			color: #222;
			margin-bottom: 18px;
			text-align: center;
		}
		.form-label {
			font-weight: 600;
			color: #5459AC;
		}
		.form-control:focus {
			border-color: #5459AC;
			box-shadow: 0 0 0 2px rgba(84,89,172,0.13);
		}
		.btn-primary {
			background: linear-gradient(90deg, #5459AC 70%, #6fc3d0 100%);
			border: none;
			font-weight: 700;
			border-radius: 10px;
			box-shadow: 0 2px 8px rgba(84,89,172,0.10);
			transition: background 0.2s;
		}
		.btn-primary:hover {
			background: linear-gradient(90deg, #6fc3d0 0%, #5459AC 100%);
		}
		.login-footer {
			text-align: center;
			color: #888;
			font-size: 13px;
			margin-top: 18px;
		}
		.login-footer a {
			color: #5459AC;
			text-decoration: none;
			font-weight: 600;
		}
	</style>
</head>


<body>
	<div class="login-container">
		<div class="login-card">
			<div class="login-brand">Apothecary</div>
			<div class="login-title">Login ke Sistem Klinik</div>
			<form method="POST" novalidate="">
				<div class="mb-3">
					<label for="username" class="form-label">Username</label>
					<input id="username" type="text" class="form-control" name="username" required autofocus>
				</div>
				<div class="mb-3">
					<label for="password" class="form-label">Password</label>
					<input id="password" type="password" class="form-control" name="password" required>
				</div>
				<button type="submit" name="submit" class="btn btn-primary w-100">Login</button>
			</form>
			<?php
			if (isset($_POST['submit'])) {
				$user = $_POST['username'];
				$pass = $_POST['password'];
				$query = mysqli_query($koneksi, "SELECT * FROM tb_user WHERE username='$user' AND password='$pass'");
				$masuk = mysqli_num_rows($query);
				if ($masuk == 0) {
					echo "<div class='alert alert-danger mt-3 text-center' style='font-size:14px;'>Username atau password anda salah</div>";
				} else {
					$masuk1 = mysqli_fetch_assoc($query);
					if ($masuk1["jabatan"] == 'admin') {
						$_SESSION["jabatan"] = 'admin';
						$_SESSION["user"] = $user;
						echo "<script>alert('Anda berhasil Login!');document.location='../index.php'</script>";
					} else if ($masuk1["jabatan"] == 'pembayaran') {
						$_SESSION["jabatan"] = 'pembayaran';
						echo "<script>alert('Anda berhasil Login!');document.location='../index.php'</script>";
					} else if ($masuk1["jabatan"] == 'pendaftaran') {
						$_SESSION["jabatan"] = 'pendaftaran';
						echo "<script>alert('Anda berhasil Login!');document.location='../index.php'</script>";
					} else if ($masuk1["jabatan"] == 'pemeriksaan') {
						$_SESSION["jabatan"] = 'pemeriksaan';
						echo "<script>alert('Anda berhasil Login!');document.location='../index.php'</script>";
					}
				}
			}
			?>
			<div class="login-footer mt-4">
				Copyright &copy; Apothecary 2025<br>
				<span style="font-size:12px;">Sistem Manajemen Klinik Modern</span>
			</div>
		</div>
	</div>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>