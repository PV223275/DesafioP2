<?php
// Funcion asociativos
function asignaAlumnos() {
    return [
        "Básico" => [
            "Inglés" => 25,
            "Francés" => 10,
            "Mandarín" => 8,
            "Ruso" => 12,
            "Portugués" => 30,
            "Japonés" => 90
        ],
        "Intermedio" => [
            "Inglés" => 15,
            "Francés" => 5,
            "Mandarín" => 4,
            "Ruso" => 8,
            "Portugués" => 15,
            "Japonés" => 25
        ],
        "Avanzado" => [
            "Inglés" => 10,
            "Francés" => 2,
            "Mandarín" => 1,
            "Ruso" => 4,
            "Portugués" => 10,
            "Japonés" => 67
        ]
    ];
}

// Funcio muestra los datos de los alumnos
function mostrarTablaPorIdioma($alumnos) {
    $idiomas = array_keys($alumnos["Básico"]);

    // Se reccorre cada idioma
    foreach ($idiomas as $idioma) {
        echo "<h2 class='text-center mt-4'>$idioma</h2>";
        echo "<p class='text-center mb-4'>Número de alumnos por nivel de idioma:</p>";
        // se recorre cada nivel
        foreach ($alumnos as $nivel => $idiomasNivel) {
            $alumnosNivel = $idiomasNivel[$idioma]; 
            echo "<p class='text-center'>En el nivel <strong>$nivel</strong>, idioma <strong>$idioma</strong>, hay <strong>$alumnosNivel</strong> alumnos.</p>";
        }

        // se crea la tabla para mostrar datoss
        echo "<div class='container mb-5'>";
        echo "<table class='table table-bordered text-center'>";
        echo "<thead class='table-light'><tr><th>Nivel</th><th>Cantidad de alumnos</th></tr></thead>";
        echo "<tbody>";

        foreach ($alumnos as $nivel => $idiomasNivel) {
            $color = '';
            if ($nivel == "Básico") $color = "table-success";  // Verde
            elseif ($nivel == "Intermedio") $color = "table-warning";  // Amarillo
            else $color = "table-danger";  // Rojo

            echo "<tr class='$color'>";
            echo "<td>$nivel</td>"; 
            echo "<td>{$idiomasNivel[$idioma]}</td>";
            echo "</tr>";
        }

        echo "</tbody></table></div>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ejercicio 1A - Arreglos Asociativos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1 class="text-center mt-5 mb-4">Registros de Idiomas y Alumnos en Cada Nivel</h1>
        
        <?php
            // se cargan lkos datos de los alumnos
            $alumnos = asignaAlumnos();
            // se muetras los datos
            mostrarTablaPorIdioma($alumnos);
        ?>
    </div>
</body>
</html>
