<?php
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: POST');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

  include_once '../../config/Database.php';
  include_once '../../models/Valuta.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog post object
  $valuta = new Valuta($db);

  // Get raw posted data
  $data = json_decode(file_get_contents("php://input"));

  $valuta->naziv_valute = $data->naziv_valute;
  $valuta->kod = $data->kod;
  $valuta->broj = $data->broj;
  $valuta->id_drzave = $data->id_drzave;

  // Create post
  if($valuta->create()) {
    echo json_encode(
      array('message' => 'Valuta je kreirana')
    );
  } else {
    echo json_encode(
      array('message' => 'Valuta Nije Kreirana')
    );
  }
  ?>
