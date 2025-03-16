<?php
namespace App\Models;
use App\Models\DBAbstractModel;

class Usuarios extends DBAbstractModel
{
    private static $instancia;

    // Patrón singleton, no puedo tener dos objetos de la clase Usuarios
    public static function getInstancia()
    {
        if (!isset(self::$instancia)) {
            $miClase = __CLASS__;
            self::$instancia = new $miClase;
        }
        return self::$instancia;
    }

    // Método para evitar la clonación del objeto
    public function __clone()
    {
        trigger_error('La clonación de este objeto no está permitida', E_USER_ERROR);
    }

    //atributos de la clase
    private $id;
    private $usuario;
    private $password;
    private $nombre;
    private $perfil;

    //setters
    public function setId($id)
    {
        $this->id = $id;
    }

    public function setUsuario($usuario)
    {
        $this->usuario = $usuario;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    public function setPerfil($perfil)
    {
        $this->perfil = $perfil;
    }

    //Getters
    public function getId()
    {
        return $this->id;
    }

    public function getUsuario()
    {
        return $this->usuario;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function getPerfil()
    {
        return $this->perfil;
    }

    //Métodos CRUD
    public function set() {
        $this->query = "INSERT INTO usuarios(usuario, password, nombre, perfil) VALUES (:usuario, :password, :nombre, :perfil)";
        $this->parametros['usuario'] = $this->usuario;
        $this->parametros['password'] = $this->password;
        $this->parametros['nombre'] = $this->nombre;
        $this->parametros['perfil'] = $this->perfil;
        $this->get_results_from_query();
        $this->mensaje = 'Usuario agregado exitosamente';
    }

    public function get($id = "") {
        $this->query = "SELECT * FROM usuarios WHERE id = :id";
        $this->parametros['id'] = $id;
        $this->get_results_from_query();
        if (count($this->rows) == 1) {
            $this->mensaje = 'Usuario encontrado';
        } else {
            $this->mensaje = 'Usuario no encontrado';
        }
        return $this->rows;
    }

    public function edit() {
        $this->query = "UPDATE usuarios SET usuario = :usuario, password = :password, nombre = :nombre, perfil = :perfil WHERE id = :id";
        $this->parametros['id'] = $this->id;
        $this->parametros['usuario'] = $this->usuario;
        $this->parametros['password'] = $this->password;
        $this->parametros['nombre'] = $this->nombre;
        $this->parametros['perfil'] = $this->perfil;
        $this->get_results_from_query();
        $this->mensaje = 'Usuario modificado';
    }

    public function delete($id = "") {
        $this->query = "DELETE FROM usuarios WHERE id = :id";
        $this->parametros['id'] = $id;
        $this->get_results_from_query();
        $this->mensaje = 'Usuario eliminado';
    }

    public function getAll() {
        $this->query = "SELECT * FROM usuarios";
        $this->get_results_from_query();
        return $this->rows;
    }

    public function getByUsuario($usuario) {
        $this->query = "SELECT * FROM usuarios WHERE usuario = :usuario";
        $this->parametros['usuario'] = $usuario;
        $this->get_results_from_query();
        return $this->rows[0];
    }

    public function getConductores() {
        $this->query = "SELECT * FROM usuarios WHERE perfil = 'conductor'";
        $this->get_results_from_query();
        return $this->rows;
    }
}