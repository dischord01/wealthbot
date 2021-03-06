<?php

namespace Wealthbot\ClientBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Wealthbot\ClientBundle\Manager\ClientToSystemAccountTypeAdapter;
use Wealthbot\ClientBundle\Model\ClientAccount as BaseClientAccount;
use Wealthbot\UserBundle\Entity\User;

/**
 * Wealthbot\ClientBundle\Entity\ClientAccount
 */
class ClientAccount extends BaseClientAccount
{
    /**
     * @var integer $id
     */
    protected $id;

    /**
     * @var integer $client_id
     */
    protected $client_id;

    /**
     * @var string $financial_institution
     */
    protected $financial_institution;

    /**
     * @var float $value
     */
    private $value;

    /**
     * @var float $monthly_contributions
     */
    protected $monthly_contributions;

    /**
     * @var float $monthly_distributions
     */
    protected $monthly_distributions;

    /**
     * @var \Wealthbot\UserBundle\Entity\User
     */
    protected $client;

    /**
     * @var float
     */
    private $sas_cash;

    /**
     * @var integer
     */
    private $group_type_id;

    /**
     * @var \Wealthbot\ClientBundle\Entity\AccountGroupType
     */
    protected $groupType;

    /**
     * @var integer
     */
    protected $process_step;

    /**
     * @var string
     */
    protected $step_action;

    /**
     * @var boolean
     */
    private $is_pre_saved;

    /**
     * @var \Wealthbot\ClientBundle\Entity\SystemAccount
     */
    protected $systemAccount;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    protected $beneficiaries;

    /**
     * @var \Wealthbot\ClientBundle\Entity\RetirementPlanInformation
     */
    private $retirementPlanInfo;

    /**
     * @var \Wealthbot\ClientBundle\Entity\TransferInformation
     */
    protected $transferInformation;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $accountOutsideFunds;

    /**
     * @var \Wealthbot\ClientBundle\Entity\AccountContribution
     */
    protected $accountContribution;

    /**
     * @var integer
     */
    protected $consolidator_id;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    protected $consolidatedAccounts;

    /**
     * @var \Wealthbot\ClientBundle\Entity\ClientAccount
     */
    protected $consolidator;

    /**
     * @var integer
     */
    protected $system_type;

    /**
     * @var boolean
     */
    private $unconsolidated;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    protected $accountOwners;

    /**
     * @var \DateTime
     */
    private $created;

    /**
     * @var boolean
     */
    private $is_init_rebalanced;

    /**
     * @var \DateTime
     */
    private $modified;

    /**
     * @var string
     */
    private $modified_by;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->process_step = 0;
        $this->is_pre_saved = false;
        $this->unconsolidated = false;
        $this->is_init_rebalanced = false;

