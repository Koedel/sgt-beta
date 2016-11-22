<?php if(!isset($_SESSION)){session_start();}?>
<?php
include("include/conexao/conecta.php");
include 'include/funcoes.php';
$conexao = conecta();
if(isset($_POST['usuario']) && !empty($_POST['usuario']) && isset($_POST['senha']) && !empty($_POST['senha']))
	{
		$usuario = $_POST['usuario'];
		$senha = $_POST['senha'];
                
                $pegaUsuario=$conexao->prepare("SELECT * FROM usuario WHERE nm_usuario = :usuario");
                $pegaUsuario->bindValue(":usuario", $usuario);
                $pegaUsuario->execute();
                
                                
//		$sql = "SELECT * FROM usuario WHERE nm_usuario = '$usuario'";
//		//exit($sql);
//		                
//                $query = mysqli_query($conexao, $sql) ;
                if($pegaUsuario->rowCount() == 0){
                    header("Location: login.php?erro=invalido");                                
                    exit;
                }else{
                    $usuario = $pegaUsuario->fetch(PDO::FETCH_ASSOC);
                    
                    if(md5($senha)==$usuario['ds_senha'] && $usuario['ds_ativo'] == 1){
                        $_SESSION['cdUsuario'] = $usuario['id_usuario'];
                        $_SESSION['nomeUsuario'] = $usuario['nm_usuario'];
                        $_SESSION['permissao'] = $usuario['ds_permissao'];
			auditoria("Logou");
                        header("Location: home.php");
                        exit;
                    }else{                                    
                        header("Location: login.php?erro=invalido");
                        exit;                                
                    }
                }
  
//		if(mysqli_num_rows($query) == 0)
//			{
//				header("Location: login.php?erro=invalido");                                
//				exit;
//			}else{
//				$usuario = mysqli_fetch_assoc($query);
//				
//				if(md5($senha) == $usuario['ds_senha'] && $usuario['ds_ativo'] == 1 ){
//					$_SESSION['cdUsuario'] = $usuario['id_usuario'];
//					$_SESSION['nomeUsuario'] = $usuario['nm_usuario'];
//                                        $_SESSION['permissao'] = $usuario['ds_permissao'];
//					
//					header("Location: home.php");
//					exit;
//					
//				}else{                                    
//        				header("Location: login.php?erro=invalido");
//					exit;                                
//                                }
//			}			
	}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="utf-8">
	<meta charset="iso-8859-1" />
	<title>SGT</title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta name="description" content="Avant" />
	<meta name="author" content="The Red Team" />

	<link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600' rel='stylesheet' type='text/css' />
	<link href="assets/css/styles.min.css" rel='stylesheet' type='text/css' />
    <script type='text/javascript' src='assets/js/jquery-1.10.2.min.js'></script> 
	<style type="text/css">
	body,td,th {
	font-family: "FontAwesome","Source Sans Pro", "Open Sans", "Segoe UI", "Droid Sans", "Tahoma", "Arial", "sans-serif";
	}
    </style>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<script type="text/javascript">
$(function() {
	$('#usuario').focus();
	$('#btn_entrar').click(function() {
		$('#formLogin').submit();
	});
	$('#senha').keypress(function(e){
		if(e.wich == 13 || e.keyCode == 13){
		// e = evento; 13 = code do enter :D
		//o que você quer que faca qdo apertar enter aqui!
		$('#formLogin').submit();	
	}
}); 
})
</script>
</head>
<body class="focusedform">

