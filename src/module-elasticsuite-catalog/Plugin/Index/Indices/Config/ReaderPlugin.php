<?php
/*
 * @package      Webcode_elasticsuite
 *
 * @author       Kostadin Bashev (bashev@webcode.bg)
 * @copyright    Copyright © 2021 Webcode Ltd. (https://webcode.bg/)
 * @license      See LICENSE.txt for license details.
 */

namespace Smile\ElasticsuiteCatalog\Plugin\Index\Indices\Config;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Smile\ElasticsuiteCatalog\Plugin\Index\MappingPlugin;
use Smile\ElasticsuiteCore\Api\Index\Mapping\FieldInterface;
use Smile\ElasticsuiteCore\Index\Indices\Config\Reader;

/**
 * Indices Config Plugin.
 * Used to init category name weight at the lowes level possible (so that it can goes to the cache after).
 *
 * @category Smile
 * @package  Smile\ElasticsuiteCatalog
 * @author   Romain Ruaud <romain.ruaud@smile.fr>
 */
class ReaderPlugin
{
    /**
     * @var string The location of the parameter
     */
    const XML_CATEGORY_NAME_WEIGHT = 'smile_elasticsuite_catalogsearch_settings/catalogsearch/category_name_weight';

    /**
     * ConfigPlugin constructor.
     *
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig Store Configuration
     */
    public function __construct(ScopeConfigInterface $scopeConfig)
    {
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * Inject the collector field after reading the initial XML files.
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     *
     * @param \Smile\ElasticsuiteCore\Index\Indices\Config\Reader $subject The indices config reader
     * @param array                                               $config  The config read from XML file
     *
     * @return array
     */
    public function afterRead(Reader $subject, array $config)
    {
        $categoryNameWeight = $this->scopeConfig->getValue(self::XML_CATEGORY_NAME_WEIGHT);

        if (isset($config['catalog_product']['types']['product']['mapping']['staticFields']['category.name'])) {
            $fieldConfig = $config['catalog_product']['types']['product']['mapping']['staticFields']['category.name']['fieldConfig'] ?? [];
            if (isset($fieldConfig['is_searchable']) && ((bool) $fieldConfig['is_searchable'] === true)) {
                $fieldConfig['search_weight'] = (int) $categoryNameWeight;
                $config['catalog_product']['types']['product']['mapping']['staticFields'][MappingPlugin::CATEGORY_NAME_FIELD] = [
                    'fieldConfig' => $fieldConfig,
                    'type'        => FieldInterface::FIELD_TYPE_TEXT,
                ];
            }
        }

        return $config;
    }
}
