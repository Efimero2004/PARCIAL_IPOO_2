<?php
include_once "Plan.php";
include_once "Canal.php";
include_once "Cliente.php";
include_once "Contrato.php";
class EmpresaCable {
private $ColPlanes;
private $ColCanales;
private $ColClientes;
private $ColContratos;

public function __construct($ColPlanes,$ColCanales,$ColClientes,$ColContratos)
{
    $this->ColPlanes =$ColPlanes ;
    $this->ColCanales =$ColCanales ;
    $this->ColClientes =$ColClientes ;
    $this->ColContratos =$ColContratos ;
}
public function getColPlanes() {
        return $this->ColPlanes;
    }

    public function getColCanales() {
        return $this->ColCanales;
    }

    public function getColClientes() {
        return $this->ColClientes;
    }

    public function getColContratos() {
        return $this->ColContratos;
    }

    public function setColPlanes($ColPlanes) {
        $this->ColPlanes = $ColPlanes;
    }

    public function setColCanales($ColCanales) {
        $this->ColCanales = $ColCanales;
    }

    public function setColClientes($ColClientes) {
        $this->ColClientes = $ColClientes;
    }

    public function setColContratos($ColContratos) {
        $this->ColContratos = $ColContratos;
    }

    public function BuscarContrato($tipoDocumento,$nroDocumento){
        $ContratoEncontrado=null;
        $colContratos=$this->getColContratos();
        foreach ($colContratos as $Contrato ) {
            $cliente=$Contrato->getObjCliente();
            if ($cliente->getTipoDoc()==$tipoDocumento && $cliente->getNroDoc()==$nroDocumento) {
                $ContratoEncontrado=$Contrato;
            }
            return $ContratoEncontrado;
        }
    }

    public function IncorporarContrato($ObjPlan,$ObjCliente,$fechaInicio,$fechaVencimiento,$es_web){
        $colContratos=$this->getColContratos();
        $tipoDocCliente=$ObjCliente->getTipoDoc();
        $nroDocCliente=$ObjCliente->getNroDoc();
        $Contrato=$this->BuscarContrato($tipoDocCliente,$nroDocCliente);
        if ($es_web) {
          // incorpora contrato en la clase contrato web con su funcion redefinida
        }else{
          //  incorpora contrato en la clase Contrato 
        }
}
}