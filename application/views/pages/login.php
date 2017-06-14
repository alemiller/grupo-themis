<!DOCTYPE html>
<html lang="en-us">
    <head>
        <meta charset="utf-8">
        <!--<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">-->

        <title> Grupo Themis | Admin Portal </title>
        <meta name="description" content="">
        <meta name="author" content="DigitAles">

        <!-- 
        <meta name="HandheldFriendly" content="True">
        <meta name="MobileOptimized" content="320">-->

        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <link rel="image/x-icon" href="<?php echo base_url(); ?>assets/css/img/favicon.ico">
        <link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url(); ?>assets/css/bootstrap.min.css">  
        <link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url(); ?>assets/css/font-awesome.min.css">
        <link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url(); ?>assets/css/smartadmin-production.css">
        <link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url(); ?>assets/css/smartadmin-skins.css"> 

        <!-- Demo purpose only: goes with demo.js, you can delete this css when designing your own WebApp -->
        <link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url(); ?>assets/css/style.css">
        <link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url(); ?>assets/css/jquery-ui-1.9.2.custom.css">

        <!-- FAVICONS -->
        <link rel="shortcut icon" href="img/favicon/favicon.ico" type="image/x-icon">
        <link rel="icon" href="img/favicon/favicon.ico" type="image/x-icon">

        <!-- GOOGLE FONT -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,300,400,700">

        <script type="text/javascript">
            base_url = "<?php echo base_url(); ?>";
        </script>

        <script src="<?php echo base_url(); ?>assets/js/plugin/pace/pace.min.js"></script>

        <!-- Link to Google CDN's jQuery + jQueryUI; fall back to local -->
        <script src="<?php echo base_url(); ?>assets/js/jquery-1.11.0.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/jquery-ui-1.9.2.custom.js"></script>

        <!-- JS TOUCH : include this plugin for mobile drag / drop touch events     
        <script src="js/plugin/jquery-touch/jquery.ui.touch-punch.min.js"></script> -->

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

        <!--[if IE 7]>
          
          <h1>Your browser is out of date, please update your browser by going to www.microsoft.com/download</h1>
          
        <![endif]-->

        <!-- MAIN APP JS FILE -->
        <script src="<?php echo base_url(); ?>assets/js/app.js"></script>

    </head>

    <body id="login" class="animated fadeInDown" style="height: 100%">
        <header id="mainHeader">
        </header>
        <script type="text/javascript">
            msg = '<?php (isset($msg) ? $msg : ''); ?>';
        </script>

       

        <div id="main" role="main" style="min-height: 100%;height: auto!important;margin: 0 auto -45px;">
            <div id="content" class="container" style="padding-top: 100px;">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-7 col-lg-6 hidden-xs hidden-sm">
                        <div class="hero">
                            <img id="logo-img" src="<?php echo base_url() . '/assets/img/logo.jpg'; ?>"/>
                        </div>
                    </div>
                    <div id="signUp"  class="col-xs-12 col-sm-12 col-md-5 col-lg-4">
                        <div class="well no-padding">
                            <form action="login/log_user" method="POST" id="login-form" class="smart-form client-form">
                                <header>
                                    LogIn
                                </header>

                                <fieldset>

                                    <section>
                                        <label class="label">Usuario</label>
                                        <label class="input"> <i class="icon-append fa fa-user"></i>
                                            <input type="text" name="user" id="user" class="metadata">
                                            <b class="tooltip tooltip-top-right"><i class="fa fa-user txt-color-teal"></i> Por favor ingrese su username</b></label>
                                    </section>

                                    <section>
                                        <label class="label">Password</label>
                                        <label class="input"> <i class="icon-append fa fa-lock"></i>
                                            <input type="password" name="password" id="password" class="metadata">
                                            <b class="tooltip tooltip-top-right"><i class="fa fa-lock txt-color-teal"></i> Ingrese su password</b> </label>
                                        <div class="note">
                                        </div>
                                    </section>

                                    <section>
                                        <div id="error-msg" class="alert alert-danger fade in" style="display: none;">
                                            <button class="close">×</button>
                                            <strong>Error: </strong> El usuario o el password son incorrectos
                                        </div>

                                    </section>
                                </fieldset>
                                <footer>
                                    <button type="submit" id='btnLogin' class="btn btn-primary">
                                        Ingresar
                                    </button>
                                </footer>
                            </form>

                        </div>
                    </div>
                </div>
            </div>

        </div>

        <footer id="main-footer">
            <p>©2017 Grupo-Themis. Todos los derechos reservados.</p>
        </footer>



        <script type="text/javascript">

            $(function () {

                $('#user').focus();

                $('#login-form input').focus(function () {

                    if ($('#password').hasClass('login-error')) {
                        $(this).val('');
                    }
                    $(this).removeClass('login-error');
                    $('#error-msg').hide();
                });

                $("#btnLogin").click(function (event) {

                    admin_login();

                    event.preventDefault();
                });



                $(document).on('submit', '#login-form', function (event) {
                    admin_login();
                    event.preventDefault();
                });


                function admin_login() {

                    $.ajax({
                        url: '<?php echo base_url(); ?>index.php/adminLogin/login',
                        type: 'POST',
                        dataType: 'json',
                        data: "user=" + $('#user').val() + "&password=" + $('#password').val(),
                        success: function (data) {
                            console.log(data);

                            if (data) {
                                window.location.href = 'main#clientes';
                            } else {
                                console.log('distinto a uno')
                                $('input.metadata').addClass('login-error');
                                $('#error-msg').show();


                            }
                        }
                    });
                }
            });
        </script>



