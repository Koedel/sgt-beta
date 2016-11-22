<?php
include '../include/head.php';
include '../include/funcoes.php';
include '../include/conexao/conecta.php';
$conexao = conecta();
validaAcesso();


if (isset($_GET['acao']) && $_GET['acao'] != '') {

    $acao = $_GET['acao'];

    $id = (isset($_GET['id']) && !empty($_GET['id'])) ? $_GET['id'] : 0;
    $id = base64_decode($id);

    if ($acao == 'excluir') {
        $deletaInfracao = $conexao->prepare("DELETE FROM infracao WHERE id_infracao = :id");
        $deletaInfracao->bindValue(":id", $id);
        $deletaInfracao->execute();

        if ($deletaInfracao->rowCount() == 0) {
            echo "<script>alert('Houve um erro ao deletar!');
                location.href=\"index.php\"</script>";
        } else {
            echo "<script>alert('Registro excluido com sucesso!');
                   location.href=\"index.php\"</script>";
        }
    }
    if ($acao == 'visualizar' || $acao == 'editar') {
        $pegaInfracoes = $conexao->prepare("SELECT * FROM infracao WHERE id_infracao = :id");
        $pegaInfracoes->bindValue(":id", $id);
        $pegaInfracoes->execute();
        $infracao = $pegaInfracoes->fetch(PDO::FETCH_ASSOC);

        $id = $infracao['id_infracao'];
        $codigoInfracao = $infracao['cd_infracao'];
        $tipoMulta = $infracao['nm_tipo_multa'];
        $cd_ait = $infracao['cd_ait'];        
        $descricao = $infracao['nm_infracao'];
        $pontos = $infracao['qt_pontuacao'];
        $valor = $infracao['vl_infracao'];
    }

    if ($acao == 'novo') {

        $id = 0;
        $codigoInfracao = "";
        $tipoMulta = "";
        $cd_ait = "";
        $descricao = "";
        $pontos = "";
        $valor = "";
    }
}

if (isset($_POST['id_infracao']) && $_POST['id_infracao'] != '') {
    $id = $_POST['id_infracao'];
    $codigoInfracao = $_POST['cd_infracao'];
        $tipoMulta = $_POST['nm_tipo_multa'];
        $cd_ait = $_POST['cd_ait'];        
        $descricao = $_POST['nm_infracao'];
        $pontos = $_POST['qt_pontuacao'];
        $valor = $_POST['vl_infracao'];



    if (empty($id)) {


        try {
            $novaInfracao = $conexao->prepare("INSERT INTO infracao (cd_infracao, nm_tipo_multa, cd_ait, nm_infracao, qt_pontuacao,"
                    . "vl_infracao ) "
                    . "VALUES ( :codigoInfracao, :tipoMulta, :cd_ait, :descricao, :pontos, :valor )");
            $novaInfracao->bindValue(":codigoInfracao", $codigoInfracao);
            $novaInfracao->bindValue(":tipoMulta", $tipoMulta, PDO::PARAM_STR);
            $novaInfracao->bindValue(":cd_ait", $cd_ait);
            $novaInfracao->bindValue(":descricao", $descricao, PDO::PARAM_STR);
            $novaInfracao->bindValue(":pontos", $pontos);
            $novaInfracao->bindValue(":valor", $valor);

            $novaInfracao->execute();
            // echo $novoUsuario->rowCount();
            //var_dump($novoUsuario);


            $retorno = 'inserido';
        } catch (Exception $e) {
            echo $e;
            exit($e);
        }
    } else {
        try {
            $atualizarInfracao = $conexao->prepare("UPDATE infracao SET cd_infracao = :codigoInfracao, nm_tipo_multa = :tipoMulta, cd_ait = :cd_ait, nm_infracao = :descricao,"
                    . " qt_pontuacao = :pontos, vl_infracao = :valor "
                    . "WHERE id_infracao = :id");
            $atualizarInfracao->bindValue(":codigoInfracao", $codigoInfracao);
            $atualizarInfracao->bindValue(":tipoMulta", $tipoMulta, PDO::PARAM_STR);
            $atualizarInfracao->bindValue(":cd_ait", $cd_ait);
            $atualizarInfracao->bindValue(":descricao", $descricao, PDO::PARAM_STR);
            $atualizarInfracao->bindValue(":pontos", $pontos);
            $atualizarInfracao->bindValue(":valor", $valor);
            $atualizarInfracao->bindValue(":id", $id);
            $atualizarInfracao->execute();

//                echo $atualizarUsuario->rowCount();
//                var_dump($atualizarUsuario);
//                echo $atualizarUsuario->errorCode();
//                exit();

            $retorno = 'alterado';
        } catch (Exception $e) {
            echo $e;
            exit();
        }
    }

    if ($retorno) {
        header('Location: index.php?retorno=' . $retorno);
    } else {
        header('Location: gerencia.php?id=' . base64_encode($id) . '&acao=novo&retorno=invalido');
    }
}
?>
<script>alertaSucesso("a", "a", "a")</script>


<body class="">
<?php include '../include/header.php'; ?>

    <div id="page-container">

