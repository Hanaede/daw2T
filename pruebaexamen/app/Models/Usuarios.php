<?php
namespace App\Models;
require_once('DBAbstractModel.php');

use App\Models\Notas;

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

    // Atributos de la clase
    private $id;
    private $nombre;
    private $apellidos;
    private $email;
    private $password;
    private $resumen_perfil;
    private $foto;
    private $visible;

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
    public function setResumenPerfil($resumen_perfil)
    {
        $this->resumen_perfil = $resumen_perfil;
    }
    public function setFoto($foto)
    {
        $this->foto = $foto;
    }
    public function setVisible($visible)
    {
        $this->visible = $visible;
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
    public function getResumenPerfil()
    {
        return $this->resumen_perfil;
    }
    public function getFoto()
    {
        return $this->foto;
    }
    public function getVisible()
    {
        return $this->visible;
    }

    public function addNotas($nota) {
        $this->notas[] = $nota;
    }
    

    //SET
    public function set() {
        $this->query = "INSERT INTO usuarios (nombre, apellidos, email, password, resumen_perfil, foto, visible) VALUES (:nombre, :apellidos, :email, :password, :resumen_perfil, :foto, :visible)";
        $this->parametros['nombre'] = $this->nombre;
        $this->parametros['apellidos'] = $this->apellidos;
        $this->parametros['email'] = $this->email;
        $this->parametros['password'] = $this->password;
        $this->parametros['resumen_perfil'] = $this->resumen_perfil;
        $this->parametros['foto'] = $this->foto;
        $this->parametros['visible'] = $this->visible;



        try {
            $this->get_results_from_query();
            
            $idNota = $this->lastInsert();
            foreach ($this->notas as $nota) {
                $this->query = "INSERT INTO notas (id_usuario, id_examen, nota, fecha_realizacion) VALUES (:id_usuario, :id_examen, :nota, :fecha_realizacion)";
                $this->parametros['id_usuario'] = $idNota;
                $this->parametros['nota'] = $nota->getNota();
                $this->parametros['fecha_realizacion'] = $nota->getFechaRealizacion();
                $this->parametros['id_examen'] = $nota->getIdExamen();
                $this->get_results_from_query();
            }
            $this->mensaje = 'Usuario agregado exitosamente';

        
        } catch (Exception $e) {
            $this->mensaje = 'Error al agregar el usuario';
        }
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
        $fecha = new \DateTime();
        
        $this->query = "UPDATE usuarios SET nombre = :nombre, apellidos = :apellidos, email = :email, resumen_perfil = :resumen_perfil, foto = :foto WHERE id = :id";
        $this->parametros['nombre'] = $this->nombre;
        $this->parametros['apellidos'] = $this->apellidos;
        $this->parametros['email'] = $this->email;
        $this->parametros['password'] = $this->password;
        $this->parametros['resumen_perfil'] = $this->resumen_perfil;
        $this->parametros['foto'] = $this->foto;
        $this->parametros['id'] = $this->id;
        $this->get_results_from_query();
        // var_dump($this->rows); die();
        $this->mensaje = 'Usuario modificado';
        
        return $this->rows;
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

    public function getNotas($id_usuario)
    {
        $this->query = "SELECT * FROM notas WHERE id_usuario = :id_usuario";
        $this->parametros['id_usuario'] = $id_usuario;
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