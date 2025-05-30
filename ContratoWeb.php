<?php
include_once "Contrato.php";
class ContratoWeb extends Contrato{

private $porcentajeDescuento;

public function __construct($plan,$ObjCliente,$fechaInicio,$fechaVencimiento,$se_renueva,$costo)
{
    parent::__construct($plan,$ObjCliente,$fechaInicio,$fechaVencimiento,$se_renueva,$costo);
    $this->porcentajeDescuento=0.1;
}
public function getPorcentajeDescuento(){
    return $this->porcentajeDescuento;
}
public function setPorcentajeDescuento($porDesc){
    $this->porcentajeDescuento=$porDesc;
}

public function calcularImporte($objContratoWeb){
    $objContrato=$objContratoWeb;
    $this->actualizarEstadoContrato($objContrato);
    
    $costo=$objContrato->getCosto();
    $descuento=$costo*$objContrato->getPorcentajeDescuento();
    $estado=$objContrato->getEstado();
    if ($estado=="al dia") {
        $objContrato->setSeRenueva(true);
        $importeFinal=$costo-$descuento;

    }elseif ($estado=="moroso") {
        $objContrato->setSeRenueva(true);
        $diasVencido=$objContrato->diasContratoVencido($objContrato);
        $importeFinal=(($costo*0.1)*$diasVencido)+$costo-$descuento;
    }elseif ($estado=="suspendido") {
        $objContrato->setSeRenueva(false);
        $diasVencido=$objContrato->diasContratoVencido($objContrato);
        $importeFinal=(($costo*0.1)*$diasVencido)+$costo-$descuento;
    }else{
        $importeFinal=$costo;
    }
return $importeFinal;
}

public function __toString()
{
    $cadena= parent::__toString();
    $cadena.= "\n"."Descuento:".$this->getPorcentajeDescuento();
    return $cadena;
}

}