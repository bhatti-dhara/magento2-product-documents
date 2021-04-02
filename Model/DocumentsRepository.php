<?php
/**
 * BhattiDhara
 * Copyright (C) 2021 BhattiDhara
 *
 * NOTICE OF LICENSE
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see http://opensource.org/licenses/gpl-3.0.html
 *
 * @category BhattiDhara
 * @package Mage2_ProductDocs
 * @copyright Copyright (c) 2021 BhattiDhara
 * @license http://opensource.org/licenses/gpl-3.0.html GNU General Public License,version 3 (GPL-3.0)
 * @author BhattiDhara
 */

declare(strict_types=1);

namespace Mage2\ProductDocs\Model;

use Mage2\ProductDocs\Api\Data\DocumentsInterface;
use Mage2\ProductDocs\Api\Data\DocumentsSearchResultsInterface;
use Mage2\ProductDocs\Api\DocumentsRepositoryInterface;
use Mage2\ProductDocs\Model\ResourceModel\Documents as DocumentsResource;
use Mage2\ProductDocs\Model\ResourceModel\Documents\CollectionFactory as DocumentsCollectionFactory;
use Exception;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchResultsInterfaceFactory;
use Magento\Framework\Api\SortOrder;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Class DocumentsRepository
 */
class DocumentsRepository implements DocumentsRepositoryInterface
{
    /**
     * @var DocumentsFactory
     */
    protected $documentsFactory;

    /**
     * @var DocumentsResource
     */
    protected $resource;

    /**
     * @var SearchResultsInterfaceFactory
     */
    protected $searchResultsFactory;

    /**
     * @var DocumentsCollectionFactory
     */
    protected $documentsCollectionFactory;

    /**
     * DocumentsRepository constructor.
     *
     * @param DocumentsResource $resource
     * @param DocumentsFactory $documentsFactory
     * @param DocumentsCollectionFactory $documentsCollectionFactory
     * @param SearchResultsInterfaceFactory $searchResultsFactory
     */
    public function __construct(
        DocumentsResource $resource,
        DocumentsFactory $documentsFactory,
        DocumentsCollectionFactory $documentsCollectionFactory,
        SearchResultsInterfaceFactory $searchResultsFactory
    ) {
        $this->resource                   = $resource;
        $this->documentsFactory           = $documentsFactory;
        $this->documentsCollectionFactory = $documentsCollectionFactory;
        $this->searchResultsFactory       = $searchResultsFactory;
    }

    /**
     * Save product document
     *
     * @param DocumentsInterface $document
     * @return DocumentsInterface
     * @throws CouldNotSaveException
     * @throws NoSuchEntityException
     */
    public function save(DocumentsInterface $document)
    {
        try {
            $this->resource->save($document);
        } catch (Exception $e) {
            throw new CouldNotSaveException(__($e->getMessage()));
        }
        return $document;
    }

    /**
     * Delete product document by given document identifier
     *
     * @param int $documentId
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function deleteById($documentId)
    {
        return $this->delete($this->getById($documentId));
    }

    /**
     * Delete product document
     *
     * @param DocumentsInterface $document
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function delete(DocumentsInterface $document)
    {
        try {
            $this->resource->delete($document);
        } catch (Exception $e) {
            throw new CouldNotDeleteException(__($e->getMessage()));
        }
        return true;
    }

    /**
     * Get product document by document identifier
     *
     * @param int $documentId
     * @return DocumentsInterface
     * @throws NoSuchEntityException
     */
    public function getById($documentId)
    {
        $document = $this->documentsFactory->create();
        $this->resource->load($document, $documentId);
        if (!$document->getId()) {
            throw new NoSuchEntityException(__('The product document with the "%1" ID doesn\'t exist.', $documentId));
        }
        return $document;
    }

    /**
     * Get product documents matching the specified criteria
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @return DocumentsSearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);
        $collection = $this->documentsCollectionFactory->create();
        foreach ($searchCriteria->getFilterGroups() as $filterGroup) {
            $fields     = [];
            $conditions = [];
            foreach ($filterGroup->getFilters() as $filter) {
                $condition    = $filter->getConditionType() ? $filter->getConditionType() : 'eq';
                $fields[]     = $filter->getField();
                $conditions[] = [$condition => $filter->getValue()];
            }
            if ($fields) {
                //$collection->addFieldToFilter($fields, $conditions);
            }
        }
        $searchResults->setTotalCount($collection->getSize());
        $sortOrders = $searchCriteria->getSortOrders();
        if ($sortOrders) {
            /** @var SortOrder $sortOrder */
            foreach ($sortOrders as $sortOrder) {
                $collection->addOrder(
                    $sortOrder->getField(),
                    ($sortOrder->getDirection() == SortOrder::SORT_ASC) ? 'ASC' : 'DESC'
                );
            }
        }
        $collection->setCurPage($searchCriteria->getCurrentPage());
        $collection->setPageSize($searchCriteria->getPageSize());
        $objects = [];
        foreach ($collection as $objectModel) {
            $objects[] = $objectModel;
        }
        $searchResults->setItems($objects);
        return $searchResults;
    }
}
