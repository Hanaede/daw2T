<?php
namespace App\Models;
require_once('DBAbstractModel.php');
use App\Models\Habilidades;


class Publicaciones extends DBAbstractModel
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

    //Atributos
    private $id;
    private $usuario_id;
    private $titulo;
    private $contenido;
    private $imagen;
    private $created_at;
    private $updated_at;

    //Setters
    public function setId($id)
    {
        $this->id = $id;
    }
    public function setUsuarioId($usuario_id)
    {
        $this->usuario_id = $usuario_id;
    }
    public function setTitulo($titulo)
    {
        $this->titulo = $titulo;
    }
    public function setContenido($contenido)
    {
        $this->contenido = $contenido;
    }
    public function setImagen($imagen)
    {
        $this->imagen = $imagen;
    }
    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;
    }
    public function setUpdatedAt($updated_at)
    {
        $this->updated_at = $updated_at;
    }

    //getters
    public function getId()
    {
        return $this->id;
    }
    public function getUsuarioId()
    {
        return $this->usuario_id;
    }
    public function getTitulo()
    {
        return $this->titulo;
    }
    public function getContenido()
    {
        return $this->contenido;
    }
    public function getImagen()
    {
        return $this->imagen;
    }
    public function getCreatedAt()
    {
        return $this->created_at;
    }
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    //Métodos
    public function set() {}
    public function get() {}
    public function edit() {}
    public function delete() {}

    public function getPublicaciones($usuario_id)
    {
        $this->query = "SELECT * FROM publicaciones WHERE usuario_id = :usuario_id";
        $this->parametros['usuario_id'] = $usuario_id;
        $this->get_results_from_query();
        return $this->rows;
    }

}