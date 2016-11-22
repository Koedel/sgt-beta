<?php
//DADOS PARA CONEXAO COM O BANCO DE DADOS LOCAL
$dbHost = "localhost";
$dbName = "sgt";
$dbUser = "root";
$dbPassword = "";
//--

//DADOS PARA CONEXAO COM O BANCO DE DADOS DOMINIO
//$dbHost = "mysql.hostinger.com.br";
//$dbName = "u698970389_sgt";
//$dbUser = "u698970389_sgt";
//$dbPassword = "fatecpg";
//--

// CONEXAO COM O BANCO DE DADOS
$conexao = mysqli_connect($dbHost,$dbUser,$dbPassword);
mysqli_select_db($conexao, $dbName);
//--

// TÍTULO DAS PÁGINAS
//$titulo = "Painel de controle";
//--

function conecta(){
    //DADOS PARA CONEXAO COM O BANCO DE DADOS LOCAL
    $dbHost        = "localhost";
    $dbName        = "sgt"; 
    $dbUser        = "root";
    $dbPassword    = "";
    //--

    //DADOS PARA CONEXAO COM O BANCO DE DADOS DOMINIO
    //$dbHost        = "mysql.hostinger.com.br";
    //$dbName        = "u698970389_sgt"; 
    //$dbUser        = "u698970389_sgt";
    //$dbPassword    = "fatecpg";
    //--
    try{
        $conexao = new PDO('mysql:host='.$dbHost.';dbname='.$dbName , $dbUser, $dbPassword);
    } catch (Exception $ex) {
        $echo= $ex->getMessage();
    }
    return $conexao;


}
?>