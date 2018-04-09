<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title><?php echo $page_title; ?></title>
    <base href="<?php echo base_url() ?>"/>
    <link rel="icon" href="<?php echo base_url() ?>assets/images/favicon.png" type="image/x-icon"/>

    <?php
    if (!empty($css)) {
        foreach ($css as $c) {
            ?>
            <link href="<?php echo base_url() . $c ?>" rel="stylesheet">
            <?php
        }
    }
    ?>

    <!-- App css -->
    <link href="<?php echo base_url() ?>assets/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo base_url() ?>assets/css/core.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo base_url() ?>assets/css/components.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo base_url() ?>assets/css/icons.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo base_url() ?>assets/css/pages.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo base_url() ?>assets/css/menu.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo base_url() ?>assets/css/responsive.css" rel="stylesheet" type="text/css"/>

    <!-- HTML5 Shiv and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->

    <script type="text/javascript" src="<?php echo base_url() ?>assets/js/modernizr.min.js"></script>

    <!--Add on 28_04_2016 For Custom Css-->
    <link href="<?php echo base_url() ?>assets/css/custom.css" rel="stylesheet" type="text/css"/>

</head>
<body class="fixed-left">
<!-- Begin page -->
<div id="wrapper">

    <!-- Top Bar -->
    <?php $this->load->view('element/admin_topbar'); ?>

    <!-- ========== Left Sidebar ========== -->
    <?php
    if ($this->session->userdata['userData']['session_role_id'] == 1) {
        $this->load->view('element/super_admin_left_sidebar');
    } elseif ($this->session->userdata['userData']['session_role_id'] == 4) { // Staff
        $this->load->view('element/staff_left_sidebar');
    }  elseif ($this->session->userdata['userData']['session_role_id'] == 3) { // Admin
        $this->load->view('element/admin_left_sidebar');
    } else { // Corporate Super Admin 2
        $this->load->view('element/corporate_super_admin_left_sidebar');
    }
    ?>
    <div class="content-page">
        <div class="content">
            <div class="container">
                <?php echo $content; ?>
            </div>
        </div>
        <footer class="footer text-right">
            <?php echo date('Y');?> &copy; <b>Banglasofts</b>. All rights reserved.
        </footer>
    </div>

    <!-- ============================================================== -->
    <!-- End Right content here -->
    <!-- ============================================================== -->

    <?php $this->load->view('element/admin_right_sidebar'); ?>
</div>
<!-- END wrapper -->

<script>
    var resizefunc = [];
</script>

<!-- jQuery  -->
<script src="<?php echo base_url() ?>assets/js/jquery.min.js"></script>
<script src="<?php echo base_url() ?>assets/js/bootstrap.min.js"></script>
<script src="<?php echo base_url() ?>assets/js/detect.js"></script>
<script src="<?php echo base_url() ?>assets/js/fastclick.js"></script>
<script src="<?php echo base_url() ?>assets/js/jquery.blockUI.js"></script>
<script src="<?php echo base_url() ?>assets/js/waves.js"></script>
<script src="<?php echo base_url() ?>assets/js/jquery.nicescroll.js"></script>
<script src="<?php echo base_url() ?>assets/js/jquery.scrollTo.min.js"></script>

<?php
if (!empty($js)) {
    foreach ($js as $v) {
        ?>
        <script type="text/javascript" src="<?php echo base_url() . $v ?>"></script>
        <?php
    }
}
?>

<?php
if (!empty($js_form)) {
    foreach ($js_form as $v) {
        ?>
        <script type="text/javascript" src="<?php echo base_url() . $v ?>"></script>
        <?php
    }
}
?>

<!-- KNOB JS -->
<!--[if IE]>
<script type="text/javascript" src="assets/plugins/jquery-knob/excanvas.js"></script>
<![endif]-->

<!-- Validation js (Parsleyjs) -->
<?php
if (!empty($form_validation)) {
    echo $form_validation;
}
?>

<!-- App js -->
<script src="<?php echo base_url() ?>assets/js/jquery.core.js"></script>
<script src="<?php echo base_url() ?>assets/js/jquery.app.js"></script>

<!--Date Picker-->
<?php
if (!empty($form_datepicker)) {
    echo $form_datepicker;
}
?>




</body>
</html>
