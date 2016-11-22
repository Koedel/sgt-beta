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
$placa = '';
$filtroModalidade = '';
$tipoVistoria = '';
$resultado = "";
$modalidade = "";

if (isset($_POST['cd_placa']) && !empty($_POST['cd_placa'])) {
    $placa = $_POST['cd_placa'];
}
if (isset($_POST['cd_modalidade']) && !empty($_POST['cd_modalidade'])) {
    $modalidade = $_POST['cd_modalidade'];
    $filtroModalidade = "AND cd_modalidade = $modalidade "; 
}

if (isset($_POST['nm_vistoria']) && !empty($_POST['nm_vistoria'])) {
    $tipoVistoria = $_POST['nm_vistoria'];
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
    $contador = $conexao->prepare("SELECT count(*) as qtd FROM vistoria "
            . "WHERE cd_placa LIKE  :placa AND nm_vistoria LIKE :tipoVistoria "
            . " AND ds_resultado LIKE  :resultado 
                                  " . $filtroModalidade." " . $limit);

    $contador->bindValue(":placa", '%' . $placa . '%');
    
    $contador->bindValue(":tipoVistoria", '%' . $tipoVistoria . '%');
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
    $vistorias = $conexao->prepare("SELECT * FROM vistoria "
            . "WHERE cd_placa LIKE  :placa AND  nm_vistoria LIKE :tipoVistoria "
            . " AND ds_resultado LIKE  :resultado 
                                 " .$filtroModalidade. "ORDER BY nm_vistoria ASC " . $limit);
    $vistorias->bindValue(":placa", '%' . $placa . '%');
    
    $vistorias->bindValue(":tipoVistoria", '%' . $tipoVistoria . '%');
    $vistorias->bindValue(":resultado", '%' . $resultado . '%');
    $vistorias->execute();
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
                        <li class='active'><a href="../home.php">Home</a> > Vistorias</li>
                    </ol>
                    <h1>Vistorias</h1>  
                    <div class="options">
                        <div class="btn-toolbar">
                            <a href="gerencia.php?acao=novo"  class="btn btn-primary"><i class="icon-user"></i>&nbsp;&nbsp;Nova Vistoria</a>
                        </div>
                    </div>
                </div>      
                <div class="container">               
                    <div class="container">		
                        <div class="row">
                            <div class="col-md-12">
                                <div class="panel panel-primary">
                                    <div class="panel-heading">
                                        <h4>Exibindo vistorias cadastradas</h4>										
                                    </div>

                                    <div class="panel-body collapse in">
                                        <div id="example_wrapper" class="dataTables_wrapper" role="grid">
                                            <form name="vistorias" method="POST" id="vistorias">
                                                                                              
                              
                                <div class="col-sm-4">                                        
                                    <select name="cd_modalidade" id="cd_modalidade" class="form-control" <?php if ($acao == 'visualizar') { ?>disabled="disabled" <?php }; ?> >
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
                            
                                                <div class="row">
                                                    <div class="col-xs-2">
                                                        <input class="form-control" name="cd_placa" placeholder="Digite a placa do veiculo" value="<?php echo($placa); ?>" type="text">
                                                    </div>
                                                    
                                                     <div class="col-sm-2">                                                    
                                                        <select name="nm_vistoria" id="nm_vistoria" class="form-control">
                                                            <option value=''>Tipo de vistoria...</option>
                                                            <option value='VISTORIA NORMAL' >VISTORIA NORMAL</option>
                                                            <option value="OUTRO" >OUTRO</option>
                                                            
                                                        </select> 
                                                    </div>
                                                    
                                                    
                                                    <div class="col-sm-2">                                                    
                                                        <select name="ds_resultado" id="ds_resultado" class="form-control">
                                                            <option value=''>Resultado...</option>
                                                            <option value='APROVADO' >APROVADO</option>
                                                            <option value="REPROVADO" >REPROVADO</option>
                                                            
                                                        </select> 
                                                    </div>
                                                   


                                                    <div class="col-xs-1">
                                                        <button style="float:left" class="btn-primary btn">Buscar</button>
                                                    </div><br /><br /><br />
                                                </div>
                                            </form>

<?php if ($vistorias->rowCount() > 0) { ?>
                                                <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered datatables dataTable sortable" id="example" aria-describedby="example_info">
                                                    <thead>
                                                        <tr role="row">
                                                            <th class="sorting_asc" role="columnheader" tabindex="1" aria-controls="example" rowspan="1" colspan="1" aria-sort="ascending" aria-label="" style="width:150px;">Tipo do seviço</th>		

                                                            <th class="sorting_asc" role="columnheader" tabindex="1" aria-controls="example" rowspan="1" colspan="1" aria-sort="ascending" aria-label="" style="width:150px;">Placa do Veiculo</th>		
                                                            <th role="columnheader" tabindex="2" aria-controls="example" rowspan="1" colspan="1" aria-label="" style="width:150px;">Tipo de vistoria</th>  
                                                            <th role="columnheader" tabindex="2" aria-controls="example" rowspan="1" colspan="1" aria-label="" style="width:150px;">Resultado</th>                                                      
                                                            <th role="columnheader" tabindex="2" aria-controls="example" rowspan="1" colspan="1" aria-label="" style="width:150px;">Opções</th>
                                                        </tr>
                                                    </thead>

                                                    <tbody role="alert" aria-live="polite" aria-relevant="all">
    <?php while ($vistoria = $vistorias->fetch(PDO::FETCH_ASSOC)) { ?>
                                                            <tr class="gradeA odd">
                                                                 <?php
                                        try {
                                            $tipoServicos = $conexao->prepare("SELECT DISTINCT c.cd_modalidade, t.nm_modalidade FROM veiculo c , tipoVeiculo t where c.cd_modalidade = t.cd_modalidade");
                                            $tipoServicos->execute();
                                        } catch (Exception $e) {
                                            echo $e;
                                            exit();
                                        }
                                        ?>
                                        <?php while ($tipoServico = $tipoServicos->fetch(PDO::FETCH_ASSOC)) { 
                                            if($tipoServico['cd_modalidade'] == $vistoria['cd_modalidade']){?>
                     <td style="width:10%" class=""><?php echo $tipoServico['nm_modalidade'] ; ?>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                        <?php }} ?>
                                                               
                                                               <td style="width:10%" class=""><?php echo $vistoria['cd_placa']; ?>&nbsp;&nbsp;&nbsp;&nbsp;</td>

                                                                <td style="width:5%" class=""><?php echo $vistoria['nm_vistoria']; ?></td>
                                                                <td style="width:5%" class=""><?php echo $vistoria['ds_resultado']; ?></td>
                                                                <td style="width:40%" class="center">

                                                                    <a href="gerencia.php?id=<?php echo base64_encode($vistoria['cd_vistoria']); ?>&acao=editar" onClick="buscaPessoa('<?php echo($vistoria['cd_vistoria']); ?>')" class="btn btn-primary"><i class="icon-pencil">&nbsp;&nbsp;Editar</i> </a>
                                                                    <a href="gerencia.php?id=<?php echo base64_encode($vistoria['cd_vistoria']); ?>&acao=visualizar" onClick="buscaPessoa('<?php echo($vistoria['cd_vistoria']); ?>')" class="btn btn-success"><i class="icon-eye-open">&nbsp;&nbsp;Visualizar</i> </a>

                                                                    <a onClick="if(confirm('Tem certeza que deseja excluir este registro?')){location.href='gerencia.php?acao=excluir&id=<?php echo base64_encode($vistoria['cd_vistoria']); ?>'}" class="btn btn-danger"> <i class="icon-trash">&nbsp;&nbsp;Excluir</i> </a>
                                                                 </td>
                                                         </tr>
                                                 <?php }?>                
                                                    </tbody>
                                                </table>

                                                <div style="float:left">
                                                    &nbsp;<?php echo($qtd['qtd']); ?> registros encontrados.
                                                </div>
                                            <?php } else { ?>
                                                <div style="margin-left:10px">Nenhum documeto encontrado.</div>
                                            <?php } ?>
                                        </div>		



                                        <div class="tab-pane active" style="text-align:right;" id="dompaginate">
                                            <ul class="pagination">

                                                <li><a href="?pagina=1&nome=<?php echo($veiculo); ?>"><i class="icon-double-angle-left"></i>&nbsp;</a></li>

                                                <?php
                                                $inicio_paginacao = ($pagina - 2 < 1) ? 1 : $pagina - 2;

                                                if ($pagina > 1) {
                                                    ?>
                                                    <li><a href="?pagina=<?php echo($pagina - 1); ?>&nome=<?php echo($veiculo); ?>"><i class="icon-angle-left"></i>&nbsp;</a></li>
                                                <?php } else { ?>
                                                    <li class="disabled"><a href="#"><i class="icon-angle-left"></i>&nbsp;</a></li>
                                                <?php } ?>

                                                <?php
                                                for ($i = $inicio_paginacao; $i < $inicio_paginacao + 5; $i++) {
                                                    if ($i <= $ultima_pagina) {
                                                        ?>
                                                        <li<?php echo ($pagina == $i) ? ' class="active"' : ''; ?>><a href="?pagina=<?php echo($i); ?>&nome=<?php echo($veiculo); ?>"><?php echo($i); ?></a></li>
                                                    <?php } ?>
                                                <?php } ?>
                                                <li <?php echo($pagina >= $ultima_pagina) ? 'class="disabled"' : '' ?>><a href="?pagina=<?php echo($pagina + 1); ?>&nome=<?php echo($veiculo); ?>"><i class="icon-angle-right"></i>&nbsp;</a></li> 

                                                <li><a href="?pagina=<?php echo($ultima_pagina); ?>&nome=<?php echo($veiculo); ?>"><i class="icon-double-angle-right"></i>&nbsp;</a></li>

                                                <div style="margin-left:30px;width:100px;float:left;">
                                                    <input type="text" name="pagina_ir" id="pagina_ir" class="form-control" value="<?php echo($pagina); ?>" style="float:left;width:50px">
                                                    <a onclick="location.href = '?pagina=' + $('#pagina_ir').val() + '&nome=<?php echo($veiculo); ?>'" style="float:left;margin-left: 5px; margin-top: 3px" class="btn btn-muted btn-default"><i class="icon-arrow-right"></i></a>
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

