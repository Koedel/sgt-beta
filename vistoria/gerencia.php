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
        $deletaVistoria = $conexao->prepare("DELETE FROM vistoria WHERE cd_vistoria = :id");
        $deletaVistoria->bindValue(":id", $id);
        $deletaVistoria->execute();

        if ($deletaVistoria->rowCount() == 0) {
            echo "<script>alert('Houve um erro ao deletar!');
                location.href=\"index.php\"</script>";
        } else {
            echo "<script>alert('Registro excluido com sucesso!');
                   location.href=\"index.php\"</script>";
        }
    }
    if ($acao == 'visualizar' || $acao == 'editar') {
        $pegaVistorias = $conexao->prepare("SELECT * FROM vistoria WHERE cd_vistoria = :id");
        $pegaVistorias->bindValue(":id", $id);
        $pegaVistorias->execute();
        $vistoria = $pegaVistorias->fetch(PDO::FETCH_ASSOC);

        $id = $vistoria['cd_vistoria'];
        $placa = $vistoria['cd_placa'];
        $modalidade = $vistoria['cd_modalidade'];
        $dataVistoria = $vistoria['dt_vistoria'];
        $resultado = $vistoria['ds_resultado'];
        $tipoVistoria = $vistoria['nm_vistoria'];
        $observacoes = $vistoria['ds_observacao'];
    }

    if ($acao == 'novo') {

        $id = 0;
        $placa = "";
        $modalidade = "";
        $dataVistoria = "";
        $resultado = "";
        $tipoVistoria = "";
        $observacoes = "";
    }
}

