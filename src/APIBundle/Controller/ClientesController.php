<?php

namespace APIBundle\Controller;

use AppBundle\Entity\Empresa;
use AppBundle\Entity\Cliente;
use AppBundle\Entity\User;
use AppBundle\Entity\Ruta;
use AppBundle\Entity\RutaDetalle;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ClientesController extends APIBaseController
{
    /**
    * Obtener lista de clientes de la empresa
    * @return Response La respuesta serializada
    */ 
    public function getEmpresasClientesAction(Request $request, $idEmpresa){
        
        $groups = ['cliente_lista','r_cliente_comuna','comuna_detalle','frecuencia_detalle'];
        if(is_array($request->get('expand'))){
            $groups = array_merge($groups, $request->get('expand'));
        }

        $clientes = $this->getDoctrine()->getRepository('AppBundle:Cliente')
                         ->obtenerClientesDeLaEmpresa($idEmpresa);

        return $this->serializedResponse($clientes, $groups); 
    }

    /**
    * Editar Cliente
    * @return Response La respuesta serializada
    */
    public function patchEmpresasClientesAction(Request $request, $idEmpresa, Cliente $cliente ){
        $groups ='';
        
        $frecuencia = $this->getDoctrine()->getRepository('AppBundle:Frecuencia')->find($request->get('frecuencia'));
        
        $comuna = $this->getDoctrine()->getRepository('AppBundle:Comuna')->find($request->get('comuna'));
        
        $cliente->setCliNombre($request->get('nombre'))
                ->setCliDireccion($request->get('direccion'))
                ->setCliNumero($request->get('numero'))
                ->setCliCelular($request->get('celular'))
                ->setCliCorreo($request->get('correo'))
                ->setCliTelefono($request->get('telefono'))
                ->setFrecuencia($frecuencia)
                ->setCliDemanda($request->get('demanda'))
                ->setCliTheta($request->get('theta'))
                ->setComuna($comuna)
                ->setCliVisible($request->get('visible'));

        $em = $this->getDoctrine()->getManager();
        $em->persist($cliente);
        $em->flush();

        return $this->serializedResponse($cliente, $groups);
    }

    public function postEmpresasClientesAction(Request $request, Empresa $empresa){
        $groups ='';

        $frecuencia = $this->getDoctrine()->getRepository('AppBundle:Frecuencia')->find($request->get('frecuencia'));
        
        $comuna = $this->getDoctrine()->getRepository('AppBundle:Comuna')->find($request->get('comuna'));
        
        $cliente = new Cliente();

        $cliente->setCliNombre($request->get('nombre'))
                ->setCliDireccion($request->get('direccion'))
                ->setCliNumero($request->get('numero'))
                ->setCliCelular($request->get('celular'))
                ->setCliCorreo($request->get('correo'))
                ->setCliTelefono($request->get('telefono'))
                ->setCliTheta($request->get('theta'))
                ->setFrecuencia($frecuencia)
                ->setCliDemanda(str_replace(",",".",$request->get('demanda')))
                ->setComuna($comuna)
                ->setCliVisible($request->get('visible'));
    
        $direccion = $request->get('direccion').' '.$request->get('numero').', '.$comuna->getComNombre().', Chile';
        
        $coordenadas = $this->getDoctrine()->getRepository('AppBundle:CentroDeAcopio')->obtenerLatitudYLongitud($direccion);

        $cliente->setCliLatitud($coordenadas['latitud'])
                ->setCliLongitud($coordenadas['longitud']);

        $em = $this->getDoctrine()->getManager();
        $em->persist($cliente);
        $em->flush();

        //Crear usuario del cliente
        $usuario = new User();
        $token = $this->getDoctrine()->getRepository('AppBundle:User')->obtenerTokenParaElUsuario();
        $username = "cliente-".$cliente->getId();
        $pass = $this->container->get('security.password_encoder');
        $password = $pass->encodePassword($usuario,12345);
        $rol   = $this->getDoctrine()->getRepository('AppBundle:Rol')->find(3); 

        $usuario->setEmpresa($empresa);
        $usuario->setRol($rol);
        $usuario->setUsername($username);
        $usuario->setPassword($password);
        $usuario->setToken($token);
        $em = $this->getDoctrine()->getManager();
        $em->persist($usuario);
        $em->flush();

        //Actualizar dato de usuario en el cliente
        $cliente->setUsuario($usuario);
        $em = $this->getDoctrine()->getManager();
        $em->persist($cliente);
        $em->flush();

        return $this->serializedResponse($cliente, $groups);
    }
}
