<?php
namespace App\Models;
require_once('DBAbstractModel.php');


class Multas extends DBAbstractModel
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
    private $id_agente;
    private $id_conductor;
    private $matricula;
    private $id_tipo_sanciones;
    private $descripcion;
    private $fecha;
    private $importe;
    private $descuento;
    private $estado;

    //setters
    public function setId($id)
    {
        $this->id = $id;
    }
    public function setIdAgente($id_agente)
    {
        $this->id_agente = $id_agente;
    }
    public function setIdConductor($id_conductor)
    {
        $this->id_conductor = $id_conductor;
    }
    public function setMatricula($matricula)
    {
        $this->matricula = $matricula;
    }
    public function setIdTipoSanciones($id_tipo_sanciones)
    {
        $this->id_tipo_sanciones = $id_tipo_sanciones;
    }
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
    }
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;
    }
    public function setImporte($importe)
    {
        $this->importe = $importe;
    }
    public function setDescuento($descuento)
    {
        $this->descuento = $descuento;
    }
    public function setEstado($estado)
    {
        $this->estado = $estado;
    }

    //getters
    public function getId()
    {
        return $this->id;
    }
    public function getIdAgente()
    {
        return $this->id_agente;
    }
    public function getIdConductor()
    {
        return $this->id_conductor;
    }
    public function getMatricula()
    {
        return $this->matricula;
    }
    public function getIdTipoSanciones()
    {
        return $this->id_tipo_sanciones;
    }
    public function getDescripcion()
    {
        return $this->descripcion;
    }
    public function getFecha()
    {
        return $this->fecha;
    }
    public function getImporte()
    {
        return $this->importe;
    }
    public function getDescuento()
    {
        return $this->descuento;
    }
    public function getEstado()
    {
        return $this->estado;
    }



    public function set() {
        $this->query = "INSERT INTO multas (id_agente, id_conductor, matricula, id_tipo_sanciones, descripcion, fecha, importe, descuento, estado) VALUES (:id_agente, :id_conductor, :matricula, :id_tipo_sanciones, :descripcion, :fecha, :importe, :descuento, :estado)";
        $this->parametros['id_agente'] = $this->id_agente;
        $this->parametros['id_conductor'] = $this->id_conductor;
        $this->parametros['matricula'] = $this->matricula;
        $this->parametros['id_tipo_sanciones'] = $this->id_tipo_sanciones;
        $this->parametros['descripcion'] = $this->descripcion;
        $this->parametros['fecha'] = $this->fecha;
        $this->parametros['importe'] = $this->importe;
        $this->parametros['descuento'] = $this->descuento;
        $this->parametros['estado'] = $this->estado;
        $this->get_results_from_query();
        $this->mensaje = 'Multa agregada';
    }

    public function get($id = "") {
        $this->query = "SELECT * FROM multas WHERE id = :id";
        $this->parametros['id'] = $id;
        $this->get_results_from_query();

        return $this->rows;
    }

    public function edit() {
        $this->query = "UPDATE multas SET id_agente = :id_agente, id_conductor = :id_conductor, matricula = :matricula, id_tipo_sanciones = :id_tipo_sanciones, descripcion = :descripcion, fecha = :fecha, importe = :importe, descuento = :descuento, estado = :estado WHERE id = :id";
        $this->parametros['id'] = $this->id;
        $this->parametros['id_agente'] = $this->id_agente;
        $this->parametros['id_conductor'] = $this->id_conductor;
        $this->parametros['matricula'] = $this->matricula;
        $this->parametros['id_tipo_sanciones'] = $this->id_tipo_sanciones;
        $this->parametros['descripcion'] = $this->descripcion;
        $this->parametros['fecha'] = $this->fecha;
        $this->parametros['importe'] = $this->importe;
        $this->parametros['descuento'] = $this->descuento;
        $this->parametros['estado'] = $this->estado;
        $this->get_results_from_query();
        $this->mensaje = 'Multa modificada';
    }

    public function delete(){
        $this->query = "DELETE FROM multas WHERE id = :id";
        $this->parametros['id'] = $this->id;
        $this->get_results_from_query();
        $this->mensaje = 'Multa eliminada';
    }


    public function getByUsuario($id_conductor=''){
        $this->query = "SELECT * FROM multas WHERE id_conductor = :id_conductor";
        $this->parametros['id_conductor'] = $id_conductor;
        $this->get_results_from_query();
        return $this->rows;
    }

    public function getByAgente($id_agente=''){
        $this->query = "SELECT * FROM multas WHERE id_agente = :id_agente";
        $this->parametros['id_agente'] = $id_agente;
        $this->get_results_from_query();
        return $this->rows;
    }

    // Funcion para pagar las multas
    public function pagarMulta($id, $estado){
        $this->query = "UPDATE multas SET estado = :estado WHERE id = :id";
        $this->parametros['id'] = $id;
        $this->parametros['estado'] = $estado;
        $this->get_results_from_query();
    }

    public function getTotalMultas() {
        $this->query = "SELECT COUNT(*) as total FROM multas";
        $this->get_results_from_query();
        return $this->rows[0]['total'];
    }
    
    
}