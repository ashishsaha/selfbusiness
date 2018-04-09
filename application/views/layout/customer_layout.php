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
<body class="fixed-left customer-panel">
<!-- Begin page -->
<div id="wrapper">

    <!-- Top Bar -->
    <?php $this->load->view('element/customer_topbar'); ?>

    <div class="content-page customer-page-container">
        <div class="content">
            <div class="container">
                    <?php echo $content; ?>
            </div>
        </div>
        <footer class="footer text-right customer-footer">
            2016 &copy; <?php echo $this->session->userdata['userData']['session_corporate_account_name']; ?>. All rights reserved.
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


<script type="text/javascript">
    $(document).ready(function () {
        //$('#datatable').dataTable();
        //$('#datatable-keytable').DataTable( { keys: true } );
        //$('#datatable-responsive').DataTable();
        //$('#datatable-scroller').DataTable( { ajax: "<?php echo base_url()?>assets/plugins/datatables/json/scroller-demo.json", deferRender: true, scrollY: 380, scrollCollapse: true, scroller: true } );
        //var table = $('#datatable-fixed-header').DataTable( { fixedHeader: true } );

        /*$('#datatable-buttons').DataTable( {
         "order": [[ 3, "desc" ]]
         } );*/
    });
    TableManageButtons.init();

    /*$(document).ready(function() {
     $('#not_access').delay(3000).fadeOut('slow');
     });*/
</script>

<script type="text/javascript">
    $(document).ready(function () {
        $('#notification_show').click(function () {
            var target = '<?php echo base_url();?>dashboard/notification/';
            //alert(target);
            var form_data = '';
            document.getElementById('notification_list').innerHTML = '<img src="<?php echo base_url();?>assets/images/preloader.gif" alt="">';
            $.ajax({
                url: target,
                //asnc: true,
                type: 'POST',
                data: form_data,
                success: function (data, textStatus, XMLHttpRequest) {
                    if (data != '') {
                        //alert("222");
                        document.getElementById('notification_list').innerHTML = data;
                    }
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    //alert("444");
                    //alert("error"+data.success_message);
                }
            });
        });


        $('.left-sidebar-menu li a').on('click', function (event) {
            $('li a.active').removeClass('active');
            $(this).addClass('active');
            event.preventDefault();
        }
    });


    /*$('#sidebar-menu li a').on('click', function(){
     $(this).addClass('active').parent().siblings().children().removeClass('active');
     });*/

</script>

<!--For Calendar-->
<?php /*if ($calendar == 'Calendar') { */ ?><!--
    <script type="text/javascript">
        if ($('#fc-button-calendar').val() == '') {
            $('#fc-button-calendar').val('month');
        }

        $('.fc-month-button').click(function () {
            //alert('111');
            $('#fc-button-calendar').val('month');
        });

        $('.fc-agendaWeek-button').click(function () {
            //alert('222');
            $('#fc-button-calendar').val('agendaWeek');
        });

        $('.fc-agendaDay-button').click(function () {
            //alert('333');
            $('#fc-button-calendar').val('agendaDay');
        });
    </script>
--><?php /*} */ ?>

</body>
</html>