<html >
    <head>
        <meta charset="UTF-8">

        <script src="http://s.codepen.io/assets/libs/modernizr.js" type="text/javascript"></script>




        <link rel='stylesheet prefetch' href='http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css'>
        <link rel='stylesheet prefetch' href='http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css'>
        <link rel='stylesheet prefetch' href='http://cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.0/css/bootstrapValidator.min.css'>

        <link rel="stylesheet" href="../assets/css/contato.css">





    </head>
    <?php
    include '../include/head.php';
    include '../include/funcoes.php';
    validaAcesso();
    ?>

    <body class="">
        <?php include '../include/header.php'; ?>

        <div id="page-container">

            <?php include '../include/menu.php'; ?>

            <div id="page-content">
                <div id='wrap'>
                    <div id="page-heading">
                        <ol class="breadcrumb">
                            <!-- <li class='active'><a href="index.php">Home</a></li> -->
                        </ol>

                    </div>

                    <div class="container">
                        <div class="container">
                            <script src="../assets/js/pesquisaCep.js"></script>
                            <script src="../assets/js/mascaraCpf-Tel.js"></script>
                            <form class="well form-horizontal" action="contato.php" method="post"  id="form_contato">
                                <img src="..//assets/img/adsix_logog.png">
                                <fieldset>
                                    <!-- Form Name -->
                                    <legend>Fale conosco</legend>

                                    <!-- Text input-->

                                    <div class="form-group">
                                        <label class="col-md-4 control-label">Nome</label>
                                        <div class="col-md-4 inputGroupContainer">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="icon-user"></i></span>
                                                <input  name="nome" placeholder="Nome" class="form-control"  type="text" required>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Text input-->

                                    <div class="form-group">
                                        <label class="col-md-4 control-label">E-Mail</label>
                                        <div class="col-md-4 inputGroupContainer">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="icon-envelope"></i></span>
                                                <input name="email" placeholder="E-Mail" class="form-control"  type="email" required>
                                            </div>
                                        </div>
                                    </div>


                                    <!-- Text input-->

                                    <div class="form-group">
                                        <label class="col-md-4 control-label">Telefone </label>
                                        <div class="col-md-4 inputGroupContainer">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="icon-phone"></i></span>
                                                <input name="telefone" placeholder="(xx)xxxx-xxxx" class="form-control" onkeypress="javascript: mascara(this, tel_mask);" type="text" required>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Text input-->

                                    <div class="form-group">
                                        <label class="col-md-4 control-label">Mensagem</label>
                                        <div class="col-md-4 inputGroupContainer">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="icon-pencil"></i></span>
                                                <textarea class="form-control"  name="msg" cols="16" rows="5" placeholder="Mensagem" required ></textarea>

                                            </div>
                                        </div>
                                    </div>

                                    <!-- Success message -->
                                    <!-- <div class="alert alert-success" role="alert" id="success_message">Success <i class="glyphicon glyphicon-thumbs-up"></i> Thanks for contacting us, we will get back to you shortly.</div> -->

                                    <!-- Button -->
                                    <div class="form-group">
                                        <label class="col-md-4 control-label"></label>
                                        <div class="col-md-4">
                                            <button type="submit" >Enviar<span class="glyphicon glyphicon-send"></span></button>
                                        </div>
                                    </div>

                                </fieldset>
                            </form>
                        </div>
                    </div><!-- /.container -->
                </div> <!-- container -->
            </div> <!--wrap -->
            
        <?php include '../include/footer.php'; ?>

        </div> <!-- page-content -->


    <!--
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
    <script>!window.jQuery && document.write(unescape('%3Cscript src="assets/js/jquery-1.10.2.min.js"%3E%3C/script%3E'))</script>
    <script type="text/javascript">!window.jQuery.ui && document.write(unescape('%3Cscript src="assets/js/jqueryui-1.10.3.min.js'))</script>
    -->

    <script type='text/javascript' src='../assets/js/jquery-1.10.2.min.js'></script>
    <script type='text/javascript' src='../assets/js/jqueryui-1.10.3.min.js'></script>
    <script type='text/javascript' src='../assets/js/bootstrap.min.js'></script>
    <script type='text/javascript' src='../assets/js/enquire.js'></script>
    <script type='text/javascript' src='../assets/js/jquery.cookie.js'></script>
    <script type='text/javascript' src='../assets/js/jquery.touchSwipe.min.js'></script>
    <script type='text/javascript' src='../assets/js/jquery.nicescroll.min.js'></script>
    <script type='text/javascript' src='../assets/plugins/codeprettifier/prettify.js'></script>
    <script type='text/javascript' src='../assets/plugins/easypiechart/jquery.easypiechart.min.js'></script>
    <script type='text/javascript' src='../assets/plugins/sparklines/jquery.sparklines.min.js'></script>
    <script type='text/javascript' src='../assets/plugins/form-toggle/toggle.min.js'></script>
    <script type='text/javascript' src='../assets/plugins/form-wysihtml5/wysihtml5-0.3.0.min.js'></script>
    <script type='text/javascript' src='../assets/plugins/form-wysihtml5/bootstrap-wysihtml5.js'></script>
    <script type='text/javascript' src='../assets/plugins/fullcalendar/fullcalendar.min.js'></script>
    <script type='text/javascript' src='../assets/plugins/form-daterangepicker/daterangepicker.min.js'></script>
    <script type='text/javascript' src='../assets/plugins/form-daterangepicker/moment.min.js'></script>
    <script type='text/javascript' src='../assets/plugins/charts-flot/jquery.flot.min.js'></script>
    <script type='text/javascript' src='../assets/plugins/charts-flot/jquery.flot.resize.min.js'></script>
    <script type='text/javascript' src='../assets/plugins/charts-flot/jquery.flot.orderBars.min.js'></script>
    <script type='text/javascript' src='../assets/js/placeholdr.js'></script>
    <script type='text/javascript' src='../assets/demo/demo-index.js'></script>
    <script type='text/javascript' src='../assets/js/application.js'></script>
    <script type='text/javascript' src='../assets/demo/demo.js'></script>

    <script src='http://cdnjs.cloudflare.com/ajax/libs/bootstrap-validator/0.4.5/js/bootstrapvalidator.min.js'></script>

    <script src="../assets/js/contato.js"></script>
</body>
</html>