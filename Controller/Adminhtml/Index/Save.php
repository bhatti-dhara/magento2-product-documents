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
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Serialize\Serializer\Json;
use Mage2\ProductDocs\Model\DocumentsFactory;
use Mage2\ProductDocs\Model\DocumentsRepository;

/**
 * Class Save
 */
class Save extends Action implements HttpPostActionInterface
{
    /**
     * @var DocumentsFactory
     */
    protected $documentsFactory;

    /**
     * @var DocumentsRepository
     */
    protected $documentsRepository;

    /**
     * @var Json
     */
    protected $json;

    /**
     * Save constructor.
     *
     * @param Action\Context $context
     * @param Json $json
     * @param DocumentsFactory $documentsFactory
     * @param DocumentsRepository $documentsRepository
     */
    public function __construct(
        Action\Context $context,
        Json $json,
        DocumentsFactory $documentsFactory,
        DocumentsRepository $documentsRepository
    ) {
        $this->json = $json;
        $this->documentsFactory = $documentsFactory;
        $this->documentsRepository = $documentsRepository;
        parent::__construct($context);
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\Result\Redirect|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();

        if ($data) {
            $id = (int) $data['document_id'];

            try {
                $inputFilter = new \Zend_Filter_Input([], [], $data);
                $data = $inputFilter->getUnescaped();

                if ($id) {
                    $model = $this->documentsRepository->getById((int)$id);

                } else {
                    $model = $this->documentsFactory->create();
                    $data['document_id'] = null;
                }

                $this->prepareData($data);

                $model->addData($data);

                $this->_getSession()->setPageData($data);
                $this->documentsRepository->save($model);

                $this->getMessageManager()->addSuccessMessage(__('You saved the item.'));
                $this->_getSession()->setPageData(false);

                return $this->processBlockReturn($model, $data, $resultRedirect);
            } catch (\Exception $e) {
                $this->getMessageManager()->addErrorMessage(
                    __($e->getMessage())
                );
                $this->_getSession()->setPageData($data);

                return $resultRedirect->setPath('*/*/edit', ['id' => $id]);
            }
        }

        return $resultRedirect->setPath('documents/*/');
    }

    private function prepareData(array &$data): void
    {
        if (isset($data['store_ids']) && !empty($data['store_ids'])) {
            $data['store_ids'] = implode(',', $data['store_ids']);
        }

        if (isset($data['rh_products']) && !empty($data['rh_products'])) {
            $products = $this->json->unserialize($data['rh_products']);
            $data['product_ids'] = implode(',', array_keys($products));
        }
    }

    private function processBlockReturn($model, $data, $resultRedirect)
    {
        $redirect = $data['back'] ?? 'close';

        if ($redirect === 'continue') {
            $resultRedirect->setPath('*/*/edit', ['id' => $model->getId()]);
        } elseif ($redirect === 'close') {
            $resultRedirect->setPath('*/*/');
        } elseif ($redirect === 'duplicate') {
            $duplicateModel = $this->documentsFactory->create(['data' => $data]);
            $duplicateModel->setId(null);
            $this->documentsRepository->save($duplicateModel);
            $id = $duplicateModel->getId();
            $this->messageManager->addSuccessMessage(__('You duplicated the banner.'));
            $this->_getSession()->setPageData($data);
            $resultRedirect->setPath('*/*/edit', ['id' => $id]);
        }
        return $resultRedirect;
    }
}
