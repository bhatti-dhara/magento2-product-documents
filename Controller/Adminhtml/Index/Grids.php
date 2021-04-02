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

namespace Mage2\ProductDocs\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\Result\RawFactory;
use Magento\Framework\View\LayoutFactory;

/**
 * Class Grids
 */
class Grids extends Action implements HttpPostActionInterface, HttpGetActionInterface
{
    /**
     * @var RawFactory
     */
    protected $rawFactory;

    /**
     * @var LayoutFactory
     */
    protected $layoutFactory;

    /**
     * Grids constructor.
     *
     * @param Action\Context $context
     * @param RawFactory $rawFactory
     * @param LayoutFactory $layoutFactory
     */
    public function __construct(
        Action\Context $context,
        RawFactory $rawFactory,
        LayoutFactory $layoutFactory
    ) {
        parent::__construct($context);
        $this->rawFactory = $rawFactory;
        $this->layoutFactory = $layoutFactory;
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\Result\Raw|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $resultRaw = $this->rawFactory->create();

        return $resultRaw->setContents(
            $this->layoutFactory->create()->createBlock(
                'Mage2\ProductDocs\Block\Adminhtml\Tab\ProductGrid',
                'rh.custom.tab.productgrid'
            )->toHtml()
        );
    }
}
