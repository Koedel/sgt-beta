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
         $delataVeiculo = $conexao->prepare("DELETE FROM veiculo WHERE cd_veiculo = :id");
         $delataVeiculo->bindValue(":id", $id);
         $delataVeiculo->execute();
 
         if ($delataVeiculo->rowCount() == 0) {
             echo "<script>alert('Houve um erro ao deletar!');
                 location.href=\"index.php\"</script>";
         } else {
             echo "<script>alert('Registro excluido com sucesso!');
                    location.href=\"index.php\"</script>";
         }
     }
     if ($acao == 'visualizar' || $acao == 'editar') {
         $pegaVeiculos = $conexao->prepare("SELECT * FROM veiculo WHERE cd_veiculo = :id");
         $pegaVeiculos->bindValue(":id", $id);
         $pegaVeiculos->execute();
         $veiculo = $pegaVeiculos->fetch(PDO::FETCH_ASSOC);
 
         $id = $veiculo['cd_veiculo'];
         $pessoa = $veiculo['cd_pessoa'];
         $tipoPessoa = $veiculo['nm_tipo_pessoa'];
         $ait = $veiculo['cd_ait'];
         $processo = $veiculo['cd_processo'];
         $modalidade = $veiculo['cd_modalidade'];
         $associacao = $veiculo['cd_associacao'];
         $placa = $veiculo['cd_placa'];
         $prefixo = $veiculo['cd_prefixo'];
         $fabricante = $veiculo['nm_fabricante'];
         $modelo = $veiculo['nm_modelo'];
         $cor = $veiculo['nm_cor'];
         $anoFabricacao = $veiculo['aa_fabricacao'];
         $anoModelo = $veiculo['aa_modelo'];
         $municipio = $veiculo['nm_municipio_vec'];
         $uf = $veiculo['nm_UF'];
         $publicidade = $veiculo['ds_permissao_publicidade'];
         $particular = $veiculo['ds_particular'];
         $renavam = $veiculo['cd_renavam'];
         $vencSeguro = $veiculo['vl_vencimento_seguro'];
         $alvara = $veiculo['cd_alvara'];
         $descAlvara = $veiculo['ds_alvara'];
         $dataAlvara = $veiculo['dt_emissao_alvara'];
         $validadeAlvara = $veiculo['dt_validade_alvara'];
     }
 
     if ($acao == 'novo') {
 
         $id = 0;
         $pessoa = "";
         $tipoPessoa = "";
         $ait = "";
         $processo = "";
         $modalidade = "";
         $associacao = "";
         $placa = "";
         $prefixo = "";
         $fabricante = "";
         $modelo = "";
         $cor = "";
         $anoFabricacao = "";
         $anoModelo = "";
         $municipio = "";
         $uf = "";
         $publicidade = 0;
         $particular = 0;
         $renavam = "";
         $vencSeguro = "";
         $alvara = "";
         $descAlvara = "";
         $dataAlvara = "";
         $validadeAlvara = "";
     }
 }
 
 if (isset($_POST['cd_veiculo']) && $_POST['cd_veiculo'] != '') {
     $id = $_POST['cd_veiculo'];
     $pessoa = $_POST['cd_pessoa'];
     $tipoPessoa = $_POST['nm_tipo_pessoa'];
     $ait = $_POST['cd_ait'];
     if ($_POST['cd_ait'] === '') {
        $ait = $_POST['cd_ait'] = NULL; 
    }
    $processo = $_POST['cd_processo'];
    if ($_POST['cd_processo'] === '') {
        $processo = $_POST['cd_processo'] = NULL; 
    }
     $processo = $_POST['cd_processo'];
     $modalidade = $_POST['cd_modalidade'];
     $associacao = $_POST['cd_associacao'];
     $placa = $_POST['cd_placa'];
     $prefixo = $_POST['cd_prefixo'];
     $fabricante = $_POST['nm_fabricante'];
     $modelo = $_POST['nm_modelo'];
     $cor = $_POST['nm_cor'];
     $anoFabricacao = $_POST['aa_fabricacao'];
     $anoModelo = $_POST['aa_modelo'];
     $municipio = $_POST['nm_municipio_vec'];
     $uf = $_POST['nm_UF'];
     $publicidade = isset($_POST['ds_permissao_publicidade']) ? '1' : '0';
     $particular = isset($_POST['ds_particular']) ? '1' : '0';
     $renavam = $_POST['cd_renavam'];
     $vencSeguro = $_POST['vl_vencimento_seguro'];
     $alvara = $_POST['cd_alvara'];
     $descAlvara = $_POST['ds_alvara'];
     $dataAlvara = $_POST['dt_emissao_alvara'];
     $validadeAlvara = $_POST['dt_validade_alvara'];
 
 
 
 
     if (empty($id)) {
 
 
         try {
             $novoVeiculo = $conexao->prepare("INSERT INTO veiculo (cd_pessoa, nm_tipo_pessoa, cd_ait, cd_processo, cd_modalidade, cd_associacao,"
                     . "cd_placa, cd_prefixo, nm_fabricante, nm_modelo, nm_cor, aa_fabricacao, aa_modelo, nm_municipio_vec, nm_UF, ds_permissao_publicidade,"                    
                     . "ds_particular, cd_renavam, vl_vencimento_seguro, cd_alvara, ds_alvara, dt_emissao_alvara, dt_validade_alvara)"
                     . "VALUES ( :pessoa, :tipoPessoa, :ait, :processo, :modalidade, :associacao, :placa, :prefixo, :fabricante, :modelo, :cor,"
                     . ":anoFabricacao, :anoModelo, :municipio, :uf, :publicidade, :particular, :renavam, :vencSeguro, :alvara, :descAlvara, :dataAlvara, :validadeAlvara )");
             $novoVeiculo->bindValue(":pessoa", $pessoa);
             $novoVeiculo->bindValue(":tipoPessoa", $tipoPessoa, PDO::PARAM_STR);
             $novoVeiculo->bindValue(":ait", $ait);
             $novoVeiculo->bindValue(":processo", $processo);
             $novoVeiculo->bindValue(":modalidade", $modalidade);
             $novoVeiculo->bindValue(":associacao", $associacao);
             $novoVeiculo->bindValue(":placa", $placa, PDO::PARAM_STR);
             $novoVeiculo->bindValue(":prefixo", $prefixo, PDO::PARAM_STR);
             $novoVeiculo->bindValue(":fabricante", $fabricante, PDO::PARAM_STR);
             $novoVeiculo->bindValue(":modelo", $modelo, PDO::PARAM_STR);
             $novoVeiculo->bindValue(":cor", $cor, PDO::PARAM_STR);
             $novoVeiculo->bindValue(":anoFabricacao", $anoFabricacao, PDO::PARAM_STR);
             $novoVeiculo->bindValue(":anoModelo", $anoModelo, PDO::PARAM_STR);
             $novoVeiculo->bindValue(":municipio", $municipio, PDO::PARAM_STR);
             $novoVeiculo->bindValue(":uf", $uf, PDO::PARAM_STR);
             $novoVeiculo->bindValue(":publicidade", $publicidade);
             $novoVeiculo->bindValue(":particular", $particular);
             $novoVeiculo->bindValue(":renavam", $renavam);
             $novoVeiculo->bindValue(":vencSeguro", $vencSeguro, PDO::PARAM_STR);
             $novoVeiculo->bindValue(":alvara", $alvara);
             $novoVeiculo->bindValue(":descAlvara", $descAlvara, PDO::PARAM_STR);
             $novoVeiculo->bindValue(":dataAlvara", $dataAlvara, PDO::PARAM_STR);
             $novoVeiculo->bindValue(":validadeAlvara", $validadeAlvara, PDO::PARAM_STR);
             $novoVeiculo->execute();
                 //echo $novoVeiculo->rowCount();
                //var_dump($novoVeiculo);
                // echo $novoVeiculo->errorCode();
                 //exit();
             $retorno = 'inserido';
         } catch (Exception $e) {
             echo $e;
             exit($e);
         }
     } else {
         try {
             $atualizarVeiculo = $conexao->prepare("UPDATE veiculo SET cd_pessoa = :pessoa, nm_tipo_pessoa = :tipoPessoa, cd_ait = :ait, cd_processo = :processo, cd_modalidade = :modalidade, cd_associacao = :associacao, cd_placa = :placa, cd_prefixo = :prefixo, nm_fabricante = :fabricante, nm_modelo = :modelo, nm_cor = :cor, "
                     . "aa_fabricacao = :anoFabricacao, aa_modelo = :anoModelo, nm_municipio_vec = :municipio, nm_UF = :uf, ds_permissao_publicidade = :publicidade, ds_particular = :particular, cd_renavam = :renavam, vl_vencimento_seguro = :vencSeguro, cd_alvara = :alvara, "
                     . "ds_alvara = :descAlvara, dt_emissao_alvara = :dataAlvara, dt_validade_alvara = :validadeAlvara "
                     . "WHERE cd_veiculo = :id");
             $atualizarVeiculo->bindValue(":pessoa", $pessoa);
             $atualizarVeiculo->bindValue(":tipoPessoa", $tipoPessoa, PDO::PARAM_STR);
             $atualizarVeiculo->bindValue(":ait", $ait);
             $atualizarVeiculo->bindValue(":processo", $processo);
             $atualizarVeiculo->bindValue(":modalidade", $modalidade);
             $atualizarVeiculo->bindValue(":associacao", $associacao);
             $atualizarVeiculo->bindValue(":placa", $placa, PDO::PARAM_STR);
             $atualizarVeiculo->bindValue(":prefixo", $prefixo, PDO::PARAM_STR);
             $atualizarVeiculo->bindValue(":fabricante", $fabricante, PDO::PARAM_STR);
             $atualizarVeiculo->bindValue(":modelo", $modelo, PDO::PARAM_STR);
             $atualizarVeiculo->bindValue(":cor", $cor, PDO::PARAM_STR);
             $atualizarVeiculo->bindValue(":anoFabricacao", $anoFabricacao, PDO::PARAM_STR);
             $atualizarVeiculo->bindValue(":anoModelo", $anoModelo, PDO::PARAM_STR);
             $atualizarVeiculo->bindValue(":municipio", $municipio, PDO::PARAM_STR);
             $atualizarVeiculo->bindValue(":uf", $uf, PDO::PARAM_STR);
             $atualizarVeiculo->bindValue(":publicidade", $publicidade);
             $atualizarVeiculo->bindValue(":particular", $particular);
             $atualizarVeiculo->bindValue(":renavam", $renavam);
             $atualizarVeiculo->bindValue(":vencSeguro", $vencSeguro, PDO::PARAM_STR);
             $atualizarVeiculo->bindValue(":alvara", $alvara);
             $atualizarVeiculo->bindValue(":descAlvara", $descAlvara, PDO::PARAM_STR);
             $atualizarVeiculo->bindValue(":dataAlvara", $dataAlvara, PDO::PARAM_STR);
             $atualizarVeiculo->bindValue(":validadeAlvara", $validadeAlvara, PDO::PARAM_STR);
             $atualizarVeiculo->bindValue(":id", $id);
             $atualizarVeiculo->execute();
 
                // echo $atualizarVeiculo->rowCount();
                // var_dump($atualizarVeiculo);
                 //echo $atualizarVeiculo->errorCode();
                // exit();
 
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
                         <li class='active'><a href="../home.php">Home</a> > <a href="index.php">Veículo</a> > Novo Veículo</li>
 
                     </ol>
                     <h1>Veículos</h1>            
                 </div>       
 
                 <div class="container">               
 
                     <div class="panel panel-midnightblue">
 
                         <div class="panel-heading">
                             <h4>Dados do veículo</h4>
 
                         </div>
                         <div class="panel-body collapse in">
                             <script src="../assets/js/pesquisaCep.js"></script>
                             <script src="../assets/js/mascaraCpf-Tel.js"></script>
                             <script src="../assets/js/MascaraValidacao.js"></script>
 
                             <form id="formVeiculo" name="formVeiculo" action="gerencia.php" method="post"  class="form-horizontal" />
                             <input type="hidden" name="cd_veiculo" id="cd_veiculo" value="<?php echo($id); ?>">
                             <div class="form-group">                                                    
                                 <label class="col-sm-2 control-label">Participante</label>
                                 <div class="col-sm-4">                                        
                                     <select name="cd_pessoa" id="cd_pessoa" class="form-control" <?php if ($acao == 'visualizar') { ?>disabled="disabled" <?php }; ?> required>
                                         <option value='' >Nome do participante..</option>
 <?php
 try {
     $participantes = $conexao->prepare("SELECT * FROM pessoa ");
     $participantes->execute();
 } catch (Exception $e) {
     echo $e;
     exit();
 }
 ?>
                                         <?php while ($participante = $participantes->fetch(PDO::FETCH_ASSOC)) { ?>
                                             <option value='<?php echo $participante['cd_pessoa']; ?>' <?php echo ($participante['cd_pessoa'] == $pessoa) ? 'selected' : ''; ?>><?php echo $participante['nm_pessoa']; ?>  </option>
                                         <?php } ?>                                              
                                     </select>
                                 </div>
                             </div>
                             <div class="form-group">                                                    
                                 <label class="col-sm-2 control-label">Tipo de Participante</label>
                                 <div class="col-sm-4">                                        
                                     <select name="nm_tipo_pessoa" id="nm_tipo_pessoa" class="form-control" <?php if ($acao == 'visualizar') { ?>disabled="disabled" <?php }; ?> required>
                                         <option value='' >Tipo do Participante..</option>
 <?php
 try {
     $tipoParticipantes = $conexao->prepare("SELECT * FROM tipoPessoa ");
     $tipoParticipantes->execute();
 } catch (Exception $e) {
     echo $e;
     exit();
 }
 ?>
                                         <?php while ($tipoParticipante = $tipoParticipantes->fetch(PDO::FETCH_ASSOC)) { ?>
                                             <option value='<?php echo $tipoParticipante['nm_tipo_pessoa']; ?>' <?php echo ($tipoParticipante['nm_tipo_pessoa'] == $tipoPessoa) ? 'selected' : ''; ?>><?php echo $tipoParticipante['nm_tipo_pessoa']; ?>  </option>
                                         <?php } ?>                                              
                                     </select>
                                 </div>
                             </div>
                             <div class="form-group">                                                    
                                 <label class="col-sm-2 control-label">Numero do AIT</label>
                                 <div class="col-sm-4">                                        
                                     <select name="cd_ait" id="cd_ait" class="form-control" <?php if ($acao == 'visualizar') { ?>disabled="disabled" <?php }; ?> >
                                         <option value='' >Numero do AIT..</option>
 <?php
 try {
     $aitsMulta = $conexao->prepare("SELECT * FROM multa ");
     $aitsMulta->execute();
 } catch (Exception $e) {
     echo $e;
     exit();
 }
 ?>
                                         <?php while ($aitMulta = $aitsMulta->fetch(PDO::FETCH_ASSOC)) { ?>
                                             <option value='<?php echo $aitMulta['cd_ait']; ?>' <?php echo ($aitMulta['cd_ait'] == $ait) ? 'selected' : ''; ?>><?php echo $aitMulta['cd_ait']; ?>  </option>
                                         <?php } ?>                                              
                                     </select>
                                 </div>
                             </div>
                             <div class="form-group">                                                    
                                 <label class="col-sm-2 control-label">Numero do Processo</label>
                                 <div class="col-sm-4">                                        
                                     <select name="cd_processo" id="cd_processo" class="form-control" <?php if ($acao == 'visualizar') { ?>disabled="disabled" <?php }; ?> >
                                         <option value='' >Numero do Processo..</option>
 <?php
 try {
     $processosProcesso = $conexao->prepare("SELECT * FROM processo ");
     $processosProcesso->execute();
 } catch (Exception $e) {
     echo $e;
     exit();
 }
 ?>
                                         <?php while ($processos = $processosProcesso->fetch(PDO::FETCH_ASSOC)) { ?>
                                             <option value='<?php echo $processos['cd_processo']; ?>' <?php echo ($processos['cd_processo'] == $processo) ? 'selected' : ''; ?>><?php echo $processos['cd_processo']; ?>  </option>
                                         <?php } ?>                                              
                                     </select>
                                 </div>
                             </div>
                             <div class="form-group">                                                    
                                 <label class="col-sm-2 control-label">Tipo do Serviço</label>
                                 <div class="col-sm-4">                                        
                                     <select name="cd_modalidade" id="cd_modalidade" class="form-control" <?php if ($acao == 'visualizar') { ?>disabled="disabled" <?php }; ?> required>
                                         <option value='' >Tipo do Serviço..</option>
 <?php
 try {
     $tipoServicos = $conexao->prepare("SELECT * FROM tipoVeiculo");
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
                                 <label class="col-sm-2 control-label">Associação</label>
                                 <div class="col-sm-4">                                        
                                     <select name="cd_associacao" id="cd_associacao" class="form-control" <?php if ($acao == 'visualizar') { ?>disabled="disabled" <?php }; ?> required>
                                         <option value='' >Nome da Associação..</option>
 <?php
 try {
     $associacoes = $conexao->prepare("SELECT * FROM associacao ");
     $associacoes->execute();
 } catch (Exception $e) {
     echo $e;
     exit();
 }
 ?>
                                         <?php while ($Associacao = $associacoes->fetch(PDO::FETCH_ASSOC)) { ?>
                                             <option value='<?php echo $Associacao['cd_associacao']; ?>' <?php echo ($Associacao['cd_associacao'] == $associacao) ? 'selected' : ''; ?>><?php echo $Associacao['nm_razao_social']; ?>  </option>
                                         <?php } ?>                                              
                                     </select>
                                 </div>
                             </div>
                             <div class="form-group">
                                 <label class="col-sm-2 control-label">Placa</label>
                                 <div class="col-sm-4">
                                     <input name="cd_placa" id="cd_placa" type="text" class="form-control"   value="<?php echo $placa ?>" <?php if ($acao == 'visualizar') { ?>readonly="readonly" <?php }; ?> required/>
                                 </div>
                             </div>
 
                             <div class="form-group">
                                 <label class="col-sm-2 control-label">Prefixo</label>
                                 <div class="col-sm-4">
                                     <input name="cd_prefixo" id="cd_prefixo" type="text" class="form-control" value="<?php echo $prefixo ?>" <?php if ($acao == 'visualizar') { ?>readonly="readonly" <?php }; ?> required/>
                                 </div>
                             </div>
 
                             <div class="form-group">
                                 <label class="col-sm-2 control-label">Fabricante</label>
                                 <div class="col-sm-4">
                                     <select name="nm_fabricante" id="nm_fabricante" class="form-control" <?php if ($acao == 'visualizar') { ?>disabled="disabled" <?php }; ?> required>
                                         <option value=''>Nome do Fabricante..</option>
                                         <option value="MARCOPOLO" <?php echo($fabricante == 'MARCOPOLO') ? 'selected' : ''; ?>>MARCOPOLO</option>
                                         <option value="OUTRO" <?php echo($fabricante == 'OUTRO') ? 'selected' : ''; ?>>OUTRO</option>
 
                                     </select> 
                                 </div>
                             </div>
                             <div class="form-group">
                                 <label class="col-sm-2 control-label">Modelo</label>
                                 <div class="col-sm-4">
                                     <input name="nm_modelo" id="nm_modelo" type="text"  class="form-control"  value="<?php echo $modelo ?>" <?php if ($acao == 'visualizar') { ?>readonly="readonly" <?php }; ?> required/>
                                 </div>
                             </div>
                             <div class="form-group">
                                 <label class="col-sm-2 control-label">Cor</label>
                                 <div class="col-sm-4">
                                     <input name="nm_cor" id="nm_cor" type="text" class="form-control"  value="<?php echo $cor ?>" <?php if ($acao == 'visualizar') { ?>readonly="readonly" <?php }; ?> required/>
                                 </div>
                             </div>
 
                             <div class="form-group">
                                 <label class="col-sm-2 control-label">Ano de Fabricação</label>
                                 <div class="col-sm-4">
                                     <input name="aa_fabricacao" id="aa_fabricacao" type="text" class="form-control"  value="<?php echo $anoFabricacao ?>" <?php if ($acao == 'visualizar') { ?>readonly="readonly" <?php }; ?> pattern="[0-9]{4}" title="No minimo quatro caracteres (Apenas numeros)." required/>
                                 </div>
                             </div>
                             <div class="form-group">
                                 <label class="col-sm-2 control-label">Ano do Modelo</label>
                                 <div class="col-sm-4">
                                     <input name="aa_modelo" id="aa_modelo" type="text" class="form-control"  value="<?php echo $anoModelo ?>" <?php if ($acao == 'visualizar') { ?>readonly="readonly" <?php }; ?> pattern="[0-9]{4}" title="No minimo quatro caracteres (Apenas numeros)." required/>
                                 </div>
                             </div>
                             <div class="form-group">
                                 <label class="col-sm-2 control-label">Municipio do Veículo</label>
                                 <div class="col-sm-4">
                                     <input name="nm_municipio_vec" id="nm_municipio_vec" type="text" class="form-control"  value="<?php echo $municipio ?>" <?php if ($acao == 'visualizar') { ?>readonly="readonly" <?php }; ?> required/>
                                 </div>
                             </div>
 
                             <div class="form-group"> 
                                 <label  class="col-sm-2 control-label">UF</label>
                                 <div class="col-sm-4">
                                     <select name="nm_UF" id="nm_UF" class="form-control" <?php if ($acao == 'visualizar') { ?>disabled="disabled" <?php }; ?>> 
                                         <option value="AC" <?php echo($uf == 'AC') ? 'selected' : ''; ?>>Acre</option> 
                                         <option value="AL" <?php echo($uf == 'AL') ? 'selected' : ''; ?>>Alagoas</option> 
                                         <option value="AP" <?php echo($uf == 'AP') ? 'selected' : ''; ?>>Amazonas</option> 
                                         <option value="AM" <?php echo($uf == 'AM') ? 'selected' : ''; ?>>Amapá</option> 
                                         <option value="BA" <?php echo($uf == 'BA') ? 'selected' : ''; ?>>Bahia</option> 
                                         <option value="CE" <?php echo($uf == 'CE') ? 'selected' : ''; ?>>Ceará</option> 
                                         <option value="DF" <?php echo($uf == 'DF') ? 'selected' : ''; ?>>Distrito Federal</option> 
                                         <option value="ES" <?php echo($uf == 'ES') ? 'selected' : ''; ?>>Espírito Santo</option> 
                                         <option value="GO" <?php echo($uf == 'GO') ? 'selected' : ''; ?>>Goiás</option> 
                                         <option value="MA" <?php echo($uf == 'MA') ? 'selected' : ''; ?>>Maranhão</option> 
                                         <option value="MT" <?php echo($uf == 'MT') ? 'selected' : ''; ?>>Mato Grosso</option> 
                                         <option value="MS" <?php echo($uf == 'MS') ? 'selected' : ''; ?>>Mato Grosso do Sul</option> 
                                         <option value="MG" <?php echo($uf == 'MG') ? 'selected' : ''; ?>>Minas Gerais</option> 
                                         <option value="PA" <?php echo($uf == 'PA') ? 'selected' : ''; ?>>Pará</option> 
                                         <option value="PB" <?php echo($uf == 'PB') ? 'selected' : ''; ?>>Paraíba</option> 
                                         <option value="PR" <?php echo($uf == 'PR') ? 'selected' : ''; ?>>Paraná</option> 
                                         <option value="PE" <?php echo($uf == 'PE') ? 'selected' : ''; ?>>Pernambuco</option> 
                                         <option value="PI" <?php echo($uf == 'PI') ? 'selected' : ''; ?>>Piauí</option> 
                                         <option value="RJ" <?php echo($uf == 'RJ') ? 'selected' : ''; ?>>Rio de Janeiro</option> 
                                         <option value="RN" <?php echo($uf == 'RN') ? 'selected' : ''; ?>>Rio Grande do Norte</option> 
                                         <option value="RO" <?php echo($uf == 'RO') ? 'selected' : ''; ?>>Rondônia</option> 
                                         <option value="RS" <?php echo($uf == 'RS') ? 'selected' : ''; ?>>Rio Grande do Sul</option> 
                                         <option value="RR" <?php echo($uf == 'RR') ? 'selected' : ''; ?>>Roraima</option> 
                                         <option value="SC" <?php echo($uf == 'SC') ? 'selected' : ''; ?>>Santa Catarina</option> 
                                         <option value="SE" <?php echo($uf == 'SE') ? 'selected' : ''; ?>>Sergipe</option> 
                                         <option value="SP" <?php echo($uf == 'SP') ? 'selected' : ''; ?>>São Paulo</option> 
                                         <option value="TO" <?php echo($uf == 'TO') ? 'selected' : ''; ?>>Tocantins</option> 
                                     </select>
                                 </div>
                             </div>
 
 
                             <div class="form-group">
                                 <label class="col-sm-2 control-label">Permitido publicidade</label>
                                 <div class="col-sm-4">
                                     <label class="checkbox-inline">
                                         <input name="ds_permissao_publicidade" id="ds_permissao_publicidade" <?php echo($publicidade == '1') ? 'checked' : ''; ?> <?php if ($acao == 'visualizar') { ?>disabled="disabled"  <?php }; ?> type="checkbox" value="1"> 
                                     </label>
 
                                 </div>
                             </div>    
                             <div class="form-group">
                                 <label class="col-sm-2 control-label">Particular</label>
                                 <div class="col-sm-4">
                                     <label class="checkbox-inline">
                                         <input name="ds_particular" id="ds_particular" <?php echo($particular == '1') ? 'checked' : ''; ?> <?php if ($acao == 'visualizar') { ?>disabled="disabled"  <?php }; ?> type="checkbox" value="1"> 
                                     </label>
 
                                 </div>
                             </div>  
                             <div class="form-group">
                                 <label class="col-sm-2 control-label">Numero do Renavam</label>
                                 <div class="col-sm-4">
                                     <input name="cd_renavam" id="cd_renavam" type="number" class="form-control"  value="<?php echo $renavam ?>" <?php if ($acao == 'visualizar') { ?>readonly="readonly" <?php }; ?> required/>
                                 </div>
                             </div>
                             <div class="form-group">
                                 <label class="col-sm-2 control-label">Vencimento do Seguro</label>
                                 <div class="col-sm-4">
                                     <input name="vl_vencimento_seguro" id="vl_vencimento_seguro" type="date" class="form-control"  value="<?php echo $vencSeguro ?>" <?php if ($acao == 'visualizar') { ?>readonly="readonly" <?php }; ?> required/>
                                 </div>
                             </div>
 
                             <div class="form-group">
                                 <label class="col-sm-2 control-label">Numero do Alvará</label>
                                 <div class="col-sm-4">
                                     <input name="cd_alvara" id="cd_alvara" type="number" class="form-control"  value="<?php echo $alvara ?>" <?php if ($acao == 'visualizar') { ?>readonly="readonly" <?php }; ?> />
                                 </div>
                             </div>
                             <div class="form-group">
                                 <label class="col-sm-2 control-label">Descrição do Alvará</label>
                                 <div class="col-sm-4">
                                     <input name="ds_alvara" id="ds_alvara" type="text" class="form-control"  value="<?php echo $descAlvara ?>" <?php if ($acao == 'visualizar') { ?>readonly="readonly" <?php }; ?> />
                                 </div>
                             </div>
                             <div class="form-group">
                                 <label class="col-sm-2 control-label">Data de emissão do Alvará</label>
                                 <div class="col-sm-4">
                                     <input name="dt_emissao_alvara" id="dt_emissao_alvara" type="date" class="form-control"  value="<?php echo $dataAlvara ?>" <?php if ($acao == 'visualizar') { ?>readonly="readonly" <?php }; ?> />
                                 </div>
                             </div>
 
                             <div class="form-group">
                                 <label class="col-sm-2 control-label">Data de validade do Alvará</label>
                                 <div class="col-sm-4">
                                     <input name="dt_validade_alvara" id="dt_validade_alvara" type="date" class="form-control"  value="<?php echo $validadeAlvara ?>" <?php if ($acao == 'visualizar') { ?>readonly="readonly" <?php }; ?> />
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
