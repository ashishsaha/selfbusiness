<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?php echo $page_title;?></title>
    <link rel="icon" href="<?php echo base_url()?>assets/images/favicon.png" type="image/x-icon" />

    <!-- App CSS -->
    <link href="<?php echo base_url()?>assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url()?>assets/css/core.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url()?>assets/css/components.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url()?>assets/css/icons.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url()?>assets/css/pages.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url()?>assets/css/menu.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url()?>assets/css/responsive.css" rel="stylesheet" type="text/css" />

    <!-- HTML5 Shiv and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->

    <link href="<?php echo base_url()?>assets/css/custom.css" rel="stylesheet" type="text/css" />

    <script src="<?php echo base_url()?>assets/js/modernizr.min.js"></script>

    <style type="text/css">
        div.login_details
        {
            display: block;
            color: #000000;
            background-color: #ccc !important;
            border: 1px solid #ccc !important;
            margin-bottom:0 !important;
            max-width:346px;
            margin:0 auto;
        }
    </style>
</head>

<body>
<div class="account-pages"></div>
<div class="clearfix"></div>
<div class="wrapper-page">
    <?php echo $content; ?>
</div>

<script>
    var resizefunc = [];
</script>

<!-- jQuery  -->
<script src="<?php echo base_url()?>assets/js/jquery.min.js"></script>
<script src="<?php echo base_url()?>assets/js/bootstrap.min.js"></script>
<script src="<?php echo base_url()?>assets/js/detect.js"></script>
<script src="<?php echo base_url()?>assets/js/fastclick.js"></script>
<script src="<?php echo base_url()?>assets/js/jquery.slimscroll.js"></script>
<script src="<?php echo base_url()?>assets/js/jquery.blockUI.js"></script>
<script src="<?php echo base_url()?>assets/js/waves.js"></script>
<script src="<?php echo base_url()?>assets/js/wow.min.js"></script>
<script src="<?php echo base_url()?>assets/js/jquery.nicescroll.js"></script>
<script src="<?php echo base_url()?>assets/js/jquery.scrollTo.min.js"></script>

<!-- App js -->
<script src="<?php echo base_url()?>assets/js/jquery.core.js"></script>
<script src="<?php echo base_url()?>assets/js/jquery.app.js"></script>

</body>
</html>