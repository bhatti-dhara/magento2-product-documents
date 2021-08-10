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

namespace Mage2\ProductDocs\Block\Documents;

use Magento\Framework\View\Element\Template;
use Magento\Framework\Registry;
use Mage2\ProductDocs\Model\ResourceModel\Documents\CollectionFactory;

/**
 * Class Download
 */
class Download extends Template
{
    /**
     * Mage2 documents upload directory path
     */
    const DOCUMENT_PATH = 'mage2/documents/';

    /**
     * @var Registry
     */
    protected $registry;

    /**
     * @var CollectionFactory
     */
    protected $documentsCollectionFactory;

    /**
     * Download constructor.
     *
     * @param Template\Context $context
     * @param Registry $registry
     * @param CollectionFactory $documentsCollectionFactory
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        Registry $registry,
        CollectionFactory $documentsCollectionFactory,
        array $data = []
    ) {
        $this->registry = $registry;
        $this->documentsCollectionFactory = $documentsCollectionFactory;
        parent::__construct($context, $data);
    }

    /**
     * Get product documents collection
     *
     * @return \Mage2\ProductDocs\Model\ResourceModel\Documents\Collection
     */
    public function getDocumentsData()
    {
        $currentProductId = $this->getCurrentProductId();
        $storeId = $this->getStoreId();

        $collection = $this->documentsCollectionFactory->create();
        $collection->addFieldToFilter('product_ids', ['finset' => $currentProductId]);
        $collection->addFieldToFilter(
            'store_ids',
            [
                ['eq' => 0],
                ['finset' => $storeId]
            ]
        );
        $collection->setOrder('sort_order', 'ASC');

        return $collection;
    }

    /**
     * Get current product entity id
     *
     * @return int
     */
    public function getCurrentProductId()
    {
        $currentProduct = $this->registry->registry('current_product');
        return $currentProduct->getId();
    }

    /**
     * Get current store id
     *
     * @return int
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getStoreId()
    {
        return $this->_storeManager->getStore()->getId();
    }

    /**
     * Get Mage2 Documents uploaded directory url
     *
     * @return string
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getDocumentsMediaPath()
    {
        $mediaPath = $this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
        $documentPath = $mediaPath . self::DOCUMENT_PATH;
        return $documentPath;
    }
}
