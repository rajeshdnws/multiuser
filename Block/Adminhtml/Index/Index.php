<?php


namespace Born\MultiUsers\Block\Adminhtml\Index;

class Index extends \Magento\Backend\Block\Template
{

    /**
     * Constructor
     *
     * @param \Magento\Backend\Block\Template\Context  $context
     * @param array $data
     */
    public function __construct(
        \Magento\Customer\Model\CustomerFactory $customerFactory,
        \Magento\Backend\Model\SessionFactory $adminsession,
        \Magento\Backend\Block\Template\Context $context,
        array $data = []
    ) 
    {
        $this->adminsession = $adminsession;
        $this->_customerFactory = $customerFactory;
        parent::__construct($context, $data);
    }

    public function getFilteredCustomerCollection() {
        $admin =  $this->adminsession->create();
        $customerData=$admin->getData();
        $customer_id = $customerData['customer_data']['customer_id'];
        $customer_data = $this->_customerFactory->create()->getCollection()
                ->addAttributeToSelect("*")
                ->addAttributeToFilter("entity_id", array("neq" =>$customerData['customer_data']['customer_id']))
                ->addAttributeToFilter("parent_account",$customer_id)
                ->load();
                
        return $customer_data;
    }

}
