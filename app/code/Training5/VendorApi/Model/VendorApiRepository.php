<?php
/**
 * Copyright © 2017 PT Kemana Teknologi Solusi. All rights reserved.
 * http://www.kemana.com
 */

/**
 * @category Training5
 * @package  Training5_VendorApi
 * @license  http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 *
 *
 * @author   Kemana Team
 *
 */
 
namespace Training5\VendorApi\Model;

use Training5\VendorApi\Api\VendorApiInterface;

use Magento\Framework\App\ResponseInterface;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\App\Action\Context;

class VendorApiRepository implements VendorApiInterface
{
    protected $repositoryFactory;

    protected $searchCriteriaBuilder;

    protected $filterBuilder;

    protected $filterGroupFilter;
    
    protected $sortOrderBuilder;
    
    protected $resultJsonFactory;
    
    protected $vendorModelFactory;


    
    public function __construct(
        \Training4\Vendor\Model\VendorFactory  $vendorModelFactory,
        \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder,
        \Magento\Framework\Api\FilterBuilder $filterBuilder,
        \Magento\Framework\Api\Search\FilterGroupBuilder $filterGroupBuilder,
        \Magento\Framework\Api\SortOrderBuilder $sortOrderBuilder,
        \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory,
        \Training5\VendorRepository\Model\VendorRepositoryFactory $repositoryInterfaceFactory
    ) {
        $this->repositoryFactory = $repositoryInterfaceFactory;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->filterBuilder = $filterBuilder;
        $this->filterGroupFilter = $filterGroupBuilder;
        $this->sortOrderBuilder = $sortOrderBuilder;
        $this->resultJsonFactory = $resultJsonFactory;
        $this->vendorModelFactory = $vendorModelFactory;
    }
    
    public function save($vendor)
    {
        try {
            $repo = $this->vendorModelFactory
                    ->create()
                    ->setVendorName($vendor)
                    ->save();
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save the vendor: %1',
                $exception->getMessage()
            ));
        }

        return true;
    }
    
    
    
    public function load($vendorId)
    {
        try {
            $repo = $this->vendorModelFactory->create();
            $data = $repo->load($vendorId);
            
            return ['vendor'=>$data->getData()];
        } catch (\Exception $x) {
            return $x->getMessage();
        }
    }

    public function getList()
    {
        try {
            $vendorsData = $this->getVendorsList()->getItems();
            
            $listvendors = array();
            
            foreach ($vendorsData as $vendor) {
                $listvendors[] = [
                    'vendor_id'=>$vendor->getVendorId(),
                    'vendor_name'=>$vendor->getVendorName(),
                    
                ];
            }
            return $listvendors;
        } catch (\Exception $x) {
            return $x->getMessage();
        }
    }
    public function getAssociatedProductIds($vendorId)
    {
        $result = [];
        
        try {
            if ($vendorId) {
                $repository = $this->repositoryFactory->create();
                $result = $repository->getAssociatedProductIds($vendorId);
            }
            
            $listProduct = array();
            
            foreach ($result as $vendor) {
                $listProduct[] = [
                    
                    'product_id'=>$vendor['product_id'],
                    
                ];
            }
            
            return $listProduct;
        } catch (\Exception $x) {
            return $x->getMessage();
        }
    }
    
    public function getVendorsList()
    {
        $searchCriteria = $this->searchCriteriaBuilder->create();

        $repository = $this->repositoryFactory->create();

        $list = $repository->getList($searchCriteria);
        if ($list) {
            return $list;
        }
        return [];
    }
}
