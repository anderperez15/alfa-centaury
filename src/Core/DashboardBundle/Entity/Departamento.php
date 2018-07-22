<?php

namespace Core\DashboardBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Departamento
 *
 * @ORM\Table(name="departamento")
 * @ORM\Entity
 */
class Departamento
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="departamento_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="dep_cod", type="string", length=2, nullable=false)
     */
    private $depCod;

    /**
     * @var string
     *
     * @ORM\Column(name="dep_nom", type="string", length=50, nullable=false)
     */
    private $depNom;

    /**
     * @var boolean
     *
     * @ORM\Column(name="dep_estado", type="boolean", nullable=true)
     */
    private $depEstado;



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
     * Set depCod
     *
     * @param string $depCod
     * @return Departamento
     */
    public function setDepCod($depCod)
    {
        $this->depCod = $depCod;
    
        return $this;
    }

    /**
     * Get depCod
     *
     * @return string 
     */
    public function getDepCod()
    {
        return $this->depCod;
    }

    /**
     * Set depNom
     *
     * @param string $depNom
     * @return Departamento
     */
    public function setDepNom($depNom)
    {
        $this->depNom = $depNom;
    
        return $this;
    }

    /**
     * Get depNom
     *
     * @return string 
     */
    public function getDepNom()
    {
        return $this->depNom;
    }

    /**
     * Set depEstado
     *
     * @param boolean $depEstado
     * @return Departamento
     */
    public function setDepEstado($depEstado)
    {
        $this->depEstado = $depEstado;
    
        return $this;
    }

    /**
     * Get depEstado
     *
     * @return boolean 
     */
    public function getDepEstado()
    {
        return $this->depEstado;
    }
    
     public function __toString() {
        return $this->depNom.' ';
    }
}