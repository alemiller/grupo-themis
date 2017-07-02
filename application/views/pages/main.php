
<?php $this->load->view("templates/header"); ?>
<script type="text/javascript">
    var base_url = "<?php echo base_url(); ?>";

</script>
<style type="text/css">

    /* Override ribbon style */
    #ribbon {
        padding: 0;
    }
    .ribbon-button-alignment {
        padding-left: 13px;
    }
    .nav>li {
        width: 130px;
        text-align: center;
        font-size: 14px;
    }
    .dropdown-menu>li>a {
        text-align: left;
    }
    #logo {
        display: inline-block;
        width: 160px;
        margin-top: 0px;
        margin-left: 15px;
    }
    #logo img {
        width: 145px!important;
        height: auto;
        margin-top: 3px;
    }
</style>

<body class="smart-style-0">

    <!-- HEADER -->
    <header id="header">
        <div id="logo-group">
            <span id="logo"> <img src="<?php echo base_url(); ?>assets/img/isologo.png" alt="UVod"></span>
        </div>

        <div class="pull-right">

            <!-- collapse menu button -->
            <div id="hide-menu" class="btn-header pull-right">
                <span> <a href="javascript:void(0);" title="Collapse Menu"><i class="fa fa-reorder"></i></a> </span>
            </div>
            <!-- end collapse menu -->

            <!-- logout button -->
            <div id="logout" class="btn-header transparent pull-right">
                <span> <a href="adminLogin/logout" title="Sign Out"><i class="fa fa-sign-out"></i></a> </span>
            </div>
            <!-- end logout button -->

            <!-- search mobile button (this is hidden till mobile view port) -->
            <div id="search-mobile" class="btn-header transparent pull-right">
                <span> <a href="javascript:void(0)" title="Search"><i class="fa fa-search"></i></a> </span>
            </div>
            <!-- end search mobile button -->



        </div>
    </header>

    <!-- Left panel : Navigation area -->
    <aside id="left-panel">

        <!-- User info -->
        <div class="login-info">
            <span>
                <a href="#" id="show-shortcut">

                    <span>
                        <?php
                        //session_start();
                        //echo $_SESSION['user'];

                        echo $this->session->userdata('user');
                        ?>&nbsp;&nbsp;
                    </span>
                  
                </a> 
            </span>
        </div>
        <!-- end user info -->

        <nav>
            <ul>
                <li>
                    <a href="clientes" class="nav-menu-link"><i class="fa fa-lg fa-fw fa-user"></i><span class="menu-item-parent">Clientes</span></a>
                </li>
                <li>
                    <a href="tramites" class="nav-menu-link"><i class="fa fa-lg fa-fw fa-archive"></i><span class="menu-item-parent">Trámites</span></a>
                </li>
                <li>
                    <a href="corresponsales" class="nav-menu-link"><i class="fa fa-lg fa-fw fa-briefcase"></i><span class="menu-item-parent">Corresponsales</span></a>
                </li>
                <li>
                    <a href="#"><i class="fa fa-lg fa-fw fa-cog"></i><span class="menu-item-parent nav-menu-link">Configuración</span></a>
                    <ul>
                        <li>
                            <a href="clases_tramite" class="nav-menu-link"><i class="fa fa-fw fa-list-ul"></i> <span> Clases de Trámite</span></a>  
                        </li>
                        <li>
                            <a href="zonas" class="nav-menu-link"><i class="fa fa-fw fa-globe"></i> <span> Zonas</span></a>
                        </li>
                        <li>
                            <a href="subzonas" class="nav-menu-link"><i class="fa fa-fw fa-globe"></i> <span> Sub-zonas</span></a>
                        </li>
                        <?php if ($this->session->userdata('user_type') === "superadmin") { ?>
                            <li>
                                <a href="usuarios" class="nav-menu-link"><i class="fa fa-fw fa-group"></i> <span> Usuarios</span></a>
                            </li>
                            <?php
                        }
                        ?>
                    </ul>
            </ul>
        </nav>
        <span class="minifyme"> <i class="fa fa-arrow-circle-left hit"></i> </span>

    </aside>

    <!-- MAIN PANEL -->
    <div id="main" role="main">

        <!-- RIBBON -->
        <div id="ribbon">


            <!-- breadcrumb -->
            <ol class="breadcrumb">
                <li>Dashboard</li>
            </ol>
            <!-- end breadcrumb -->


            <!-- NavBar -->
            <div class="collapse navbar-collapse navbar-inverse" >



            </div>
        </div>
        <!-- END RIBBON -->

        <!-- MAIN CONTENT -->
        <div id="content">

        </div>
        <!-- END MAIN CONTENT -->

    </div>
    <!-- END MAIN PANEL -->

    <!--================================================== -->

    <!-- PACE LOADER -->
    <script data-pace-options='{ "restartOnRequestAfter": true }' src="<?php echo base_url(); ?>assets/js/plugin/pace/pace.min.js"></script>

    <!-- Link to Google CDN's jQuery + jQueryUI; fall back to local -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
    <script>
    if (!window.jQuery) {
        document.write('<script src="<?php echo base_url(); ?>assets/js/libs/jquery-2.0.2.min.js"><\/script>');
    }
    </script>

    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
    <script>
    if (!window.jQuery.ui) {
        document.write('<script src="<?php echo base_url(); ?>assets/js/libs/jquery-ui-1.10.3.min.js"><\/script>');
    }
    </script>

    <!-- JS TOUCH -->
    <script src="<?php echo base_url(); ?>assets/js/plugin/jquery-touch/jquery.ui.touch-punch.min.js"></script> 
    <!-- BOOTSTRAP JS -->
    <script src="<?php echo base_url(); ?>assets/js/bootstrap/bootstrap.min.js"></script>
    <!-- CUSTOM NOTIFICATION -->
    <script src="<?php echo base_url(); ?>assets/js/notification/SmartNotification.min.js"></script>
    <!-- JARVIS WIDGETS -->
    <script src="<?php echo base_url(); ?>assets/js/smartwidgets/jarvis.widget.min.js"></script>
    <!-- EASY PIE CHARTS -->
    <script src="<?php echo base_url(); ?>assets/js/plugin/easy-pie-chart/jquery.easy-pie-chart.min.js"></script>
    <!-- SPARKLINES -->
    <script src="<?php echo base_url(); ?>assets/js/plugin/sparkline/jquery.sparkline.min.js"></script>
    <!-- JQUERY VALIDATE -->
    <script src="<?php echo base_url(); ?>assets/js/plugin/jquery-validate/jquery.validate.min.js"></script>
    <!-- JQUERY MASKED INPUT -->
    <script src="<?php echo base_url(); ?>assets/js/plugin/masked-input/jquery.maskedinput.min.js"></script>
    <!-- JQUERY SELECT2 INPUT -->
    <script src="<?php echo base_url(); ?>assets/js/plugin/select2/select2.min.js"></script>
    <!-- JQUERY UI + Bootstrap Slider -->
    <script src="<?php echo base_url(); ?>assets/js/plugin/bootstrap-slider/bootstrap-slider.min.js"></script>
    <!-- browser msie issue fix -->
    <script src="<?php echo base_url(); ?>assets/js/plugin/msie-fix/jquery.mb.browser.min.js"></script>
    <!-- FastClick: For mobile devices -->
    <script src="<?php echo base_url(); ?>assets/js/plugin/fastclick/fastclick.js"></script>

    <script src="<?php echo base_url(); ?>assets/js/plugin/datatables/jquery.dataTables-cust.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/plugin/datatables/ColReorder.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/plugin/datatables/FixedColumns.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/plugin/datatables/ColVis.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/plugin/datatables/ZeroClipboard.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/plugin/datatables/media/js/TableTools.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/plugin/datatables/DT_bootstrap.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/plugin/datatables/fnFilterClear.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/genericos.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/helpers.js"></script>

    <!--[if IE 7]>
    <h1>Your browser is out of date, please update your browser by going to www.microsoft.com/download</h1>
    <![endif]-->

    <!-- MAIN APP JS FILE -->
    <script src="<?php echo base_url(); ?>assets/js/app.js"></script>


    <script>
    $(document).ready(function () {





// PAGE RELATED SCRIPTS
        $(".js-status-update a").click(function () {
            var selText = $(this).text();
            var $this = $(this);
            $this.parents('.btn-group').find('.dropdown-toggle').html(selText + ' <span class="caret"></span>');
            $this.parents('.dropdown-menu').find('li').removeClass('active');
            $this.parent().addClass('active');
        });



    })
    </script>

</body>
</html>