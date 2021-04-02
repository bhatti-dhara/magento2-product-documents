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

namespace Mage2\ProductDocs\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Mage2\ProductDocs\Api\Data\DocumentsInterface;
use Mage2\ProductDocs\Api\Data\DocumentsSearchResultsInterface;

/**
 * Interface DocumentsRepositoryInterface
 */
interface DocumentsRepositoryInterface
{
    /**
     * Save product document
     *
     * @param DocumentsInterface $document
     * @return DocumentsInterface
     * @throws CouldNotSaveException
     * @throws NoSuchEntityException
     */
    public function save(DocumentsInterface $document);

    /**
     * Get product document by document identifier
     *
     * @param int $documentId
     * @return DocumentsInterface
     * @throws NoSuchEntityException
     */
    public function getById($documentId);

    /**
     * Delete product document
     *
     * @param DocumentsInterface $document
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function delete(DocumentsInterface $document);

    /**
     * Delete product document by given document identifier
     *
     * @param int $documentId
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function deleteById($documentId);

    /**
     * Get product documents matching the specified criteria
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @return DocumentsSearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria);
}
