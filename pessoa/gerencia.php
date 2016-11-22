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
        $deletaPessoa = $conexao->prepare("DELETE FROM pessoa WHERE cd_pessoa = :id");
        $deletaPessoa->bindValue(":id", $id);
        $deletaPessoa->execute();
        if ($deletaPessoa->rowCount() == 0) {
            echo "<script>alert('Houve um erro ao deletar!');
                location.href=\"index.php\"</script>";
        } else {
            echo "<script>alert('Registro excluido com sucesso!');
                   location.href=\"index.php\"</script>";
        }
    }
    if ($acao == 'visualizar' || $acao == 'editar') {
        $pegaPessoas = $conexao->prepare("SELECT * FROM pessoa WHERE cd_pessoa = :id");
        $pegaPessoas->bindValue(":id", $id);
        $pegaPessoas->execute();
        $pessoa = $pegaPessoas->fetch(PDO::FETCH_ASSOC);
        $id = $pessoa['cd_pessoa'];
        $tipoPessoa = $pessoa['nm_tipo_pessoa'];
        $nomePessoa = $pessoa['nm_pessoa'];
        $associacao = $pessoa['nm_associacao'];
        $cep = $pessoa['cd_cep'];
        $local = $pessoa['nm_local'];
        $numero = $pessoa['cd_endereco'];
        $complemento = $pessoa['ds_complemento'];
        $bairro = $pessoa['nm_bairro'];
        $municipio = $pessoa['nm_municipio'];
        $uf = $pessoa['nm_UF'];
        $telefone = $pessoa['cd_telefone'];
        $celular = $pessoa['cd_celular'];
        $email = $pessoa['nm_email'];
        $rg = $pessoa['cd_rg'];
        $ufRg = $pessoa['nm_uf_rg'];
        $cpf = $pessoa['cd_cpf'];
        $tit = $pessoa['cd_titulo_eleitor'];
        $zona = $pessoa['cd_zona'];
        $secao = $pessoa['cd_secao_eleitoral'];
        $dataNascimento = $pessoa['dt_nascimento'];
        $reservista = $pessoa['cd_certidao_reservista'];
        $serie = $pessoa['cd_serie'];
        $dataAAC = $pessoa['dt_atestado_antecedente_criminais'];
        $cnh = $pessoa['cd_cnh'];
        $catcnh = $pessoa['nm_categoria'];
        $dtexpcnh = $pessoa['dt_expedicao_cnh'];
        $dtrencnh = $pessoa['dt_renovacao_cnh'];
        $dtdirdef = $pessoa['dt_direcao_defensiva'];
        $gerdetran = $pessoa['cd_gerenciamento_detran'];
        $dtcredetran = $pessoa['dt_credenciamento_detran'];
        $carteirinha = $pessoa['cd_carteirinha'];
        $valcarteirinha = $pessoa['dt_validade_carteirinha'];
        $insciss = $pessoa['cd_inscricao_iss'];
        $carteira = $pessoa['ds_carteira'];
        $dtinicio = $pessoa['dt_inicio'];
        $inativo = $pessoa['ds_inativo'];
    }
    if ($acao == 'novo') {
        $id = 0;
        $tipoPessoa = "";
        $nomePessoa = "";
        $associacao = "";
        $cep = "";
        $local = "";
        $numero = "";
        $complemento = "";
        $bairro = "";
        $municipio = "";
        $uf = "";
        $telefone = "";
        $celular = "";
        $email = "";
        $rg = "";
        $ufRg = "";
        $cpf = "";
        $tit = "";
        $zona = "";
        $secao = "";
        $dataNascimento = "";
        $reservista = "";
        $serie = "";
        $dataAAC = "";
        $cnh = "";
        $catcnh = "";
        $dtexpcnh = "";
        $dtrencnh = "";
        $dtdirdef = "";
        $gerdetran = "";
        $dtcredetran = "";
        $carteirinha = "";
        $valcarteirinha = "";
        $insciss = "";
        $carteira = "";
        $dtinicio = "";
        $inativo = 0;
    }
}
if (isset($_POST['cd_pessoa']) && $_POST['cd_pessoa'] != '') {
    $id = $_POST['cd_pessoa'];
    $tipoPessoa = $_POST['nm_tipo_pessoa'];
    $nomePessoa = $_POST['nm_pessoa'];
    $associacao = $_POST['nm_associacao'];
    $cep = $_POST['cd_cep'];
    $local = $_POST['nm_local'];
    $numero = $_POST['cd_endereco'];
    $complemento = $_POST['ds_complemento'];
    $bairro = $_POST['nm_bairro'];
    $municipio = $_POST['nm_municipio'];
    $uf = $_POST['nm_UF'];
    $telefone = $_POST['cd_telefone'];
    $celular = $_POST['cd_celular'];
    $email = $_POST['nm_email'];
    $rg = $_POST['cd_rg'];
    $ufRg = $_POST['nm_uf_rg'];
    $cpf = $_POST['cd_cpf'];
    $tit = $_POST['cd_titulo_eleitor'];
    $zona = $_POST['cd_zona'];
    $secao = $_POST['cd_secao_eleitoral'];
    $dataNascimento = $_POST['dt_nascimento'];
    $reservista = $_POST['cd_certidao_reservista'];
    $serie = $_POST['cd_serie'];
    $dataAAC = $_POST['dt_atestado_antecedente_criminais'];
    $cnh = $_POST['cd_cnh'];
    $catcnh = $_POST['nm_categoria'];
    $dtexpcnh = $_POST['dt_expedicao_cnh'];
    $dtrencnh = $_POST['dt_renovacao_cnh'];
    $dtdirdef = $_POST['dt_direcao_defensiva'];
    $gerdetran = $_POST['cd_gerenciamento_detran'];
    $dtcredetran = $_POST['dt_credenciamento_detran'];
    $carteirinha = $_POST['cd_carteirinha'];
    $valcarteirinha = $_POST['dt_validade_carteirinha'];
    $insciss = $_POST['cd_inscricao_iss'];
    $carteira = $_POST['ds_carteira'];
    $dtinicio = $_POST['dt_inicio'];
    $inativo = isset($_POST['ds_inativo']) ? '1' : '0';
    if (empty($id)) {
        try {
            $novaPessoa = $conexao->prepare("INSERT INTO pessoa (nm_tipo_pessoa, nm_pessoa, nm_associacao, cd_cep, nm_local, cd_endereco,"
                    . "ds_complemento,  nm_bairro, nm_municipio, nm_UF, cd_telefone, cd_celular, nm_email, cd_rg, nm_uf_rg, cd_cpf,"
                    . "cd_titulo_eleitor, cd_zona, cd_secao_eleitoral, dt_nascimento, cd_certidao_reservista, cd_serie, dt_atestado_antecedente_criminais,"
                    . "cd_cnh, nm_categoria, dt_expedicao_cnh, dt_renovacao_cnh, dt_direcao_defensiva, cd_gerenciamento_detran, dt_credenciamento_detran, cd_carteirinha,"
                    . "dt_validade_carteirinha, cd_inscricao_iss, ds_carteira, dt_inicio, ds_inativo) "
                    . "VALUES ( :tipoPessoa, :nomePessoa, :associacao, :cep, :local, :numero, :complemento, :bairro, :municipio, :uf, :telefone,"
                    . ":celular, :email, :rg, :ufRg, :cpf, :tit, :zona, :secao, :dataNascimento, :reservista, :serie, :dataAAC, :cnh,"
                    . ":catcnh, :dtexpcnh, :dtrencnh, :dtdirdef, :gerdetran, :dtcredetran, :carteirinha, :valcarteirinha, :insciss, :carteira, :dtinicio, :inativo )");
            $novaPessoa->bindValue(":tipoPessoa", $tipoPessoa, PDO::PARAM_STR);
            $novaPessoa->bindValue(":nomePessoa", $nomePessoa, PDO::PARAM_STR);
            $novaPessoa->bindValue(":associacao", $associacao, PDO::PARAM_STR);
            $novaPessoa->bindValue(":cep", $cep);
            $novaPessoa->bindValue(":local", $local, PDO::PARAM_STR);
            $novaPessoa->bindValue(":numero", $numero);
            $novaPessoa->bindValue(":complemento", $complemento, PDO::PARAM_STR);
            $novaPessoa->bindValue(":bairro", $bairro, PDO::PARAM_STR);
            $novaPessoa->bindValue(":municipio", $municipio, PDO::PARAM_STR);
            $novaPessoa->bindValue(":uf", $uf, PDO::PARAM_STR);
            $novaPessoa->bindValue(":telefone", $telefone, PDO::PARAM_STR);
            $novaPessoa->bindValue(":celular", $celular, PDO::PARAM_STR);
            $novaPessoa->bindValue(":email", $email, PDO::PARAM_STR);
            $novaPessoa->bindValue(":rg", $rg, PDO::PARAM_STR);
            $novaPessoa->bindValue(":ufRg", $ufRg, PDO::PARAM_STR);
            $novaPessoa->bindValue(":cpf", $cpf);
            $novaPessoa->bindValue(":tit", $tit);
            $novaPessoa->bindValue(":zona", $zona);
            $novaPessoa->bindValue(":secao", $secao);
            $novaPessoa->bindValue(":dataNascimento", $dataNascimento, PDO::PARAM_STR);
            $novaPessoa->bindValue(":reservista", $reservista, PDO::PARAM_STR);
            $novaPessoa->bindValue(":serie", $serie, PDO::PARAM_STR);
            $novaPessoa->bindValue(":dataAAC", $dataAAC, PDO::PARAM_STR);
            $novaPessoa->bindValue(":cnh", $cnh);
            $novaPessoa->bindValue(":catcnh", $catcnh, PDO::PARAM_STR);
            $novaPessoa->bindValue(":dtexpcnh", $dtexpcnh, PDO::PARAM_STR);
            $novaPessoa->bindValue(":dtrencnh", $dtrencnh, PDO::PARAM_STR);
            $novaPessoa->bindValue(":dtdirdef", $dtdirdef, PDO::PARAM_STR);
            $novaPessoa->bindValue(":gerdetran", $gerdetran);
            $novaPessoa->bindValue(":dtcredetran", $dtcredetran, PDO::PARAM_STR);
            $novaPessoa->bindValue(":carteirinha", $carteirinha);
            $novaPessoa->bindValue(":valcarteirinha", $valcarteirinha, PDO::PARAM_STR);
            $novaPessoa->bindValue(":insciss", $insciss, PDO::PARAM_STR);
            $novaPessoa->bindValue(":carteira", $carteira, PDO::PARAM_STR);
            $novaPessoa->bindValue(":dtinicio", $dtinicio, PDO::PARAM_STR);
            $novaPessoa->bindValue(":inativo", $inativo);
            $novaPessoa->execute();
            // echo $novoUsuario->rowCount();
            //var_dump($novoUsuario);
            $retorno = 'inserido';
        } catch (Exception $e) {
            echo $e;
            exit($e);
        }
    } else {
        try {
            $atualizarPessoa = $conexao->prepare("UPDATE pessoa SET nm_tipo_pessoa = :tipoPessoa, nm_pessoa = :nomePessoa, nm_associacao = :associacao, nm_local = :local, cd_endereco = :numero, ds_complemento = :complemento, cd_cep = :cep, nm_bairro = :bairro, nm_municipio = :municipio, nm_UF = :uf, cd_telefone = :telefone, "
                    . "cd_celular = :celular, nm_email = :email, cd_rg = :rg, nm_uf_rg = :ufRg, cd_cpf = :cpf, cd_titulo_eleitor = :tit, cd_zona = :zona, cd_secao_eleitoral = :secao, dt_nascimento = :dataNascimento, "
                    . "cd_certidao_reservista = :reservista, cd_serie = :serie, dt_atestado_antecedente_criminais = :dataAAC, cd_cnh = :cnh, nm_categoria = :catcnh, dt_expedicao_cnh = :dtexpcnh, dt_renovacao_cnh = :dtrencnh, dt_direcao_defensiva = :dtdirdef, cd_gerenciamento_detran = :gerdetran,"
                    . "dt_credenciamento_detran = :dtcredetran, cd_carteirinha = :carteirinha, dt_validade_carteirinha = :valcarteirinha, cd_inscricao_iss = :insciss, ds_carteira = :carteira, dt_inicio = :dtinicio, ds_inativo = :inativo "
                    . "WHERE cd_pessoa = :id");
            $atualizarPessoa->bindValue(":tipoPessoa", $tipoPessoa, PDO::PARAM_STR);
            $atualizarPessoa->bindValue(":nomePessoa", $nomePessoa, PDO::PARAM_STR);
            $atualizarPessoa->bindValue(":associacao", $associacao, PDO::PARAM_STR);
            $atualizarPessoa->bindValue(":cep", $cep);
            $atualizarPessoa->bindValue(":local", $local, PDO::PARAM_STR);
            $atualizarPessoa->bindValue(":numero", $numero);
            $atualizarPessoa->bindValue(":complemento", $complemento, PDO::PARAM_STR);
            $atualizarPessoa->bindValue(":bairro", $bairro, PDO::PARAM_STR);
            $atualizarPessoa->bindValue(":municipio", $municipio, PDO::PARAM_STR);
            $atualizarPessoa->bindValue(":uf", $uf, PDO::PARAM_STR);
            $atualizarPessoa->bindValue(":telefone", $telefone, PDO::PARAM_STR);
            $atualizarPessoa->bindValue(":celular", $celular, PDO::PARAM_STR);
            $atualizarPessoa->bindValue(":email", $email, PDO::PARAM_STR);
            $atualizarPessoa->bindValue(":rg", $rg, PDO::PARAM_STR);
            $atualizarPessoa->bindValue(":ufRg", $ufRg, PDO::PARAM_STR);
            $atualizarPessoa->bindValue(":cpf", $cpf);
            $atualizarPessoa->bindValue(":tit", $tit);
            $atualizarPessoa->bindValue(":zona", $zona);
            $atualizarPessoa->bindValue(":secao", $secao);
            $atualizarPessoa->bindValue(":dataNascimento", $dataNascimento, PDO::PARAM_STR);
            $atualizarPessoa->bindValue(":reservista", $reservista, PDO::PARAM_STR);
            $atualizarPessoa->bindValue(":serie", $serie, PDO::PARAM_STR);
            $atualizarPessoa->bindValue(":dataAAC", $dataAAC, PDO::PARAM_STR);
            $atualizarPessoa->bindValue(":cnh", $cnh);
            $atualizarPessoa->bindValue(":catcnh", $catcnh, PDO::PARAM_STR);
            $atualizarPessoa->bindValue(":dtexpcnh", $dtexpcnh, PDO::PARAM_STR);
            $atualizarPessoa->bindValue(":dtrencnh", $dtrencnh, PDO::PARAM_STR);
            $atualizarPessoa->bindValue(":dtdirdef", $dtdirdef, PDO::PARAM_STR);
            $atualizarPessoa->bindValue(":gerdetran", $gerdetran);
            $atualizarPessoa->bindValue(":dtcredetran", $dtcredetran, PDO::PARAM_STR);
            $atualizarPessoa->bindValue(":carteirinha", $carteirinha);
            $atualizarPessoa->bindValue(":valcarteirinha", $valcarteirinha, PDO::PARAM_STR);
            $atualizarPessoa->bindValue(":insciss", $insciss, PDO::PARAM_STR);
            $atualizarPessoa->bindValue(":carteira", $carteira, PDO::PARAM_STR);
            $atualizarPessoa->bindValue(":dtinicio", $dtinicio, PDO::PARAM_STR);
            $atualizarPessoa->bindValue(":inativo", $inativo);
            $atualizarPessoa->bindValue(":id", $id);
            $atualizarPessoa->execute();
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
         <?php  if($_SESSION['permissao']!= 1){
        echo '<script>alert("Acesso Restrito!'. '\n' .'Você será redirecionado para a tela inicial!");
                   location.href="../home.php"</script>';
    }?>   

        <div id="page-content">
            <div id='wrap'>
                <div id="page-heading">
                    <ol class="breadcrumb">
                        <li class='active'><a href="../home.php">Home</a> > <a href="index.php">Pessoa</a> > Nova Pessoa</li>

                    </ol>
                    <h1>Pessoas</h1>            
                </div>       

                <div class="container">               

                    <div class="panel panel-midnightblue">

                        <div class="panel-heading">
                            <h4>Dados da Pessoa</h4>

                        </div>
                        <div class="panel-body collapse in">
                            <script src="../assets/js/pesquisaCep.js"></script>
                            <script src="../assets/js/mascaraCpf-Tel.js"></script>
                            <script src="../assets/js/MascaraValidacao.js"></script>

                            <form id="formPessoa" name="formPessoa" action="gerencia.php" method="post"  class="form-horizontal" />
                            <input type="hidden" name="cd_pessoa" id="cd_pessoa" value="<?php echo($id); ?>">
                            <div class="form-group">                                                    
                                <label class="col-sm-2 control-label">Tipo de Serviço</label>
                                <div class="col-sm-4">                                        
                                    <select name="nm_tipo_pessoa" id="nm_tipo_pessoa" class="form-control" <?php if ($acao == 'visualizar') { ?>disabled="disabled" <?php }; ?> required>
                                        <option value='' >Tipo de Pessoa...</option>
                                        <?php
                                        try {
                                            $tipopessoas = $conexao->prepare("SELECT * FROM tipoPessoa ");
                                            $tipopessoas->execute();
                                        } catch (Exception $e) {
                                            echo $e;
                                            exit();
                                        }
                                        ?>
                                        <?php while ($tipopessoa = $tipopessoas->fetch(PDO::FETCH_ASSOC)) { ?>
                                            <option value='<?php echo $tipopessoa['nm_tipo_pessoa']; ?>' <?php echo ($tipopessoa['nm_tipo_pessoa'] == $tipoPessoa) ? 'selected' : ''; ?>><?php echo $tipopessoa['nm_tipo_pessoa']; ?>  </option>
                                        <?php } ?>                                              
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Nome</label>
                                <div class="col-sm-4">
                                    <input name="nm_pessoa" id="nm_pessoa" type="text" class="form-control"  value="<?php echo $nomePessoa ?>" <?php if ($acao == 'visualizar') { ?>readonly="readonly" <?php }; ?> required/>
                                </div>
                            </div>
                            <div class="form-group">                                                    
                                <label class="col-sm-2 control-label">Associação</label>
                                <div class="col-sm-4">                                        
                                    <select name="nm_associacao" id="nm_associacao" class="form-control" <?php if ($acao == 'visualizar') { ?>disabled="disabled" <?php }; ?> required>
                                        <option value='' >Associação...</option>
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
                                            <option value='<?php echo $Associacao['nm_razao_social']; ?>' <?php echo ($Associacao['nm_razao_social'] == $associacao) ? 'selected' : ''; ?>><?php echo $Associacao['nm_razao_social']; ?>  </option>
                                        <?php } ?>                                              
                                    </select>
                                </div>
                            </div>


                            <div class="form-group">
                                <label class="col-sm-2 control-label">CEP</label>
                                <div class="col-sm-4">
                                    <input name="cd_cep" id="cd_cep" type="text" class="form-control" onblur="pesquisacep(this.value);" value="<?php echo $cep ?>" <?php if ($acao == 'visualizar') { ?>readonly="readonly" <?php }; ?> required/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">Endereço</label>
                                <div class="col-sm-4">
                                    <input name="nm_local" id="nm_local" type="text" class="form-control"  value="<?php echo $local ?>" <?php if ($acao == 'visualizar') { ?>readonly="readonly" <?php }; ?> required/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Número</label>
                                <div class="col-sm-4">
                                    <input name="cd_endereco" id="cd_endereco" type="number" min=1  title="Insira um valor maior ou igual a 1" class="form-control"  value="<?php echo $numero ?>" <?php if ($acao == 'visualizar') { ?>readonly="readonly" <?php }; ?> required/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Complemento</label>
                                <div class="col-sm-4">
                                    <input name="ds_complemento" id="ds_complemento" type="text" class="form-control"  value="<?php echo $complemento ?>" <?php if ($acao == 'visualizar') { ?>readonly="readonly" <?php }; ?>/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">Bairro</label>
                                <div class="col-sm-4">
                                    <input name="nm_bairro" id="nm_bairro" type="text" class="form-control"  value="<?php echo $bairro ?>" <?php if ($acao == 'visualizar') { ?>readonly="readonly" <?php }; ?> required/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Município</label>
                                <div class="col-sm-4">
                                    <input name="nm_municipio" id="nm_municipio" type="text" class="form-control"  value="<?php echo $municipio ?>" <?php if ($acao == 'visualizar') { ?>readonly="readonly" <?php }; ?> required/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">UF</label>
                                <div class="col-sm-4">
                                    <input name="nm_UF" id="nm_UF" type="text" class="form-control"  value="<?php echo $uf ?>" <?php if ($acao == 'visualizar') { ?>readonly="readonly" <?php }; ?> required/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Telefone</label>
                                <div class="col-sm-4">
                                    <input name="cd_telefone" id="cd_telefone" type="text" class="form-control"  onkeypress="javascript: mascara(this, tel_mask);" value="<?php echo $telefone ?>" <?php if ($acao == 'visualizar') { ?>readonly="readonly" <?php }; ?> required/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">Celular</label>
                                <div class="col-sm-4">
                                    <input name="cd_celular" id="cd_celular" type="text" class="form-control"  onkeypress="javascript: mascara(this, cel_mask);" value="<?php echo $celular ?>" <?php if ($acao == 'visualizar') { ?>readonly="readonly" <?php }; ?> required/>
                                </div>
                            </div>


                            <div class="form-group">
                                <label class="col-sm-2 control-label">Email</label>
                                <div class="col-sm-4">
                                    <input name="nm_email" id="nm_email" type="email" class="form-control"  value="<?php echo $email ?>" <?php if ($acao == 'visualizar') { ?>readonly="readonly" <?php }; ?> required/>
                                </div>
                            </div>


                            <div class="form-group">
                                <label class="col-sm-2 control-label">RG</label>
                                <div class="col-sm-4">
                                    <input name="cd_rg" id="cd_rg" type="text" class="form-control" maxlength="12" onKeyPress="javascript: mascara(this , mascaraRG);" value="<?php echo $rg ?>" <?php if ($acao == 'visualizar') { ?>readonly="readonly" <?php }; ?> required/>
                                </div>
                            </div>

                            <div class="form-group"> 
                                <label  class="col-sm-2 control-label">UF-RG</label>
                                <div class="col-sm-4">
                                    <select name="nm_uf_rg" id="nm_uf_rg" class="form-control" <?php if ($acao == 'visualizar') { ?>disabled="disabled" <?php }; ?>> 
                                        <option value="AC" <?php echo($ufRg == 'AC') ? 'selected' : ''; ?>>Acre</option> 
                                        <option value="AL" <?php echo($ufRg == 'AL') ? 'selected' : ''; ?>>Alagoas</option> 
                                        <option value="AP" <?php echo($ufRg == 'AP') ? 'selected' : ''; ?>>Amazonas</option> 
                                        <option value="AM" <?php echo($ufRg == 'AM') ? 'selected' : ''; ?>>Amapá</option> 
                                        <option value="BA" <?php echo($ufRg == 'BA') ? 'selected' : ''; ?>>Bahia</option> 
                                        <option value="CE" <?php echo($ufRg == 'CE') ? 'selected' : ''; ?>>Ceará</option> 
                                        <option value="DF" <?php echo($ufRg == 'DF') ? 'selected' : ''; ?>>Distrito Federal</option> 
                                        <option value="ES" <?php echo($ufRg == 'ES') ? 'selected' : ''; ?>>Espírito Santo</option> 
                                        <option value="GO" <?php echo($ufRg == 'GO') ? 'selected' : ''; ?>>Goiás</option> 
                                        <option value="MA" <?php echo($ufRg == 'MA') ? 'selected' : ''; ?>>Maranhão</option> 
                                        <option value="MT" <?php echo($ufRg == 'MT') ? 'selected' : ''; ?>>Mato Grosso</option> 
                                        <option value="MS" <?php echo($ufRg == 'MS') ? 'selected' : ''; ?>>Mato Grosso do Sul</option> 
                                        <option value="MG" <?php echo($ufRg == 'MG') ? 'selected' : ''; ?>>Minas Gerais</option> 
                                        <option value="PA" <?php echo($ufRg == 'PA') ? 'selected' : ''; ?>>Pará</option> 
                                        <option value="PB" <?php echo($ufRg == 'PB') ? 'selected' : ''; ?>>Paraíba</option> 
                                        <option value="PR" <?php echo($ufRg == 'PR') ? 'selected' : ''; ?>>Paraná</option> 
                                        <option value="PE" <?php echo($ufRg == 'PE') ? 'selected' : ''; ?>>Pernambuco</option> 
                                        <option value="PI" <?php echo($ufRg == 'PI') ? 'selected' : ''; ?>>Piauí</option> 
                                        <option value="RJ" <?php echo($ufRg == 'RJ') ? 'selected' : ''; ?>>Rio de Janeiro</option> 
                                        <option value="RN" <?php echo($ufRg == 'RN') ? 'selected' : ''; ?>>Rio Grande do Norte</option> 
                                        <option value="RO" <?php echo($ufRg == 'RO') ? 'selected' : ''; ?>>Rondônia</option> 
                                        <option value="RS" <?php echo($ufRg == 'RS') ? 'selected' : ''; ?>>Rio Grande do Sul</option> 
                                        <option value="RR" <?php echo($ufRg == 'RR') ? 'selected' : ''; ?>>Roraima</option> 
                                        <option value="SC" <?php echo($ufRg == 'SC') ? 'selected' : ''; ?>>Santa Catarina</option> 
                                        <option value="SE" <?php echo($ufRg == 'SE') ? 'selected' : ''; ?>>Sergipe</option> 
                                        <option value="SP" <?php echo($ufRg == 'SP') ? 'selected' : ''; ?>>São Paulo</option> 
                                        <option value="TO" <?php echo($ufRg == 'TO') ? 'selected' : ''; ?>>Tocantins</option> 
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">CPF</label>
                                <div class="col-sm-4">
                                    <input name="cd_cpf" id="cd_cpf" type="text" class="form-control" maxlength="15" onKeyPress="javascript: mascara(this, cpf_mask);" value="<?php echo $cpf ?>" <?php if ($acao == 'visualizar') { ?>readonly="readonly" <?php }; ?> required/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Título de eleitor</label>
                                <div class="col-sm-4">
                                    <input name="cd_titulo_eleitor" id="cd_titulo_eleitor" type="text" class="form-control" maxlength="14"  value="<?php echo $tit ?>" <?php if ($acao == 'visualizar') { ?>readonly="readonly" <?php }; ?> required/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">Zona</label>
                                <div class="col-sm-4">
                                    <input name="cd_zona" id="cd_zona" type="number" class="form-control"  value="<?php echo $zona ?>" <?php if ($acao == 'visualizar') { ?>readonly="readonly" <?php }; ?> required/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Seção</label>
                                <div class="col-sm-4">
                                    <input name="cd_secao_eleitoral" id="cd_secao_eleitoral" type="number" class="form-control"  value="<?php echo $secao ?>" <?php if ($acao == 'visualizar') { ?>readonly="readonly" <?php }; ?> required/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Data de Nascimento</label>
                                <div class="col-sm-4">
                                    <input name="dt_nascimento" id="dt_nascimento" type="date" class="form-control"  value="<?php echo $dataNascimento ?>" <?php if ($acao == 'visualizar') { ?>readonly="readonly" <?php }; ?> required/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">Nº Reservista</label>
                                <div class="col-sm-4">
                                    <input name="cd_certidao_reservista" id="cd_certidao_reservista" type="text" class="form-control"  value="<?php echo $reservista ?>" <?php if ($acao == 'visualizar') { ?>readonly="readonly" <?php }; ?> />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Série</label>
                                <div class="col-sm-4">
                                    <input name="cd_serie" id="cd_serie" type="text" class="form-control"  value="<?php echo $serie ?>" <?php if ($acao == 'visualizar') { ?>readonly="readonly" <?php }; ?> />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Data A.A.Criminais </label>
                                <div class="col-sm-4">
                                    <input name="dt_atestado_antecedente_criminais" id="dt_atestado_antecedente_criminais" type="date" class="form-control"  value="<?php echo $dataAAC ?>" <?php if ($acao == 'visualizar') { ?>readonly="readonly" <?php }; ?> />
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">CNH</label>
                                <div class="col-sm-4">
                                    <input name="cd_cnh" id="cd_cnh" type="number" class="form-control" value="<?php echo $cnh ?>" <?php if ($acao == 'visualizar') { ?>readonly="readonly" <?php }; ?> />
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">Categoria</label>
                                <div class="col-sm-4">
                                    <input maxlength= "1" name="nm_categoria" id="nm_categoria" type="text" class="form-control" value="<?php echo $catcnh ?>" <?php if ($acao == 'visualizar') { ?>readonly="readonly" <?php }; ?> />
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">Data Expedição </label>
                                <div class="col-sm-4">
                                    <input name="dt_expedicao_cnh" id="dt_expedicao_cnh" type="date" class="form-control"  value="<?php echo $dtexpcnh ?>" <?php if ($acao == 'visualizar') { ?>readonly="readonly" <?php }; ?> />
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">Data Renovação </label>
                                <div class="col-sm-4">
                                    <input name="dt_renovacao_cnh" id="dt_renovacao_cnh" type="date" class="form-control"  value="<?php echo $dtrencnh ?>" <?php if ($acao == 'visualizar') { ?>readonly="readonly" <?php }; ?> />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Data Dir.Defensiva </label>
                                <div class="col-sm-4">
                                    <input name="dt_direcao_defensiva" id="dt_direcao_defensiva" type="date" class="form-control"  value="<?php echo $dtdirdef ?>" <?php if ($acao == 'visualizar') { ?>readonly="readonly" <?php }; ?> />
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">Gerenciamento Detran</label>
                                <div class="col-sm-4">
                                    <input name="cd_gerenciamento_detran" id="cd_gerenciamento_detran" type="number" class="form-control" value="<?php echo $gerdetran ?>" <?php if ($acao == 'visualizar') { ?>readonly="readonly" <?php }; ?> />
                                </div>
                            </div> 

                            <div class="form-group">
                                <label class="col-sm-2 control-label">Data Cred. Detran </label>
                                <div class="col-sm-4">
                                    <input name="dt_credenciamento_detran" id="dt_credenciamento_detran" type="date" class="form-control"  value="<?php echo $dtcredetran ?>" <?php if ($acao == 'visualizar') { ?>readonly="readonly" <?php }; ?> />
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">Carteirinha</label>
                                <div class="col-sm-4">
                                    <input name="cd_carteirinha" id="cd_carteirinha" type="text" class="form-control" value="<?php echo $carteirinha ?>" <?php if ($acao == 'visualizar') { ?>readonly="readonly" <?php }; ?> />
                                </div>
                            </div> 

                            <div class="form-group">
                                <label class="col-sm-2 control-label">Validade Carteirinha </label>
                                <div class="col-sm-4">
                                    <input name="dt_validade_carteirinha" id="dt_validade_carteirinha" type="date" class="form-control"  value="<?php echo $valcarteirinha ?>" <?php if ($acao == 'visualizar') { ?>readonly="readonly" <?php }; ?> />
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">Inscrição ISS</label>
                                <div class="col-sm-4">
                                    <input name="cd_inscricao_iss" id="cd_inscricao_iss" type="text" class="form-control" value="<?php echo $insciss ?>" <?php if ($acao == 'visualizar') { ?>readonly="readonly" <?php }; ?> />
                                </div>
                            </div> 

                            <div class="form-group">
                                <label class="col-sm-2 control-label">Obs. Carteira</label>
                                <div class="col-sm-4">
                                    <input name="ds_carteira" id="ds_carteira" type="text" class="form-control" value="<?php echo $carteira ?>" <?php if ($acao == 'visualizar') { ?>readonly="readonly" <?php }; ?> />
                                </div>
                            </div> 

                            <div class="form-group">
                                <label class="col-sm-2 control-label">Data de Início </label>
                                <div class="col-sm-4">
                                    <input name="dt_inicio" id="dt_inicio" type="date" class="form-control"  value="<?php echo $dtinicio ?>" <?php if ($acao == 'visualizar') { ?>readonly="readonly" <?php }; ?> />
                                </div>
                            </div>



                            <div class="form-group">
                                <label class="col-sm-2 control-label">Inativo</label>
                                <div class="col-sm-4">
                                    <label class="checkbox-inline">
                                        <input name="ds_inativo" id="ds_inativo" <?php echo($inativo == '1') ? 'checked' : ''; ?> <?php if ($acao == 'visualizar') { ?>disabled="disabled"  <?php }; ?> type="checkbox" value="1"> 
                                    </label>

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
