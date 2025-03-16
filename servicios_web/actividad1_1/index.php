<?php
/*
1. Carga el valor del ISBN enviado por la URL
*/
$isbn = isset($_GET['isbn']) ? $_GET['isbn'] : '';

/*
2. Carga en una variable una cadena de caracteres con el fichero XML
que se debe enviar.
*/
$msgSoap = <<<EOD
<?xml version="1.0" encoding="utf-8"?>
<soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
  <soap:Body>
    <IsValidISBN13 xmlns="http://webservices.daehosting.com/ISBN">
      <sISBN>{$isbn}</sISBN>
    </IsValidISBN13>
  </soap:Body>
</soap:Envelope>
EOD;

/*
3. Inicia curl
*/
$curl = curl_init();

curl_setopt_array($curl, [
    CURLOPT_URL => 'http://webservices.daehosting.com/services/isbnservice.wso?WSDL',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS => $msgSoap,
    CURLOPT_HTTPHEADER => [
        'Content-Type: text/xml; charset=utf-8',
    ],
]);

/*
4. Ejecuta curl y procesa la respuesta
*/
$response = curl_exec($curl);
curl_close($curl);

// Analiza la respuesta para extraer el resultado
$matches = [];
preg_match('/<.*IsValidISBN13Result.*>(true|false)<\/.*IsValidISBN13Result.*>/', $response, $matches);

if (!empty($matches)) {
    $isValid = $matches[1] === 'true' ? 'es válido' : 'no es válido';
    echo "El ISBN-13 '{$isbn}' {$isValid}.".PHP_EOL;
} else {
    echo "No se pudo determinar si el ISBN-13 '{$isbn}' es válido.".PHP_EOL;
}
