<?php
require_once __DIR__.("/config/database.php");

$db = new Database();
$conn = $db->connect();

// Verificar si ya existen asientos
$result = $conn->query("SELECT COUNT(*) as total FROM asientos");
$row = $result->fetch_assoc();

if ($row["total"] > 0) {
    echo "Los asientos ya fueron generados";
    exit;
}
// Cantidad de filas de A a J
$filas = range('A', 'J');

// Asientos iniciales
$asientos = 12;

foreach($filas as $fila){

    for($i = 1; $i <= $asientos; $i++){

    $conn -> query("
    INSERT INTO asientos(fila, numero)
    VALUES ('$fila', '$i')
    ");
    }

    // Incrementar 2 asientos for fila
    $asientos += 2;
}
echo "Asientos generados correctamente";

?>