<?php
include_once "Plan.php";
include_once "Cliente.php";
class Contrato{
    private static $ultimoId = 0;
  public $id;
private $fechaInicio;
private $fechaVencimiento;
private $ObjPlan;
private $estado;
private $costo;
private $se_renueva;
private $ObjCliente;


public function __construct($plan,$ObjCliente,$fechaInicio,$fechaVencimiento,$se_renueva,$costo)
{
    $this->ObjPlan=$plan;
    $this->ObjCliente=$ObjCliente;
    $this->fechaInicio=$fechaInicio;
    $this->fechaVencimiento=$fechaVencimiento;
    $this->costo=$costo;
    $this->estado="al dia";
    $this->se_renueva=$se_renueva;
    self::$ultimoId++; 
    $this->id = self::$ultimoId;// ID para no confundir los contratos en el punto 14

}

 public function getFechaInicio() {
        return $this->fechaInicio;
    }

    public function getFechaVencimiento() {
        return $this->fechaVencimiento;
    }

    public function getObjPlan() {
        return $this->ObjPlan;
    }

    public function getEstado() {
        return $this->estado;
    }

    public function getCosto() {
        return $this->costo;
    }

    public function getSeRenueva() {
        return $this->se_renueva;
    }

    public function getObjCliente() {
        return $this->ObjCliente;
    }

    public function setFechaInicio($fechaInicio) {
        $this->fechaInicio = $fechaInicio;
    }

    public function setFechaVencimiento($fechaVencimiento) {
        $this->fechaVencimiento = $fechaVencimiento;
    }

    public function setObjPlan($ObjPlan) {
        $this->ObjPlan = $ObjPlan;
    }

    public function setEstado($estado) {
        $this->estado = $estado;
    }

    public function setCosto($costo) {
        $this->costo = $costo;
    }

    public function setSeRenueva($se_renueva) {
        $this->se_renueva = $se_renueva;
    }

    public function setObjCliente($ObjCliente) {
        $this->ObjCliente = $ObjCliente;
    }

public function actualizarEstadoContrato($objContrato){
    $diasVencido=$objContrato->diasContratoVencido($objContrato);
    if ($diasVencido==0){
        $objContrato->setEstado("al dia");
    }else{
       if ($diasVencido>10) {
        $objContrato->setEstado("suspendido");
       }else {
        $objContrato->setEstado("moroso");
       };
       
    };

}

public function diasContratoVencido($objContrato){
$esta_vencido=0;
$Finicio=$objContrato->getFechaInicio();
$Fvencimiento=$objContrato->getFechaVencimiento();
$diferenciaDias=$Finicio->diff($Fvencimiento);
if ((($diferenciaDias)->format('%a'))>30) {
    $esta_vencido=(($diferenciaDias)->format('%a')-30);
}
return $esta_vencido;
}

public function calcularImporte($objContrato){
    $this->actualizarEstadoContrato($objContrato);
    $costo=$objContrato->getCosto();
    $estado=$objContrato->getEstado();
    if ($estado=="al dia") {
        $objContrato->setSeRenueva(true);
        $importeFinal=$objContrato->getCosto();

    }elseif ($estado=="moroso") {
        $objContrato->setSeRenueva(true);
        $diasVencido=$objContrato->diasContratoVencido($objContrato);
        $importeFinal=(($costo*0.1)*$diasVencido)+$costo;
    }elseif ($estado=="suspendido") {
        $objContrato->setSeRenueva(false);
        $diasVencido=$objContrato->diasContratoVencido($objContrato);
        $importeFinal=(($costo*0.1)*$diasVencido)+$costo;
    }else{
        $importeFinal=$costo;
    }
return $importeFinal;
}

public function __toString()
{
    
}
}