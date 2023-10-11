<i class="bi bi-list mobile-nav-toggle d-xl-none"></i>

<header id="header">
    <?php 
        require_once "./clases/Autenticacion.php";
        $autenticar = new Autenticacion();
    ?>
    <div class="d-flex flex-column">

        <div class="profile">
        <img src="assets/img/profile-img.jpg" alt="" class="img-fluid rounded-circle">
        <!-- Verificamos si 'nombre_usuario' está definido en la sesión antes de mostrarlo -->
        <h1 class="text-light"><a href="#">
            <?php
            if (isset($_SESSION['nombre_usuario'])) {
                echo $_SESSION['nombre_usuario'];
            } else {
                echo "Invitado";
            }
            ?>
        </a></h1>
        </div>

        <nav id="navbar" class="nav-menu navbar">
        <ul>
            <li>
                <a href="#" class="nav-link scrollto active"><i class="bi bi-house-door"></i> <span>Home</span></a>
            </li>
            <li>
                <a href="./estudiantes_activos.php" class="nav-link scrollto"><i class="bi bi-person"></i> <span>Gestión Estudiantes</span></a>
            </li>
            <li>
                <a href="./estudiantes_desertados.php" class="nav-link scrollto"><i class="bi bi-person-x"></i> <span>Estudiantes Desertados</span></a>
            </li>
            <li>
                <a href="./estudiantes_reubicados.php" class="nav-link scrollto"><i class="bi bi-person-check"></i> <span>Estudiantes Reubicaciones</span></a>
            </li>
            <li>
                <a href="./estudiantes_egresados.php" class="nav-link scrollto"><i class="bi bi-person-dash"></i> <span>Estudiantes Egresados</span></a>
            <li>
                <a href="./gestión_profesores.php" class "nav-link scrollto"><i class="bi bi-person-lines-fill"></i> <span>Gestión Profesores</span></a>
            </li>
            <li>
                <form action="" method="post">
                    <input type="submit" class="btn btn-danger px-2" name="cerrar_sesion" value="Cerrar Sesión">
                </form>

                <?php $autenticar->cerrarSesion(); ?>
            </li>
        </ul>
        </nav>
    </div>
</header>
