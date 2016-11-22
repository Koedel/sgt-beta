<?php
include '../include/conexao/conecta.php';
include '../include/head.php';
include '../include/funcoes.php';
validaAcesso();
$conexao = conecta();

if (isset($_GET['retorno']) && $_GET['retorno'] == 'inserido') {

    echo "<script>alert('Registro inserido com sucesso!');
                   location.href=\"index.php\"</script>";
}

if (isset($_GET['retorno']) && $_GET['retorno'] == 'alterado') {

    echo "<script>alert('Registro alterado com sucesso!');
                   location.href=\"index.php\"</script>";
}
//WHERE
$where = '';
$tipo_veiculo = '';
$filtroProcesso = '';
$aa_processo = '';
$denuncia = '';
$resultado = '';


if (isset($_POST['nm_modalidade']) && !empty($_POST['nm_modalidade'])) {
    $tipo_veiculo = $_POST['nm_modalidade'];
}
if (isset($_POST['processo']) && !empty($_POST['processo'])) {
    $processo = $_POST['processo'];
    $filtroProcesso = "AND cd_processo = $processo "; 
}

if (isset($_POST['aa_processo']) && !empty($_POST['aa_processo'])) {
    $aa_processo = $_POST['aa_processo'];
}

if (isset($_POST['dt_relato_denuncia']) && !empty($_POST['dt_relato_denuncia'])) {
    $denuncia = $_POST['dt_relato_denuncia'];
}

if (isset($_POST['ds_resultado']) && !empty($_POST['ds_resultado'])) {
    $resultado = $_POST['ds_resultado'];
}




// PAGINAÇÃO
$pagina = (isset($_GET['pagina']) && !empty($_GET['pagina']) ? $_GET['pagina'] : 1);
$registros = 10;

$inicio = ($pagina - 1) * $registros;
$fim = $registros; //$pagina * $registros;

$limit = "LIMIT $inicio, $fim";


