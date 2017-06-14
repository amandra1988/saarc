<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;

/**
 * Camion
 *
 * @ORM\Table(name="camion")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CamionRepository")
 */
class Camion
{
    /**
     * @var int
     *
     * @ORM\Column(name="cam_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @JMS\SerializedName("id_camion")
     * @JMS\Groups({"camion_detalle","camion_lista"})
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="cam_patente", type="string", length=10)
     * @JMS\SerializedName("patente_camion")
     * @JMS\Groups({"camion_detalle","camion_lista"})
     */
    private $camPatente;

    /**
     * @var int
     *
     * @ORM\Column(name="cam_capacidad", type="integer")
     * @JMS\SerializedName("capacidad_camion")
     * @JMS\Groups({"camion_detalle","camion_lista"})
     */
    private $camCapacidad;

    /**
     * @var int
     * 1.-Simple, 2.- Peligrosa
     * @ORM\Column(name="cam_tipo_carga", type="integer")
     * @JMS\SerializedName("tipo_carga_camion")
     * @JMS\Groups({"camion_detalle","camion_lista"})
     */
    private $camTipoCarga;
    
    
    /**
     * @var bool
     *
     * @ORM\Column(name="cam_visible", type="boolean")
     */
    private $camVisible;
    
    /**
     * @var bool
     * 0.- Fuera de circulación, 1.- Ok 
     * @ORM\Column(name="cam_estado", type="boolean")
     * @JMS\SerializedName("estado_camion")
     * @JMS\Groups({"camion_detalle","camion_lista"})
     */
    private $camEstado;
    
    /**
     * @ORM\ManyToOne(targetEntity="Empresa", inversedBy="camiones" )
     * @ORM\JoinColumn(name="emp_id", referencedColumnName="emp_id")
     * @JMS\SerializedName("camion_empresa")
     * @JMS\Groups({"r_camion_empresa"})
     */
    private $empresa;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set camPatente
     *
     * @param string $camPatente
     *
     * @return Camion
     */
    public function setCamPatente($camPatente)
    {
        if($camPatente){
            $this->camPatente = $camPatente;
        }
        return $this;
    }

    /**
     * Get camPatente
     *
     * @return string
     */
    public function getCamPatente()
    {
        return $this->camPatente;
    }

    /**
     * Set camCapacidad
     *
     * @param integer $camCapacidad
     *
     * @return Camion
     */
    public function setCamCapacidad($camCapacidad)
    {
        if($camCapacidad){
            $this->camCapacidad = $camCapacidad;
        }
        return $this;
    }

    /**
     * Get camCapacidad
     *
     * @return int
     */
    public function getCamCapacidad()
    {
        return $this->camCapacidad;
    }

    /**
     * Set camTipoCarga
     *
     * @param boolean $camTipoCarga
     *
     * @return Camion
     */
    public function setCamTipoCarga($camTipoCarga)
    {
        if($camTipoCarga){
            $this->camTipoCarga = $camTipoCarga;
        }
        return $this;
    }

    /**
     * Get camTipoCarga
     *
     * @return bool
     */
    public function getCamTipoCarga()
    {
        return $this->camTipoCarga;
    }

    /**
     * Set camEstado
     *
     * @param boolean $camEstado
     *
     * @return Camion
     */
    public function setCamEstado($camEstado)
    {
        $this->camEstado = $camEstado;

        return $this;
    }

    /**
     * Get camEstado
     *
     * @return bool
     */
    public function getCamEstado()
    {
        return $this->camEstado;
    }

    /**
     * Set camVisible
     *
     * @param boolean $camVisible
     *
     * @return Camion
     */
    public function setCamVisible($camVisible)
    {
        $this->camVisible = $camVisible;

        return $this;
    }

    /**
     * Get camVisible
     *
     * @return boolean
     */
    public function getCamVisible()
    {
        return $this->camVisible;
    }

    /**
     * Set empresa
     *
     * @param \AppBundle\Entity\Empresa $empresa
     *
     * @return Camion
     */
    public function setEmpresa(\AppBundle\Entity\Empresa $empresa = null)
    {
        $this->empresa = $empresa;

        return $this;
    }

    /**
     * Get empresa
     *
     * @return \AppBundle\Entity\Empresa
     */
    public function getEmpresa()
    {
        return $this->empresa;
    }
}
