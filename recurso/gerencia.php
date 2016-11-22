<?php
include '../include/head.php';
include '../include/funcoes.php';
include '../include/conexao/conecta.php';
validaAcesso();
$conexao = conecta();

if (isset($_GET['acao']) && $_GET['acao'] != '') {

    $acao = $_GET['acao'];

    $id = (isset($_GET['id']) && !empty($_GET['id'])) ? $_GET['id'] : 0;
    $id = base64_decode($id);

    if ($acao == 'excluir') {
        $deletaRecurso = $conexao->prepare("DELETE FROM recurso WHERE id_recurso = :id");
        $deletaRecurso->bindValue(":id", $id);
        $deletaRecurso->execute();

        if ($deletaRecurso->rowCount() == 0) {
            echo "<script>alert('Houve um erro ao deletar!');
                location.href=\"index.php\"</script>";
        } else {
            echo "<script>alert('Registro excluido com sucesso!');
                   location.href=\"index.php\"</script>";
        }
    }
    if ($acao == 'visualizar' || $acao == 'editar') {
        $pegaRecursos = $conexao->prepare("SELECT * FROM recurso WHERE id_recurso = :id");
        $pegaRecursos->bindValue(":id", $id);
        $pegaRecursos->execute();
        $recurso = $pegaRecursos->fetch(PDO::FETCH_ASSOC);

        $id = $recurso['id_recurso'];
        $codigoProcesso = $recurso['cd_processo'];
        $codigoRecurso = $recurso['cd_recurso'];
        $anoRecurso = $recurso['aa_recurso'];
        $dataTransJulgado = $recurso['dt_transito_julgado'];
        $dataInicioJulg = $recurso['dt_inicio_julgamento_recurso'];
        $dataJulgado = $recurso['dt_julgado_recurso'];
       
        $resultado = $recurso['ds_resultado_recurso'];
        $notificacao = $recurso['dt_notificacao_recurso'];
        $arquivoDeprot = $recurso['dt_arquivo_deprot'];
        $observacoes = $recurso['ds_observacao_recurso'];
    }

    if ($acao == 'novo') {

        $id = 0;
        $codigoProcesso = "";
        $codigoRecurso = "";
        $anoRecurso = "";
        $dataTransJulgado = "";
        $dataInicioJulg = "";
        $dataJulgado = "";
        $resultado = "";
        $notificacao = "";
        $arquivoDeprot = "";
        $observacoes = "";
    }
}

