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
 

namespace Training5\VendorRepository\Model;

use Training5\VendorRepository\Api\VendorRepositoryInterface;
use Training4\Vendor\Api\Data\VendorSearchResultsInterfaceFactory;
use Training4\Vendor\Api\Data\VendorInterfaceFactory;

use Magento\Framework\Api\SearchResultsInterfaceFactory;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Api\SortOrder;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Reflection\DataObjectProcessor;
use Training4\Vendor\Model\VendorFactory;
use Training4\Vendor\Model\ResourceModel\Vendor as ResourceVendor;
use Training4\Vendor\Model\ResourceModel\Vendor\CollectionFactory as VendorCollectionFactory;
use Magento\Store\Model\StoreManagerInterface;

class VendorRepository implements VendorRepositoryInterface
{
    protected $resource;

    protected $vendorFactory;

    protected $vendorCollectionFactory;

    protected $searchResultsFactory;

    protected $dataObjectHelper;

    protected $dataObjectProcessor;

    protected $dataVendorFactory;

    protected $storeManager;


    /**
     * @param ResourceVendor $resource
     * @param VendorFactory $vendorFactory
     * @param VendorInterfaceFactory $dataVendorFactory
     * @param VendorCollectionFactory $vendorCollectionFactory
     * @param VendorSearchResultsInterfaceFactory $searchResultsFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param DataObjectProcessor $dataObjectProcessor
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(
        ResourceVendor $resource,
        VendorFactory $vendorFactory,
        VendorInterfaceFactory $dataVendorFactory,
        VendorCollectionFactory $vendorCollectionFactory,
        /* VendorSearchResultsInterfaceFactory */ SearchResultsInterfaceFactory $searchResultsFactory,
        DataObjectHelper $dataObjectHelper,
        DataObjectProcessor $dataObjectProcessor,
        StoreManagerInterface $storeManager
    ) {
        $this->vendorFactory = $vendorFactory;
        $this->resource = $resource;
        $this->vendorCollectionFactory = $vendorCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->dataVendorFactory = $dataVendorFactory;
        $this->dataObjectProcessor = $dataObjectProcessor;
        $this->storeManager = $storeManager;
    }

    /**
     * {@inheritdoc}
     */
    public function save(
        \Training4\Vendor\Api\Data\VendorInterface $vendor
    ) {
        try {
            $this->resource->save($vendor);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save the vendor: %1',
                $exception->getMessage()
            ));
        }
        return $vendor;
    }

    /**
     * {@inheritdoc}
     */
     
    public function load($vendorId)
    {
        return $this->getById($vendorId);
    }
     
    public function getById($vendorId)
    {
        $vendor = $this->vendorFactory->create();
        $vendor->load($vendorId);
        if (!$vendor->getId()) {
            throw new NoSuchEntityException(__('Vendor with id "%1" does not exist.', $vendorId));
        }
        return $vendor;
    }

    /**
     * {@inheritdoc}
     */
     
    public function getList(SearchCriteriaInterface $criteria)
    {
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);
        $collection = $this->vendorCollectionFactory->create();
        foreach ($criteria->getFilterGroups() as $filterGroup) {
            $fields = [];
            $conditions = [];
            foreach ($filterGroup->getFilters() as $filter) {
                $condition = $filter->getConditionType() ? $filter->getConditionType() : 'eq';
                $fields[] = $filter->getField();
                $conditions[] = [$condition => $filter->getValue()];
            }
            if ($fields) {
                $collection->addFieldToFilter($fields, $conditions);
            }
        }
        $searchResults->setTotalCount($collection->getSize());
        $sortOrders = $criteria->getSortOrders();
        if ($sortOrders) {
            /** @var SortOrder $sortOrder */
            foreach ($sortOrders as $sortOrder) {
                $collection->addOrder(
                    $sortOrder->getField(),
                    ($sortOrder->getDirection() == SortOrder::SORT_ASC) ? 'ASC' : 'DESC'
                );
            }
        }
        $collection->setCurPage($criteria->getCurrentPage());
        $collection->setPageSize($criteria->getPageSize());
        $objects = [];
        foreach ($collection as $objectModel) {
            $objects[] = $objectModel;
        }
        $searchResults->setItems($objects);
        return $searchResults;
    }
     
    

    /**
     * {@inheritdoc}
     */
    public function delete(
        \Training4\Vendor\Api\Data\VendorInterface $vendor
    ) {
        try {
            $this->resource->delete($vendor);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the Vendor: %1',
                $exception->getMessage()
            ));
        }
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function deleteById($vendorId)
    {
        return $this->delete($this->getById($vendorId));
    }
    
    
        
    public function getAssociatedProductIds($vendor)
    {
        $result = [];
        if ($vendor) {
            if ($vendor instanceof Data\VendorInterface) {
                $vendorId = $vendor->getId();
            } else {
                $vendorId = $vendor;
            }
           
            $result = $this->vendorCollectionFactory->create()->getProductsByVendorId($vendorId);
        }
        return $result;
    }
}
