<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

/* ========= CONFIG ========= */
$db = [
    "host" => "localhost",
    "name" => "tienda",
    "user" => "postgres",
    "pass" => "123456"
];

define("API_TOKEN", "123456");

/* ========= CONEXIÓN ========= */
try {
    $pdo = new PDO(
        "pgsql:host={$db['host']};dbname={$db['name']}",
        $db['user'],
        $db['pass'],
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
    );
} catch (PDOException $e) {
    echo json_encode(["error" => "No se pudo conectar a la base de datos"]);
    exit;
}

$method = $_SERVER['REQUEST_METHOD'];

/* ========= FUNCIONES ========= */
function checkToken() {
    if (
        !isset($_SERVER['HTTP_AUTHORIZATION']) ||
        $_SERVER['HTTP_AUTHORIZATION'] !== "Bearer " . API_TOKEN
    ) {
        echo json_encode(["error" => "Token inválido"]);
        exit;
    }
}

/* ========= ROUTER ========= */
switch ($method) {

    case 'GET':
        if (isset($_GET['id'])) {
            $stmt = $GLOBALS['pdo']->prepare(
                "SELECT * FROM producto WHERE id = :id"
            );
            $stmt->execute(['id' => $_GET['id']]);
            echo json_encode($stmt->fetch());
        } else {
            $stmt = $GLOBALS['pdo']->query(
                "SELECT * FROM producto"
            );
            echo json_encode($stmt->fetchAll());
        }
        break;

    case 'PUT':
        checkToken();

        if (
            !isset($_GET['id']) ||
            !isset($_GET['nombre']) ||
            !isset($_GET['precio']) ||
            !isset($_GET['id_fabricante'])
        ) {
            echo json_encode(["error" => "Parámetros incompletos"]);
            exit;
        }

        $stmt = $pdo->prepare(
            "UPDATE producto
             SET nombre = :nombre,
                 precio = :precio,
                 id_fabricante = :id_fabricante
             WHERE id = :id"
        );

        $stmt->execute([
            "nombre" => $_GET['nombre'],
            "precio" => $_GET['precio'],
            "id_fabricante" => $_GET['id_fabricante'],
            "id" => $_GET['id']
        ]);

        echo json_encode([
            "mensaje" => "Producto actualizado correctamente"
        ]);
        break;

    case 'DELETE':
        checkToken();

        if (!isset($_GET['id'])) {
            echo json_encode(["error" => "ID no proporcionado"]);
            exit;
        }

        $stmt = $pdo->prepare(
            "DELETE FROM producto WHERE id = :id"
        );
        $stmt->execute(["id" => $_GET['id']]);

        echo json_encode([
            "mensaje" => "Producto eliminado correctamente"
        ]);
        break;

    default:
        echo json_encode([
            "error" => "Método no permitido"
        ]);
}
