<?php 
    include '../include/conexao/conecta.php';
    include '../include/head.php';
    include '../include/funcoes.php';
    validaAcesso();
    $conexao = conecta();
    
    if(isset($_GET['retorno']) && $_GET['retorno'] == 'inserido'){
       
       echo "<script>alert('Registro inserido com sucesso!');
                   location.href=\"index.php\"</script>";
    }
    
     if(isset($_GET['retorno']) && $_GET['retorno'] == 'alterado'){
       
       echo "<script>alert('Registro alterado com sucesso!');
                   location.href=\"index.php\"</script>";
    }    
    
    //WHERE
    $filtroPermissao = '';
    $nome = '';
    $inativo = 0;  
    $tipo_pessoa ='';
    if(isset($_POST['nm_pessoa']) && !empty($_POST['nm_pessoa'])){
            $nome = $_POST['nm_pessoa'];            
    }
    
   if (isset($_POST['nm_tipo_pessoa']) && !empty($_POST['nm_tipo_pessoa'])) {
    $tipo_pessoa = $_POST['nm_tipo_pessoa'];
}  
 if(isset($_POST['ds_inativo'])){
            $inativo = ($_POST['ds_inativo']);            
    }
    //End WHERE
    
    // PAGINAÇÃO
    $pagina = (isset($_GET['pagina']) && !empty($_GET['pagina']) ? $_GET['pagina'] : 1);
    $registros = 10;
    $inicio = ($pagina -1) * $registros;
    $fim = $registros;//$pagina * $registros;
    $limit = "LIMIT $inicio, $fim";
    
    try{
        $contador = $conexao->prepare("SELECT count(*) as qtd FROM pessoa "
                                . "WHERE nm_pessoa LIKE  :nome AND ds_inativo = :inativo AND nm_tipo_pessoa LIKE :tipo_pessoa "
                                . " ".$limit);
        $contador->bindValue(":nome", '%'.$nome.'%');
        $contador->bindValue(":inativo", $inativo);      
        $contador->bindValue(":tipo_pessoa", '%'.$tipo_pessoa.'%');
        $contador->execute();
                
    }catch (Exception $e){
        echo $e;
        exit();
    }
    $qtd = $contador->fetch(PDO::FETCH_ASSOC);
    $ultima_pagina = ceil((int)$qtd['qtd']/$registros);
    //End PAGINAÇÃO
    
    
     try{
        $pessoas = $conexao->prepare("SELECT * FROM pessoa "
                                . "WHERE nm_pessoa LIKE  :nome AND ds_inativo = :inativo AND nm_tipo_pessoa LIKE :tipo_pessoa "
                                . " ORDER BY nm_pessoa ASC ".$limit);
        $pessoas->bindValue(":nome", '%'.$nome.'%');
        $pessoas->bindValue(":inativo", $inativo);      
        $pessoas->bindValue(":tipo_pessoa",  '%'.$tipo_pessoa.'%');    
        $pessoas->execute();
                
    }catch (Exception $e){
        echo $e;
        exit();
    }
      
?>


<body class="">
    <?php include '../include/header.php';?>

    <div id="page-container">
       
        <?php include '../include/menu.php';?>

	 <?php  if($_SESSION['permissao']!= 1){
        echo '<script>alert("Acesso Restrito!'. '\n' .'Você será redirecionado para a tela inicial!");
                   location.href="../home.php"</script>';
    }?>    
	    
<div id="page-content">
    <div id='wrap'>
        <div id="page-heading">
            <ol class="breadcrumb">
                <li class='active'><a href="../home.php">Home</a> > Pessoas</li>
            </ol>
            <h1>Pessoas</h1>  
            <div class="options">
                <div class="btn-toolbar">
                    <a href="gerencia.php?acao=novo"  class="btn btn-primary"><i class="icon-user"></i>&nbsp;&nbsp;Nova Pessoa</a>
                </div>
            </div>
        </div>      
        <div class="container">               
            <div class="container">		
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                    <h4>Exibindo pessoas cadastradas</h4>										
                            </div>
                            
                            <div class="panel-body collapse in">
                                <div id="example_wrapper" class="dataTables_wrapper" role="grid">
                                    <form name="pessoas" method="POST" id="pessoas">
                                        <div class="row">
                                            <div class="col-xs-3">
                                                <input class="form-control" name="nm_pessoa" placeholder="Nome" value="<?php echo($nome);?>" type="text">
                                            </div>
                                           <div class="col-sm-2">                                                    
                                                    <select name="nm_tipo_pessoa" id="nm_tipo_pessoa" class="form-control">
                                                        <option value='' >Tipo de Pessoa...</option>
                                                       <?php try {
                                                        $tipopessoas = $conexao->prepare("SELECT * FROM tipoPessoa ");
                                                       
                                                        $tipopessoas->execute();
                                                    } catch (Exception $e) {
                                                        echo $e;
                                                        exit();
                                                    } ?>
