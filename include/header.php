<?php include 'headerBar.php';?>
<header class="navbar navbar-inverse navbar-fixed-top" role="banner">
        <a id="leftmenu-trigger" class="pull-left" data-toggle="tooltip" data-placement="bottom" title="Toggle Left Sidebar"></a>
        <a id="rightmenu-trigger" class="pull-right" data-toggle="tooltip" data-placement="bottom" title="Toggle Right Sidebar"></a>

        <div class="navbar-header pull-left">
            <a class="navbar-brand" href="home.php"></a>
        </div>

        <ul class="nav navbar-nav pull-right toolbar">
        	<li class="dropdown">
        		<a href="#" class="dropdown-toggle username" data-toggle="dropdown"><span class="hidden-xs"><?php echo $_SESSION['nomeUsuario'] ?><i class="icon-caret-down icon-scale"></i></span></a>
        		<ul class="dropdown-menu userinfo arrow">
        			<li class="username">
                        <a href="#">

                            <div class="pull-right"><h5>Olá, <?php echo $_SESSION['nomeUsuario'] ?>!</h5><small>Logado como: <span>username</span></small></div>
                        </a>
        			</li>
        			<li class="userlinks">
        				<ul class="dropdown-menu">
<!--        					<li><a href="#">Edit Profile <i class="pull-right icon-pencil"></i></a></li>
        					<li><a href="#">Account <i class="pull-right icon-cog"></i></a></li>
        					<li><a href="#">Help <i class="pull-right icon-question-sign"></i></a></li>-->

        					<li><a href="../sair.php" class="text-right">Sair</a></li>
        				</ul>
        			</li>
        		</ul>
        	</li>


		</ul>
</header>