<div class="verticalcenter">
	<!--<img src="assets/img/logo-big.png" alt="Logo" class="brand" />-->
    <div style="text-align:center"><h2>Painel de controle</h2></div>
	<div class="panel panel-primary">
		<div class="panel-body">
			<img src="assets/img/sgt_logo.png" class="profile-img" />
			<h4 class="text-center" style="margin-bottom: 25px;">Informe seu nome de usu&aacute;rio e senha</h4>
                <?php if(isset($_GET['erro']) && $_GET['erro'] == 'invalido'){?>
                <div class="alert alert-dismissable alert-danger">
                    <strong>Nome de usuário ou senha inválidos</strong><br />Verifique os dados e tente novamente.
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
				</div>
                <?php }?>
                <?php if(isset($_GET['erro']) && $_GET['erro'] == 'aut'){?>
                <div class="alert alert-dismissable alert-danger">
                    <strong>Acesso restrito</strong><br />Para acessar a aplicação é preciso estar autenticado.
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
				</div>
                <?php }?>
				<!-- <form action="#" class="form-horizontal">
					<div class="col-md-12">
						<div class="form-group">
							<label for="email" class="control-label sr-only">Email</label>
							<input type="text" class="form-control" id="email" placeholder="Email">
						</div>
						<div class="form-group">
							<label for="password" class="control-label sr-only">Password</label>
							<input type="password" class="form-control" id="password" placeholder="Password">
						</div>
					</div>
					<div class="row">
					<div class="clearfix">
						<div class="pull-right"><label><input type="checkbox" checked> Remember Me?</label></div>
					</div>
				</form> -->
				<form action="#" method="post" class="form-horizontal" name="formLogin" id="formLogin" style="margin-bottom: 0px !important;" />
						<div class="form-group">
							<div class="col-sm-12">
								<div class="input-group">
									<span class="input-group-addon"><i class="icon-user"></i></span>
									<input type="text" class="form-control" name="usuario" id="usuario" placeholder="Nome de usuário" />
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-12">
								<div class="input-group">
									<span class="input-group-addon"><i class="icon-lock"></i></span>
									<input type="password" class="form-control" name="senha" id="senha" placeholder="Senha" />
								</div>
							</div>
						</div>
						<!--<div class="clearfix">
							<div class="pull-right"><label><input type="checkbox" style="margin-bottom: 20px" checked="" /> Lembrar meus dados</label></div>
						</div>-->
					</form>
					
		</div>
		<div class="panel-footer">
		<!--	<a href="#" class="pull-left btn btn-link" style="padding-left:0">Esqueceu sua senha?</a>-->
			<div class="pull-left"><img src="/assets/img/adsix_logo.png"> </div>			
			<div class="pull-right">
				<a href="#" id="btn_limpar" class="btn btn-default" onClick="formLogin.reset();">Limpar</a>
				<a href="#" id="btn_entrar" class="btn btn-primary">Entrar</a>
			</div>
		</div>
	</div>
 </div>
	

<script type='text/javascript' src='assets/js/jqueryui-1.10.3.min.js'></script> 
<script type='text/javascript' src='assets/js/bootstrap.min.js'></script> 
<?php /*?><script type='text/javascript' src='assets/js/enquire.js'></script> 
<script type='text/javascript' src='assets/js/jquery.cookie.js'></script> 
<script type='text/javascript' src='assets/js/jquery.touchSwipe.min.js'></script> 
<script type='text/javascript' src='assets/js/jquery.nicescroll.min.js'></script> 
<script type='text/javascript' src='assets/plugins/codeprettifier/prettify.js'></script> 
<script type='text/javascript' src='assets/plugins/easypiechart/jquery.easypiechart.min.js'></script> 
<script type='text/javascript' src='assets/plugins/sparklines/jquery.sparklines.min.js'></script> 
<script type='text/javascript' src='assets/plugins/form-toggle/toggle.min.js'></script> 
<script type='text/javascript' src='assets/plugins/pines-notify/jquery.pnotify.min.js'></script> 
<script type='text/javascript' src='assets/demo/demo-alerts.js'></script> 
<script type='text/javascript' src='assets/js/placeholdr.js'></script> 
<script type='text/javascript' src='assets/js/application.js'></script> 
<script type='text/javascript' src='assets/demo/demo.js'></script> 
<?php */ ?>
</body>
</html>