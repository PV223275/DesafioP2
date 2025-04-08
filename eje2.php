<?php
session_start();

// Clase Libro
class Libro {
    public $autor;
    public $titulo;
    public $edicion;
    public $lugar;
    public $editorial;
    public $anio;
    public $paginas;
    public $notas;
    public $isbn;

    // Constructor de la clase
    public function __construct($autor, $titulo, $edicion, $lugar, $editorial, $anio, $paginas, $notas, $isbn) {
        $this->autor = $autor;
        $this->titulo = $titulo;
        $this->edicion = $edicion;
        $this->lugar = $lugar;
        $this->editorial = $editorial;
        $this->anio = $anio;
        $this->paginas = $paginas;
        $this->notas = $notas;
        $this->isbn = $isbn;
    }

    // Método para mostrar los detalles del libro
    public function mostrarDetalles() {
        echo "<tr>";
        echo "<td>{$this->autor}</td>";
        echo "<td>{$this->titulo}</td>";
        echo "<td>{$this->edicion}</td>";
        echo "<td>{$this->lugar}</td>";
        echo "<td>{$this->editorial}</td>";
        echo "<td>({$this->anio})</td>";
        echo "<td>{$this->paginas}</td>";
        echo "<td>{$this->notas}</td>";
        echo "<td>{$this->isbn}</td>";
        echo "</tr>";
    }
}

// Función de validación de ISBN (13 dígitos)
function validarISBN($isbn) {
    return preg_match('/^\d{13}$/', $isbn);
}

// Función de validación de autor
function validarAutor($autor) {
    return preg_match('/^([A-Za-z]+, [A-Za-z]+|VARIOS AUTORES)$/', $autor);
}

// Función de validación de otros campos
function validarCampo($campo, $regex) {
    return preg_match($regex, $campo);
}

// Validar formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recoger los datos del formulario
    $autor = $_POST['autor'];
    $titulo = $_POST['titulo'];
    $edicion = $_POST['edicion'];
    $lugar = $_POST['lugar'];
    $editorial = $_POST['editorial'];
    $anio = $_POST['anio'];
    $paginas = $_POST['paginas'];
    $notas = $_POST['notas'];
    $isbn = $_POST['isbn'];

    // Validar campos
    $errores = [];
    if (!validarAutor($autor)) {
        $errores[] = "El autor debe estar en el formato adecuado (Apellido, Nombre o VARIOS AUTORES).";
    }
    if (!validarCampo($titulo, '/^[A-Za-z\s]+$/')) {
        $errores[] = "El título debe estar en formato adecuado.";
    }
    if (!validarISBN($isbn)) {
        $errores[] = "El ISBN debe ser un número de 13 dígitos.";
    }

    // Si no hay errores se crea el libro
    if (empty($errores)) {
        $libro = new Libro($autor, $titulo, $edicion, $lugar, $editorial, $anio, $paginas, $notas, $isbn);

        if (!isset($_SESSION['libros'])) {
            $_SESSION['libros'] = [];
        }
        $_SESSION['libros'][] = $libro;

        // Limpiar los campos del formulario
        $autor = $titulo = $edicion = $lugar = $editorial = $anio = $paginas = $notas = $isbn = "";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inventario de Biblioteca</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mt-4 mb-4 fw-bold text-success">Formulario de Inventario de Biblioteca</h1>

        <?php if (!empty($errores)): ?>
            <div class="alert alert-danger">
                <ul>
                    <?php foreach ($errores as $error): ?>
                        <li><?= $error ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-3">
                <label for="autor" class="form-label">Autor</label>
                <input type="text" name="autor" id="autor" class="form-control" value="<?= $autor ?? '' ?>" required>
            </div>
            <div class="mb-3">
                <label for="titulo" class="form-label">Título del libro</label>
                <input type="text" name="titulo" id="titulo" class="form-control" value="<?= $titulo ?? '' ?>" required>
            </div>
            <div class="mb-3">
                <label for="edicion" class="form-label">Número de edición</label>
                <input type="text" name="edicion" id="edicion" class="form-control" value="<?= $edicion ?? '' ?>" required>
            </div>
            <div class="mb-3">
                <label for="lugar" class="form-label">Lugar de publicación</label>
                <input type="text" name="lugar" id="lugar" class="form-control" value="<?= $lugar ?? '' ?>" required>
            </div>
            <div class="mb-3">
                <label for="editorial" class="form-label">Editorial</label>
                <input type="text" name="editorial" id="editorial" class="form-control" value="<?= $editorial ?? '' ?>" required>
            </div>
            <div class="mb-3">
                <label for="anio" class="form-label">Año de edición</label>
                <input type="number" name="anio" id="anio" class="form-control" value="<?= $anio ?? '' ?>" required>
            </div>
            <div class="mb-3">
                <label for="paginas" class="form-label">Número de páginas</label>
                <input type="number" name="paginas" id="paginas" class="form-control" value="<?= $paginas ?? '' ?>" required>
            </div>
            <div class="mb-3">
                <label for="notas" class="form-label">Notas</label>
                <input type="text" name="notas" id="notas" class="form-control" value="<?= $notas ?? '' ?>">
            </div>
            <div class="mb-3">
                <label for="isbn" class="form-label">ISBN</label>
                <input type="text" name="isbn" id="isbn" class="form-control" value="<?= $isbn ?? '' ?>" required>
            </div>
            <button type="submit" class="btn btn-success">Registrar</button>
        </form>

        <!-- Se muestran los libros -->
        <?php if (isset($_SESSION['libros']) && count($_SESSION['libros']) > 0): ?>
            <h2 class="mt-5">Libros Registrados</h2>
            <table class="table table-bordered mt-3">
                <thead>
                    <tr>
                        <th>Autor</th>
                        <th>Título</th>
                        <th>Edición</th>
                        <th>Lugar</th>
                        <th>Editorial</th>
                        <th>Año</th>
                        <th>Páginas</th>
                        <th>Notas</th>
                        <th>ISBN</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($_SESSION['libros'] as $libro): ?>
                        <?= $libro->mostrarDetalles() ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</body>
</html>
