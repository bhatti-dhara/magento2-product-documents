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

namespace Mage2\ProductDocs\Setup\Patch\Data;

use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Filesystem\Io\File;
use Magento\Framework\App\Filesystem\DirectoryList;

/**
 * Class AddDocumentsDirectory
 */
class AddDocumentsDirectory implements DataPatchInterface
{
    /**
     * @var ModuleDataSetupInterface
     */
    private $moduleDataSetup;

    /**
     * @var File
     */
    private $io;

    /**
     * @var DirectoryList
     */
    private $directoryList;

    /**
     * AddDocumentsDirectory constructor.
     *
     * @param ModuleDataSetupInterface $moduleDataSetup
     * @param File $io
     * @param DirectoryList $directoryList
     */
    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        File $io,
        DirectoryList $directoryList
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->io = $io;
        $this->directoryList = $directoryList;
    }

    /**
     * Adding mage2 product documents directory in pub/media directory
     *
     * @return AddDocumentsDirectory|void
     * @throws \Magento\Framework\Exception\FileSystemException
     */
    public function apply()
    {
        $this->moduleDataSetup->getConnection()->startSetup();

        $this->io->mkdir($this->directoryList->getPath('media') . '/mage2/documents', 0755);

        $this->moduleDataSetup->getConnection()->endSetup();
    }

    /**
     * @return array
     */
    public function getAliases()
    {
        return [];
    }

    /**
     * @return array
     */
    public static function getDependencies()
    {
        return [];
    }
}
