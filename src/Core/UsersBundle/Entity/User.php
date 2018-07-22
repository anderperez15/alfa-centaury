<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

// src/Core/UsersBundle/Entity/User.php

namespace Core\UsersBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="firstName", type="string", length=255, nullable=true)
     */
    private $firstName;

    /**
     * @var string
     *
     * @ORM\Column(name="lastName", type="string", length=255, nullable=true)
     */
    private $lastName;

    /**
     * @var \Core\UsersBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="\Core\UsersBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="createdBy", referencedColumnName="id")
     * })
     */
    private $createdBy;

    /**
     * @var \Core\UsersBundle\Entity\Group
     *
     * @ORM\ManyToOne(targetEntity="\Core\UsersBundle\Entity\Group")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="dependecyID", referencedColumnName="id")
     * })
     */
    private $dependecyID;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="createdOn", type="datetime", nullable=true)
     */
    private $createdOn;

    /**
     * @var boolean
     *
     * @ORM\Column(name="isBoss", type="boolean", nullable=true)
     */
    private $isBoss;

    /**
     * @var string
     *
     * @ORM\Column(name="adress", type="string", length=255, nullable=true)
     */
    private $adress;

    /**
     * @var string
     *
     * @ORM\Column(name="documento", type="string", length=255, nullable=true)
     */
    private $documento;

    /**
     * @var string
     *
     * @ORM\Column(name="tipo_doc", type="string", length=255, nullable=true)
     */
    private $tipoDoc;

    /**
     * @var string
     *
     * @ORM\Column(name="genero", type="string", length=255, nullable=true)
     * @Assert\Choice(choices = {"male", "female"}, message = "Choose a valid gender.")
     */
    private $genero;

    /**
     * @var string
     *
     * @ORM\Column(name="telefono", type="string", length=255, nullable=true)
     */
    private $telefono;


    /**
     * @var string
     *
     * @ORM\Column(name="edad", type="string", length=255, nullable=true)
     */
    private $edad;


    /**
     * @var string
     *
     * @ORM\Column(name="poblacion", type="string", length=255, nullable=true)
     */
    private $poblacion;


    /**
     * @var string
     *
     * @ORM\Column(name="pais", type="string", length=255, nullable=true)
     */
    private $pais;

    /**
     * @var string
     *
     * @ORM\Column(name="departamento", type="string", length=255, nullable=true)
     */
    private $departamento;

    /**
     * @var string
     *
     * @ORM\Column(name="ciudad", type="string", length=255, nullable=true)
     */
    private $ciudad;
    
    /**
     * @var string
     *
     * @ORM\Column(name="rep", type="string", length=255, nullable=true)
     */
    private $tipoA;
    
    /**
     * @var string
     *
     * @ORM\Column(name="n_cedula", type="string", length=255, nullable=true)
     */
    private $cedula;

     /**
     * @var string
     *
     * @ORM\Column(name="nombre_a", type="string", length=255, nullable=true)
     */
    private $nombreR;
    
    
    public function __construct()
    {
        parent::__construct();
        $this->createdOn = new \DateTime("now");
        $this->messages = new ArrayCollection();
    }

    public function isGranted($role)
    {
        return in_array($role, $this->getRoles());
    }

    public function __toString() {
        return $this->lastName ." ".$this->firstName;
    }

    function getFirstName() {
        return $this->firstName;
    }

    function getLastName() {
        return $this->lastName;
    }

    function getCreatedBy() {
        return $this->createdBy;
    }

    function getCreatedOn() {
        return $this->createdOn;
    }

    function setFirstName($firstName) {
        $this->firstName = $firstName;
    }

    function setLastName($lastName) {
        $this->lastName = $lastName;
    }

    function setCreatedBy(\Core\UsersBundle\Entity\User $createdBy) {
        $this->createdBy = $createdBy;
    }

    function setCreatedOn(\DateTime $createdOn) {
        $this->createdOn = $createdOn;
    }

    function getIsBoss() {
        return $this->isBoss;
    }

    function setIsBoss($isBoss) {
        $this->isBoss = $isBoss;
    }


    /**
     * @ORM\OneToMany(targetEntity="\Core\DashboardBundle\Entity\Message", mappedBy="createdBy" , cascade={"remove"})
     */
    protected $messages;

    function getMessages()
    {
        return $this->messages;
    }

    /**
     * @ORM\OneToMany(targetEntity="\Core\DashboardBundle\Entity\NotificationUsers", mappedBy="userID" , cascade={"remove"})
     */
    protected $notifications;

    function getNotifications()
    {
        return $this->notifications;
    }

    public function setEmail($email)
    {
        parent::setEmail($email);
        $this->setUsername($email);
    }


    function getAdress() {
        return $this->adress;
    }

    function setAdress($adress) {
        $this->adress = $adress;
    }

    function getDependecyID() {
        return $this->dependecyID;
    }

    function setDependecyID(\Core\UsersBundle\Entity\Group $dependecyID) {
        $this->dependecyID = $dependecyID;
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
    public function getTipoDoc()
    {
        return $this->tipoDoc;
    }

    /**
     * @param string $tipoDoc
     */
    public function setTipoDoc($tipoDoc)
    {
        $this->tipoDoc = $tipoDoc;
    }

    /**
     * @return string
     */
    public function getGenero()
    {
        return $this->genero;
    }

    /**
     * @param string $genero
     */
    public function setGenero($genero)
    {
        $this->genero = $genero;
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
     * @return string
     */
    public function getEdad()
    {
        return $this->edad;
    }

    /**
     * @param string $edad
     */
    public function setEdad($edad)
    {
        $this->edad = $edad;
    }

    /**
     * @return string
     */
    public function getPoblacion()
    {
        return $this->poblacion;
    }

    /**
     * @param string $poblacion
     */
    public function setPoblacion($poblacion)
    {
        $this->poblacion = $poblacion;
    }

    /**
     * @return string
     */
    public function getPais()
    {
        return $this->pais;
    }

    /**
     * @param string $pais
     */
    public function setPais($pais)
    {
        $this->pais = $pais;
    }

    /**
     * @return string
     */
    public function getDepartamento()
    {
        return $this->departamento;
    }

    /**
     * @param string $departamento
     */
    public function setDepartamento($departamento)
    {
        $this->departamento = $departamento;
    }

    /**
     * @return string
     */
    public function getCiudad()
    {
        return $this->ciudad;
    }

    /**
     * @param string $ciudad
     */
    public function setCiudad($ciudad)
    {
        $this->ciudad = $ciudad;
    }
    
    /**
     * @return string
     */
    public function getTipoA()
    {
        return $this->tipoA;
    }

    /**
     * @param string $tipoA
     */
    public function setTipoA($tipoA)
    {
        $this->tipoA = $tipoA;
    }
    
    /**
     * @return string
     */
    public function getCedula()
    {
        return $this->cedula;
    }

    /**
     * @param string $cedula
     */
    public function setCedula($cedula)
    {
        $this->ciudad = $cedula;
    }
    
    /**
     * @return string
     */
    public function getNombreR()
    {
        return $this->nombreR;
    }

    /**
     * @param string $nombreR
     */
    public function setNombreR($nombreR)
    {
        $this->nombreR = $nombreR;
    }
}