<?php
// ima interakciju sa modelom
// HEADERS
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Valuta.php';

$database = new Database();
$db = $database->connect();

$valuta = new Valuta($db);

$result = $valuta->read();
//Get row count
$num = $result->rowCount();

if($num>0) {
    $valute_arr = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $valute_item = array(
            'id_valute' => $id_valute,
            'id_drzave' => $id_drzave,
            'naziv_valute' => $naziv_valute,
            'kod' => $kod,
            'broj' => $broj
        );

        array_push($valute_arr, $valute_item);
    }


    function encodeHtml($responseData)
    {

      $htmlResponse = "<table border='1'>";
      $i = 0;
      foreach ($responseData as $key => $value[$i]) {
        $htmlResponse .= "<tr><td>" . $key . "</td><td>" . $value[$i]["naziv_valute"] . "</td></tr>";
        $i++;
      }
      $htmlResponse .= "</table>";
      return $htmlResponse;
    }

    function encodeJson($responseData)
    {
      $jsonResponse = json_encode($responseData);
      return $jsonResponse;
    }

    function encodeXml($responseData)
    {
      // creating object of SimpleXMLElement
      $xml = new SimpleXMLElement('<?xml version="1.0"?><valute_arr></valute_arr>');
      $i = 0;
      foreach ($responseData as $key => $value[$i]) {
        $pom2 = strval($value[$i]["naziv_valute"]);
        $pom = strval($value[$i]["kod"]);
        $xml->addChild($key, $pom);
        $xml->addChild($key, $pom2);
        $i++;
      }
      return $xml->asXML();
    }

    $rawData = $valute_arr;
    $requestContentType = $_SERVER['HTTP_ACCEPT'];
    //setHttpHeaders($requestContentType, $statusCode);

    if (strpos($requestContentType, 'application/json') !== false) {
      $response = encodeJson($rawData);
      echo $response;
    } else if (strpos($requestContentType, 'text/html') !== false) {
      $response = encodeHtml($rawData);
      echo $response;

    } else if (strpos($requestContentType, 'application/xml') !== false) {
      $response = encodeXml($rawData);
      echo $response;
    }
    // echo json_encode($valute_arr);

} else {
    // No Posts
    echo json_encode(array('message' => 'Nema sadrzaja'));
  }