<?php while ($tipopessoa = $tipopessoas->fetch(PDO::FETCH_ASSOC)) { ?>
                                                            <option value='<?php echo $tipopessoa['nm_tipo_pessoa']; ?>'><?php echo $tipopessoa['nm_tipo_pessoa']; ?></option>
<?php } ?>                                              
                                                    </select>
                                                </div>
                                             
                                             <div class="col-sm-2">
                                                    <select name="ds_inativo" id="ds_inativo" class="form-control">
                                                        <option value='0'>Ativo</option>
                                                        <option value='1' onClick>Inativo</option>                                                                                                                                                              
                                                    </select>
                                            </div>
                                            <div class="col-xs-2">
                                                    <button style="float:left" class="btn-primary btn">Buscar</button>
                                            </div><br /><br /><br />
                                        </div>
                                    </form>

                                    <?php if($pessoas->rowCount() > 0){ ?>
                                            <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered datatables dataTable sortable" id="example" aria-describedby="example_info">
                                                <thead>
                                                        <tr role="row">
                                                                <th class="sorting_asc" role="columnheader" tabindex="1" aria-controls="example" rowspan="1" colspan="1" aria-sort="ascending" aria-label="" style="width:150px;">Nome</th>		
                                                                <th role="columnheader" tabindex="2" aria-controls="example" rowspan="1" colspan="1" aria-label="" style="width:150px;">Tipo de pessoa</th>
                                                                <th role="columnheader" tabindex="2" aria-controls="example" rowspan="1" colspan="1" aria-label="" style="width:150px;">Inativo</th>
                                                                <th role="columnheader" tabindex="2" aria-controls="example" rowspan="1" colspan="1" aria-label="" style="width:150px;">Opções</th>
                                                        </tr>
                                                </thead>

                                                <tbody role="alert" aria-live="polite" aria-relevant="all">
                                                <?php while($pessoa = $pessoas->fetch(PDO::FETCH_ASSOC)){?>
                                                        <tr class="gradeA odd">
                                                                <td style="width:30%" class=""><?php echo($pessoa['nm_pessoa']);?>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                                                <td style="width:20%" class=""><?php echo($pessoa['nm_tipo_pessoa']); ?>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                                                <?php   
                                                                    if($pessoa['ds_inativo'] == 1 ){
                                                                        $Inativo = "SIM";
                                                                    }else{
                                                                        $Inativo = "NÃO";
                                                                    }
                                                                ?>
                                                                <td style="width:10%" class=""><?php echo $Inativo;?></td>
                                                                <td style="width:40%" class="center">
                                                                    <a href="gerencia.php?id=<?php echo base64_encode($pessoa['cd_pessoa']); ?>&acao=editar" onClick="buscaPessoa('<?php echo($pessoa['cd_pessoa']);?>')" class="btn btn-primary"><i class="icon-pencil">&nbsp;&nbsp;Editar</i> </a>
                                                                    <a href="gerencia.php?id=<?php echo base64_encode($pessoa['cd_pessoa']); ?>&acao=visualizar" onClick="buscaPessoa('<?php echo($pessoa['cd_pessoa']);?>')" class="btn btn-success"><i class="icon-eye-open">&nbsp;&nbsp;Visualizar</i> </a>
<!--                                                                    <a onClick="buscaUsuario('<?php echo($pessoa['cd_pessoa']);?>');location.href='gerencia.php?acao=visualizar&id_usuario=<?php echo $pessoa['cd_pessoa']; ?>'" class="btn btn-success"><i class="icon-trash">&nbsp;&nbsp;Visualizar</i> </a>-->
                                                                    <a onClick="if(confirm('Tem certeza que deseja excluir este registro?')){location.href='gerencia.php?acao=excluir&id=<?php echo base64_encode($pessoa['cd_pessoa']); ?>'}" class="btn btn-danger"> <i class="icon-trash">&nbsp;&nbsp;Excluir</i> </a>
                                                                </td>
                                                        </tr>
                                                <?php }?>
                                                </tbody>
                                            </table>
                                            
                                            <div style="float:left">
                                                &nbsp;<?php echo($qtd['qtd']); ?> registros encontrados.
                                            </div>
                                    <?php }else{ ?>
                                            <div style="margin-left:10px">Nenhum documento encontrado.</div>
                                    <?php } ?>
                                    </div>		                     
                                    
                                    <div class="tab-pane active" style="text-align:right;" id="dompaginate">
                                        <ul class="pagination">

                                        <li><a href="?pagina=1&nome=<?php echo($nome);?>"><i class="icon-double-angle-left"></i>&nbsp;</a></li>
                                        
                                        <?php
                                        $inicio_paginacao = ($pagina-2<1) ? 1 : $pagina - 2;
                                        if($pagina >1){?>
                                              <li><a href="?pagina=<?php echo($pagina-1);?>&nome=<?php echo($nome);?>"><i class="icon-angle-left"></i>&nbsp;</a></li>
                                        <?php }else{ ?>
                                              <li class="disabled"><a href="#"><i class="icon-angle-left"></i>&nbsp;</a></li>
                                        <?php }?>

                                        <?php
                                        for($i = $inicio_paginacao;$i < $inicio_paginacao +5;$i++){
                                                if($i<=$ultima_pagina){?>
                                              <li<?php echo ($pagina == $i) ? ' class="active"': ''; ?>><a href="?pagina=<?php echo($i);?>&nome=<?php echo($nome);?>"><?php echo($i);?></a></li>
                                        <?php }?>
                                        <?php }?>
                                        <li <?php echo($pagina>=$ultima_pagina) ? 'class="disabled"' : ''?>><a href="?pagina=<?php echo($pagina+1);?>&nome=<?php echo($nome);?>"><i class="icon-angle-right"></i>&nbsp;</a></li> 

                                        <li><a href="?pagina=<?php echo($ultima_pagina);?>&nome=<?php echo($nome);?>"><i class="icon-double-angle-right"></i>&nbsp;</a></li>

                                        <div style="margin-left:30px;width:100px;float:left;">
                                              <input type="text" name="pagina_ir" id="pagina_ir" class="form-control" value="<?php echo($pagina);?>" style="float:left;width:50px">
                                              <a onclick="location.href='?pagina='+$('#pagina_ir').val()+'&nome=<?php echo($nome);?>' 	" style="float:left;margin-left: 5px; margin-top: 3px" class="btn btn-muted btn-default"><i class="icon-arrow-right"></i></a>
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

    <?php include '../include/footer.php';?>

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