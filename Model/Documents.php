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
use Magento\Framework\Model\AbstractModel;

/**
 * Class Documents
 */
class Documents extends AbstractModel implements DocumentsInterface
{
    const CACHE_TAG = 'product_documents';

    /**
     * @var string
     */
    protected $_cacheTag = self::CACHE_TAG;

    /**
     * @var string
     */
    protected $_eventPrefix = 'mage2_productdocs';

    /**
     * @var string
     */
    protected $_idFieldName = self::DOCUMENT_ID;

    /**
     * Get product document identifier
     *
     * @return int
     */
    public function getId()
    {
        return $this->getData(self::DOCUMENT_ID);
    }

    /**
     * Set product document identifier
     *
     * @param int $id
     * @return $this
     */
    public function setId($id)
    {
        return $this->setData(self::DOCUMENT_ID, $id);
    }

    /**
     * Get document label or title
     *
     * @return string
     */
    public function getDocumentLabel()
    {
        return $this->getData(self::DOCUMENT_LABEL);
    }

    /**
     * Set document label or title
     *
     * @param string $label
     * @return $this
     */
    public function setDocumentLabel($label)
    {
        return $this->setData(self::DOCUMENT_LABEL, $label);
    }

    /**
     * Get product document file name
     *
     * @return string
     */
    public function getFileName()
    {
        return $this->getData(self::FILE_NAME);
    }

    /**
     * Set product document file name
     *
     * @param $filename
     * @return $this
     */
    public function setFileName($filename)
    {
        return $this->setData(self::FILE_NAME, $filename);
    }

    /**
     * Get product ids associated to product document
     *
     * @return string|null
     */
    public function getProductIds()
    {
        return $this->getData(self::PRODUCT_IDS);
    }

    /**
     * Set product ids associated to product document
     *
     * @param string $productIds
     * @return $this
     */
    public function setProductIds($productIds)
    {
        return $this->setData(self::PRODUCT_IDS, $productIds);
    }

    /**
     * Get store ids
     *
     * @return \Magento\Store\Api\Data\StoreInterface[]|null
     */
    public function getStoreIds()
    {
        return $this->getData(self::STORE_IDS);
    }

    /**
     * Set store ids
     *
     * @param \Magento\Store\Api\Data\StoreInterface[] $storeIds
     * @return $this
     */
    public function setStoreIds($storeIds)
    {
        return $this->setData(self::STORE_IDS, $storeIds);
    }

    /**
     * Get position
     *
     * @return int
     */
    public function getSortOrder()
    {
        return $this->getData(self::SORT_ORDER);
    }

    /**
     * Set position
     *
     * @param $sortOrder
     * @return $this
     */
    public function setSortOrder($sortOrder)
    {
        return $this->setData(self::SORT_ORDER, $sortOrder);
    }

    /**
     * Get document created time
     *
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->getData(self::CREATED_AT);
    }

    /**
     * Set document created time
     *
     * @param $createdAt
     * @return $this
     */
    public function setCreatedAt($createdAt)
    {
        return $this->setData(self::CREATED_AT, $createdAt);
    }

    /**
     * Model construct that should be used for object initialization
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(\Mage2\ProductDocs\Model\ResourceModel\Documents::class);
    }
}