        parent::__construct();
    }
    
    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return parent::getId();
    }

    /**
     * Set client_id
     *
     * @param integer $clientId
     * @return ClientAccount
     */
    public function setClientId($clientId)
    {
        parent::setClientId($clientId);
    
        return $this;
    }

    /**
     * Get client_id
     *
     * @return integer 
     */
    public function getClientId()
    {
        return parent::getClientId();
    }

    /**
     * Set financial_institution
     *
     * @param string $financialInstitution
     * @return ClientAccount
     */
    public function setFinancialInstitution($financialInstitution)
    {
        parent::setFinancialInstitution($financialInstitution);
    
        return $this;
    }

    /**
     * Get financial_institution
     *
     * @return string 
     */
    public function getFinancialInstitution()
    {
        return parent::getFinancialInstitution();
    }

    /**
     * Set value
     *
     * @param integer $value
     * @return ClientAccount
     */
    public function setValue($value)
    {
        $this->value = $value;
    
        return $this;
    }

    /**
     * Get value
     *
     * @return float
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set monthly_contributions
     *
     * @param float $monthlyContributions
     * @return ClientAccount
     */
    public function setMonthlyContributions($monthlyContributions)
    {
        parent::setMonthlyContributions($monthlyContributions);
    
        return $this;
    }

    /**
     * Get monthly_contributions
     *
     * @return float
     */
    public function getMonthlyContributions()
    {
        return parent::getMonthlyContributions();
    }

    /**
     * Set monthly_distributions
     *
     * @param float $monthlyDistributions
     * @return ClientAccount
     */
    public function setMonthlyDistributions($monthlyDistributions)
    {
        parent::setMonthlyDistributions($monthlyDistributions);
    
        return $this;
    }

    /**
     * Get monthly_distributions
     *
     * @return float
     */
    public function getMonthlyDistributions()
    {
        return parent::getMonthlyDistributions();
    }

    /**
     * Set client
     *
     * @param \Wealthbot\UserBundle\Entity\User $client
     * @return ClientAccount
     */
    public function setClient(\Wealthbot\UserBundle\Entity\User $client = null)
    {
        parent::setClient($client);
    
        return $this;
    }

    /**
     * Get client
     *
     * @return \Wealthbot\UserBundle\Entity\User
     */
    public function getClient()
    {
        return parent::getClient();
    }

    /**
     * Set sas_cash
     *
     * @param float $sasCash
     * @return ClientAccount
     */
    public function setSasCash($sasCash)
    {
        $this->sas_cash = $sasCash;
    
        return $this;
    }

    /**
     * Get sas_cash
     *
     * @return float 
     */
    public function getSasCash()
    {
        return $this->sas_cash;
    }

    /**
     * Set group_type_id
     *
     * @param integer $groupTypeId
     * @return ClientAccount
     */
    public function setGroupTypeId($groupTypeId)
    {
        $this->group_type_id = $groupTypeId;
    
        return $this;
    }

    /**
     * Get group_type_id
     *
     * @return integer 
     */
    public function getGroupTypeId()
    {
        return $this->group_type_id;
    }

    /**
     * Set groupType
     *
     * @param \Wealthbot\ClientBundle\Entity\AccountGroupType $groupType
     * @return ClientAccount
     */
    public function setGroupType(\Wealthbot\ClientBundle\Entity\AccountGroupType $groupType = null)
    {
        parent::setGroupType($groupType);

        // Update system_account field
        if ($groupType) {
            $typeAdapter = new ClientToSystemAccountTypeAdapter($this);
            $this->setSystemType($typeAdapter->getType());
        }

        return $this;
    }

    /**
     * Get groupType
     *
     * @return \Wealthbot\ClientBundle\Entity\AccountGroupType 
     */
    public function getGroupType()
    {
        return parent::getGroupType();
    }

    /**
     * Set process_step
     *
     * @param integer $processStep
     * @return ClientAccount
     */
    public function setProcessStep($processStep)
    {
        return parent::setProcessStep($processStep);
    }

    /**
     * Get process_step
     *
     * @return integer 
     */
    public function getProcessStep()
    {
        return parent::getProcessStep();
    }

    /**
     * Add beneficiaries
     *
     * @param \Wealthbot\ClientBundle\Entity\Beneficiary $beneficiaries
     * @return ClientAccount
     */
    public function addBeneficiarie(\Wealthbot\ClientBundle\Entity\Beneficiary $beneficiaries)
    {
        parent::addBeneficiarie($beneficiaries);

        return $this;
    }

    /**
     * Remove beneficiaries
     *
     * @param Beneficiary $beneficiaries
     */
    public function removeBeneficiarie(\Wealthbot\ClientBundle\Entity\Beneficiary $beneficiaries)
    {
        parent::removeBeneficiarie($beneficiaries);
    }

    /**
     * Get beneficiaries
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getBeneficiaries()
    {
        return parent::getBeneficiaries();
    }

    /**
     * Set retirementPlanInfo
     *
     * @param RetirementPlanInformation $retirementPlanInfo
     * @return ClientAccount
     */
    public function setRetirementPlanInfo(\Wealthbot\ClientBundle\Entity\RetirementPlanInformation $retirementPlanInfo = null)
    {
        $this->retirementPlanInfo = $retirementPlanInfo;
    
        return $this;
    }

    /**
     * Get retirementPlanInfo
     *
     * @return \Wealthbot\ClientBundle\Entity\RetirementPlanInformation 
     */
    public function getRetirementPlanInfo()
    {
        return $this->retirementPlanInfo;
    }

    /**
     * Set transferInformation
     *
     * @param TransferInformation $transferInformation
     * @return ClientAccount
     */
    public function setTransferInformation(\Wealthbot\ClientBundle\Entity\TransferInformation $transferInformation = null)
    {
        parent::setTransferInformation($transferInformation);

        return $this;
    }

    /**
     * Get transferInformation
     *
     * @return \Wealthbot\ClientBundle\Entity\TransferInformation 
     */
    public function getTransferInformation()
    {
        return parent::getTransferInformation();
    }

    /**
     * Set step_action
     *
     * @param string $stepAction
     * @return ClientAccount
     */
    public function setStepAction($stepAction)
    {
        return parent::setStepAction($stepAction);
    }

    /**
     * Get step_action
     *
     * @return string 
     */
    public function getStepAction()
    {
        return parent::getStepAction();
    }

    /**
     * Set is_pre_saved
     *
     * @param boolean $isPreSaved
     * @return ClientAccount
     */
    public function setIsPreSaved($isPreSaved)
    {
        $this->is_pre_saved = $isPreSaved;
    
        return $this;
    }

    /**
     * Get is_pre_saved
     *
     * @return boolean 
     */
    public function getIsPreSaved()
    {
        return $this->is_pre_saved;
    }

    /**
     * Add accountOutsideFunds
     *
     * @param AccountOutsideFund $accountOutsideFunds
     * @return ClientAccount
     */
    public function addAccountOutsideFund(\Wealthbot\ClientBundle\Entity\AccountOutsideFund $accountOutsideFunds)
    {
        $this->accountOutsideFunds[] = $accountOutsideFunds;
    
        return $this;
    }

    /**
     * Remove accountOutsideFunds
     *
     * @param \Wealthbot\ClientBundle\Entity\AccountOutsideFund $accountOutsideFunds
     */

    /**
     * @param AccountOutsideFund $accountOutsideFunds
     */
    public function removeAccountOutsideFund(\Wealthbot\ClientBundle\Entity\AccountOutsideFund $accountOutsideFunds)
    {
        $this->accountOutsideFunds->removeElement($accountOutsideFunds);
    }

    /**
     * Get accountOutsideFunds
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAccountOutsideFunds()
    {
        return $this->accountOutsideFunds;
    }

    public function isCompleted()
    {
        $step = $this->getProcessStep();
        $group = $this->getGroupName();

        if (($group == AccountGroup::GROUP_EMPLOYER_RETIREMENT && $step == self::PROCESS_STEP_COMPLETED_CREDENTIALS) ||
            ($group != AccountGroup::GROUP_EMPLOYER_RETIREMENT && $step == self::PROCESS_STEP_FINISHED_APPLICATION)
        ) {
            return true;
        }

        return false;
    }

    /**
     * Set systemAccount
     *
     * @param \Wealthbot\ClientBundle\Entity\SystemAccount $systemAccount
     * @return ClientAccount
     */
    public function setSystemAccount(\Wealthbot\ClientBundle\Entity\SystemAccount $systemAccount = null)
    {
        parent::setSystemAccount($systemAccount);
    
        return $this;
    }

    /**
     * Get systemAccount
     *
     * @return \Wealthbot\ClientBundle\Entity\SystemAccount
     */
    public function getSystemAccount()
    {
        return parent::getSystemAccount();
    }

    /**
     * Set accountContribution
     *
     * @param \Wealthbot\ClientBundle\Entity\AccountContribution $accountContribution
     * @return ClientAccount
     */
    public function setAccountContribution(\Wealthbot\ClientBundle\Entity\AccountContribution $accountContribution = null)
    {
        parent::setAccountContribution($accountContribution);
    
        return $this;
    }

    /**
     * Get accountContribution
     *
     * @return AccountContribution
     */
    public function getAccountContribution()
    {
        return parent::getAccountContribution();
    }

    /**
     * Set consolidator_id
     *
     * @param integer $consolidatorId
     * @return ClientAccount
     */
    public function setConsolidatorId($consolidatorId)
    {
        parent::setConsolidatorId($consolidatorId);
    
        return $this;
    }

    /**
     * Get consolidator_id
     *
     * @return integer 
     */
    public function getConsolidatorId()
    {
        return parent::getConsolidatorId();
    }

    /**
     * Add consolidatedAccounts
     *
     * @param \Wealthbot\ClientBundle\Entity\ClientAccount $consolidatedAccounts
     * @return ClientAccount
     */
    public function addConsolidatedAccount(\Wealthbot\ClientBundle\Entity\ClientAccount $consolidatedAccounts)
    {
        parent::addConsolidatedAccount($consolidatedAccounts);
    
        return $this;
    }

    /**
     * Remove consolidatedAccounts
     *
     * @param \Wealthbot\ClientBundle\Entity\ClientAccount $consolidatedAccounts
     */
    public function removeConsolidatedAccount(\Wealthbot\ClientBundle\Entity\ClientAccount $consolidatedAccounts)
    {
        parent::removeConsolidatedAccount($consolidatedAccounts);
    }

    /**
     * Get consolidatedAccounts
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getConsolidatedAccounts()
    {
        return parent::getConsolidatedAccounts();
    }

    /**
     * Set consolidator
     *
     * @param \Wealthbot\ClientBundle\Entity\ClientAccount $consolidator
     * @return ClientAccount
     */
    public function setConsolidator(\Wealthbot\ClientBundle\Entity\ClientAccount $consolidator = null)
    {
        parent::setConsolidator($consolidator);
    
        return $this;
    }

    /**
     * Get consolidator
     *
     * @return \Wealthbot\ClientBundle\Entity\ClientAccount 
     */
    public function getConsolidator()
    {
        return parent::getConsolidator();
    }

    /**
     * Set system_type
     *
     * @param integer $systemType
     * @return ClientAccount
     */
    public function setSystemType($systemType)
    {
        parent::setSystemType($systemType);
    
        return $this;
    }

    /**
     * Get system_type
     *
     * @return integer 
     */
    public function getSystemType()
    {
        return parent::getSystemType();
    }

    /**
     * Set unconsolidated
     *
     * @param boolean $unconsolidated
     * @return ClientAccount
     */
    public function setUnconsolidated($unconsolidated)
    {
        $this->unconsolidated = $unconsolidated;
    
        return $this;
    }

    /**
     * Get unconsolidated
     *
     * @return boolean 
     */
    public function getUnconsolidated()
    {
        return $this->unconsolidated;
    }

    /**
     * Get sum of the consolidated accounts values or value if account is not consolidated
     *
     * @return float
     */
    public function getValueSum()
    {
        $sum = $this->getValue();

        if ($this->getConsolidatedAccounts() && $this->getConsolidatedAccounts()->count()) {
            foreach ($this->getConsolidatedAccounts() as $account) {
                $sum += $account->getValue();
            }
        }

        return $sum;
    }

    /**
     * Get sum of the consolidated accounts monthly_contributions or monthly_contribution if account is not consolidated
     *
     * @return float
     */
    public function getContributionsSum()
    {
        $sum = $this->getMonthlyContributions();

        if ($this->getConsolidatedAccounts() && $this->getConsolidatedAccounts()->count()) {
            foreach ($this->getConsolidatedAccounts() as $account) {
                $sum += $account->getMonthlyContributions();
            }
        }

        return $sum;
    }

    /**
     * Get sum of the consolidated accounts monthly_distributions or monthly_distribution if account is not consolidated
     *
     * @return float
     */
    public function getDistributionsSum()
    {
        $sum = $this->getMonthlyDistributions();

        if ($this->getConsolidatedAccounts() && $this->getConsolidatedAccounts()->count()) {
            foreach ($this->getConsolidatedAccounts() as $account) {
                $sum += $account->getMonthlyDistributions();
            }
        }

        return $sum;
    }

    /**
     * Get sum of the consolidated accounts sas_cache or sas_cache if account is not consolidated
     *
     * @return float
     */
    public function getSasCashSum()
    {
        $sum = $this->getSasCash();

        if ($this->getConsolidatedAccounts() && $this->getConsolidatedAccounts()->count()) {
            foreach ($this->getConsolidatedAccounts() as $account) {
                $sum += $account->getSasCash();
            }
        }

        return $sum;
    }

    /**
     * Add accountOwners
     *
     * @param \Wealthbot\ClientBundle\Model\ClientAccountOwner $accountOwner
     * @return ClientAccount
     */
    public function addAccountOwner(\Wealthbot\ClientBundle\Model\ClientAccountOwner $accountOwner)
    {
        parent::addAccountOwner($accountOwner);
    
        return $this;
    }

    /**
     * Remove accountOwners
     *
     * @param \Wealthbot\ClientBundle\Model\ClientAccountOwner $accountOwner
     */
    public function removeAccountOwner(\Wealthbot\ClientBundle\Model\ClientAccountOwner $accountOwner)
    {
        parent::removeAccountOwner($accountOwner);
    }

    /**
     * Get accountOwners
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAccountOwners()
    {
        return parent::getAccountOwners();
    }


    /**
     * Add beneficiaries
     *
     * @param \Wealthbot\ClientBundle\Entity\Beneficiary $beneficiaries
     * @return ClientAccount
     */
    public function addBeneficiary(\Wealthbot\ClientBundle\Entity\Beneficiary $beneficiaries)
    {
        $this->beneficiaries[] = $beneficiaries;

        return $this;
    }

    /**
     * Remove beneficiaries
     *
     * @param \Wealthbot\ClientBundle\Entity\Beneficiary $beneficiaries
     */
    public function removeBeneficiary(\Wealthbot\ClientBundle\Entity\Beneficiary $beneficiaries)
    {
        $this->beneficiaries->removeElement($beneficiaries);
    }

    public function getOwnerNames()
    {
        $owners = $this->getAccountOwners()->getValues();

        $names = array_map(function($owner){
                /** @var $owner ClientAccountOwner */
                $client = $owner->getClient();
                if ($client) {
                    return $client->getLastName() . ' ' . $client->getFirstName();
                }
                return '';
        }, $owners);

        return implode(', ', $names);
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return ClientAccount
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
     * Set is_init_rebalanced
     *
     * @param boolean $isInitRebalanced
     * @return ClientAccount
     */
    public function setIsInitRebalanced($isInitRebalanced)
    {
        $this->is_init_rebalanced = $isInitRebalanced;

        return $this;
    }

    /**
     * Get is_init_rebalanced
     *
     * @return boolean 
     */
    public function getIsInitRebalanced()
    {
        return $this->is_init_rebalanced;
    }

    /**
     * Set modified
     *
     * @param \DateTime $modified
     * @return ClientAccount
     */
    public function setModified($modified)
    {
        $this->modified = $modified;

        return $this;
    }

    /**
     * Get modified
     *
     * @return \DateTime 
     */
    public function getModified()
    {
        return $this->modified;
    }

    /**
     * Set modified_by
     *
     * @param string $modifiedBy
     * @return ClientAccount
     */
    public function setModifiedBy($modifiedBy)
    {
        $this->modified_by = $modifiedBy;

        return $this;
    }

    /**
     * Get modified_by
     *
     * @return string 
     */
    public function getModifiedBy()
    {
        return $this->modified_by;
    }
}
