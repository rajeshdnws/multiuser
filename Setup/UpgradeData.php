<?php


namespace Born\MultiUsers\Setup;

use Magento\Framework\Setup\UpgradeDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Customer\Model\Customer;
use Magento\Customer\Setup\CustomerSetupFactory;

class UpgradeData implements UpgradeDataInterface
{

    private $customerSetupFactory;

    /**
     * Constructor
     *
     * @param \Magento\Customer\Setup\CustomerSetupFactory $customerSetupFactory
     */
    public function __construct(
        CustomerSetupFactory $customerSetupFactory
    ) {
        $this->customerSetupFactory = $customerSetupFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function upgrade(
        ModuleDataSetupInterface $setup,
        ModuleContextInterface $context
    ) {
        $customerSetup = $this->customerSetupFactory->create(['setup' => $setup]);

        if (version_compare($context->getVersion(), "1.0.2", "<")) {
        
            $customerSetup->addAttribute(\Magento\Customer\Model\Customer::ENTITY, 'parent_account', [
                'type' => 'int',
                'label' => 'Parent Account',
                'input' => 'select',
                'source' => 'Born\MultiUsers\Model\Customer\Attribute\Source\ParentAccount',
                'required' => false,
                'visible' => true,
                'position' => 333,
                'system' => false,
				 'is_used_in_grid' => true,
                'is_visible_in_grid' => true,
                'is_filterable_in_grid' => true,
                'is_searchable_in_grid' => true,
                'backend' => ''
            ]);
            
            $attribute = $customerSetup->getEavConfig()->getAttribute('customer', 'parent_account')
            ->addData(['used_in_forms' => [
                    'adminhtml_customer',
                    'customer_account_create',
                    'customer_account_edit'
                ]
            ]);
            $attribute->save();
        }
    }
}
