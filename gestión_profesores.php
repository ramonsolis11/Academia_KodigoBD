<?php
    //iniciando la sesion
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- Favicons -->
    <link href="assets/img/favicon.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <!-- Template Main CSS File -->
    <link href="assets/css/style.css" rel="stylesheet">
</head>
<body>

    <?php include "./modulos/header.php";
        require_once "./clases/Profesores.php";

        $profesor = new Coach();
        $arreglo_datos = $profesor->getProfesores();
    ?>

    <main id="main">
        <section class="container">
            <h1>Gestion de Profesores</h1>
            <table class="table">
                <thead>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Telefono</th>
                    <th>Correo</th>
                    <th>Materia</th>
                    <th>Estado</th>
                </thead>
                <tbody>
                    <?php foreach($arreglo_datos as $item){ ?>
                        <tr>
                            <td><?php echo $item["nombre"]; ?></td>
                            <td><?php echo $item["apellido"]; ?></td>
                            <td><?php echo $item["telefono"]; ?></td>
                            <td><?php echo $item["correo"]; ?></td>
                            <td><?php echo $item["materia"]; ?></td>
                            <td><?php echo $item["id_estado"]; ?></td>
                        </tr>

                        
                    <?php } ?>
                </tbody>
            </table>
        </section>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>