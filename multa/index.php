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
$filtroAit = '';
$nomeInfracao = '';
$filtroPago = '';  

if (isset($_POST['nm_modalidade']) && !empty($_POST['nm_modalidade'])) {
    $tipo_veiculo = $_POST['nm_modalidade'];
}


if (isset($_POST['nm_infracao']) && !empty($_POST['nm_infracao'])) {
    $nomeInfracao = $_POST['nm_infracao'];
}

if (isset($_POST['cd_ait']) && !empty($_POST['cd_ait'])) {
    $numeroAit = $_POST['cd_ait'];
    $filtroAit = "AND cd_ait = $numeroAit ";
}

if (isset($_POST['pago']) && !empty($_POST['pago'])) {
    if($_POST['pago'] == 'NAO'){
    $pago = $_POST['pago'];
    $filtroPago = "AND dt_pagamento_multa = '' ";
    
    }else if($_POST['pago'] == 'SIM'){
    $pago = $_POST['pago'];
    $filtroPago = "AND dt_pagamento_multa != '' ";}
}



// PAGINAÇÃO
$pagina = (isset($_GET['pagina']) && !empty($_GET['pagina']) ? $_GET['pagina'] : 1);
$registros = 10;

$inicio = ($pagina - 1) * $registros;
$fim = $registros; //$pagina * $registros;

$limit = "LIMIT $inicio, $fim";


try {
    $contador = $conexao->prepare("SELECT count(*) as qtd FROM multa "
            . "WHERE nm_modalidade LIKE  :tipo_veiculo AND nm_infracao LIKE :nomeInfracao "
            . $filtroAit . $filtroPago. " " . $limit);

    $contador->bindValue(":tipo_veiculo", '%' . $tipo_veiculo . '%');
    $contador->bindValue(":nomeInfracao", '%' . $nomeInfracao . '%');
    $contador->execute();
} catch (Exception $e) {
    echo $e;
    exit();
}

$qtd = $contador->fetch(PDO::FETCH_ASSOC);
$ultima_pagina = ceil((int) $qtd['qtd'] / $registros);
//End PAGINAÇÃO

