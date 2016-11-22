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
$filtroProcesso = '';
$filtroRecurso = '';
$aa_recurso = '';
$julgado = '';
$filtroResultadoRecurso = '';
if (isset($_POST['processo']) && !empty($_POST['processo'])) {
    $processo = $_POST['processo'];
    $filtroProcesso = "AND cd_processo = $processo "; 
}
if (isset($_POST['recurso']) && !empty($_POST['recurso'])) {
    $recurso = $_POST['recurso'];
    $filtroRecurso = "AND cd_recurso = $recurso "; 
      
}
if (isset($_POST['aa_recurso']) && !empty($_POST['aa_recurso'])) {
    $aa_recurso = $_POST['aa_recurso'];
    
}

if (isset($_POST['dt_transito_julgado']) && !empty($_POST['dt_transito_julgado'])) {
    $julgado = $_POST['dt_transito_julgado'];
  
}

if (isset($_POST['ds_resultado_recurso']) && !empty($_POST['ds_resultado_recurso'])) {
    $resultadoRecurso = $_POST['ds_resultado_recurso'];
    $filtroResultadoRecurso = "AND ds_resultado_recurso LIKE '%$resultadoRecurso%' ";
}




// PAGINAÇÃO
$pagina = (isset($_GET['pagina']) && !empty($_GET['pagina']) ? $_GET['pagina'] : 1);
$registros = 10;

$inicio = ($pagina - 1) * $registros;
$fim = $registros; //$pagina * $registros;

$limit = "LIMIT $inicio, $fim";


try {
    $contador = $conexao->prepare("SELECT count(*) as qtd FROM recurso "
            . "WHERE aa_recurso LIKE  :aa_recurso AND dt_transito_julgado LIKE :julgado "
             .$filtroResultadoRecurso.$filtroProcesso.$filtroRecurso." " . $limit);
$contador->bindValue(":aa_recurso", '%' . $aa_recurso . '%');
     $contador->bindValue(":julgado", '%' . $julgado . '%');

    $contador->execute();
} catch (Exception $e) {
    echo $e;
    exit();
}

