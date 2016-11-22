<?php
include '/include/funcoes.php';
include '/include/conexao/conecta.php';


    $key=$_GET['key'];
    $array = array();
    $conexao = conecta();
    $query=mysql_query("select * from  veiculo where <cd_placa> LIKE '%{$key}%'");
    while($row=mysql_fetch_assoc($query))
    {
      $array[] = $row['title'];
    }
    echo json_encode($array);
?>
