<!DOCTYPE html>
<html class="loading" lang="en">
<!-- BEGIN : Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <title>Data Terpadu Kesejahteraan Sosial</title>
    <link rel="shortcut icon" type="image/x-icon" href="<?= base_url(THEMES_BACKEND); ?>app-assets/img/ico/favicon-kemsos.ico">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-touch-fullscreen" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <!-- BEGIN VENDOR CSS-->
    <!-- font icons-->
    <link rel="stylesheet" type="text/css" href="<?= base_url(THEMES_BACKEND); ?>app-assets/fonts/feather/style.min.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url(THEMES_BACKEND); ?>app-assets/fonts/simple-line-icons/style.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url(THEMES_BACKEND); ?>app-assets/fonts/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url(THEMES_BACKEND); ?>app-assets/vendors/css/perfect-scrollbar.min.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url(THEMES_BACKEND); ?>app-assets/vendors/css/prism.min.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url(THEMES_BACKEND); ?>app-assets/vendors/css/switchery.min.css">
    <!-- END VENDOR CSS-->
    <!-- BEGIN APEX CSS-->
    <link rel="stylesheet" type="text/css" href="<?= base_url(THEMES_BACKEND); ?>app-assets/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url(THEMES_BACKEND); ?>app-assets/css/bootstrap-extended.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url(THEMES_BACKEND); ?>app-assets/css/colors.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url(THEMES_BACKEND); ?>app-assets/css/components.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url(THEMES_BACKEND); ?>app-assets/css/themes/layout-dark.css">
    <link rel="stylesheet" href="<?= base_url(THEMES_BACKEND); ?>app-assets/css/plugins/switchery.css">
    <!-- END APEX CSS-->
    <!-- BEGIN Page Level CSS-->
    <link rel="stylesheet" href="<?= base_url(THEMES_BACKEND); ?>app-assets/css/pages/authentication.css">
    <link rel="stylesheet" href="<?= base_url(THEMES_BACKEND); ?>app-assets/css/pages/page-error.css">
    <!-- END Page Level CSS-->
    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="<?= base_url(THEMES_BACKEND); ?>assets/css/style.css">
    <!-- END: Custom CSS-->
</head>
<!-- END : Head-->

<!-- BEGIN : Body-->

<body class="vertical-layout vertical-menu 1-column auth-page navbar-sticky blank-page" data-menu="vertical-menu" data-col="1-column">
    <!-- ////////////////////////////////////////////////////////////////////////////-->
    <div class="wrapper">
        <div class="main-panel">
            <!-- BEGIN : Main Content-->
            <div class="main-content">
                <div class="content-overlay"></div>
                <div class="content-wrapper">
                    <!--Error page starts-->
                    <section id="error" class="auth-height">
                        <div class="container-fluid">
                            <div class="row full-height-vh">
                                <div class="col-12 d-flex align-items-center justify-content-center">
                                    <div class="row">
                                        <div class="col-12 text-center">
                                            <img src="<?= base_url(THEMES_BACKEND); ?>app-assets/img/gallery/error.png" alt="" class="img-fluid error-img mt-2" height="300" width="400">
                                            <h1 class="mt-2">405 - Not Allowed!</h1>
                                            <div class="w-50 error-text mx-auto mt-2">
                                                <p>The page you are looking for might have beel removed, had it's name changed, or is temporarily unavailable.</p>
                                            </div>
                                            <a href="<?= base_url('config/menu') ?>" class="btn btn-warning my-2">Back To Home</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                    <!--Error page ends-->

                </div>
            </div>
            <!-- END : End Main Content-->
        </div>
    </div>
    <!-- ////////////////////////////////////////////////////////////////////////////-->

    <!-- BEGIN VENDOR JS-->
    <script src="<?= base_url(THEMES_BACKEND); ?>app-assets/vendors/js/vendors.min.js"></script>
    <script src="<?= base_url(THEMES_BACKEND); ?>app-assets/vendors/js/switchery.min.js"></script>
    <!-- BEGIN VENDOR JS-->
    <!-- BEGIN PAGE VENDOR JS-->
    <!-- END PAGE VENDOR JS-->
    <!-- BEGIN APEX JS-->
    <script src="<?= base_url(THEMES_BACKEND); ?>app-assets/js/core/app-menu.js"></script>
    <script src="<?= base_url(THEMES_BACKEND); ?>app-assets/js/core/app.js"></script>
    <script src="<?= base_url(THEMES_BACKEND); ?>app-assets/js/notification-sidebar.js"></script>
    <script src="<?= base_url(THEMES_BACKEND); ?>app-assets/js/customizer.js"></script>
    <script src="<?= base_url(THEMES_BACKEND); ?>app-assets/js/scroll-top.js"></script>
    <!-- END APEX JS-->
    <!-- BEGIN PAGE LEVEL JS-->
    <!-- END PAGE LEVEL JS-->
    <!-- BEGIN: Custom CSS-->
    <script src="<?= base_url(THEMES_BACKEND); ?>assets/js/scripts.js"></script>
    <!-- END: Custom CSS-->
</body>
<!-- END : Body-->

</html>