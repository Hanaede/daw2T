<?php
namespace App\Models;
require_once('DBAbstractModel.php');

use App\Models\Publicaciones;

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

    //Atributos
    private $id;
    private $nombre;
    private $apellidos;
    private $email;
    private $password;
    private $foto;
    private $visible;
    private $created_at;
    private $updated_at;

    //Setters
    public function setId($id)
    {
        $this->id = $id;
    }
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }
    public function setApellidos($apellidos)
    {
        $this->apellidos = $apellidos;
    }
    public function setEmail($email)
    {
        $this->email = $email;
    }
    public function setPassword($password)
    {
        $this->password = $password;
    }
    public function setFoto($foto)
    {
        $this->foto = $foto;
    }
    public function setVisible($visible)
    {
        $this->visible = $visible;
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
    public function getNombre()
    {
        return $this->nombre;
    }
    public function getApellidos()
    {
        return $this->apellidos;
    }
    public function getEmail()
    {
        return $this->email;
    }
    public function getPassword()
    {
        return $this->password;
    }
    public function getFoto()
    {
        return $this->foto;
    }
    public function getVisible()
    {
        return $this->visible;
    }
    public function getCreatedAt()
    {
        return $this->created_at;
    }
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    public function addPublicaciones($publicaciones)
    {
        $this->publicaciones[] = $publicaciones;
    }


    //Método set
    public function set() {
        $fecha = new \DateTime();
        $this->query = "INSERT INTO usuarios(nombre, apellidos, email, password, foto, visible, created_at)
                        VALUES (:nombre, :apellidos, :email, :password, :foto, :visible, :created_at)";
        $this->parametros['nombre'] = $this->nombre;
        $this->parametros['apellidos'] = $this->apellidos;
        $this->parametros['email'] = $this->email;
        $this->parametros['password'] = $this->password;
        $this->parametros['foto'] = $this->foto;
        $this->parametros['visible'] = $this->visible;
        $this->parametros['created_at'] = $fecha->format('Y-m-d H:i:s');

        try {
            $this->get_results_from_query();

            $idUsuario = $this->lastInsert();
            
            foreach ($this->publicaciones as $publicacion) {
                $this->query = "INSERT INTO publicaciones (usuario_id, titulo, contenido, imagen, created_at)
                                VALUES (:usuario_id, :titulo, :contenido, :imagen, :created_at)";
                $this->parametros['usuario_id'] = $idUsuario;
                $this->parametros['titulo'] = $publicacion->getTitulo();
                $this->parametros['contenido'] = $publicacion->getContenido();
                $this->parametros['imagen'] = $publicacion->getImagen();
                $this->parametros['created_at'] = $fecha->format('Y-m-d H:i:s');
                $this->get_results_from_query();
            }
            $this->mensaje = 'Usuario y publicaciones añadidos exitosamente';

        } catch (Exception $e) {
            $this->mensaje = 'Error: ' . $e->getMessage();
        }
    }
    public function get($id = ""){
        $this->query = "SELECT * FROM usuarios WHERE id = :id";
    
        // Asignar el valor del parámetro id
        $this->parametros['id'] = $id;
        
        // Ejecutar la consulta
        $this->get_results_from_query();
        
        // Verificar si se ha encontrado un usuario
        if (count($this->rows) == 1) {
            // Establecer el mensaje de éxito
            $this->mensaje = 'Usuario encontrado';
        } else {
            // Si no se encuentra un usuario, establecer el mensaje de error
            $this->mensaje = 'Usuario no encontrado';
        }
        
        // Asignar el primer resultado de la consulta a la variable $usuario, o null si no se encuentra
        $usuario = $this->rows[0] ?? null;

        // Obtener las publicaiones del usuario
        //$publicaciones = Publicaciones::getInstancia()->getPublicaciones($id);

        return $usuario ?? null;

    }

    public function edit($id = ""){
        $fecha = new \DateTime();
        $this->query = "UPDATE usuarios SET nombre = :nombre, apellidos = :apellidos, email = :email, password = :password, foto = :foto, visible = :visible, updated_at = :updated_at WHERE id = :id";

        $this->parametros['nombre'] = $this->nombre;
        $this->parametros['apellidos'] = $this->apellidos;
        $this->parametros['email'] = $this->email;
        $this->parametros['password'] = $this->password;
        $this->parametros['foto'] = $this->foto;
        $this->parametros['visible'] = $this->visible;
        $this->parametros['updated_at'] = $fecha->format('Y-m-d H:i:s');
        $this->parametros['id'] = $id;
        $this->get_results_from_query();
        $this->mensaje = 'Usuario modificado';
    }
    
    public function delete($id = ""){
        $this->query = "DELETE FROM usuarios WHERE id = :id";
        $this->parametros['id'] = $id;
        $this->get_results_from_query();
        $this->mensaje = 'Usuario eliminado';        
    }

    
    // Método para obtener personajes visibles
    public function getVisibleUsuarios()
    {
        $this->query = "SELECT * FROM usuarios WHERE visible = 1";
        $this->get_results_from_query();
        return $this->rows;
    }


    //getbyEmail
    public function getByEmail($email)
    {
        $this->query = "SELECT * FROM usuarios WHERE email = :email";
        $this->parametros['email'] = $email;
        $this->get_results_from_query();
        return $this->rows[0] ?? null;
    }
    

}