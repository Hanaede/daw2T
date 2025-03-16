<?php
namespace App\Models;
require_once('DBAbstractModel.php');
use App\Models\Habilidades;


class Personajes extends DBAbstractModel
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

    // Atributos base de datos
    private $personaje_id;
    private $nombre;
    private $email;
    private $contrasena;
    private $token;
    private $foto;
    private $clase;
    private $raza;
    private $armas;
    private $created_at;
    private $updated_at;
    private $visible;
    private $cuenta_activa;
    private $fecha_creacion_token;


    //setters
    public function setPersonajeId($personaje_id){
        $this->personaje_id = $personaje_id;
    }
    public function setNombre($nombre){
        $this->nombre = $nombre;
    }
    public function setEmail($email){
        $this->email = $email;
    }
    public function setContrasena($contrasena){
        $this->contrasena = $contrasena;
    }
    public function setToken($token){
        $this->token = $token;
    }
    public function setFoto($foto){
        $this->foto = $foto;
    }
    public function setClase($clase){
        $this->clase = $clase;
    }
    public function setRaza($raza){
        $this->raza = $raza;
    }
    public function setArmas($armas){
        $this->armas = $armas;
    }
    public function setCreatedAt($created_at){
        $this->created_at = $created_at;
    }
    public function setUpdatedAt($updated_at){
        $this->updated_at = $updated_at;
    }
    public function setVisible($visible){
        $this->visible = $visible;
    }
    public function setCuentaActiva($cuenta_activa){
        $this->cuenta_activa = $cuenta_activa;
    }
    public function setFechaCreacionToken($fecha_creacion_token){
        $this->fecha_creacion_token = $fecha_creacion_token;
    }

    //Getters
    public function getPersonajeId(){
        return $this->personaje_id;
    }
    public function getNombre(){
        return $this->nombre;
    }
    public function getEmail(){
        return $this->email;
    }
    public function getContrasena(){
        return $this->contrasena;
    }
    public function getToken(){
        return $this->token;
    }
    public function getFoto(){
        return $this->foto;
    }
    public function getClase(){
        return $this->clase;
    }
    public function getRaza(){
        return $this->raza;
    }
    public function getArmas(){
        return $this->armas;
    }
    public function getCreatedAt(){
        return $this->created_at;
    }
    public function getUpdatedAt(){
        return $this->updated_at;
    }
    public function getVisible(){
        return $this->visible;
    }
    public function getCuentaActiva(){
        return $this->cuenta_activa;
    }
    public function getFechaCreacionToken(){
        return $this->fecha_creacion_token;
    }


    public function addHabilidad($habilidad) {
        $this->habilidades[] = $habilidad;
    }

    
    // Método para insertar datos en la tabla
    public function set() {
        $fecha = new \DateTime();
        $this->query = "INSERT INTO personajes (nombre, email, contrasena, token, foto, clase, raza, armas, created_at, updated_at, visible, cuenta_activa, fecha_creacion_token) VALUES (:nombre, :email, :contrasena, :token, :foto, :clase, :raza, :armas, :created_at, :updated_at, :visible, :cuenta_activa, :fecha_creacion_token)";
        
        // Asignar valores a los parámetros
        $this->parametros['nombre'] = $this->nombre;
        $this->parametros['email'] = $this->email;
        $this->parametros['contrasena'] = $this->contrasena;
        $this->parametros['token'] = $this->token;
        $this->parametros['foto'] = $this->foto;
        $this->parametros['clase'] = $this->clase;
        $this->parametros['raza'] = $this->raza;
        $this->parametros['armas'] = $this->armas;
        $this->parametros['created_at'] = date( 'Y-m-d H:i:s', $fecha->getTimestamp());
        $this->parametros['visible'] = 1;
        $this->parametros['cuenta_activa'] = 0;
        $this->parametros['fecha_creacion_token'] = date( 'Y-m-d H:i:s', $fecha->getTimestamp());

        try {
            $this->get_results_from_query();

            $idHabilidad = $this->lastInsert();

            foreach ($this->habilidades as $habilidad) {
                $this->query = "INSERT INTO habilidades (nombre_habilidad, descripcion, elemento, visible, personaje_id, created_at, updated_at, nivel_habilidad) VALUES (:nombre_habilidad, :descripcion, :elemento, :visible, :personaje_id, :created_at, :updated_at, :nivel_habilidad)";
                $this->parametros['nombre_habilidad'] = $habilidad->getNombreHabilidad();
                $this->parametros['descripcion'] = $habilidad->getDescripcion();
                $this->parametros['elemento'] = $habilidad->getElemento();
                $this->parametros['visible'] = $habilidad->getVisible();
                $this->parametros['personaje_id'] = $idHabilidad;
                $this->parametros['created_at'] = date( 'Y-m-d H:i:s', $fecha->getTimestamp());
                $this->parametros['updated_at'] = date( 'Y-m-d H:i:s', $fecha->getTimestamp());
                $this->parametros['nivel_habilidad'] = $habilidad->getNivelHabilidad();
                $this->get_results_from_query();
            }
            $this->mensaje = 'Habilidad agregado exitosamente';


        } catch (Exception $e) {
            $this->mensaje = 'Error: ". $e->getMessage()';
        }

    }

        // Método get para obtener un usuario por id
    // Método para obtener un personaje por ID
    public function get($id=''){
        $this->query = "SELECT * FROM personajes WHERE personaje_id = :personaje_id";
        $this->parametros['personaje_id'] = $id;
        $this->get_results_from_query();
        if (count($this->rows) == 1) {
            $this->mensaje = 'Personaje encontrado';
            return $this->rows[0];
        } else {
            $this->mensaje = 'Personaje no encontrado';
            return null;
        }
    }

    // Método para editar usuarios
    public function edit($id = ''){
        $fecha = new \DateTime();
        $this->query = "UPDATE personajes SET nombre = :nombre, email = :email, contrasena = :contrasena, token = :token, foto = :foto, clase = :clase, raza = :raza, armas = :armas, updated_at = :updated_at WHERE personaje_id = :personaje_id";
        $this->parametros['nombre'] = $this->nombre;
        $this->parametros['email'] = $this->email;
        $this->parametros['contrasena'] = $this->contrasena;
        $this->parametros['token'] = $this->token;
        $this->parametros['foto'] = $this->foto;
        $this->parametros['clase'] = $this->clase;
        $this->parametros['raza'] = $this->raza;
        $this->parametros['armas'] = $this->armas;
        $this->parametros['updated_at'] = date( 'Y-m-d H:i:s', $fecha->getTimestamp());
        $this->parametros['personaje_id'] = $personaje_id;
        $this->get_results_from_query();
        $this->mensaje = 'Personaje modificado';
    }

    // Método para eliminar personaje
    public function delete($id = ''){
        $this->query = "DELETE FROM personajes WHERE personaje_id = :personaje_id";
        $this->parametros['personaje_id'] = $id;
        $this->get_results_from_query();
        $this->mensaje = 'Personaje eliminado';
    }

    // Método para obtener todos los personajes
    public function getAll(){
        $this->query = "SELECT * FROM personajes";
        $this->get_results_from_query();
        // Recorro usuarios y guardo datos según id
        foreach ($this->rows as $personaje) {
            $personaje[] = $personaje;
            $personaje['habilidades'] = Habilidades::getInstancia()->get($personaje['personaje_id']);

        }
        return $this->rows;
    }

    // Método para obtener personajes visibles
    public function getVisiblePersonajes() {
        $this->query = "SELECT * FROM personajes WHERE visible = 1";
        $this->get_results_from_query();
        return $this->rows;
    }

    // Método para obtener un personaje por email
    public function getByEmail($email) {
        $this->query = "SELECT * FROM personajes WHERE email = :email";
        $this->parametros['email'] = $email;
        $this->get_results_from_query();
        return $this->rows[0] ?? null;
    }

    // Método para obtener personaje por nombre
    public function getByName($nombre) {
        $this->query = "SELECT * FROM personajes WHERE nombre = :nombre AND visible = 1"; // Obtener por nombre y que sea visible
        $this->parametros['nombre'] = $nombre;
        $this->get_results_from_query();
        return $this->rows; // Devuelve un array de usuarios
    }

    // Método para cambiar la visibilidad del perfil
    public function cambiarVisibilidad($id) {
        $this->query = "UPDATE personajes SET visible = NOT visible WHERE personaje_id = :personaje_id";
        $this->parametros['personaje_id'] = $id;
        $this->get_results_from_query();
        $this->mensaje = 'Visibilidad del perfil cambiada';
    }

    // Método para obtener el mensaje de la instancia
    public function getMensaje(){
        return $this->mensaje;
    }

    // Función para comprobar si la cuenta del personaje está activa
    public function estaActivo($email){
        $this->query = "SELECT cuenta_activa FROM personajes WHERE email = :email";
        $this->parametros['email'] = $email;
        $this->get_results_from_query();
        if ($this->rows[0]['cuenta_activa'] == 1) {
            return true;
        } else {
            return false;
        }
    }

    // Método para verificar el token de un personaje
    public function verificarToken($token = ''){
        $this->query = "SELECT * FROM personajes WHERE token = :token";
        $this->parametros['token'] = $token;
        $this->get_results_from_query();
        if(count($this->rows) == 1){
            // Comprobar si el token ha caducado
            $this->fecha_creacion_token = $this->rows[0]['fecha_creacion_token'];
            $fecha_actual = date('Y-m-d H:i:s');
            $diferencia = strtotime($fecha_actual) - strtotime($this->fecha_creacion_token);
            if ($diferencia < 86400) {
                $this->query = "UPDATE personajes SET token = NULL, fecha_creacion_token = NULL, visible = 1 , cuenta_activa = 1 WHERE token = :token";
                $this->parametros['token'] = $token;
                $this->get_results_from_query();
                $this->mensaje = 'Usuario verificado';
            } else {
                $this->mensaje = 'El token ha caducado';
            }
        } else {
            $this->mensaje = 'Token no encontrado';
        }
    }

        // Método para obtener las habilidades de un personaje
    public function getHabilidades($personaje_id)
    {
        $this->query = "SELECT * FROM habilidades WHERE personaje_id = :personaje_id";
        $this->parametros['personaje_id'] = $personaje_id;
        $this->get_results_from_query();
        return $this->rows;
    }


}   