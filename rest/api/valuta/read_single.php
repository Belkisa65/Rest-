<?php

  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/Database.php';
  include_once '../../models/Valuta.php';
  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();
  // Instantiate blog category object
  $valuta = new Valuta($db);

  // Get ID
  $valuta->id_valute = isset($_GET['id_valute']) ? $_GET['id_valute'] : die();

  // Get post
  $valuta->read_single();

  // Create array
  $valuta_arr = array(
    'id_valute' => $valuta->id_valute,
    'naziv_valute' => $valuta->naziv_valute,
    'kod' => $valuta->kod,
    'broj' => $valuta->broj
  );

  // Make JSON
  print_r(json_encode($valuta_arr));
