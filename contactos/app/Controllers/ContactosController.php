<?php

namespace App\Controllers;

use App\Models\Contactos;

class ContactosController
{

    private $requestMethod;
    private $contactos;
    private $contactosId;

    public function __construct($requestMethod, $contactosId)
    {
        $this->requestMethod = $requestMethod;
        $this->contactosId = $contactosId;
        $this->contactos = Contactos::getInstancia();
    }


    public function processRequest(){

        switch($this->requestMethod){
            case 'GET':
                if($this->contactosId){
                    $response = $this->getContactos($this->contactosId);
                } else {
                    $response = $this->Todos();
                }
                // $response = $this->getContactos($this->contactosId);
                break;

            case 'POST':
                // $input = (array) json_decode(file_get_contents('php://input'), TRUE);
                $response = $this->createContactos();
                break;

            case 'PUT':
                // $input = (array) json_decode(file_get_contents('php://input'), TRUE);
                $response = $this->updateContactos($this->contactosId);
                break;

            case 'DELETE':
                $response = $this->deleteContactos($this->contactosId);
                break;
                
            default:
                $response = $this->notFoundResponse();
                break;
        }

        header($response['status_code_header']);
        if ($response['body']) {
            echo $response['body'];
        }
    }
    
    private function Todos(){
        $result = $this->contactos->getAll();
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($result);
        return $response;
    }
    
    private function getContactos($id){
        $result = $this->contactos->get($id);
        if(!$result){
            return $this->notFoundResponse();
        }

        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($result);
        return $response;
    }

    private function createContactos()
    {
        $input = (array) json_decode(file_get_contents('php://input'), TRUE);
        if (!$this->validateContactos($input)) {
            return $this->notFoundResponse();
        }

        var_dump($input);

        $this->contactos->set($input);
        $response['status_code_header'] = 'HTTP/1.1 201 Created';
        $response['body'] = json_encode(['message' => 'Contacto creado con éxito'], JSON_UNESCAPED_UNICODE);
        return $response;
    }

    private function updateContactos($id)
    {
        $result = $this->contactos->get($id);
        if (!$result) {
            return $this->notFoundResponse();
        }
        $input = (array) json_decode(file_get_contents('php://input'), TRUE);
        if (!$this->validateContactos($input)) {
            return $this->notFoundResponse();
        }

        $result = $this->contactos->edit($id, $input);
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode(['message' => 'Contacto actualizado con éxito'], JSON_UNESCAPED_UNICODE);
        return $response;
    }

    private function deleteContactos($id){
        $result = $this->contactos->get($id);
        if (!$result) {
            return $this->notFoundResponse();
        }

        $this->contactos->delete($id);
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode(['message' => 'Contacto borrado con éxito'], JSON_UNESCAPED_UNICODE);
        return $response;
    }

    private function validateContactos($input){
        if (!isset($input['nombre']) || !isset($input['telefono']) || !isset($input['email'])) {
            return false;
        }
        return true;
    }

    private function notFoundResponse()
    {
        $response['status_code_header'] = 'HTTP/1.1 404 Not Found';
        $response['body'] = json_encode(['message' => 'Recurso no encontrado']);
        return $response;
}


}
?>