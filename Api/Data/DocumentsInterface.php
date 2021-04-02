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

namespace Mage2\ProductDocs\Api\Data;

/**
 * Interface DocumentsInterface
 */
interface DocumentsInterface
{
    /**
     * Product Documents columns constants
     */
    const DOCUMENT_ID    = 'document_id';
    const DOCUMENT_LABEL = 'document_label';
    const FILE_NAME     = 'file_name';
    const PRODUCT_IDS    = 'product_ids';
    const STORE_IDS      = 'store_ids';
    const SORT_ORDER     = 'sort_order';
    const CREATED_AT     = 'created_at';

    /**
     * Get product document identifier
     *
     * @return int
     */
    public function getId();

    /**
     * Set product document identifier
     *
     * @param int $id
     * @return $this
     */
    public function setId($id);

    /**
     * Get document label or title
     *
     * @return string
     */
    public function getDocumentLabel();

    /**
     * Set document label or title
     *
     * @param string $label
     * @return $this
     */
    public function setDocumentLabel($label);

    /**
     * Get product document file name
     *
     * @return string
     */
    public function getFileName();

    /**
     * Set product document file name
     *
     * @param $filename
     * @return $this
     */
    public function setFileName($filename);

    /**
     * Get product ids associated to product document
     *
     * @return string|null
     */
    public function getProductIds();

    /**
     * Set product ids associated to product document
     *
     * @param string $productIds
     * @return $this
     */
    public function setProductIds($productIds);

    /**
     * Get store ids
     *
     * @return \Magento\Store\Api\Data\StoreInterface[]|null
     */
    public function getStoreIds();

    /**
     * Set store ids
     *
     * @param \Magento\Store\Api\Data\StoreInterface[] $storeIds
     * @return $this
     */
    public function setStoreIds($storeIds);

    /**
     * Get position
     *
     * @return int
     */
    public function getSortOrder();

    /**
     * Set position
     *
     * @param $sortOrder
     * @return $this
     */
    public function setSortOrder($sortOrder);

    /**
     * Get document created time
     *
     * @return mixed
     */
    public function getCreatedAt();

    /**
     * Set document created time
     *
     * @param $createdAt
     * @return $this
     */
    public function setCreatedAt($createdAt);
}
