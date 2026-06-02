<?php
$conexion = mysqli_connect('127.0.0.1', 'root', '', 'databasetekax');

if (!$conexion) {
    die("Error al conectar a la base de datos: " . mysqli_connect_error());
}

if (isset($_POST['enviardatos'])) {
    $Nombre = $_POST['nombre'];
    $selectorDisponibilidad = $_POST['disponibilidad']; 
    $selectorCategoria = $_POST['categoria'];           
    $Cantidad = $_POST['Cantidad'];
    $Precio = $_POST['precio'];
    $Descripcion = $_POST['descripcion'];
    
    // --- LÓGICA PARA SUBIR LA IMAGEN ---
    $nombreImagen = ""; // Valor por defecto si no suben nada

    if (isset($_FILES['Imagen']) && $_FILES['Imagen']['error'] === 0) {
        $rutaDestino = "imagenes/"; // Carpeta donde se guardarán las fotos
        
        // Si la carpeta no existe, la crea automáticamente
        if (!file_exists($rutaDestino)) {
            mkdir($rutaDestino, 0777, true);
        }

        // Obtener extensión del archivo (jpg, png, etc)
        $ext = pathinfo($_FILES['Imagen']['name'], PATHINFO_EXTENSION);
        
        // Encriptamos el nombre para que no se dupliquen si suben archivos con el mismo nombre
        $nombreImagen = time() . "_" . uniqid() . "." . $ext; 
        
        $rutaCompleta = $rutaDestino . $nombreImagen;

        // Mover el archivo temporal a la carpeta destino
        if (!move_uploaded_file($_FILES['Imagen']['tmp_name'], $rutaCompleta)) {
            echo "Error al guardar la imagen en el servidor.";
            exit();
        }
    }
    // ------------------------------------

    $Nombre = mysqli_real_escape_string($conexion, $Nombre);
    $Descripcion = mysqli_real_escape_string($conexion, $Descripcion);

    // Guardamos la variable $nombreImagen en la columna 'imagen'
    $query = "INSERT INTO productos(nombre, disponibilidad, categoria, cantidad, precio, descripcion, imagen) 
              VALUES('$Nombre', '$selectorDisponibilidad', '$selectorCategoria', '$Cantidad', '$Precio', '$Descripcion', '$nombreImagen')";
    
    $resultado = mysqli_query($conexion, $query);

    if ($resultado) {
        header("Location: Index.php?status=success");
        exit();
    } else {
        echo "Error en la inserción: " . mysqli_error($conexion);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <link class="html-embed" rel="stylesheet" href="EstiloRegistrarPedido.css">
</head>
<body>
    <div class="container">

        <h1>Bienvenido al modulo de registro de producto</h1>
        <br>

        <form method="POST" action="" enctype="multipart/form-data">

            <p>Ingrese el nombre del producto</p>
            <input type="text" id="nombre" name="nombre" size="50" required>
            
            <br>

            <p>Disponibilidad</p>
            <select name="disponibilidad" id="selectorDisponibilidad">
                <option value="Disponible">Disponible</option>
                <option value="No disponible">No disponible</option>
            </select>

            <br>

            <p>Selecciona la categoria</p>
            <select name="categoria" id="selectorCategoria">
                <option value="">Seleccione una opcion</option>
                <option value="Agricultura">Agricultura</option>
                <option value="Apicultura">Apicultura</option>
                <option value="Artesania">Artesania</option>
            </select>

            <br>

            <p>Ingresa la cantidad del producto</p>
            <input type="number" id="Cantidad" name="Cantidad" value="0">

            <br>

            <p>Precio por unidad $</p>
            <input type="number" id="precio" name="precio" value="0">

            <br>

            <p>Ingrese una breve descripcion</p>
            <input type="text" id="descripcion" name="descripcion" size="40" maxlength="100">

            <br>

            <p>Ingrese la imagen del producto</p>
            <input type="file" id="Imagen" name="Imagen" accept="image/*" required> 
            
            <br><br>

            <div class="button-group">
                <input type="submit" name="enviardatos" value="Registrar">
                <button type="button" class="btn-cancel" onclick="window.location.href='Index.php'">Cancelar o Regresar</button>
            </div>

        </form> </div>
</body>
</html>