try {
    $multas = $conexao->prepare("SELECT * FROM multa "
            . "WHERE nm_modalidade LIKE  :tipo_veiculo AND  nm_infracao LIKE :nomeInfracao "
            . $filtroAit . $filtroPago . "ORDER BY nm_modalidade ASC " . $limit);
    $multas->bindValue(":tipo_veiculo", '%' . $tipo_veiculo . '%');

    $multas->bindValue(":nomeInfracao", '%' . $nomeInfracao . '%');

    $multas->execute();
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
                        <li class='active'><a href="../home.php">Home</a> > Multas</li>
                    </ol>
                    <h1>Multas</h1>  
                    <div class="options">
                        <div class="btn-toolbar">
                            <a href="gerencia.php?acao=novo"  class="btn btn-primary"><i class="icon-user"></i>&nbsp;&nbsp;Nova Multa</a>
                        </div>
                    </div>
                </div>      
                <div class="container">               
                    <div class="container">		
                        <div class="row">
                            <div class="col-md-12">
                                <div class="panel panel-primary">
                                    <div class="panel-heading">
                                        <h4>Exibindo multas cadastradas</h4>										
                                    </div>

                                    <div class="panel-body collapse in">
                                        <div id="example_wrapper" class="dataTables_wrapper" role="grid">
                                            <form name="multas" method="POST" id="multas">
                                                <div class="col-sm-2">                                                    
                                                    <select name="nm_modalidade" id="nm_modalidade" class="form-control">
                                                        <option value='' >Tipo do Serviço...</option>
                                                        <?php
                                                        try {
                                                            $tipoveiculos = $conexao->prepare("SELECT * FROM tipoVeiculo ");

                                                            $tipoveiculos->execute();
                                                        } catch (Exception $e) {
                                                            echo $e;
                                                            exit();
                                                        }
                                                        ?>
                                                        <?php while ($tipoveiculo = $tipoveiculos->fetch(PDO::FETCH_ASSOC)) { ?>
                                                            <option value='<?php echo $tipoveiculo['nm_modalidade']; ?>'><?php echo $tipoveiculo['nm_modalidade']; ?></option>
<?php } ?>                                              
                                                    </select>
                                                </div>
                                                <div class="col-xs-2">
                                                    <input class="form-control" name="nm_infracao" id="nm_infracao" placeholder="Infração" value="<?php echo($nomeInfracao); ?>" type="text" >
                                                </div>
                                                <div class="row">
                                                    <div class="col-xs-2">
                                                        <input class="form-control" name="cd_ait" placeholder="Numero AIT" value="<?php echo($numeroAit); ?>" type="number">
                                                    </div>
                                                     <div class="col-sm-2">
                                                    <select name="pago" id="pago" class="form-control">
                                                        <option value='' >Pagamento...</option>
                                                        <option value='SIM'>Sim</option>
                                                        <option value='NAO'>Não</option>                                                                                                                                                              
                                                    </select>
                                            </div>

                                                    <div class="col-xs-1">
                                                        <button style="float:left" class="btn-primary btn">Buscar</button>
                                                    </div><br /><br /><br />
                                                </div>
                                            </form>

<?php if ($multas->rowCount() > 0) { ?>
                                                <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered datatables dataTable sortable" id="example" aria-describedby="example_info">
                                                    <thead>
                                                        <tr role="row">
                                                            <th class="sorting_asc" role="columnheader" tabindex="1" aria-controls="example" rowspan="1" colspan="1" aria-sort="ascending" aria-label="" style="width:150px;">Tipo do seviço</th>		

                                                            <th class="sorting_asc" role="columnheader" tabindex="1" aria-controls="example" rowspan="1" colspan="1" aria-sort="ascending" aria-label="" style="width:150px;">Infração</th>		
                                                            <th role="columnheader" tabindex="2" aria-controls="example" rowspan="1" colspan="1" aria-label="" style="width:150px;">Numero AIT</th>
                                                            <th role="columnheader" tabindex="2" aria-controls="example" rowspan="1" colspan="1" aria-label="" style="width:150px;">Data Vencimento</th>
                                                            <th role="columnheader" tabindex="2" aria-controls="example" rowspan="1" colspan="1" aria-label="" style="width:150px;">Data Pagamento</th>                                                      
                                                            <th role="columnheader" tabindex="2" aria-controls="example" rowspan="1" colspan="1" aria-label="" style="width:150px;">Opções</th>
                                                        </tr>
                                                    </thead>

                                                    <tbody role="alert" aria-live="polite" aria-relevant="all">
    <?php while ($multa = $multas->fetch(PDO::FETCH_ASSOC)) { ?>
                                                            <tr class="gradeA odd">
                                                                <td style="width:15%" class=""><?php echo($multa['nm_modalidade']); ?>&nbsp;&nbsp;&nbsp;&nbsp;</td>

                                                                <td style="width:20%" class=""><?php echo($multa['nm_infracao']); ?>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                                                <td style="width:10%" class=""><?php echo($multa['cd_ait']); ?>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                                                <td style="width:10%" class=""><?php echo strftime('%d/%m/%y', strtotime($multa['dt_vencimento_infracao'])); ?></td>
                                                                <td style="width:10%" class=""><?php if($multa['dt_pagamento_multa']=='0000-00-00'){echo 'Não Pago';}else{ echo strftime('%d/%m/%y', strtotime($multa['dt_pagamento_multa'])); } ?></td>

                                                                <td style="width:40%" class="center">

                                                                    <a href="gerencia.php?id=<?php echo base64_encode($multa['id_multa']); ?>&acao=editar" onClick="buscaPessoa('<?php echo($multa['id_multa']); ?>')" class="btn btn-primary"><i class="icon-pencil">&nbsp;&nbsp;Editar</i> </a>
                                                                    <a href="gerencia.php?id=<?php echo base64_encode($multa['id_multa']); ?>&acao=visualizar" onClick="buscaPessoa('<?php echo($multa['id_multa']); ?>')" class="btn btn-success"><i class="icon-eye-open">&nbsp;&nbsp;Visualizar</i> </a>

                                                                    <a onClick="if (confirm('Tem certeza que deseja excluir este registro?')) {
                                                                                location.href = 'gerencia.php?acao=excluir&id=<?php echo base64_encode($multa['id_multa']); ?>'
                                                                            }" class="btn btn-danger"> <i class="icon-trash">&nbsp;&nbsp;Excluir</i> </a>
                                                                </td> 
                                                            </tr>




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

                                                <li><a href="?pagina=1&nome=<?php echo($multa); ?>"><i class="icon-double-angle-left"></i>&nbsp;</a></li>

                                                <?php
                                                $inicio_paginacao = ($pagina - 2 < 1) ? 1 : $pagina - 2;

                                                if ($pagina > 1) {
                                                    ?>
                                                    <li><a href="?pagina=<?php echo($pagina - 1); ?>&nome=<?php echo($multa); ?>"><i class="icon-angle-left"></i>&nbsp;</a></li>
                                                <?php } else { ?>
                                                    <li class="disabled"><a href="#"><i class="icon-angle-left"></i>&nbsp;</a></li>
                                                <?php } ?>

                                                <?php
                                                for ($i = $inicio_paginacao; $i < $inicio_paginacao + 5; $i++) {
                                                    if ($i <= $ultima_pagina) {
                                                        ?>
                                                        <li<?php echo ($pagina == $i) ? ' class="active"' : ''; ?>><a href="?pagina=<?php echo($i); ?>&nome=<?php echo($multa); ?>"><?php echo($i); ?></a></li>
    <?php } ?>
<?php } ?>
                                                <li <?php echo($pagina >= $ultima_pagina) ? 'class="disabled"' : '' ?>><a href="?pagina=<?php echo($pagina + 1); ?>&nome=<?php echo($multa); ?>"><i class="icon-angle-right"></i>&nbsp;</a></li> 

                                                <li><a href="?pagina=<?php echo($ultima_pagina); ?>&nome=<?php echo($multa); ?>"><i class="icon-double-angle-right"></i>&nbsp;</a></li>

                                                <div style="margin-left:30px;width:100px;float:left;">
                                                    <input type="text" name="pagina_ir" id="pagina_ir" class="form-control" value="<?php echo($pagina); ?>" style="float:left;width:50px">
                                                    <a onclick="location.href = '?pagina=' + $('#pagina_ir').val() + '&nome=<?php echo($multa); ?>'" style="float:left;margin-top: 3px; margin-left: 5px" class="btn btn-muted btn-default"><i class="icon-arrow-right"></i></a>
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

