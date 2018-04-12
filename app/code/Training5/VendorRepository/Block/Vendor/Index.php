<?php
/**
 * Copyright © 2017 PT Kemana Teknologi Solusi. All rights reserved.
 * http://www.kemana.com
 */

/**
 * @category Training5
 * @package  Training5_VendorRepository
 * @license  http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 *
 *
 * @author   Kemana Team
 *
 */
 
namespace Training5\VendorRepository\Block\Vendor;

use Magento\Framework\View\Element\Template\Context;

class Index extends \Magento\Framework\View\Element\Template
{
    const VENDOR_ID = 3;
    protected $coreRegistry;
    protected $searchCriteriaBuilder;
    protected $filterBuilder;
    protected $filterGroupFilter;
    protected $sortOrderBuilder;
    protected $repositoryFactory;
    protected $searchCriteriaInterface;

    public function __construct(
        Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \Training5\VendorRepository\Model\VendorRepositoryFactory  $repositoryInterfaceFactory,
        \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder,
        \Magento\Framework\Api\FilterBuilder $filterBuilder,
        \Magento\Framework\Api\Search\FilterGroupBuilder $filterGroupBuilder,
        \Magento\Framework\Api\SortOrderBuilder $sortOrderBuilder,
        array $data = []
    ) {
        $this->coreRegistry = $coreRegistry;
        $this->repositoryFactory = $repositoryInterfaceFactory;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->filterBuilder = $filterBuilder;
        $this->filterGroupFilter = $filterGroupBuilder;
        $this->sortOrderBuilder = $sortOrderBuilder;


        parent::__construct($context, $data);
    }

    public function getAllVendor()
    {
        $vendors1 = array();
        $vendors3 = '';
        $vendors4 = array();
        $vendors5 = array();
        $vendors6 = array();
        $vendors7 = array();

        $repo = $this->repositoryFactory->create();

        $search_criteria = $this->searchCriteriaBuilder->create();
        $result = $repo->getList($search_criteria);
        $products = $result->getItems();
        foreach ($products as $product) {
            $vendors1[$product->getId()] = $product->getVendorName();
        }



        $repo = $this->repositoryFactory->create();
        $vendors3 = $repo->load(self::VENDOR_ID)->getVendorName();


        $asscVendor = $this->getVendorAssocProduct(self::VENDOR_ID);

        foreach ($asscVendor as $vendor) {
            $vendors4[] = $vendor['product_id'];
        }


        $vendorByName = $this->getSortedBy('vendor_name');
        foreach ($vendorByName as $vendor) {
            $vendors5[] = $vendor->getVendorName();
        }


        $filterVendorByName = $this->filterByName('Google');

        foreach ($filterVendorByName as $vendor) {
            $vendors6[] = $vendor->getVendorName();
        }

        $filterVendorByName = $this->orFilter('Google', 'Apple');

        foreach ($filterVendorByName as $vendor) {
            $vendors7[] = $vendor->getVendorName();
        }

        return array($vendors1,$vendors3,$vendors4,$vendors5,$vendors6,$vendors7);
    }


    protected function getVendorAssocProduct($id)
    {
        $result = [];
        if ($id) {
            $repository = $this->repositoryFactory->create();
            $result = $repository->getAssociatedProductIds($id);
        }
        return $result;
    }

    /**
     * @return bool
     */
    protected function getVendorsList()
    {
        $searchCriteria = $this->searchCriteriaBuilder->create();

        $repository = $this->repositoryFactory->create();

        $list = $repository->getList($searchCriteria);
        if ($list) {
            return $list;
        }
        return false;
    }

    protected function getSortedBy($field)
    {
        $sortOrder[] = $this->sortOrderBuilder
            ->setDirection('ASC')
            ->setField($field)
            ->create();
        $searchCriteria = $this->searchCriteriaBuilder
            ->setSortOrders($sortOrder)
            ->create();
        $repository = $this->repositoryFactory->create();
        $list = $repository->getList($searchCriteria)->getItems();
        if ($list) {
            return $list;
        }
        return false;
    }

    /**
     * @param $name
     * @return bool
     */
    protected function filterByName($name)
    {
        $filters[] = $this->filterBuilder
            ->setField('vendor_name')
            ->setValue($name)
            ->create();
        $searchCriteria = $this->searchCriteriaBuilder
            ->addFilters($filters)
            ->create();

        $repository = $this->repositoryFactory->create();
        $list = $repository->getList($searchCriteria)->getItems();
        if ($list) {
            return $list;
        }
        return false;
    }

    protected function orFilter($vendor1, $vendor2)
    {
        $filters[] = $this->filterBuilder
            ->setField('vendor_name')
            ->setValue($vendor1)
            ->setConditionType('eq')
            ->create();

        $filters[] = $this->filterBuilder
            ->setField('vendor_name')
            ->setValue($vendor2)
            ->setConditionType('noq')
            ->create();


        $searchCriteria = $this->searchCriteriaBuilder
            ->addFilters($filters)
            ->create();




        $repository = $this->repositoryFactory->create();


        $list = $repository->getList($searchCriteria)->getItems();
        if ($list) {
            return $list;
        }
        return false;
    }
}
