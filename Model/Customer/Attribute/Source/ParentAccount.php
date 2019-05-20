<?php
namespace Born\MultiUsers\Model\Customer\Attribute\Source;
use Magento\Customer\Model\CustomerFactory;
use Magento\Customer\Model\Customer;
use Magento\Backend\Model\SessionFactory;
use Magento\Customer\Model\Session;
class ParentAccount extends \Magento\Eav\Model\Entity\Attribute\Source\AbstractSource
{
    protected $customer;
    protected $customerFactory;
    protected $adminsession;
	protected $customerSession;
    public function __construct(CustomerFactory $customerFactory,Customer $customers,SessionFactory $adminsession,Session $customerSession)
    { 
        $this->customerFactory = $customerFactory;
        $this->customer = $customers;
		$this->adminsession = $adminsession;
		$this->customerSession = $customerSession;
    }
 
    public function getCustomerCollection() {
        return $this->customer->getCollection()
               ->addAttributeToSelect("*")
               ->load();
    }
 
    public function getFilteredCustomerCollection() {
		 $admin =  $this->adminsession->create();
		 $customerData=$admin->getData();
		if(!empty($customerData['customer_data']['customer_id'])){
        return $this->customerFactory->create()->getCollection()
                ->addAttributeToSelect("*")
                ->addAttributeToFilter("entity_id", array("neq" =>$customerData['customer_data']['customer_id']))
                ->load();
		}else
		{
			
		return 	$this->getCustomerCollection();
			
		}
    }
    /**
     * getAllOptions
     *
     * @return array
     */
    public function getAllOptions()
    {
	 	
	/*	return $customerData['customer_data']['customer_id']; */
        if ($this->_options === null) {
			$data[] = ['value' =>0,'label' => __('Select Parent account')];
			foreach($this->getFilteredCustomerCollection() as $customer){
            $data[] = ['value' => $customer->getEntityId(), 'label' => $customer->getFirstname().' '.$customer->getLastname()];
			}	
       $this->_options = $data;		
        }
        return $this->_options;
    }
}
