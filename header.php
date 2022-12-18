<header>
    <div id="imglogo">
        <a href="index.php"><img src="images/logo.jpg" alt="" id="logo"></a>
    </div>
    <nav>
        <ul>
            <li><a href="index.php">Inicio</a></li>
            <li><a href="cruceros.php">Cruceros</a></li>
            <li><a href="about.php">Nosotros</a></li>
        </ul>
    </nav>
    <div class="dropdown show" id="link">
        <?php
        if (isset($_SESSION["usuario"]["correo"])) {
            ?>
        <a id="dropdownMenuLink" data-toggle="dropdown" ><?php echo $_SESSION["usuario"]["nombre"];?></a>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
            <a class="dropdown-item" href="perfil.php">Perfil</a>
            <?php if ($_SESSION["usuario"]["rol"] === "Administrador") { ?>
            <a class="dropdown-item" href="verUsuarios.php">Ver usuarios</a>
            <a class="dropdown-item" href="administrar.php">Administrar</a>
            <?php } ?>
            <a class="dropdown-item" href="logout.php">Cerrar sesión</a>
        </div>
        <?php 
        } else {
            ?>
            <a href="login.php">Iniciar sesión</a>
            <?php
        }
        ?>
    </div>
</header>