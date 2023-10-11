<?php 
session_start();
?>

<?php
require "./clases/Estudiantes.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id_estudiante'], $_POST['nuevoBootcamp'])) {
    $id_estudiante = $_POST['id_estudiante'];
    $nuevoBootcamp = $_POST['nuevoBootcamp'];

    $estudiante = new Estudiante();
    
    // Asumiendo que agregas un método llamado reubicarEstudiante en la clase Estudiante.
    $resultado = $estudiante->reubicarEstudiante($id_estudiante, $nuevoBootcamp);

    if ($resultado) {
        header('Location: estudiantes_reubicados.php?reubicacion=exito');
    } else {
        header('Location: estudiantes_activos.php?reubicacion=error');
    }
}
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

        error_reporting(E_ALL);
        ini_set('display_errors', 1);

        $estudiante = new Estudiante();
        $arreglo_reubicados = $estudiante->getEstudiantesReubicados();
    ?>

    <main id="main">
        <section class="container">
            <h1>Gestion de Estudiantes Reubicados</h1>
        <table class="table">
            <thead>
                <th>Nombre</th>
                <th>Direccion</th>
                <th>Carnet</th>
                <th>Bootcamp</th>
                <th>Estado</th>
            </thead>
            <tbody>
            <?php foreach($arreglo_reubicados as $item){ ?>
                <tr>
                    <td><?php echo $item["nombre"]; ?></td>
                    <td><?php echo $item["direccion"]; ?></td>
                    <td><?php echo $item["carnet"]; ?></td>
                    <td><?php echo $item["bootcamp"]; ?></td>
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
