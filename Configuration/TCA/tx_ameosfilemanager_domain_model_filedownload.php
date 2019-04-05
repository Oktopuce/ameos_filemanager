<?php
if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

$ll = 'LLL:EXT:ameos_filemanager/Resources/Private/Language/locallang_db.xlf:tx_ameosfilemanager_domain_model_filedownload';

$GLOBALS['TCA']['tx_ameosfilemanager_domain_model_filedownload'] = [
    'ctrl' => [
        'title'          => $ll,
        'label'          => 'file', 
        'tstamp'         => 'tstamp',
        'crdate'         => 'crdate',
        'cruser_id'      => 'cruser_id',
        'delete'         => 'deleted',
        'enablecolumns'  => ['disabled' => 'hidden'],
        'hideTable'      => true,
        'default_sortby' => 'ORDER BY crdate',
        'iconfile'       => ExtensionManagementUtility::extPath('ameos_filemanager') . 'ext_icon.png',
        'searchFields'   => 'file',
    ],    
    'types'       => ['0' => ['showitem' => 'file,crdate,cruser_id,']],
    'palettes'    => ['1' => ['showitem' => '']],
    'feInterface' => ['fe_admin_fieldList'  => 'file,crdate,cruser_id,'],
    'interface'   => ['showRecordFieldList' => 'file,crdate,cruser_id,'],
    'columns'     => [
        'hidden' => [        
            'exclude' => 1,
            'label'   => 'LLL:EXT:lang/locallang_general.xlf:LGL.hidden',
            'config'  => [
                'type'    => 'check',
                'default' => '0'
            ]
        ],
        'crdate' => [
            'exclude' => 0, 
            'label'   => 'LLL:EXT:lang/locallang_general.xlf:LGL.crdate',
            'config'  => [
                'type' => 'input',
            ]
        ],
        'user_download' => [
            'exclude' => 0,
            'label'   => 'LLL:EXT:lang/locallang_general.xlf:LGL.be_user',
            'config'  => [
                'type'                => 'select',
                'size'                => 5,
                'maxitems'            => 1,
                'foreign_table'       => 'be_user',
                'foreign_table_where' => 'ORDER BY be_user.uid'
            ]
        ],
        'file' => [
            'exclude' => 0,
            'label'   => $ll . '.file',
            'config'  => [
                'type'                => 'select',
                'foreign_table'       => 'sys_file_reference',
                'foreign_table_where' => 'ORDER BY sys_file_reference.title'
            ]
        ]
    ],
];