<?php include '../include/menu.php'; ?>

        <div id="page-content">
            <div id='wrap'>
                <div id="page-heading">
                    <ol class="breadcrumb">
                        <li class='active'><a href="../home.php">Home</a> > <a href="index.php">Infrações</a> > <?php echo $acao ?></li>

                    </ol>
                    <h1>Infrações</h1>            
                </div>       

                <div class="container">               

                    <div class="panel panel-midnightblue">

                        <div class="panel-heading">
                            <h4>Dados da infração</h4>

                        </div>
                        <div class="panel-body collapse in">

                            <form id="formMulta" name="formMulta"  action="gerencia.php" method="post"  class="form-horizontal" />
                            <input type="hidden" name="id_infracao" id="id_infracao" value="<?php echo($id); ?>">
                            <div class="form-group">                                                    
                                <label class="col-sm-2 control-label">Tipo de Multa</label>
                                <div class="col-sm-4">                                        
                                    <select name="nm_tipo_multa" id="nm_tipo_multa" class="form-control" <?php if ($acao == 'visualizar') { ?>disabled="disabled" <?php }; ?> required>
                                        <option value='' >Tipo de Multa...</option>
                                        
                                            <option value='A' <?php echo ($tipoMulta  == 'A') ? 'selected' : ''; ?>>A</option>
                                            <option value='B' <?php echo ($tipoMulta  == 'B') ? 'selected' : ''; ?>>B</option>
                                            <option value='C' <?php echo ($tipoMulta  == 'C') ? 'selected' : ''; ?>>C</option>
                                            <option value='D' <?php echo ($tipoMulta  == 'D') ? 'selected' : ''; ?>>D</option>
                                            <option value='E' <?php echo ($tipoMulta  == 'E') ? 'selected' : ''; ?>>E</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Código</label>
                                <div class="col-sm-4">
                                    <input type="number" name="cd_infracao" id="cd_infracao" class="form-control" value="<?php echo($codigoInfracao ); ?>" <?php if ($acao == 'visualizar') { ?>readonly="readonly" <?php }; ?>MIN="0" required>
                                </div>
                            </div>


                            <div class="form-group">
                                <label class="col-sm-2 control-label">Descrição</label>
                                <div class="col-sm-4">
                                    <input name="nm_infracao" id="nm_infracao" type="text" class="form-control"  value="<?php echo $descricao ?>" <?php if ($acao == 'visualizar') { ?>readonly="readonly" <?php }; ?> required/>
                                </div>
                            </div>
                            
<div class="form-group">                                                    
                                <label class="col-sm-2 control-label">Numero AIT</label>
                                <div class="col-sm-4">                                        
                                    <select name="cd_ait" id="cd_ait" class="form-control" <?php if ($acao == 'visualizar') { ?>disabled="disabled" <?php }; ?> >
                                        <option value='' >Numero AIT...</option>
                                        <?php
                                        try {
                                            $codigoAits = $conexao->prepare("SELECT * FROM multa ");

                                            $codigoAits->execute();
                                        } catch (Exception $e) {
                                            echo $e;
                                            exit();
                                        }
                                        ?>
<?php while ($codigoAit = $codigoAits->fetch(PDO::FETCH_ASSOC)) { ?>
                                            <option value='<?php echo $codigoAit['cd_ait']; ?>' <?php echo ($codigoAit['cd_ait'] == $cd_ait) ? 'selected' : ''; ?>><?php echo $codigoAit['cd_ait']; ?>  </option>
<?php } ?>                                              
                                    </select>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Quantidade de Pontos</label>
                                <div class="col-sm-4">
                                    <input name="qt_pontuacao" id="qt_pontuacao" type="number" class="form-control"  value="<?php echo $pontos  ?>" <?php if ($acao == 'visualizar') { ?>readonly="readonly" <?php }; ?> min="0" required/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Valor R$</label>
                                <div class="col-sm-4">
                                    <input name="vl_infracao" id="vl_infracao" type="number" class="form-control"  value="<?php echo $valor  ?>" <?php if ($acao == 'visualizar') { ?>readonly="readonly" <?php }; ?> required/>
                                </div>
                            </div>

                            <div class="panel-footer">
                                <div class="row">
                                    <div class="col-sm-6 col-sm-offset-3">
                                        <div class="btn-toolbar">
                                            <?php if ($acao == 'visualizar') { ?>
                                                <a class="btn-primary btn" href='index.php'>Voltar</a>
                                            <?php } else {
                                                ?>
                                                <button class="btn-primary btn" id="btn_gravar" >Gravar</button>
                                                <a class="btn-default btn" href='index.php'>Cancelar</a>
<?php }
?>
                                        </div>
                                    </div>
                                </div>
                            </div> 
                            </form>

                        </div>

                    </div>

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
    <script type='text/javascript' src='../assets/js/alertas.js'></script> 
    <script type='text/javascript' src='..assets/js/jqueryui-1.10.3.min.js'></script> 
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
    <script type='text/javascript' src='../assets/demo/demo-index.js'></script> 
    <script type='text/javascript' src='../assets/js/placeholdr.js'></script> 
    <script type='text/javascript' src='../assets/js/application.js'></script> 
    <script type='text/javascript' src='../assets/demo/demo.js'></script> 

</body>
</html>