try {
    $contador = $conexao->prepare("SELECT count(*) as qtd FROM processo "
            . "WHERE nm_modalidade LIKE  :tipo_veiculo AND aa_processo LIKE :aa_processo "
            . "AND dt_relato_denuncia LIKE  :denuncia AND ds_resultado LIKE  :resultado 
                                  " . $filtroProcesso." " . $limit);

    $contador->bindValue(":tipo_veiculo", '%' . $tipo_veiculo . '%');
    
    $contador->bindValue(":aa_processo", '%' . $aa_processo . '%');
    $contador->bindValue(":denuncia", '%' . $denuncia . '%');
    $contador->bindValue(":resultado", '%' . $resultado . '%');

    $contador->execute();
} catch (Exception $e) {
    echo $e;
    exit();
}

$qtd = $contador->fetch(PDO::FETCH_ASSOC);
$ultima_pagina = ceil((int) $qtd['qtd'] / $registros);
//End PAGINAÇÃO

try {
    $processos = $conexao->prepare("SELECT * FROM processo "
            . "WHERE nm_modalidade LIKE  :tipo_veiculo AND  aa_processo LIKE :aa_processo "
            . "AND dt_relato_denuncia LIKE  :denuncia AND ds_resultado LIKE  :resultado 
                                 " .$filtroProcesso. "ORDER BY cd_processo ASC " . $limit);
    $processos->bindValue(":tipo_veiculo", '%' . $tipo_veiculo . '%');
    
    $processos->bindValue(":aa_processo", '%' . $aa_processo . '%');
    $processos->bindValue(":denuncia", '%' . $denuncia . '%');
    $processos->bindValue(":resultado", '%' . $resultado . '%');
    $processos->execute();
} catch (Exception $e) {
    echo $e;
    exit();
}
?>


<body class="">
<?php include '../include/header.php'; ?>

    <div id="page-container">

<?php include '../include/menu.php'; ?>

        <div id="page-content">
            <div id='wrap'>
                <div id="page-heading">
                    <ol class="breadcrumb">
                        <li class='active'><a href="../home.php">Home</a> > Processos</li>
                    </ol>
                    <h1>Processos</h1>  
                    <div class="options">
                        <div class="btn-toolbar">
                            <a href="gerencia.php?acao=novo"  class="btn btn-primary"><i class="icon-user"></i>&nbsp;&nbsp;Novo Processo</a>
                        </div>
                    </div>
                </div>      
                <div class="container">               
                    <div class="container">		
                        <div class="row">
                            <div class="col-md-12">
                                <div class="panel panel-primary">
                                    <div class="panel-heading">
                                        <h4>Exibindo processos cadastrados</h4>										
                                    </div>

                                    <div class="panel-body collapse in">
                                        <div id="example_wrapper" class="dataTables_wrapper" role="grid">
                                            <form name="processos" method="POST" id="processos">
                                                <div class="col-sm-2">                                                    
                                                    <select name="nm_modalidade" id="nm_modalidade" class="form-control">
                                                        <option value='' >Tipo do serviço...</option>
                                                       <?php try {
                                                        $tipoveiculos = $conexao->prepare("SELECT * FROM tipoVeiculo ");
                                                       
                                                        $tipoveiculos->execute();
                                                    } catch (Exception $e) {
                                                        echo $e;
                                                        exit();
                                                    } ?>
<?php while ($tipoveiculo = $tipoveiculos->fetch(PDO::FETCH_ASSOC)) { ?>
                                                            <option value='<?php echo $tipoveiculo['nm_modalidade']; ?>'><?php echo $tipoveiculo['nm_modalidade']; ?></option>
<?php } ?>                                              
                                                    </select>
                                                </div>
                                                <div class="row">
                                                    <div class="col-xs-2">
                                                        <input class="form-control" name="processo" placeholder="Nº do processo" value="<?php echo($processo); ?>" type="number">
                                                    </div>
                                                    <div class="col-xs-2">
                                                        <input class="form-control" name="aa_processo" id="aa_processo" placeholder="Ano do processo" value="<?php echo($aa_processo); ?>" type="text" minlength="4">
                                                    </div>

                                                    <div class="col-sm-2">                                                    
                                                        <select name="dt_relato_denuncia" id="dt_relato_denuncia" class="form-control">
                                                            <option value='' >Data...</option>
                                                            <?php try {
                                                        $dataRelatos = $conexao->prepare("SELECT * FROM processo");
                                                       
                                                        $dataRelatos->execute();
                                                    } catch (Exception $e) {
                                                        echo $e;
                                                        exit();
                                                    } ?>
<?php while ($dataRelato = $dataRelatos->fetch(PDO::FETCH_ASSOC)) { ?>
                                                                <option value='<?php echo $dataRelato['dt_relato_denuncia']; ?>'><?php echo strftime('%d/%m/%y', strtotime($dataRelato['dt_relato_denuncia'])); ?></option>
<?php } ?>                                              
                                                        </select>
                                                    </div>


                                                    <div class="col-sm-2">                                                    
                                                        <select name="ds_resultado" id="ds_resultado" class="form-control">
                                                            <option value=''>Resultado...</option>
                                                            <option value='ABSOLVIÇÃO' >ABSOLVIÇÃO</option>
                                                            <option value="MULTA" >MULTA</option>
                                                            <option value="NÃO COMPARECEU" >NÃO COMPARECEU</option>
                                                            <option value="JUSTIFICADO" >JUSTIFICADO</option>
                                                            <option value="ADVERTÊNCIA" >ADVERTÊNCIA</option>
                                                            <option value="SUSPENSÃO" >SUSPENSÃO</option>
                                                            <option value="CASSAÇÃO" >CASSAÇÃO</option>
                                                        </select> 
                                                    </div>



                                                    <div class="col-xs-1">
                                                        <button style="float:left" class="btn-primary btn">Buscar</button>
                                                    </div><br /><br /><br />
                                                </div>
                                            </form>

<?php if ($processos->rowCount() > 0) { ?>
                                                <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered datatables dataTable sortable" id="example" aria-describedby="example_info">
                                                    <thead>
                                                        <tr role="row">
                                                            <th class="sorting_asc" role="columnheader" tabindex="1" aria-controls="example" rowspan="1" colspan="1" aria-sort="ascending" aria-label="" style="width:150px;">Tipo do serviço</th>		

                                                            <th class="sorting_asc" role="columnheader" tabindex="1" aria-controls="example" rowspan="1" colspan="1" aria-sort="ascending" aria-label="" style="width:150px;">Nº do processo</th>		
                                                            <th role="columnheader" tabindex="2" aria-controls="example" rowspan="1" colspan="1" aria-label="" style="width:150px;">Ano do processo</th>
                                                            <th role="columnheader" tabindex="2" aria-controls="example" rowspan="1" colspan="1" aria-label="" style="width:150px;">Data rel. denúncia</th>
                                                            <th role="columnheader" tabindex="2" aria-controls="example" rowspan="1" colspan="1" aria-label="" style="width:150px;">Resultado</th>                                                      
                                                            <th role="columnheader" tabindex="2" aria-controls="example" rowspan="1" colspan="1" aria-label="" style="width:150px;">Opções</th>
                                                        </tr>
                                                    </thead>

                                                    <tbody role="alert" aria-live="polite" aria-relevant="all">
    <?php while ($processo = $processos->fetch(PDO::FETCH_ASSOC)) { ?>
                                                            <tr class="gradeA odd">
                                                                <td style="width:20%" class=""><?php echo($processo['nm_modalidade']); ?>&nbsp;&nbsp;&nbsp;&nbsp;</td>

                                                                <td style="width:10%" class=""><?php echo($processo['cd_processo']); ?>&nbsp;&nbsp;&nbsp;&nbsp;</td>


                                                                <td style="width:10%" class=""><?php echo $processo['aa_processo']; ?></td>
                                                                <td style="width:20%" class=""><?php echo strftime('%d/%m/%y', strtotime($processo['dt_relato_denuncia'])); ?></td>
                                                                <td style="width:5%" class=""><?php echo $processo['ds_resultado']; ?></td>
                                                                <td style="width:40%" class="center">

                                                                    <a href="gerencia.php?id=<?php echo base64_encode($processo['id_processo']); ?>&acao=editar" onClick="buscaPessoa('<?php echo($processo['id_processo']); ?>')" class="btn btn-primary"><i class="icon-pencil">&nbsp;&nbsp;Editar</i> </a>
                                                                    <a href="gerencia.php?id=<?php echo base64_encode($processo['id_processo']); ?>&acao=visualizar" onClick="buscaPessoa('<?php echo($processo['id_processo']); ?>')" class="btn btn-success"><i class="icon-eye-open">&nbsp;&nbsp;Visualizar</i> </a>

                                                                    <a onClick="if (confirm('Tem certeza que deseja excluir este registro?')) {
                                                                                location.href = 'gerencia.php?acao=excluir&id=<?php echo base64_encode($processo['id_processo']); ?>'
                                                                            }" class="btn btn-danger"> <i class="icon-trash">&nbsp;&nbsp;Excluir</i> </a>
                                                                    <button type="button" data-toggle="modal" data-target="#myModal<?php echo $processo['id_processo']; ?>"  class="btn btn-inverse" ><i class="icon-eye-open">&nbsp;&nbsp;Ver recursos</i></button>
                                                                </td> 
                                                            </tr><?php
                                                    $cd_proceso = $processo['cd_processo'];

                                                    try {
                                                        $recursos = $conexao->prepare("SELECT * FROM recurso where cd_processo = :cd_processo");
                                                       
                                                        $recursos->bindValue(":cd_processo", $cd_proceso);
                                                        
                                                        $recursos->execute();
                                                    } catch (Exception $e) {
                                                        echo $e;
                                                        exit();
                                                    }

                                                    
        ?>

                                                        <div class="modal fade" id="myModal<?php echo $processo['id_processo']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                                            <div class="modal-dialog" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                            <?php if ($recursos->rowCount() == 0) {
                                                                echo 'Não há recursos para esse processo';
                                                            } ?>
        <?php while ($recurso = $recursos->fetch(PDO::FETCH_ASSOC)) { ?> 
                                                                            <h4 class="modal-title text-center" id="myModalLabel">Recurso Nº: <?php echo $recurso['cd_recurso']; ?></h4>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <p>Ano do Recurso: <?php echo $recurso['aa_recurso']; ?></p>
                                                                            <p>Resultado do recurso: <?php if ($recurso['ds_resultado_recurso'] == '') {
                                                                    echo 'Sem resultado';
                                                                } else {
                                                                    echo $recurso['ds_resultado_recurso'];
                                                                } ?></p>
                                                                        <?php } ?>   </div> 
                                                                </div>
                                                            </div>
                                                        </div> 

                                                    <?php } ?>                     
                                                    </tbody>
                                                </table>

                                                <div style="float:left">
                                                    &nbsp;<?php echo($qtd['qtd']); ?> registros encontrados.
                                                </div>
                                            <?php } else { ?>
                                                <div style="margin-left:10px">Nenhum documento encontrado.</div>
                                            <?php } ?>
                                        </div>		



                                        <div class="tab-pane active" style="text-align:right;" id="dompaginate">
                                            <ul class="pagination">

                                                <li><a href="?pagina=1&nome=<?php echo($processo); ?>"><i class="icon-double-angle-left"></i>&nbsp;</a></li>

                                                <?php
                                                $inicio_paginacao = ($pagina - 2 < 1) ? 1 : $pagina - 2;

                                                if ($pagina > 1) {
                                                    ?>
                                                    <li><a href="?pagina=<?php echo($pagina - 1); ?>&nome=<?php echo($processo); ?>"><i class="icon-angle-left"></i>&nbsp;</a></li>
                                                <?php } else { ?>
                                                    <li class="disabled"><a href="#"><i class="icon-angle-left"></i>&nbsp;</a></li>
                                                <?php } ?>

                                                <?php
                                                for ($i = $inicio_paginacao; $i < $inicio_paginacao + 5; $i++) {
                                                    if ($i <= $ultima_pagina) {
                                                        ?>
                                                        <li<?php echo ($pagina == $i) ? ' class="active"' : ''; ?>><a href="?pagina=<?php echo($i); ?>&nome=<?php echo($processo); ?>"><?php echo($i); ?></a></li>
                                                    <?php } ?>
                                                <?php } ?>
                                                <li <?php echo($pagina >= $ultima_pagina) ? 'class="disabled"' : '' ?>><a href="?pagina=<?php echo($pagina + 1); ?>&nome=<?php echo($processo); ?>"><i class="icon-angle-right"></i>&nbsp;</a></li> 

                                                <li><a href="?pagina=<?php echo($ultima_pagina); ?>&nome=<?php echo($processo); ?>"><i class="icon-double-angle-right"></i>&nbsp;</a></li>

                                                <div style="margin-left:30px;width:100px;float:left;">
                                                    <input type="text" name="pagina_ir" id="pagina_ir" class="form-control" value="<?php echo($pagina); ?>" style="float:left;width:50px">
                                                    <a onclick="location.href = '?pagina=' + $('#pagina_ir').val() + '&nome=<?php echo($processo); ?>'" style="float:left; width: 25px; height: 26px; margin-left: 5px; margin-top: 3px;" class="btn btn-muted btn-default"><i class="icon-arrow-right" ></i></a>
                                                </div>                                
                                            </ul>
                                        </div>            
                                    </div>
                                </div>
                            </div>            
                        </div>
                    </div> <!-- container -->     
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
    <script type='text/javascript' src="../assets/js/sorttable.js"></script>
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
    <script type='text/javascript' src='../assets/demo/demo-index.js'></script> 
    <script type='text/javascript' src='../assets/js/placeholdr.js'></script> 
    <script type='text/javascript' src='../assets/js/application.js'></script> 
    <script type='text/javascript' src='../assets/demo/demo.js'></script> 

</body>
</html>

