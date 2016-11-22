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
    //validaAcesso();
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
                            <form class="well form-horizontal" action=" " method="post"  id="contact_form">
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
                                                <input  name="first_name" placeholder="Nome" class="form-control"  type="text">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Text input-->

                                    <div class="form-group">
                                        <label class="col-md-4 control-label" >Sobrenome</label>
                                        <div class="col-md-4 inputGroupContainer">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="icon-user"></i></span>
                                                <input name="last_name" placeholder="Sobrenome" class="form-control"  type="text">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Text input-->
                                    <div class="form-group">
                                        <label class="col-md-4 control-label">E-Mail</label>
                                        <div class="col-md-4 inputGroupContainer">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="icon-envelope"></i></span>
                                                <input name="email" placeholder="E-Mail" class="form-control"  type="text">
                                            </div>
                                        </div>
                                    </div>


                                    <!-- Text input-->

                                    <div class="form-group">
                                        <label class="col-md-4 control-label">Telefone </label>
                                        <div class="col-md-4 inputGroupContainer">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="icon-phone"></i></span>
                                                <input name="phone" placeholder="(xx)xxxx-xxxx" class="form-control" onkeypress="javascript: mascara(this, tel_mask);" type="text">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Text input-->

                                    <div class="form-group">
                                        <label class="col-md-4 control-label">Endereço</label>
                                        <div class="col-md-4 inputGroupContainer">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="icon-home"></i></span>
                                                <input name="address" placeholder="Endereço" class="form-control" type="text">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Text input-->

                                    <div class="form-group">
                                        <label class="col-md-4 control-label">Cidade</label>
                                        <div class="col-md-4 inputGroupContainer">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="icon-home"></i></span>
                                                <input name="city" placeholder="Cidade" class="form-control"  type="text">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Select Basic -->

                                    <div class="form-group">
                                        <label class="col-md-4 control-label">Estado</label>
                                        <div class="col-md-4 selectContainer">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="icon-list"></i></span>
                                                <select name="estado" class="form-control selectpicker" >
                                                    <option selected="" value="">Selecione o Estado (UF)</option>
                                                    <option value="Acre">Acre</option>
                                                    <option value="Alagoas">Alagoas</option>
                                                    <option value="Amapá">Amapá</option>
                                                    <option value="Amazonas">Amazonas</option>
                                                    <option value="Bahia">Bahia</option>
                                                    <option value="Ceará">Ceará</option>
                                                    <option value="Distrito Federal">Distrito Federal</option>
                                                    <option value="Espírito Santo">Espírito Santo</option>
                                                    <option value="Goiás">Goiás</option>
                                                    <option value="Maranhão">Maranhão</option>
                                                    <option value="Mato Grosso">Mato Grosso</option>
                                                    <option value="Mato Grosso do Sul">Mato Grosso do Sul</option>
                                                    <option value="Minas Gerais">Minas Gerais</option>
                                                    <option value="Pará">Pará</option>
                                                    <option value="Paraíba">Paraíba</option>
                                                    <option value="Paraná">Paraná</option>
                                                    <option value="Pernambuco">Pernambuco</option>
                                                    <option value="Piauí">Piauí</option>
                                                    <option value="Rio de Janeiro">Rio de Janeiro</option>
                                                    <option value="Rio Grande do Sul">Rio Grande do Sul</option>
                                                    <option value="Rio Grande do Norte">Rio Grande do Norte</option>
                                                    <option value="Rondônia">Rondônia</option>
                                                    <option value="Roraima">Roraima</option>
                                                    <option value="Santa Catarina">Santa Catarina</option>
                                                    <option value="São Paulo">São Paulo</option>
                                                    <option value="Sergipe">Sergipe</option>
                                                    <option value="Tocantins">Tocantins</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Text input-->

                                    <div class="form-group">
                                        <label class="col-md-4 control-label">CEP</label>
                                        <div class="col-md-4 inputGroupContainer">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="icon-home"></i></span>
                                                <input name="cep" placeholder="CEP" class="form-control"  type="text">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-4 control-label">Mensagem</label>
                                        <div class="col-md-4 inputGroupContainer">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="icon-pencil"></i></span>
                                                <textarea class="form-control" name="comment" placeholder="Mensagem"></textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Success message -->
                                    <div class="alert alert-success" role="alert" id="success_message">Success <i class="glyphicon glyphicon-thumbs-up"></i> Obrigado por nos contactar, retornaremos o mais breve possível!</div>

                                    <!-- Button -->
                                    <div class="form-group">
                                        <label class="col-md-4 control-label"></label>
                                        <div class="col-md-4">
                                            <button type="submit" class="btn btn-warning" >Enviar<span class="glyphicon glyphicon-send"></span></button>
                                        </div>
                                    </div>

                                </fieldset>
                            </form>
                        </div>
                    </div><!-- /.container -->
                </div> <!-- container -->
            </div> <!--wrap -->
        </div> <!-- page-content -->

        <?php include '../include/footer.php'; ?>

    </div> <!-- page-container -->

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
