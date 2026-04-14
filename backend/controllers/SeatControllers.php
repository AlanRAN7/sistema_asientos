<?php
require_once  __DIR__ . "/../models/Seat.php";

class SeatController {
    private $seat;

    public function __construct($db){
        $this -> seat = new Seat($db);
    }

    // GET
    public function getSeats(){
        $result = $this->seat->getAll();
        
        $data = [];

        while($row = $result -> fetch_assoc()){
            $data[] = $row;
        }

        echo json_encode($data);
        }

        // POST
        public function toggleSeat($data){
            if(!isset($data['id'])){
                echo json_decode(["error" => "ID requerido"]);
                return;
            }

            $response = $this ->seat->toggle($data["id"]);

            echo json_encode($response);
        }
}
?>