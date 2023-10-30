<!DOCTYPE html>
<html class="loading" lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <title>Data Terpadu Kesejahteraan Sosial</title>
    <link rel="shortcut icon" type="image/x-icon" href="<?= base_url( THEMES_BACKEND );?>app-assets/img/ico/favicon-kemsos.ico">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-touch-fullscreen" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">

    <link href="https://fonts.googleapis.com/css?family=Rubik:300,400,500,700,900%7CMontserrat:300,400,500,600,700,800,900" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.0.0/animate.min.css" />
    <link rel="stylesheet" type="text/css" href="<?= base_url( THEMES_BACKEND );?>app-assets/css/toastr/toastr.min.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url( THEMES_BACKEND );?>app-assets/fonts/feather/style.min.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url( THEMES_BACKEND );?>app-assets/fonts/simple-line-icons/style.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url( THEMES_BACKEND );?>app-assets/fonts/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url( THEMES_BACKEND );?>app-assets/vendors/css/perfect-scrollbar.min.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url( THEMES_BACKEND );?>app-assets/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url( THEMES_BACKEND );?>app-assets/css/bootstrap-extended.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url( THEMES_BACKEND );?>app-assets/css/components.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url( THEMES_BACKEND );?>new-assets/css/style.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url( THEMES_BACKEND );?>app-assets/css/colors.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url( THEMES_BACKEND );?>app-assets/vendors/css/select2.min.css">

    <script src="<?= base_url( THEMES_BACKEND );?>new-assets/jquery/jquery.js"></script>
    <?php echo ( isset( $header_script ) ? $header_script : '' );?>
    <style media="screen">
    .breadcrumb {padding: 2px 15px !important;}
    .padd {padding: 7px}
    .anims {border-radius: 3px;}
    .trr:nth-child(even) {background-color: #f2f2f2;}
    .trr {text-align:center}

    .p0 {padding: 4px 14px 4px 14px; background-color: #000000; color: #ffffff;}
    .p1 {padding: 4px 15px 4px 15px; background-color: #808080; color: #ffffff;}
    .p2 {padding: 4px 14px 4px 14px; background-color: #2f4f4f; color: #ffffff;}
    .p3 {padding: 4px 14px 4px 14px; background-color: #fdb347; color: #ffffff;}
    .p3a {padding: 4px 10px 4px 10px; background-color: #df3c5e; color: #ffffff;}
    .m1 {padding: 4px 14px 4px 14px; background-color: #56b2d3; color: #ffffff;}
    .m2 {padding: 4px 14px 4px 14px; background-color: #fdd835; color: #000000;}
    .m3 {padding: 4px 14px 4px 14px; background-color: #98c337; color: #ffffff;}
    .m4 {padding: 4px 13px 4px 13px; background-color: #006400; color: #ffffff;}
    .m4a {padding: 4px 8px 4px 8px; background-color: #df3c5e; color: #ffffff;}
    .c1 {padding: 4px 15px 4px 15px; background-color: #006400; color: #ffffff;}
    .c1a {padding: 4px 12px 4px 12px; background-color: #ff4500; color: #ffffff;}
    .c2 {padding: 4px 14px 4px 14px; background-color: #006400; color: #ffffff;}
    .c2a {padding: 4px 10px 4px 10px; background-color: #df3c5e; color: #ffffff;}
    .mk {padding: 4px 12px 4px 12px; background-color: #006400; color: #ffffff;}
    .mka {padding: 4px 8px 4px 8px; background-color: #df3c5e; color: #ffffff;}
    .mkb {padding: 4px 8px 4px 8px; background-color: #df3c5e; color: #ffffff;}
    .q1a {padding: 4px 12px 4px 12px; background-color: #ff4500; color: #ffffff;}
    .q1b {padding: 4px 12px 4px 12px; background-color: #ff4500; color: #ffffff;}
    .q2 {padding: 4px 15px 4px 15px; background-color: #006400; color: #ffffff;}
    .q2a {padding: 4px 12px 4px 12px; background-color: #df3c5e; color: #ffffff;}
    .q2b {padding: 4px 12px 4px 12px; background-color: #006400; color: #ffffff;}

    </style>
</head>
<?php
    $user_info = $_SESSION['user_info'];
    $last_login = $this->db->get_where('dbo.core_user_account', ['user_account_id' => $user_info['user_id']])->row('user_account_last_login_datetime');
    if ( $user_info['user_image'] != '' && file_exists( ADMIN_IMAGE . $user_info['user_image'] ) ) {
        $profile_image = $user_info['w'];
    } else {
        $profile_image = 'default.png';
    }
?>
<body class="vertical-layout vertical-menu 2-columns navbar-sticky bg-default" data-menu="vertical-menu" data-col="2-columns">

    <nav class="navbar navbar-expand-lg navbar-light header-navbar navbar-fixed">
        <div class="container-fluid navbar-wrapper">
            <div class="navbar-header d-flex">
                <div class="navbar-toggle menu-toggle d-xl-none d-block float-left align-items-center justify-content-center" data-toggle="collapse"><i class="ft-menu font-medium-3"></i></div>
                <ul class="navbar-nav">
                    <li class="nav-item mr-2 d-none d-lg-block"><a class="nav-link apptogglefullscreen" id="navbar-fullscreen" href="javascript:;"><i class="ft-maximize font-medium-3"></i></a></li>
                    <li class="nav-item mr-2 d-none d-lg-block animate__animated animate__lightSpeedInRight">
                        <img src="<?php echo base_url()?>themes/admin/able/logo-siksng.png" alt="" class="img-fluid animate__animated animate__slideInDown" width="100" height="38">
                    </li>
                    <li class="nav-item mr-2 d-none d-lg-block animate__animated animate__lightSpeedInRight">
                        <p style="font-size:12px;margin-bottom:-5px">Monitoring Kualitas</p>
                        <p style="font-size:12px;margin-bottom:-2px">Data Terpadu Kesejahteraan Sosial</p>
                    </li>
                </ul>
            </div>
            <div class="navbar-container">
                <div class="collapse navbar-collapse d-block" id="navbarSupportedContent">
                    <ul class="navbar-nav">
                        <li class="i18n-dropdown dropdown nav-item mr-2">
                            <a class="nav-link d-flex">

                            </a>
                        </li>
                        <li class="i18n-dropdown dropdown nav-item mr-2">
                            <a class="nav-link d-flex">
                                <span style="font-size:12px">Last Login : <?php echo convert_datetime($last_login);?></span>
                            </a>
                        </li>
                        <li class="dropdown nav-item mr-1">
                            <div class="nav-link dropdown-toggle user-dropdown d-flex align-items-end" id="dropdownBasic2" href="javascript:;" data-toggle="dropdown">
                                <div class="user d-md-flex d-none mr-2">
                                    <span class="text-right"><?php echo $user_info['user_username'];?></span><span class="text-right text-muted font-small-3"><?php echo $user_info['user_name'];?></span>
                                </div>
                                <img class="avatar" src="<?php echo base_url( 'assets/images/profile/' ) . $profile_image;?>" alt="avatar" height="35" width="35">
                            </div>
                            <div class="dropdown-menu text-left dropdown-menu-right m-0 pb-0" aria-labelledby="dropdownBasic2">
                                <a class="dropdown-item" href="<?php echo base_url( 'logout' );?>">
                                    <div class="d-flex align-items-center"><i class="ft-power mr-2"></i><span>Logout</span></div>
                                </a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

<div class="wrapper">
    <div class="app-sidebar menu-fixed" data-background-color="white" data-image="<?= base_url( THEMES_BACKEND );?>/app-assets/img/sidebar-bg/06.jpg" data-scroll-to-active="true">
        <div class="sidebar-header">
            <div class="logo clearfix">
                <a class="logo-text float-left" href="<?php echo base_url();?>">
                    <div class="logo-img">
                        <img src="<?= base_url( THEMES_BACKEND );?>app-assets/img/logo-nav-kemsos.png" width="35" height="35" alt="Logo" />
                    </div>
                    <span class="text" style="font-family:Tahoma, Geneva, sans-serif">MK-DTKS</span>
                </a>
                <a class="nav-toggle d-none d-lg-none d-xl-block" id="sidebarToggle" href="javascript:;"><i class="toggle-icon ft-toggle-right" data-toggle="expanded"></i></a>
                <a class="nav-close d-block d-lg-block d-xl-none" id="sidebarClose" href="javascript:;"><i class="ft-x"></i></a>
            </div>
        </div>
        <div class="sidebar-content main-menu-content">
            <div class="nav-container">
                <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
                    <?php require('nav.php'); ?>
                </ul>
            </div>
        </div>
        <div class="sidebar-background"></div>
    </div>

    <div class="main-panel">
        <div class="main-content">
            <div class="content-overlay"></div>
            <div class="content-wrapper">
                <div class="row">
                    <div class="col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a class="text-info" href="<?= base_url();?>"><i class="ft-home submenu-icon"></i> Home</a></li>
                            <?php
                            if ( isset( $breadcrumb ) && is_array( $breadcrumb ) && !empty( $breadcrumb ) ){
                                $length = count( $breadcrumb );
                                $num = 1;
                                foreach ( $breadcrumb as $title => $link ) {
                                    $class_active = ( ( $num == $length ) ? "active" : null );
                                    echo '
                                    <li class="breadcrumb-item ' . $class_active . '">
                                    <a class="text-info" href="' . $link . '">' . $title. '</a>
                                    </li>';
                                }
                            }
                            ?>
                        </ol>
                        <div class="float-right mr-2" style="margin-top: -39px">
                            <a href="#" data-toggle="modal" class="text-info" data-target="#info"><i class="ft-info submenu-icon"></i> Informasi Status</a>
                        </div>
                    </div>
                </div>
                <section id="configuration">
                    <div class="row">
                        <div class="col-12">
                            <?php
                            if ( ! empty( $content ) ) echo $content;
                            ?>
                        </div>
                    </div>
                </section>
            </div>
        </div>

        <footer class="footer undefined undefined">
            <p class="clearfix text-blue m-0"><span>Copyright &copy; 2020 &nbsp;</span><a href="#">MK-DTKS</a><span class="d-none d-sm-inline-block">, All rights reserved.</span></p>
        </footer>
        <button class="btn btn-primary scroll-top" type="button"><i class="ft-arrow-up"></i></button>

    </div>
</div>

<!-- Modal -->
<div class="modal fade text-left" id="info" tabindex="-1" role="dialog" aria-labelledby="myModalLabel11" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h4 class="modal-title" id="myModalLabel11">Informasi Status</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="ft-x font-medium-2 text-bold-700"></i></span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table width="100%" border='1'>
                        <thead>
                            <tr class="trr">
                                <th colspan="2">Status RUTA</th>
                                <th colspan="2">Status ART</th>   
                            </tr>
                            <tr class="trr">
                                <th>Icon</th>
                                <th>Descript</th>
                                <th>Icon</th>
                                <th>Description</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="trr">
                                <td class="padd"><span class="anims p0">P0</span></td><td>Prelist Awal</td>
                                <td class="padd"><span class="anims mk">MK</span></td><td>Padan</td>
                            </tr>
                            <tr class="trr">
                                <td class="padd"><span class="anims p1">P1</span></td><td>Publish Ke Korwil</td>
                                <td class="padd"><span class="anims mka">MKa</span></td><td>Tidak Padan API Ditjen Capil</td>
                            </tr>
                            <tr class="trr">
                                <td class="padd"><span class="anims p2">P2</span></td><td>Publish Ke Korkab</td>
                                <td class="padd"><span class="anims mkb">MKb</span></td><td>Tidak Terkonfirmasi</td>
                            </tr>
                            <tr class="trr">
                                <td class="padd"><span class="anims p3">P3</span></td><td>Publish Ke Petugas</td>
                                <td class="padd"><span class="anims q1a">Q1a</span></td><td>Lolos QC Korkab NIK Tidak Padan</td>
                            </tr>
                            <tr class="trr">
                                <td class="padd"><span class="anims p3a">P3a</span></td><td>Prelist Kembali Ke Petugas</td>
                                <td class="padd"><span class="anims q1b">Q1b</span></td><td>Lolos QC Korkab NIK Tidak Terkonfirmasi</td>
                            </tr>
                            <tr class="trr">
                                <td class="padd"><span class="anims m1">M1</span></td><td>Simpan Pengumpul Data</td>
                                <td class="padd"><span class="anims q2">Q2</span></td><td>NIK Terkonfirmasi, NIK Padan Dukcapil</td>
                            </tr>
                            <tr class="trr">
                                <td class="padd"><span class="anims m2">M2</span></td><td>Survey Pengumpul Data</td>
                                <td class="padd"><span class="anims q2a">Q2a</span></td><td>NIK Tidak Padan Dukcapil</td>
                            </tr>
                            <tr class="trr">
                                <td class="padd"><span class="anims m3">M3</span></td><td>Survey Final</td>
                                <td class="padd"><span class="anims q2b">Q2b</span></td><td>NIK Tidak Terkonfirmasi, NIK Padan Dukcapil</td>
                            </tr>
                            <tr class="trr">
                                <td class="padd"><span class="anims m4">M4</span></td><td>Terkonfirmasi</td>
                                <td colspan="2" rowspan="6"></td>
                            </tr>
                            <tr class="trr">
                                <td class="padd"><span class="anims m4a">M4a</span></td><td>Tidak Terkonfirmasi</td>
                            </tr>
                            <tr class="trr">
                                <td class="padd"><span class="anims c1">C1</span></td><td>Sebagian ART Padan/Tidak Padan</td>
                            </tr>
                            <tr class="trr">
                                <td class="padd"><span class="anims c1a">C1a</span></td><td>Tidak Padan/Tidak Terkonfirmasi</td>
                            </tr>
                            <tr class="trr">
                                <td class="padd"><span class="anims c2">C2</span></td><td>NIK ART Padan Semua</td>
                            </tr>
                            <tr class="trr">
                                <td class="padd"><span class="anims c2a">C2a</span></td><td>NIK ART Tidak Padan</td>
                            </tr>                       
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn bg-light-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- End-Modal -->

<div class="sidenav-overlay"></div>
<div class="drag-target"></div>

<script src="<?= base_url( THEMES_BACKEND );?>app-assets/js/toastr/toastr.min.js"></script>
<script src="<?= base_url( THEMES_BACKEND );?>app-assets/js/toastr/abe-toast.js"></script>
<script src="<?= base_url( THEMES_BACKEND );?>app-assets/vendors/js/vendors.min.js"></script>
<script src="<?= base_url( THEMES_BACKEND );?>app-assets/vendors/js/switchery.min.js"></script>
<script src="<?= base_url( THEMES_BACKEND );?>app-assets/js/core/app-menu.js"></script>
<script src="<?= base_url( THEMES_BACKEND );?>app-assets/js/core/app.js"></script>
<script src="<?= base_url( THEMES_BACKEND );?>new-assets/js/scripts.js"></script>
<script src="<?= base_url( THEMES_BACKEND );?>app-assets/js/components-modal.js"></script>
<script src="<?= base_url( THEMES_BACKEND );?>app-assets/js/customizer.js"></script>
<script src="<?= base_url( THEMES_BACKEND );?>app-assets/vendors/js/select2.full.min.js"></script>
</body>
</html>
