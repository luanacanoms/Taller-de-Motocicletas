<?php
foreach ($resultado as $row) {
    $foto = $row['fotografia'];

    if (!empty($foto)) {
        // Generamos un nombre único para la imagen
        $nombre_temporal = basename(tempnam(getcwd()."/temporales", "temp"));
        $imagen = $nombre_temporal . ".jpg";
        $ruta_completa = "./temporales/" . $imagen;

        $fichero = fopen($ruta_completa, "w");
        if ($fichero) {
            fwrite($fichero, $foto);
            fclose($fichero);
            
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