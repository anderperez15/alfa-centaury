<?php

namespace Core\DashboardBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ciudades
 *
 * @ORM\Table(name="ciudades")
 * @ORM\Entity
 */
class Ciudades
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="ciudades_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="ciu_cod", type="string", length=5, nullable=false)
     */
    private $ciuCod;

    /**
     * @var string
     *
     * @ORM\Column(name="ciu_nom", type="string", length=50, nullable=false)
     */
    private $ciuNom;

    /**
     * @var boolean
     *
     * @ORM\Column(name="ciu_estado", type="boolean", nullable=true)
     */
    private $ciuEstado;

    /**
     * @var \Departamento
     *
     * @ORM\ManyToOne(targetEntity="Departamento")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="dep_id", referencedColumnName="id")
     * })
     */
    private $dep;


    private $descripcion;



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
     * Set ciuCod
     *
     * @param string $ciuCod
     * @return Ciudades
     */
    public function setCiuCod($ciuCod)
    {
        $this->ciuCod = $ciuCod;
    
        return $this;
    }

    /**
     * Get ciuCod
     *
     * @return string 
     */
    public function getCiuCod()
    {
        return $this->ciuCod;
    }

    /**
     * Set ciuNom
     *
     * @param string $ciuNom
     * @return Ciudades
     */
    public function setCiuNom($ciuNom)
    {
        $this->ciuNom = $ciuNom;
    
        return $this;
    }

    /**
     * Get ciuNom
     *
     * @return string 
     */
    public function getCiuNom()
    {
        return $this->ciuNom;
    }

    /**
     * Set ciuEstado
     *
     * @param boolean $ciuEstado
     * @return Ciudades
     */
    public function setCiuEstado($ciuEstado)
    {
        $this->ciuEstado = $ciuEstado;
    
        return $this;
    }

    /**
     * Get ciuEstado
     *
     * @return boolean 
     */
    public function getCiuEstado()
    {
        return $this->ciuEstado;
    }

    /**
     * Set dep
     *
     * @param  $dep
     * @return Ciudades
     */
    public function setDep( $dep = null)
    {
        $this->dep = $dep;
    
        return $this;
    }

    /**
     * Get dep
     *
     * @return  
     */
    public function getDep()
    {
        return $this->dep;
    }
    
    public function __toString() {
        return $this->ciuNom.' ';
    }


    public function getDescripcion()
    {
       // return $this->getDep()->getDepNom().' - '.$this->ciuNom;
          return $this->ciuNom;
    }
}