if (isset($_POST['cd_vistoria']) && $_POST['cd_vistoria'] != '') {
    $id = $_POST['cd_vistoria'];
    $placa = $_POST['cd_placa'];
    $modalidade = $_POST['cd_modalidade'];
    $dataVistoria = $_POST['dt_vistoria'];
    $resultado = $_POST['ds_resultado'];
    $tipoVistoria = $_POST['nm_vistoria'];
    $observacoes = $_POST['ds_observacao'];



    if (empty($id)) {


        try {
            $novaVistoria = $conexao->prepare("INSERT INTO vistoria (cd_placa, cd_modalidade, dt_vistoria, ds_resultado, nm_vistoria,"
                    . "ds_observacao) "
                    . "VALUES ( :placa, :modalidade, :dataVistoria, :resultado, :tipoVistoria, :observacoes)");
            $novaVistoria->bindValue(":placa", $placa, PDO::PARAM_STR);
            $novaVistoria->bindValue(":modalidade", $modalidade);
            $novaVistoria->bindValue(":dataVistoria", $dataVistoria, PDO::PARAM_STR);
            $novaVistoria->bindValue(":resultado", $resultado, PDO::PARAM_STR);
            $novaVistoria->bindValue(":tipoVistoria", $tipoVistoria, PDO::PARAM_STR);
            $novaVistoria->bindValue(":observacoes", $observacoes, PDO::PARAM_STR);
            $novaVistoria->execute();
         // echo $novaVistoria->rowCount();
           //    var_dump($novaVistoria);
          //  echo $novaVistoria->errorCode();
             //  exit();
          $retorno = 'inserido';
        } catch (Exception $e) {
            echo $e;
            exit($e);
        }
    } else {
        try {
            $atualizarVistoria = $conexao->prepare("UPDATE vistoria SET cd_placa = :placa, cd_modalidade = :modalidade, dt_vistoria = :dataVistoria, ds_resultado = :resultado, nm_vistoria = :tipoVistoria, ds_observacao = :observacoes "
                    . "WHERE cd_vistoria = :id");
            $atualizarVistoria->bindValue(":placa", $placa, PDO::PARAM_STR);
            $atualizarVistoria->bindValue(":modalidade", $modalidade);
            $atualizarVistoria->bindValue(":dataVistoria", $dataVistoria, PDO::PARAM_STR);
            $atualizarVistoria->bindValue(":resultado", $resultado, PDO::PARAM_STR);
            $atualizarVistoria->bindValue(":tipoVistoria", $tipoVistoria, PDO::PARAM_STR);
            $atualizarVistoria->bindValue(":observacoes", $observacoes, PDO::PARAM_STR);
            $atualizarVistoria->bindValue(":id", $id);
            $atualizarVistoria->execute();

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
                        <li class='active'><a href="../home.php">Home</a> > <a href="index.php">Vistorias</a> > <?php echo $acao ?></li>

                    </ol>
                    <h1>Vistorias</h1>            
                </div>       

                <div class="container">               

                    <div class="panel panel-midnightblue">

                        <div class="panel-heading">
                            <h4>Dados da vistoria</h4>

                        </div>
                        <div class="panel-body collapse in">

                            <form id="formVistoria" name="formVistoria"  action="gerencia.php" method="post"  class="form-horizontal" />
                            <input type="hidden" name="cd_vistoria" id="id_processo" value="<?php echo($id); ?>">
                           <div class="form-group">                                                    
                                <label class="col-sm-2 control-label">Tipo do Serviço</label>
                                <div class="col-sm-4">                                        
                                    <select name="cd_modalidade" id="cd_modalidade" class="form-control" <?php if ($acao == 'visualizar') { ?>disabled="disabled" <?php }; ?> required>
                                        <option value='' >Tipo do Serviço..</option>
                                        <?php
                                        try {
                                            $tipoServicos = $conexao->prepare("SELECT DISTINCT c.cd_modalidade, t.nm_modalidade FROM veiculo c , tipoVeiculo t where c.cd_modalidade = t.cd_modalidade");
                                            $tipoServicos->execute();
                                        } catch (Exception $e) {
                                            echo $e;
                                            exit();
                                        }
                                        ?>
                                        <?php while ($tipoServico = $tipoServicos->fetch(PDO::FETCH_ASSOC)) { ?>
                                            <option value='<?php echo $tipoServico['cd_modalidade']; ?>' <?php echo ($tipoServico['cd_modalidade'] == $modalidade) ? 'selected' : ''; ?>><?php echo $tipoServico['nm_modalidade']; ?>  </option>
                                        <?php } ?>                                              
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">                                                    
                                <label class="col-sm-2 control-label">Placa</label>
                                <div class="col-sm-4">                                        
                                    <select name="cd_placa" id="cd_placa" class="form-control" <?php if ($acao == 'visualizar') { ?>disabled="disabled" <?php }; ?> required>
                                        <option value='' >Placa..</option>
                                        <?php
                                        try {
                                            $placasVeiculo = $conexao->prepare("SELECT * FROM veiculo");
                                            $placasVeiculo->execute();
                                        } catch (Exception $e) {
                                            echo $e;
                                            exit();
                                        }
                                        ?>
                                        <?php while ($placas = $placasVeiculo->fetch(PDO::FETCH_ASSOC)) { ?>
                                            <option value='<?php echo $placas['cd_placa']; ?>' <?php echo ($placas['cd_placa']== $placa) ? 'selected' : ''; ?>><?php echo $placas['cd_placa']; ?>  </option>
                                        <?php } ?>                                              
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">Data da Vistoria</label>
                                <div class="col-sm-4">
                                    <input name="dt_vistoria" id="dt_vistoria" type="date" class="form-control"  value="<?php echo $dataVistoria ?>" <?php if ($acao == 'visualizar') { ?>readonly="readonly" <?php }; ?> required/>
                                </div>
                            </div>
                            

                            <div class="form-group">
                                <label class="col-sm-2 control-label">Resultado</label>
                                <div class="col-sm-4">
                                    <select name="ds_resultado" id="ds_resultado" class="form-control" <?php if ($acao == 'visualizar') { ?>disabled="disabled" <?php }; ?> >
                                        <option value=''>-</option>
                                        <option value="REPROVADO" <?php echo($resultado == 'REPROVADO') ? 'selected' : ''; ?>>REPROVADO</option>
                                        <option value="APROVADO" <?php echo($resultado == 'APROVADO') ? 'selected' : ''; ?>>APROVADO</option>
                                       
                                    </select> 
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Tipo da Vistoria</label>
                                <div class="col-sm-4">
                                    <select name="nm_vistoria" id="nm_vistoria" class="form-control" <?php if ($acao == 'visualizar') { ?>disabled="disabled" <?php }; ?> required >
                                        <option value=''>-</option>
                                        <option value="VISTORIA NORMAL" <?php echo($tipoVistoria == 'VISTORIA NORMAL') ? 'selected' : ''; ?>>VISTORIA NORMAL</option>
                                        <option value="OUTRO" <?php echo($tipoVistoria == 'OUTRO') ? 'selected' : ''; ?>>OUTRO</option>
                                       
                                    </select> 
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Observações</label>
                                <div class="col-sm-4">
                                    <textarea name="ds_observacao" id="ds_observacao" class="form-control" rows="4" cols="50" 
<?php if ($acao == 'visualizar') { ?>readonly="readonly" <?php }; ?> ><?php echo $observacoes ?></textarea>
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

