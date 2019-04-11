<?php
namespace Ameos\AmeosFilemanager\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Resource\StorageRepository;
use Ameos\AmeosFilemanager\Service\IndexationService;

/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

class IndexCommand extends Command
{

    /**
     * Configure the command by defining the name, options and arguments
     */
    public function configure()
    {
        $this
            ->setDescription('Index new directory from the command line.')
            ->setHelp('Call it like this: typo3/sysext/core/bin/typo3 filemanager:index --storage=1')
            ->addOption(
                'storage',
                's',
                InputOption::VALUE_REQUIRED,
                'UID of storage'
            );
    }

    /**
     * Execute scheduler tasks
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $objectManager = GeneralUtility::makeInstance(ObjectManager::class);

        if ((bool)$input->hasOption('storage') && (int)$input->getOption('storage') > 0) {
            $storageRepository = $objectManager->get(StorageRepository::class);
            $storage = $storageRepository->findByUid((int)$input->getOption('storage'));
        } else {
            $resourceFactory = \TYPO3\CMS\Core\Resource\ResourceFactory::getInstance();
            $storage = $resourceFactory->getDefaultStorage();
        }

        if ($storage) {
            $objectManager->get(IndexationService::class)->run($storage);
        }
    }
}