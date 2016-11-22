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
        $deletaTipoPessoa = $conexao->prepare("DELETE FROM tipoPessoa WHERE cd_tipo_pessoa = :id");
        $deletaTipoPessoa->bindValue(":id", $id);
        $deletaTipoPessoa->execute();
        if ($deletaTipoPessoa->rowCount() == 0) {
            echo "<script>alert('Houve um erro ao deletar!');
                location.href=\"index.php\"</script>";
        } else {
            echo "<script>alert('Registro excluido com sucesso!');
                   location.href=\"index.php\"</script>";
        }
    }
    if ($acao == 'visualizar' || $acao == 'editar') {
        $pegaTipoPessoa = $conexao->prepare("SELECT * FROM tipoPessoa WHERE cd_tipo_pessoa = :id");
        $pegaTipoPessoa->bindValue(":id", $id);
        $pegaTipoPessoa->execute();
        $tipopessoa = $pegaTipoPessoa->fetch(PDO::FETCH_ASSOC);
        $id = $tipopessoa['cd_tipo_pessoa'];
        $tipoPessoa = $tipopessoa['nm_tipo_pessoa'];
    }
    if ($acao == 'novo') {
        $id = 0;
        $tipoPessoa = "";
    }
}
if (isset($_POST['cd_tipo_pessoa']) && $_POST['cd_tipo_pessoa'] != '') {
    $id = $_POST['cd_tipo_pessoa'];
    $tipoPessoa = $_POST['nm_tipo_pessoa'];
    if (empty($id)) {
        $pegaTipoPessoa = $conexao->prepare("SELECT nm_tipo_pessoa FROM tipoPessoa WHERE nm_tipo_pessoa = :tipoPessoa");
            $pegaTipoPessoa->bindValue(":tipoPessoa", $tipoPessoa);
            $pegaTipoPessoa->execute();
 
            if($pegaTipoPessoa->rowCount() > 0){
            $retornoNome = 'nomeinvalido';
            
            }else{
        try {
            $novoTipoPessoa = $conexao->prepare("INSERT INTO tipoPessoa (nm_tipo_pessoa) "
                    . "VALUES ( :tipoPessoa)");
            $novoTipoPessoa->bindValue(":tipoPessoa", $tipoPessoa, PDO::PARAM_STR);
            $novoTipoPessoa->execute();
            // echo $novoUsuario->rowCount();
            //var_dump($novoUsuario);
            $retorno = 'inserido';
        } catch (Exception $e) {
            echo $e;
            exit($e);
        }
    } }else {
        try {
            $atualizarTipoPessoa = $conexao->prepare("UPDATE tipoPessoa SET nm_tipo_pessoa = :tipoPessoa "
                    . "WHERE cd_tipo_pessoa = :id");
            $atualizarTipoPessoa->bindValue(":tipoPessoa", $tipoPessoa, PDO::PARAM_STR);
            $atualizarTipoPessoa->bindValue(":id", $id);
            $atualizarTipoPessoa->execute();
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
    if ($retornoNome) {
        header('Location: gerencia.php?id=' . base64_encode($id) . '&acao=novo&retorno=nomeinvalido');
        } elseif($retorno){
            header('Location: index.php?retorno='.$retorno);
        }else{
            header('Location: gerencia.php?id='.base64_encode($id).'&acao=editar&retorno=invalido');
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
                        <li class='active'><a href="../home.php">Home</a> > <a href="index.php">Tipo de Pessoa</a> > <?php echo $acao ?></li>

                    </ol>
                    <h1>Tipo de Pessoa</h1>            
                </div>       

                <div class="container">               

                    <div class="panel panel-midnightblue">

                        <div class="panel-heading">
                            <h4>Dados do tipo de pessoa</h4>

                        </div>
                        <div class="panel-body collapse in">

                            <form id="formTipopessoa" name="formTipopessoa" action="gerencia.php"method="post"  class="form-horizontal" />
                            <input type="hidden" name="cd_tipo_pessoa" id="cd_tipo_pessoa" value="<?php echo($id); ?>">

                            <?php if (isset($_GET['retorno']) && $_GET['retorno'] == 'nomeinvalido') { ?>
                        <div class="form-group ">   
                            <label class="col-sm-2 control-label"></label>
                            <div class="alert alert-dismissable alert-danger col-sm-4 ">
                                <strong>Tipo de pessoa já cadastrado</strong>
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

                            </div>
                        </div>
                    <?php } ?>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Tipo de Pessoa</label>
                                <div class="col-sm-4">
                                    <input name="nm_tipo_pessoa" id="nm_tipo_pessoa" type="text" class="form-control"  value="<?php echo $tipoPessoa ?>" <?php if ($acao == 'visualizar') { ?>readonly="readonly" <?php }; ?> required="required" pattern=".{2,}" title="Preencha com dois ou mais caracteres"/>
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
