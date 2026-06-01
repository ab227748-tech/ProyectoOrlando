<?php
$conexion = mysqli_connect('127.0.0.1', 'root', '', 'databasetekax');

if (!$conexion) {
    die("Error al conectar a la base de datos: " . mysqli_connect_error());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagina Principal</title>
</head>
<body>

    <h1>Productos <h1>

<?php

    $resultado = mysqli_query($conexion, "SELECT * FROM productos");
    if (mysqli_num_rows($resultado) == 0) {
    echo "<p>No hay motocicletas registradas.</p>";
    } else {
    echo "<table border='5'>";
    echo "<tr>
            <th>ID Productos</th>
            <th>Nombre</th>
            <th>Disponibilidad</th>
            <th>Categoria</th>
            <th>Cantidad</th>
            <th>Precio</th>
            <th>Descripcion</th>
            <th>Imagen</th>
          </tr>";

    while ($row = mysqli_fetch_assoc($resultado)) {
        echo "<tr>";
        echo "<td>{$row['idproductos']}</td>";
        echo "<td>{$row['nombre']}</td>";
        echo "<td>{$row['disponibilidad']}</td>";
        echo "<td>{$row['categoria']}</td>";
        echo "<td>{$row['cantidad']}</td>";
        echo "<td>{$row['precio']}</td>";
        echo "<td>{$row['descripcion']}</td>";
        echo "<td>{$row['imagen']}</td>";
        echo "</tr>";
    }
    echo "</table>";
    }
?>
    <BR> <BR>

     <button> <a href="RegistrarPedido.php"> Volver atras</a> </button> 
    
</body>
</html>