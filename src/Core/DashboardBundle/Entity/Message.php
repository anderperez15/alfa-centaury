<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Core\DashboardBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Message
 *
 * @ORM\Table(name="message")
 * @ORM\Entity
 */
class Message
{
     /**
     * @var integer
     *
     * @ORM\Column(name="messageID", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;
    
     /**
     * @var \DateTime
     *
     * @ORM\Column(name="createdOn", type="datetime", nullable=true)
     */
    private $createdOn;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="closedOn", type="datetime", nullable=true)
     */
    private $closedOn;



    /**
     * @var \string
     *
     * @ORM\Column(name="verification", type="string",length=10, nullable=true)
     */
    private $verification;

    
    
    /**
     * @var \Core\DashboardBundle\Entity\Solicitante
     *
     * @ORM\ManyToOne(targetEntity="\Core\DashboardBundle\Entity\Solicitante", inversedBy="messages")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="createdBy", referencedColumnName="id")
     * })
     */
    private $createdBy;
    
    /**
     * @var \Core\UsersBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="\Core\UsersBundle\Entity\User", inversedBy="messages")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="closedBy", referencedColumnName="id")
     * })
     */
    private $closedBy;
    
    /**
     * @var string
     *
     * @ORM\Column(name="currentService", type="string", length=30, nullable=true)
     */
    private $currentService;
    
    /**
     * @var string
     *
     * @ORM\Column(name="responseText", type="string", length=30, nullable=true)
     */
    private $responseText;
    
    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=30, nullable=true)
     */
    private $status;
    
    /**
     * @var string
     *
     * @ORM\Column(name="code", type="string", length=30, nullable=true)
     */
    private $code;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="isViewed", type="boolean", nullable=true)
     */
    private $isViewed;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="canBeViewed", type="boolean", nullable=true)
     */
    private $canBeViewed;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="isTreated", type="boolean", nullable=true)
     */
    private $isTreated;
    
    /**
     * @var string
     *
     * @ORM\Column(name="subject", type="string", length=255, nullable=true)
     */
    private $subject;
    
     /**
     * @var string
     *
     * @ORM\Column(name="message", type="text", nullable=true)
     */
    private $message;
    
    /**
     * @var \Core\DashboardBundle\Entity\Demand
     *
     * @ORM\ManyToOne(targetEntity="\Core\DashboardBundle\Entity\Demand")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="demandType", referencedColumnName="demandID")
     * })
     */
    private $demandType;
    
     /**
     * @var \Core\UsersBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="\Core\UsersBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="viewedBy", referencedColumnName="id")
     * })
     */
    private $viewedBy;
    
    
    
     /**
     * @var string
     *
     * @ORM\Column(name="contactType", type="string", length=25, nullable=true)
     */
    private $contactType;
    
    /**
     * @var \Core\UsersBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="\Core\UsersBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="canBeViewedBy", referencedColumnName="id")
     * })
     */
    private $canBeViewedBy;
    
     /**
     * @var string
     *
     * @ORM\Column(name="radicado", type="string", length=255, nullable=true)
     */
    private $radicado;

    
     /**
     * @var string
     *
     * @ORM\Column(name="encuesta", type="string", length=255, nullable=true)
     */
    private $encuesta;

    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fec_ra", type="date", nullable=true)
     */
    private $fecRa;

     /**
     * @var \DateTime
     *
     * @ORM\Column(name="antes_de", type="date", nullable=true)
     */
    private $antesD;
    
    

    
    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
    
    public function __construct()
    {
        $this->createdOn = new \DateTime("now");
        $this->currentService ="Recepcion";
        $this->isTreated = FALSE;
        $this->isViewed = FALSE;
        $this->status = "abierto";
        $this->canBeViewed = FALSE;
        $this->historics = new ArrayCollection();
        $this->attachments = new ArrayCollection();
    }
    
    function getCreatedOn() {
        return $this->createdOn;
    }

    function getCreatedBy() {
        return $this->createdBy;
    }

    function getCurrentService() {
        return $this->currentService;
    }

    function getIsViewed() {
        return $this->isViewed;
    }

    function getIsTreated() {
        return $this->isTreated;
    }

    function getSubject() {
        return $this->subject;
    }

    function getMessage() {
        return $this->message;
    }

    function getDemandType() {
        return $this->demandType;
    }

    function getViewedBy() {
        return $this->viewedBy;
    }

    

    function getContactType() {
        return $this->contactType;
    }

    function setCreatedOn(\DateTime $createdOn) {
        $this->createdOn = $createdOn;
    }

    function setCreatedBy(\Core\DashboardBundle\Entity\Solicitante $createdBy) {
        $this->createdBy = $createdBy;
    }

    function setCurrentService($currentService) {
        $this->currentService = $currentService;
    }

    function setIsViewed($isViewed) {
        $this->isViewed = $isViewed;
    }

    function setIsTreated($isTreated) {
        $this->isTreated = $isTreated;
    }

    function setSubject($subject) {
        $this->subject = $subject;
    }

    function setMessage($message) {
        $this->message = $message;
    }

    function setDemandType(\Core\DashboardBundle\Entity\Demand $demandType) {
        $this->demandType = $demandType;
    }

    function setViewedBy(\Core\UsersBundle\Entity\User $viewedBy) {
        $this->viewedBy = $viewedBy;
    }

    

    function setContactType($contactType) {
        $this->contactType = $contactType;
    }
    function getStatus() {
        return $this->status;
    }

    function setStatus($status) {
        $this->status = $status;
    }

    function getExpireOn()
    {
      $creationDate = date_format($this->createdOn,('Y-m-d'));
      $skipdays = array("Saturday", "Sunday");
      $skipdates = array();
      $endDate = $this->addDays(strtotime($creationDate), $this->demandType->getNbDaysTreatement(),$skipdays,$skipdates);
      return $endDate;
    }
    
    function addDays($timestamp, $days, $skipdays = array("Saturday", "Sunday"), $skipdates = NULL)
    {
        $i = 1;

        while ($days >= $i) {
            $timestamp = strtotime("+1 day", $timestamp);
            if ( (in_array(date("l", $timestamp), $skipdays)) || (in_array(date("Y-m-d", $timestamp), $skipdates)) )
            {
                $days++;
            }
            $i++;
        }
        return date("d-m-Y",$timestamp);
    }
    
    function getCode() {
        return $this->code;
    }

    function setCode($code) {
        $this->code = $code;
    }
    
    function getClosedOn() {
        return $this->closedOn;
    }

    function getClosedBy() {
        return $this->closedBy;
    }

    function getResponseText() {
        return $this->responseText;
    }

    function setClosedOn(\DateTime $closedOn) {
        $this->closedOn = $closedOn;
    }

    function setClosedBy(\Core\UsersBundle\Entity\User $closedBy) {
        $this->closedBy = $closedBy;
    }

    function setResponseText($responseText) {
        $this->responseText = $responseText;
    }
    function getCanBeViewed() {
        return $this->canBeViewed;
    }

    function setCanBeViewed($canBeViewed) {
        $this->canBeViewed = $canBeViewed;
    }
    
     /**
     * @ORM\OneToMany(targetEntity="\Core\DashboardBundle\Entity\MessageHistorial", mappedBy="messageID" , cascade={"remove"})
     */
    protected $historics;
    
    function getHistorial()
    {
        return $this->historics;
    }
    
    /**
     * @ORM\OneToMany(targetEntity="\Core\DashboardBundle\Entity\MessageAttachment", mappedBy="messageID" , cascade={"remove"})
     */
    protected $attachments;
    
    function getAttachments()
    {
        return $this->attachments;
    }
    
    function getCanBeViewedBy() {
        return $this->canBeViewedBy;
    }

    function setCanBeViewedBy(\Core\UsersBundle\Entity\User $canBeViewedBy = NULL) {
        $this->canBeViewedBy = $canBeViewedBy;
    }
    
    /**
     * @return string
     */
    public function getRadicado()
    {
        return $this->radicado;
    }

    /**
     * @param string $radicado
     */
    public function setRadicado($radicado)
    {
        $this->radicado = $radicado;
    }


    function getFecRa() {
        return $this->fecRa;
    }


    function setFecRa(\DateTime $fecRa) {
        $this->fecRa= $fecRa;
    }


    function getAntesD() {
        return $this->antesD;
    }


    function setAntesD(\DateTime $antesD) {
        $this->antesD= $antesD;
    }

     /**
     * @return string
     */
    public function getEncuesta()
    {
        return $this->encuesta;
    }

    /**
     * @param string $encuesta
     */
    public function setEncuesta($encuesta)
    {
        $this->encuesta = $encuesta;
    }


    

    /**
     * Set verification
     *
     * @param string $verification
     *
     * @return Message
     */
    public function setVerification($verification)
    {
        $this->verification = $verification;

        return $this;
    }

    /**
     * Get verification
     *
     * @return string
     */
    public function getVerification()
    {
        return $this->verification;
    }

    /**
     * Add historic
     *
     * @param \Core\DashboardBundle\Entity\MessageHistorial $historic
     *
     * @return Message
     */
    public function addHistoric(\Core\DashboardBundle\Entity\MessageHistorial $historic)
    {
        $this->historics[] = $historic;

        return $this;
    }

    /**
     * Remove historic
     *
     * @param \Core\DashboardBundle\Entity\MessageHistorial $historic
     */
    public function removeHistoric(\Core\DashboardBundle\Entity\MessageHistorial $historic)
    {
        $this->historics->removeElement($historic);
    }

    /**
     * Get historics
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getHistorics()
    {
        return $this->historics;
    }

    /**
     * Add attachment
     *
     * @param \Core\DashboardBundle\Entity\MessageAttachment $attachment
     *
     * @return Message
     */
    public function addAttachment(\Core\DashboardBundle\Entity\MessageAttachment $attachment)
    {
        $this->attachments[] = $attachment;

        return $this;
    }

    /**
     * Remove attachment
     *
     * @param \Core\DashboardBundle\Entity\MessageAttachment $attachment
     */
    public function removeAttachment(\Core\DashboardBundle\Entity\MessageAttachment $attachment)
    {
        $this->attachments->removeElement($attachment);
    }
}
