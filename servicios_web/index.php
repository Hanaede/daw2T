<?php
/*
1. Carga en dos variables los valores enviados por la URL
*/ 

//$n1 =1;
//$n2 =2;
$n1 =isset($_GET['x']) ? (int)$_GET['x'] : 0;
$n2 =isset($_GET['y']) ? (int)$_GET['y'] : 0;
/*
2. Carga en una variable una cadena de caracteres con el fichero XML
que se debe enviar.
http://www.dneonline.com/calculator.asmx?op=Add
Utiliza sintaxis heredoc para facilitar la escritura.
Construimos mensaje soap
*/
$msgSoap = <<<EOD
<?xml version="1.0" encoding="utf-8"?>
<soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
  <soap:Body>
    <Add xmlns="http://tempuri.org/">
      <intA>{$n1}</intA>
      <intB>{$n2}</intB>
    </Add>
  </soap:Body>
</soap:Envelope>
EOD;


/*
3. Inicia curl
*/
$curl = curl_init();

curl_setopt_array($curl, [
    CURLOPT_URL => 'http://www.dneonline.com/calculator.asmx?WSDL',
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

/*4
Crea un array de configuración para curl:
url del servicio, http://www.dneonline.com/calculator.asmx?WSDL'
RETURNTRANSFER, true.
HTTP_VERSION, 1.1
CUSTOMREQUEST, POST
POSTFIELDS, Variable con fichero xml.
HTTPHEADER, text/xml y juego de caracteres 7tf-8
*/
$response = curl_exec($curl);
curl_close($curl);
// echo $response;

$matches = [];
preg_match('/<AddResult>(\d+)<\/AddResult>/', $response, $matches);
echo $n1 . ' + ' . $n2 . ' = ' . $matches[0].PHP_EOL;

