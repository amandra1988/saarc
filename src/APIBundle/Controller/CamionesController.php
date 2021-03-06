<?php

namespace APIBundle\Controller;

use AppBundle\Entity\Camion;
//use AppBundle\Entity\Operador;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class CamionesController extends APIBaseController
{
    /**
    * Obtener lista de camiones de una empresa
    * @return Response La respuesta serializada
    */ 
    public function getEmpresasCamionesAction(Request $request,$idEmpresa){
        $groups = ['camion_detalle'];
        if(is_array($request->get('expand'))){
            $groups = array_merge($groups, $request->get('expand'));
        }
        $camiones = $this->getDoctrine()->getRepository('AppBundle:Camion')->buscarCamionesDeLaEmpresa($idEmpresa);
        return $this->serializedResponse($camiones, $groups); 
    }
    
    /**
    * Obtener lista de camiones de una empresa
    * @return Response La respuesta serializada
    */ 
    public function postEmpresasCamionesAction(Request $request,$idEmpresa){
        $groups ='';
        $camion = new Camion();
        $camion->setCamPatente($request->get('patente'));
        $camion->setCamEstado(1);
        $camion->setCamTipoCarga($request->get('tipo_carga'));
        $camion->setCamVisible(true);
        $camion->setCamCapacidad($request->get('capacidad'));
        $em = $this->getDoctrine()->getManager();
        $em->persist($camion);
        $em->flush();
                
        $operador =  $this->getDoctrine()->getRepository('AppBundle:Operador')->find($request->get('operador'));
        $operador->setCamion($camion);   
        $em = $this->getDoctrine()->getManager();
        $em->persist($operador);
        $em->flush();
        return $this->serializedResponse($camion, $groups);
    }
    
    public function patchEmpresasCamionesAction(Request $request,$idEmpresa, Camion $camion){
        $groups ='';
        $camion->setCamPatente($request->get('patente'));
        $camion->setCamCapacidad($request->get('capacidad'));
        $camion->setCamEstado($request->get('estado'));
        $camion->setCamTipoCarga($request->get('tipo_carga'));
        $camion->setCamVisible($request->get('visible'));
        
        $em = $this->getDoctrine()->getManager();
        $em->persist($camion);
        $em->flush();
        
        if($request->get('operador')){
            $operador =  $this->getDoctrine()->getRepository('AppBundle:Operador')->find($request->get('operador'));
            $operador->setCamion($camion);   
            $em = $this->getDoctrine()->getManager();
            $em->persist($operador);
            $em->flush();
        }
        return $this->serializedResponse($camion, $groups);
    }
}
