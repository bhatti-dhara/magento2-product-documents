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

namespace Mage2\ProductDocs\Block\Adminhtml;

use Magento\Backend\Block\Template;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Serialize\Serializer\Json;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\Framework\View\Element\BlockInterface;
use Mage2\ProductDocs\Api\DocumentsRepositoryInterface;
use Mage2\ProductDocs\Block\Adminhtml\Tab\ProductGrid;
use Mage2\ProductDocs\Model\DocumentsFactory;

/**
 * Class AssignProducts
 */
class AssignProducts extends Template
{
    /**
     * @var string
     */
    protected $_template = 'products/assign_products.phtml';

    /**
     * @var \Magento\Framework\View\LayoutInterface
     */
    protected $blockGrid;

    /**
     * @var Json
     */
    protected $jsonEncoder;

    /**
     * @var CollectionFactory
     */
    protected $productCollectionFactory;

    /**
     * @var DocumentsRepositoryInterface
     */
    protected $documentsRepository;

    /**
     * @var DocumentsFactory
     */
    protected $documentsFactory;

    /**
     * AssignProducts constructor.
     *
     * @param Template\Context $context
     * @param Json $jsonEncoder
     * @param CollectionFactory $productCollectionFactory
     * @param DocumentsRepositoryInterface $documentsRepository
     * @param DocumentsFactory $documentsFactory
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        Json $jsonEncoder,
        CollectionFactory $productCollectionFactory,
        DocumentsRepositoryInterface $documentsRepository,
        DocumentsFactory $documentsFactory,
        array $data = []
    ) {
        $this->jsonEncoder = $jsonEncoder;
        $this->productCollectionFactory = $productCollectionFactory;
        $this->documentsRepository = $documentsRepository;
        $this->documentsFactory = $documentsFactory;
        parent::__construct($context, $data);
    }

    /**
     * Get product block grid
     *
     * @return ProductGrid|BlockInterface|\Magento\Framework\View\LayoutInterface
     * @throws \Magento\Framework\Exception\LocalizedExceptions
     */
    public function getBlockGrid()
    {
        if (null === $this->blockGrid) {
            $this->blockGrid = $this->getLayout()->createBlock(ProductGrid::class, 'category.product.grid');
        }

        return $this->blockGrid;
    }

    /**
     * Get product grid HTML content
     *
     * @return string
     */
    public function getGridHtml()
    {
        return $this->getBlockGrid()->toHtml();
    }

    /**
     * Get product data in JSON format
     *
     * @return string
     */
    public function getProductsJson()
    {
        $id = $this->getRequest()->getParam('id');

        try {
            $model = $this->documentsRepository->getById((int)$id);
        } catch (NoSuchEntityException $e) {
            $model = $this->documentsFactory->create();
        }

        $productFactory = $this->productCollectionFactory->create();
        $productFactory->addFieldToSelect('product_id')
            ->addFieldToSelect('position')
            ->addFieldToFilter('entity_id', ['in' => $model->getProductIds()]);

        $result = [];
        if (!empty($productFactory->getData())) {
            foreach ($productFactory->getData() as $rhProducts) {
                $result[$rhProducts['entity_id']] = '';
            }
            return $this->jsonEncoder->serialize($result);
        }

        return '{}';
    }
}
