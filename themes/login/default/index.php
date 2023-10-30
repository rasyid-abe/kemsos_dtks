<!DOCTYPE html>
<html class="loading" lang="en">
<!-- BEGIN : Head-->

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
	<title>Data Terpadu Kesejahteraan Sosial</title>
	<link rel="shortcut icon" type="image/x-icon" href="<?= base_url();?>themes/admin/able/app-assets/img/ico/favicon-kemsos.ico">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-touch-fullscreen" content="yes">
	<meta name="apple-mobile-web-app-status-bar-style" content="default">
	<link href="https://fonts.googleapis.com/css?family=Rubik:300,400,500,700,900%7CMontserrat:300,400,500,600,700,800,900" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.0.0/animate.min.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url()?>themes/admin/able/app-assets/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url()?>themes/admin/able/app-assets/css/bootstrap-extended.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url()?>themes/admin/able/app-assets/css/components.css">
    <link rel="stylesheet" href="<?php echo base_url()?>themes/admin/able/app-assets/css/pages/authentication.css">
</head>

<body class="vertical-layout vertical-menu 1-column auth-page navbar-sticky blank-page bg-info" data-menu="vertical-menu" data-col="1-column">
	<div class="wrapper">
		<div class="main-panel">
			<div class="main-content">
				<div class="content-overlay"></div>
				<div class="content-wrapper">
					<section id="login" class="auth-height">
						<div class="row full-height-vh m-0">
							<div class="col-12 d-flex align-items-center justify-content-center">
								<div class="card overflow-hidden">
									<div class="card-content">
										<div class="card-body auth-img">
											<div class="row m-0">												
												<div class="col-lg-12 px-4 py-3">
													<div align="center">
														<img src="<?php echo base_url()?>themes/login/default/siks-ng-kemsos.png" alt="" class="img-fluid mb-3 animate__animated animate__slideInDown" width="300" height="230">
														<h4 class="mb-2 card-title animate__animated animate__bounceIn">Login</h4>
														<p class="animate__animated animate__bounceIn">Welcome back, please login to your account.</p>
													</div>													
													<div class="form-group mb-3">
														<?php
														if ( $this->session->flashdata('message') ) {
															echo '
															<div class="alert alert-danger" role="alert">' .
															$this->session->flashdata('message') . '
															</div>';
														}
														?>
													</div>
													<form method="post" action="<?php echo base_url( 'auth/login/auth' );?>">
														<input type="hidden" name="redirect_url" value="<?php echo ( ( isset( $_GET['redirect_url'] ) ) ? $_GET['redirect_url'] : '' );?>">
														<input type="text" class="form-control mb-3" name="username" id="Username" placeholder="08130xxxx" required>
														<input type="password" class="form-control mb-2" name="password" id="Password" placeholder="********" required>
														<div class="form-group mb-3">
															<?php if ( ! empty( $content ) ) echo $content;	?>
														</div>
													</form>
													<div align="center">
														<p class="text-muted">Aplikasi MK-DTKS | PUSDATIN KESOS</p>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</section>
				</div>
			</div>
		</div>
	</div>
</body>

</html>