if (isset($_POST['id_recurso']) && $_POST['id_recurso'] != '') {
    $id = $_POST['id_recurso'];
    $codigoProcesso = $_POST['cd_processo'];
    $codigoRecurso = $_POST['cd_recurso'];
    $anoRecurso = $_POST['aa_recurso'];
    $dataTransJulgado = $_POST['dt_transito_julgado'];
    $dataJulgamento = $_POST['dt_inicio_julgamento_recurso'];
    $dataInicioJulg = $_POST['dt_inicio_julgamento_recurso'];
    $dataJulgado = $_POST['dt_julgado_recurso'];
    
    $resultado = $_POST['ds_resultado_recurso'];
    $notificacao = $_POST['dt_notificacao_recurso'];
    $arquivoDeprot = $_POST['dt_arquivo_deprot'];
    $observacoes = $_POST['ds_observacao_recurso'];



    if (empty($id)) {


        try {
            $novoRecurso = $conexao->prepare("INSERT INTO recurso (cd_processo, cd_recurso, aa_recurso, dt_transito_julgado, dt_inicio_julgamento_recurso,"
                . "dt_julgado_recurso, ds_resultado_recurso, dt_notificacao_recurso, dt_arquivo_deprot, ds_observacao_recurso) "
                    . "VALUES ( :codigoProcesso, :codigoRecurso, :anoRecurso, :dataTransJulgado, :dataInicioJulg , :dataJulgado, :resultado, :notificacao, :arquivoDeprot, :observacoes)");
            $novoRecurso->bindValue(":codigoProcesso", $codigoProcesso);
            $novoRecurso->bindValue(":codigoRecurso", $codigoRecurso);
            $novoRecurso->bindValue(":anoRecurso", $anoRecurso, PDO::PARAM_STR);
            $novoRecurso->bindValue(":dataTransJulgado", $dataTransJulgado, PDO::PARAM_STR);
            $novoRecurso->bindValue(":dataInicioJulg", $dataInicioJulg, PDO::PARAM_STR);
            $novoRecurso->bindValue(":dataJulgado", $dataJulgado, PDO::PARAM_STR);
            $novoRecurso->bindValue(":resultado", $resultado, PDO::PARAM_STR);
            $novoRecurso->bindValue(":notificacao", $notificacao, PDO::PARAM_STR);
            $novoRecurso->bindValue(":arquivoDeprot", $arquivoDeprot, PDO::PARAM_STR);
            $novoRecurso->bindValue(":observacoes", $observacoes, PDO::PARAM_STR);

            $novoRecurso->execute();
            // echo $novoUsuario->rowCount();
            //var_dump($novoUsuario);


            $retorno = 'inserido';
        } catch (Exception $e) {
            echo $e;
            exit($e);
        }
    } else {
        try {
            $atualizarRecurso = $conexao->prepare("UPDATE recurso SET cd_processo = :codigoProcesso, cd_recurso = :codigoRecurso, aa_recurso = :anoRecurso, dt_transito_julgado = :dataTransJulgado, dt_inicio_julgamento_recurso = :dataInicioJulg, dt_julgado_recurso = :dataJulgado, ds_resultado_recurso = :resultado, dt_notificacao_recurso  = :notificacao, dt_arquivo_deprot = :arquivoDeprot, ds_observacao_recurso = :observacoes "
                    . "WHERE id_recurso = :id");
            $atualizarRecurso->bindValue(":codigoProcesso", $codigoProcesso);
            $atualizarRecurso->bindValue(":codigoRecurso", $codigoRecurso);
            $atualizarRecurso->bindValue(":anoRecurso", $anoRecurso, PDO::PARAM_STR);
            $atualizarRecurso->bindValue(":dataTransJulgado", $dataTransJulgado, PDO::PARAM_STR);
            $atualizarRecurso->bindValue(":dataInicioJulg", $dataInicioJulg, PDO::PARAM_STR);
            $atualizarRecurso->bindValue(":dataJulgado", $dataJulgado, PDO::PARAM_STR);
            $atualizarRecurso->bindValue(":resultado", $resultado, PDO::PARAM_STR);
            $atualizarRecurso->bindValue(":notificacao", $notificacao, PDO::PARAM_STR);
            $atualizarRecurso->bindValue(":arquivoDeprot", $arquivoDeprot, PDO::PARAM_STR);
            $atualizarRecurso->bindValue(":observacoes", $observacoes, PDO::PARAM_STR);
            $atualizarRecurso->bindValue(":id", $id);
            $atualizarRecurso->execute();

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
                        <li class='active'><a href="../home.php">Home</a> > <a href="index.php">Recursos</a> > <?php echo $acao ?></li>

                    </ol>
                    <h1>Recursos</h1>            
                </div>       

                <div class="container">               

                    <div class="panel panel-midnightblue">

                        <div class="panel-heading">
                            <h4>Dados do recurso</h4>

                        </div>
                        <div class="panel-body collapse in">

                            <form id="formRecurso" name="formRecurso"  action="gerencia.php" method="post"  class="form-horizontal" />
                            <input type="hidden" name="id_recurso" id="id_recurso" value="<?php echo($id); ?>">
                            <div class="form-group">                                                    
                                <label class="col-sm-2 control-label">Número do processo</label>
                                <div class="col-sm-4">                                        
                                    <select name="cd_processo" id="cd_processo" class="form-control" <?php if($acao == 'visualizar'){?>disabled="disabled" <?php };?> required>
                                        <option value='' >Número do processo...</option>
                                                   <?php try {
                                                        $processos = $conexao->prepare("SELECT * FROM processo");
                                                       
                                                        $processos->execute();
                                                    } catch (Exception $e) {
                                                        echo $e;
                                                        exit();
                                                    } ?>
                                                            <?php while ($processo = $processos->fetch(PDO::FETCH_ASSOC)) { ?>
                                            <option value='<?php echo $processo['cd_processo']; ?>' <?php echo ($processo['cd_processo']==$codigoProcesso)? 'selected' : ''; ?>><?php echo $processo['cd_processo']; ?>  </option>
                                        <?php } ?>                                              
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Número do recurso</label>
                                <div class="col-sm-4">
                                    <input type="number" name="cd_recurso" id="cd_recurso" class="form-control" value="<?php echo($codigoRecurso); ?>" <?php if ($acao == 'visualizar') { ?>readonly="readonly" <?php }; ?>min="1" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">Ano do Recurso</label>
                                <div class="col-sm-4">
                                    <input name="aa_recurso" id="aa_recurso" type="text" class="form-control"  value="<?php echo $anoRecurso ?>" <?php if ($acao == 'visualizar') { ?>readonly="readonly" <?php }; ?> pattern="[0-9]{4}" title="No mínimo quatro caracteres (Apenas números)." required/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Trânsito em julg.</label>
                                <div class="col-sm-4">
                                    <input name="dt_transito_julgado" id="dt_transito_julgado" type="date" class="form-control"  value="<?php echo $dataTransJulgado ?>" <?php if ($acao == 'visualizar') { ?>readonly="readonly" <?php }; ?> required/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Inicio do Julgamento</label>
                                <div class="col-sm-4">
                                    <input name="dt_inicio_julgamento_recurso" id="dt_inicio_julgamento_recurso" type="date" class="form-control"  value="<?php echo $dataInicioJulg ?>" <?php if ($acao == 'visualizar') { ?>readonly="readonly" <?php }; ?> />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Julgado</label>
                                <div class="col-sm-4">
                                    <input name="dt_julgado_recurso" id="dt_julgado_recurso" type="date" class="form-control"  value="<?php echo $dataJulgado ?>" <?php if ($acao == 'visualizar') { ?>readonly="readonly" <?php }; ?> />
                                </div>
                            </div>
                           

                            <div class="form-group">
                                <label class="col-sm-2 control-label">Resultado</label>
                                <div class="col-sm-4">
                                    <select name="ds_resultado_recurso" id="ds_resultado_recurso" class="form-control" <?php if ($acao == 'visualizar') { ?>disabled="disabled" <?php }; ?> >
                                        <option value=''>-</option>
                                        <option value="ABSOLVIÇÃO" <?php echo($resultado == 'ABSOLVIÇÃO') ? 'selected' : ''; ?>>ABSOLVIÇÃO</option>
                                        <option value="MULTA" <?php echo($resultado == 'MULTA') ? 'selected' : ''; ?>>MULTA</option>
                                        <option value="NÃO COMPARECEU" <?php echo($resultado == 'NÃO COMPARECEU') ? 'selected' : ''; ?>>NÃO COMPARECEU</option>
                                        <option value="JUSTIFICADO" <?php echo($resultado == 'JUSTIFICADO') ? 'selected' : ''; ?>>JUSTIFICADO</option>
                                        <option value="ADVERTÊNCIA" <?php echo($resultado == 'ADVERTENCIA') ? 'selected' : ''; ?>>ADVERTÊNCIA</option>
                                        <option value="SUSPENSÃO" <?php echo($resultado == 'SUSPENSÃO') ? 'selected' : ''; ?>>SUSPENSÃO</option>
                                        <option value="CASSAÇÃO" <?php echo($resultado == 'CASSAÇÃO') ? 'selected' : ''; ?>>CASSAÇÃO</option>
                                    </select> 
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Notificado</label>
                                <div class="col-sm-4">
                                    <input name="dt_notificacao_recurso" id="dt_notificacao_recurso" type="date" class="form-control"  value="<?php echo $notificacao ?>" <?php if ($acao == 'visualizar') { ?>readonly="readonly" <?php }; ?> />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Data arquivo DEPROT</label>
                                <div class="col-sm-4">
                                    <input name="dt_arquivo_deprot" id="dt_notificacao_recurso" type="date" class="form-control"  value="<?php echo $arquivoDeprot ?>" <?php if ($acao == 'visualizar') { ?>readonly="readonly" <?php }; ?> />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Observações</label>
                                <div class="col-sm-4">
                                    <textarea name="ds_observacao_recurso" id="ds_observacao_recurso" class="form-control" rows="4" cols="50" 
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
