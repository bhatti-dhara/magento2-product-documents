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
use Magento\Backend\Model\View\Result\ForwardFactory;
use Magento\Framework\App\Action\HttpGetActionInterface;

/**
 * Class NewAction
 */
class NewAction extends Action implements HttpGetActionInterface
{
    /**
     * @var ForwardFactory
     */
    protected $forwardFactory;

    /**
     * NewAction constructor.
     *
     * @param Action\Context $context
     * @param ForwardFactory $forwardFactory
     */
    public function __construct(
        Action\Context $context,
        ForwardFactory $forwardFactory
    ) {
        parent::__construct($context);
        $this->forwardFactory = $forwardFactory;
    }

    /**
     * @return \Magento\Backend\Model\View\Result\Forward|\Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $resultForward = $this->forwardFactory->create();
        return $resultForward->forward('edit');
    }
}
