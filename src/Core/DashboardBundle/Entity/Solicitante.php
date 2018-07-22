<?php

namespace Core\DashboardBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CorpoAgente
 *
 * @ORM\Table(name="solicitante")
 * @ORM\Entity
 */
class Solicitante
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \TipoDoc
     *
     * @ORM\ManyToOne(targetEntity="TipoDoc")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="tipo_d", referencedColumnName="id")
     * })
     */
    private $tipoDoc;


    /**
     * @var string
     *
     * @ORM\Column(name="documento", type="string", length=255, nullable=false)
     */
    private $documento;

    /**
     * @var string
     *
     * @ORM\Column(name="primer_nombre", type="string", length=255, nullable=false)
     */
    private $primerNombre;
    
    /**
     * @var string
     *
     * @ORM\Column(name="segundo_nombre", type="string", length=255, nullable=false)
     */
    private $segundoNombre;

    /**
     * @var string
     *
     * @ORM\Column(name="primer_apellido", type="string", length=255, nullable=false)
     */
    private $primerApellido;
    
    /**
     * @var string
     *
     * @ORM\Column(name="segundo_apellido", type="string", length=255, nullable=false)
     */
    private $segundoApellido;

    /**
     * @var string
     *
     * @ORM\Column(name="direccion", type="string", length=255, nullable=true)
     */
    private $direccion;

    /**
     * @var string
     *
     * @ORM\Column(name="telefono", type="string", length=255, nullable=false)
     */
    private $telefono;

    /**
     * @var \Genero
     *
     * @ORM\ManyToOne(targetEntity="Genero")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="genero", referencedColumnName="id")
     * })
     */
    private $genero;
  
   /**
     * @var \Poblacion
     *
     * @ORM\ManyToOne(targetEntity="Poblacion")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="poblacion", referencedColumnName="id")
     * })
     */
    private $poblacion;


    /**
     * @var boolean
     *
     * @ORM\Column(name="terminos", type="boolean", nullable=false)
     */
    private $terminos;



    /**
     * @var integer
     *
     * @ORM\Column(name="edad", type="integer", nullable=false)
     */
    private $edad;


    /**
     * @var string
     *
     * @ORM\Column(name="correo", type="string", length=255, nullable=false)
     */
    private $correo;   
    
    
   /**
     * @var \Ciudad
     *
     * @ORM\ManyToOne(targetEntity="Ciudades")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ciudad", referencedColumnName="id")
     * })
     */
    private $ciudad;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return \TipoDoc
     */
    public function getTipoDoc()
    {
        return $this->tipoDoc;
    }

    /**
     * @param \TipoDoc $tipoDoc
     */
    public function setTipoDoc($tipoDoc)
    {
        $this->tipoDoc = $tipoDoc;
    }

    /**
     * @return string
     */
    public function getDocumento()
    {
        return $this->documento;
    }

    /**
     * @param string $documento
     */
    public function setDocumento($documento)
    {
        $this->documento = $documento;
    }

    /**
     * @return string
     */
    public function getPrimerNombre()
    {
        return $this->primerNombre;
    }

    /**
     * @param string $primerNombre
     */
    public function setPrimerNombre($primerNombre)
    {
        $this->primerNombre= $primerNombre;
    }
    
       /**
     * @return string
     */
    public function getSegundoNombre()
    {
        return $this->segundoNombre;
    }

    /**
     * @param string $primerNombre
     */
    public function setSegundoNombre($segundoNombre)
    {
        $this->segundoNombre= $segundoNombre;
    }

    /**
     * @return string
     */
    public function getPrimerApellido()
    {
        return $this->primerApellido;
    }

    /**
     * @param string $primerApellido
     */
    public function setPrimerApellido($primerApellido)
    {
        $this->primerApellido= $primerApellido;
    }
    
       /**
     * @return string
     */
    public function getSegundoApellido()
    {
        return $this->segundoApellido;
    }

    /**
     * @param string $segundoApellido
     */
    public function setSegundoApellido($segundoApellido)
    {
        $this->segundoApellido= $segundoApellido;
    }
    
    

    /**
     * @return string
     */
    public function getDireccion()
    {
        return $this->direccion;
    }

    /**
     * @param string $direccion
     */
    public function setDireccion($direccion)
    {
        $this->direccion = $direccion;
    }

    /**
     * @return string
     */
    public function getTelefono()
    {
        return $this->telefono;
    }

    /**
     * @param string $telefono
     */
    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;
    }

    /**
     * @return \Genero
     */
    public function getGenero()
    {
        return $this->genero;
    }

    /**
     * @param \Genero $genero
     */
    public function setGenero($genero)
    {
        $this->genero = $genero;
    }

     /**
     * @return \Poblacion
     */
    public function getPoblacion()
    {
        return $this->poblacion;
    }

    /**
     * @param \Poblacion $poblacion
     */
    public function setPoblacion($poblacion)
    {
        $this->poblacion = $poblacion;
    }

    /**
     * @return boolean
     */
    public function isTerminos()
    {
        return $this->terminos;
    }

    /**
     * @param boolean $terminos
     */
    public function setTerminos($terminos)
    {
        $this->terminos = $terminos;
    }

    /**
     * @return int
     */
    public function getEdad()
    {
        return $this->edad;
    }

    /**
     * @param int $edad
     */
    public function setEdad($edad)
    {
        $this->edad = $edad;
    }

    /**
     * @return string
     */
    public function getCorreo()
    {
        return $this->correo;
    }

    /**
     * @param string $correo
     */
    public function setCorreo($correo)
    {
        $this->correo= $correo;
    }
    
    /**
     * @return \Ciudad
     */
    public function getCiudad()
    {
        return $this->ciudad;
    }

    /**
     * @param \Ciudad $ciudad
     */
    public function setCiudad($ciudad)
    {
        $this->ciudad = $ciudad;
    }


}