$qtd = $contador->fetch(PDO::FETCH_ASSOC);
$ultima_pagina = ceil((int) $qtd['qtd'] / $registros);
//End PAGINAÇÃO
try {
    $recursos = $conexao->prepare("SELECT * FROM recurso "
            . "WHERE aa_recurso LIKE  :aa_recurso AND dt_transito_julgado LIKE :julgado "
             .$filtroResultadoRecurso.$filtroProcesso.$filtroRecurso. "ORDER BY cd_processo ASC " . $limit);
     $recursos->bindValue(":aa_recurso", '%' . $aa_recurso . '%');
     $recursos->bindValue(":julgado", '%' . $julgado . '%');
    $recursos->execute();
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
                        <li class='active'><a href="../home.php">Home</a> > Recursos</li>
                    </ol>
                    <h1>Recursos</h1>  
                    <div class="options">
                        <div class="btn-toolbar">
                            <a href="gerencia.php?acao=novo"  class="btn btn-primary"><i class="icon-user"></i>&nbsp;&nbsp;Novo Recurso</a>
                        </div>
                    </div>
                </div>      
                <div class="container">               
                    <div class="container">		
                        <div class="row">
                            <div class="col-md-12">
                                <div class="panel panel-primary">
                                    <div class="panel-heading">
                                        <h4>Exibindo recursos cadastrados</h4>										
                                    </div>

                                    <div class="panel-body collapse in">
                                        <div id="example_wrapper" class="dataTables_wrapper" role="grid">
                                            <form name="recursos" method="POST" id="recursos">
                                                <div class="col-xs-2">
                                                        <input class="form-control" name="processo" placeholder="Nº do processo" value="<?php echo($processo); ?>" type="number">
                                                    </div>
                                                <div class="row">
                                                    <div class="col-xs-2">
                                                        <input class="form-control" name="recurso" placeholder="Nº do recurso" value="<?php echo($recurso); ?>" type="number">
                                                    </div>
                                                    <div class="col-xs-2">
                                                        <input class="form-control" name="aa_recurso" id="aa_recurso" placeholder="Ano do recurso" value="<?php echo($aa_recurso); ?>" type="text" minlength="4">
                                                    </div>

                                                    <div class="col-sm-2">                                                    
                                                        <select name="dt_transito_julgado" id="dt_transito_julgado" class="form-control">
                                                            <option value='' >Data...</option>
                                                             <?php try {
                                                        $dataJulgados = $conexao->prepare("SELECT * FROM recurso");
                                                       
                                                        $dataJulgados->execute();
                                                    } catch (Exception $e) {
                                                        echo $e;
                                                        exit();
                                                    } ?>
                                                            <?php while ($dataJulgado = $dataJulgados->fetch(PDO::FETCH_ASSOC)) { ?>
                                                                <option value='<?php echo $dataJulgado['dt_transito_julgado']; ?>'><?php echo strftime('%d/%m/%y', strtotime($dataJulgado['dt_transito_julgado'])); ?></option>
                                                            <?php } ?>                                              
                                                        </select>
                                                    </div>
                                                    

                                                    <div class="col-sm-2">                                                    
                                                        <select name="ds_resultado_recurso" id="ds_resultado_recurso" class="form-control">
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

                                            <?php if ($recursos->rowCount() > 0) { ?>
                                                <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered datatables dataTable sortable" id="example" aria-describedby="example_info">
                                                    <thead>
                                                        <tr role="row">
                                                            <th class="sorting_asc" role="columnheader" tabindex="1" aria-controls="example" rowspan="1" colspan="1" aria-sort="ascending" aria-label="" style="width:150px;">Nº do processo</th>		
                                                            
                                                            <th class="sorting_asc" role="columnheader" tabindex="1" aria-controls="example" rowspan="1" colspan="1" aria-sort="ascending" aria-label="" style="width:150px;">Nº do recurso</th>		
                                                            <th role="columnheader" tabindex="2" aria-controls="example" rowspan="1" colspan="1" aria-label="" style="width:150px;">Ano do recurso</th>
                                                            <th role="columnheader" tabindex="2" aria-controls="example" rowspan="1" colspan="1" aria-label="" style="width:150px;">Trânsito em julg.</th>
                                                            <th role="columnheader" tabindex="2" aria-controls="example" rowspan="1" colspan="1" aria-label="" style="width:150px;">Resultado</th>                                                      
                                                            <th role="columnheader" tabindex="2" aria-controls="example" rowspan="1" colspan="1" aria-label="" style="width:150px;">Opções</th>
                                                        </tr>
                                                    </thead>

                                                    <tbody role="alert" aria-live="polite" aria-relevant="all">
                                                        <?php while ($recurso = $recursos->fetch(PDO::FETCH_ASSOC)) { ?>
                                                            <tr class="gradeA odd">
                                                                <td style="width:10%" class=""><?php echo($recurso['cd_processo']); ?>&nbsp;&nbsp;&nbsp;&nbsp;</td>

                                                                <td style="width:10%" class=""><?php echo($recurso['cd_recurso']); ?>&nbsp;&nbsp;&nbsp;&nbsp;</td>


                                                                <td style="width:10%" class=""><?php echo $recurso['aa_recurso']; ?></td>
                                                                <td style="width:20%" class=""><?php echo strftime('%d/%m/%y', strtotime($recurso['dt_transito_julgado'])); ?></td>
                                                                <td style="width:5%" class=""><?php echo $recurso['ds_resultado_recurso']; ?></td>
                                                                <td style="width:40%" class="center">
                                                                    <a href="gerencia.php?id=<?php echo base64_encode($recurso['id_recurso']); ?>&acao=editar" onClick="buscaPessoa('<?php echo($recurso['id_recurso']); ?>')" class="btn btn-primary"><i class="icon-pencil">&nbsp;&nbsp;Editar</i> </a>
                                                                    <a href="gerencia.php?id=<?php echo base64_encode($recurso['id_recurso']); ?>&acao=visualizar" onClick="buscaPessoa('<?php echo($recurso['id_recurso']); ?>')" class="btn btn-success"><i class="icon-eye-open">&nbsp;&nbsp;Visualizar</i> </a>
        <!--                                                                    <a onClick="buscaUsuario('<?php echo($recurso['id_recurso']); ?>');location.href='gerencia.php?acao=visualizar&id_usuario=<?php echo $usuario['id_usuario']; ?>'" class="btn btn-success"><i class="icon-trash">&nbsp;&nbsp;Visualizar</i> </a>-->
                                                                    <a onClick="if (confirm('Tem certeza que deseja excluir este registro?')) {
                                                                                location.href = 'gerencia.php?acao=excluir&id=<?php echo base64_encode($recurso['id_recurso']); ?>'
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

                                                <li><a href="?pagina=1&nome=<?php echo($recurso); ?>"><i class="icon-double-angle-left"></i>&nbsp;</a></li>

                                                <?php
                                                $inicio_paginacao = ($pagina - 2 < 1) ? 1 : $pagina - 2;

                                                if ($pagina > 1) {
                                                    ?>
                                                    <li><a href="?pagina=<?php echo($pagina - 1); ?>&nome=<?php echo($recurso); ?>"><i class="icon-angle-left"></i>&nbsp;</a></li>
                                                <?php } else { ?>
                                                    <li class="disabled"><a href="#"><i class="icon-angle-left"></i>&nbsp;</a></li>
                                                <?php } ?>

                                                <?php
                                                for ($i = $inicio_paginacao; $i < $inicio_paginacao + 5; $i++) {
                                                    if ($i <= $ultima_pagina) {
                                                        ?>
                                                        <li<?php echo ($pagina == $i) ? ' class="active"' : ''; ?>><a href="?pagina=<?php echo($i); ?>&nome=<?php echo($recurso); ?>"><?php echo($i); ?></a></li>
    <?php } ?>
<?php } ?>
                                                <li <?php echo($pagina >= $ultima_pagina) ? 'class="disabled"' : '' ?>><a href="?pagina=<?php echo($pagina + 1); ?>&nome=<?php echo($recurso); ?>"><i class="icon-angle-right"></i>&nbsp;</a></li> 

                                                <li><a href="?pagina=<?php echo($ultima_pagina); ?>&nome=<?php echo($recurso); ?>"><i class="icon-double-angle-right"></i>&nbsp;</a></li>

                                                <div style="margin-left:30px;width:100px;float:left;">
                                                    <input type="text" name="pagina_ir" id="pagina_ir" class="form-control" value="<?php echo($pagina); ?>" style="float:left;width:50px">
                                                    <a onclick="location.href = '?pagina=' + $('#pagina_ir').val() + '&nome=<?php echo($recurso); ?>'" style="float:left; width: 25px; height: 26px; margin-left: 5px; margin-top: 3px;" class="btn btn-muted btn-default"><i class="icon-arrow-right" ></i></a>
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

