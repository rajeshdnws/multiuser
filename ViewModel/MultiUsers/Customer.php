<?php


namespace Born\MultiUsers\ViewModel\MultiUsers;

class Customer extends \Magento\Framework\DataObject implements \Magento\Framework\View\Element\Block\ArgumentInterface
{

    /**
     * Customer constructor.
     *
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @return string
     */
    public function getSubCustomer()
    {
        //Your viewModel code
        // you can use me in your template like:
        // $viewModel = $block->getData('viewModel');
        // echo $viewModel->getSubCustomer();
        
        return __('Hello Developer!');
    }
}
