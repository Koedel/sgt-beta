<?php if(!isset($_SESSION)){session_start();}?>
<?php
	ini_set("display_errors",true);        
	include("../include/valida_acesso.php");
	include("../include/functions.php");
	include("../../conexao/webadmin.php");

	$ref = ($_GET['ref']);

$sql = "SELECT * FROM usuario
        WHERE id_usuario = '$ref'";

$linhas = mysql_query($sql, $conexao);
$usuario = array();

while($linha = mysql_fetch_assoc($linhas)){
	$codigo_usuario = $linha['id_usuario'];
        $nome = $linha['nm_usurio'];
        $ativo = $linha['ds_ativo'];
        $permicao = $linha['de_permicao'];
        
//	$nome = utf8_encode($linha['red_nome']);
//	$data_criacao = dataHumana($linha['red_data_criacao']);
//	$observacao = utf8_encode($linha['red_observacao']);
		
	array_push($rede,array('codigo_rede'=> $codigo_usuario,
                                'nome'=> $nome, 
                                'data_criacao'=> $ativo, 
                                'observacao'=> $permicao));
}

echo $resposta = '{"usurio":'.json_encode($usuario) . '}';
//echo $resposta = json_encode($rede);

?>