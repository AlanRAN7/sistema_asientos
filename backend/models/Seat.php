<?php
class Seat
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Atrae a todos los elementos
    public function getAll()
    {
        // Liberar asientos ocupados
        $this->conn->query("
        UPDATE asientos
        SET estado = 'disponible',
            reservado_at = NULL
        WHERE estado = 'ocupado'
        AND TIMESTAMPDIFF(SECOND, reservado_at, NOW()) >= 300
    ");
        $result = $this->conn->query("SELECT *,
        TIMESTAMPDIFF(SECOND, reservado_at, NOW()) as tiempo_ocupado FROM asientos ORDER BY fila, numero");

        return $result;
    }


    // Cambiar el estado del asiento
    public function toggle($id)
    {

        $res = $this->conn->query("SELECT estado FROM asientos WHERE id = $id");
        $seat = $res->fetch_assoc();

        // Validación de existencia
        if (!$seat) {
            return ["error" => "Asiento no existe"];
        }

        // Si está ocupado se va a liberar
        if ($seat['estado'] === 'ocupado') {
            $this->conn->query("
            UPDATE asientos
            SET estado = 'disponible',
            reservado_at = NULL
            WHERE id = $id
           ");
        } else {
            // Validar disponibilidad por si acaso alguien más ya lo tomó
            $check = $this->conn->query(
                "SELECT id
                FROM asientos
                WHERE id = $id AND estado = 'disponible'
                "
            );

            if ($check->num_rows > 0) {
                // Marcar como ocupado y guardar la hora actual
                $this->conn->query(
                    "UPDATE asientos
                SET estado = 'ocupado',
                reservado_at = NOW()
                WHERE id = $id"
                );
            } else {
                return ["error" => "Asiento ya Ocupado"];
            }
        }
        return ["success" => true];
    }
}
?>