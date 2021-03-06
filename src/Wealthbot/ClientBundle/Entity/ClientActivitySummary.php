<?php

namespace Wealthbot\ClientBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Wealthbot\ClientBundle\Model\ActivityInterface;
use Wealthbot\UserBundle\Entity\User;

/**
 * ClientActivitySummary
 */
class ClientActivitySummary implements ActivityInterface
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $client_id;

    /**
     * @var string
     */
    private $description;

    /**
     * @var \DateTime
     */
    private $created;

    /**
     * @var \Wealthbot\UserBundle\Entity\User
     */
    private $client;

    /**
     * @var boolean
     */
    private $is_show_ria;

    public function __construct()
    {
        $this->setIsShowRia(true);
    }

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
     * Set client_id
     *
     * @param integer $clientId
     * @return ClientActivitySummary
     */
    public function setClientId($clientId)
    {
        $this->client_id = $clientId;
    
        return $this;
    }

    /**
     * Get client_id
     *
     * @return integer 
     */
    public function getClientId()
    {
        return $this->client_id;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return ClientActivitySummary
     */
    public function setDescription($description)
    {
        $this->description = $description;
    
        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return ClientActivitySummary
     */
    public function setCreated($created)
    {
        $this->created = $created;
    
        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime 
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set client
     *
     * @param \Wealthbot\UserBundle\Entity\User $client
     * @return ClientActivitySummary
     */
    public function setClient(\Wealthbot\UserBundle\Entity\User $client = null)
    {
        $this->client = $client;
    
        return $this;
    }

    /**
     * Get client
     *
     * @return \Wealthbot\UserBundle\Entity\User 
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * Set is_show_ria
     *
     * @param boolean $isShowRia
     * @return ClientActivitySummary
     */
    public function setIsShowRia($isShowRia)
    {
        $this->is_show_ria = $isShowRia;
    
        return $this;
    }

    /**
     * Get is_show_ria
     *
     * @return boolean 
     */
    public function getIsShowRia()
    {
        return $this->is_show_ria;
    }
    /**
     * @var integer
     */
    private $document_id;

    /**
     * @var \Wealthbot\UserBundle\Entity\Document
     */
    private $Document;


    /**
     * Set document_id
     *
     * @param integer $documentId
     * @return ClientActivitySummary
     */
    public function setDocumentId($documentId)
    {
        $this->document_id = $documentId;
    
        return $this;
    }

    /**
     * Get document_id
     *
     * @return integer 
     */
    public function getDocumentId()
    {
        return $this->document_id;
    }

    /**
     * Set Document
     *
     * @param \Wealthbot\UserBundle\Entity\Document $document
     * @return ClientActivitySummary
     */
    public function setDocument(\Wealthbot\UserBundle\Entity\Document $document = null)
    {
        $this->Document = $document;
    
        return $this;
    }

    /**
     * Get Document
     *
     * @return \Wealthbot\UserBundle\Entity\Document 
     */
    public function getDocument()
    {
        return $this->Document;
    }

    /**
     * Get activity message
     *
     * @return string
     */
    public function getActivityMessage()
    {
        return 'Document Uploaded';
    }

    /**
     * Get activity client
     *
     * @return User
     */
    public function getActivityClient()
    {
        return $this->client;
    }


}
