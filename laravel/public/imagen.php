<?php
// Mantenemos tu foreach para iterar los resultados
foreach ($resultado as $row) {
    $foto = $row['fotografia'];

    // 1. Tratamiento de seguridad: Verificamos si realmente hay datos antes de crear archivos
    if (!empty($foto)) {
        // Generamos un nombre único para la imagen
        $nombre_temporal = basename(tempnam(getcwd()."/temporales", "temp"));
        $imagen = $nombre_temporal . ".jpg";
        $ruta_completa = "./temporales/" . $imagen;

        // 2. Abrimos, escribimos y cerramos con control de errores
        $fichero = fopen($ruta_completa, "w");
        if ($fichero) {
            fwrite($fichero, $foto);
            fclose($fichero);
            
            // 3. Mostramos la imagen solo si el archivo se creó correctamente
            echo "<tr>
                    <td>" . $row['email'] . "</td>
                    <td>
                        <center>
                            <a href='temporales/$imagen'> 
                                <img src='temporales/$imagen' width='50' border='0'>
                            </a>
                        </center>
                    </td>
                  </tr>";
        }
    }
}
?>