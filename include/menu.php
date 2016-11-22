<nav id="page-leftbar" role="navigation">
                <!-- BEGIN SIDEBAR MENU -->
            <ul class="acc-menu" id="sidebar">
                <li><a href="../home.php"><i class="icon-home"></i> <span>Home</span></a></li>
                    <?php if($_SESSION['permissao']== 1){?>
                    <li><a href="../veiculo/index.php"><i class="icon-road"></i> <span>Veículos</span></a></li>  
                    <li><a href="../usuario/index.php"><i class="icon-user"></i> <span>Usuários</span></a></li> <?php }; ?>
                        <li><a href="../pessoa/index.php"><i class="icon-star-empty"></i> <span>Pessoas</span></a></li>
                   <li><a href="javascript:;"><i class="icon-cog"></i> <span>Cadastros</span> </a>
            <ul class="acc-menu">
                <li><a href="../tipopessoa/index.php"><i class="icon-user"></i> <span>Tipo de Pessoa</span></a></li>
                <li><a href="../associacao/index.php"><i class="icon-link"></i> <span>Associações</span></a></li>
                <li><a href="../modalidade/index.php"><i class="icon-maxcdn"></i> <span>Modalidades</span></a></li>
                <li><a href="../processo/index.php"><i class="icon-archive"></i> <span>Processos</span></a></li>
                 <li><a href="../multa/index.php"><i class="icon-list-ul"></i> <span>Multas</span></a></li>
                <li><a href="../infracao/index.php"><i class="icon-book"></i> <span>Infrações</span></a></li>
                <li><a href="../recurso/index.php"><i class="icon-double-angle-left"></i> <span>Recursos</span></a></li>
                <li><a href="../vistoria/index.php"><i class="icon-check"></i> <span>Vistorias</span></a></li>
                
            

        </li>
                </ul>
                <li><a href="../contato/index.php"><i class="icon-envelope"></i> <span>Contato</span></a></li>
            

            </ul>
            <!-- END SIDEBAR MENU -->
        </nav>
