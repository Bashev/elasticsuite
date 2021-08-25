<?php
/*
 * @package      Webcode_elasticsuite
 *
 * @author       Kostadin Bashev (bashev@webcode.bg)
 * @copyright    Copyright © 2021 Webcode Ltd. (https://webcode.bg/)
 * @license      See LICENSE.txt for license details.
 */

namespace Smile\ElasticsuiteCatalog\Model\Category\Indexer\Fulltext\Datasource;

use Smile\ElasticsuiteCatalog\Model\Eav\Indexer\Fulltext\Datasource\AbstractAttributeData;
use Smile\ElasticsuiteCore\Api\Index\DatasourceInterface;
use Smile\ElasticsuiteCore\Api\Index\Mapping\DynamicFieldProviderInterface;

/**
 * Datasource used to index product attributes.
 * This class is also used to generate attribute mapping since it implements DynamicFieldProviderInterface.
 *
 * @category Smile
 * @package  Smile\ElasticsuiteCatalog
 * @author   Aurelien FOUCRET <aurelien.foucret@smile.fr>
 */
class AttributeData extends AbstractAttributeData implements DatasourceInterface, DynamicFieldProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function addData($storeId, array $indexData)
    {
        $categoryIds   = array_keys($indexData);

        foreach ($this->attributeIdsByTable as $backendTable => $attributeIds) {
            $attributesData = $this->loadAttributesRawData($storeId, $categoryIds, $backendTable, $attributeIds);
            foreach ($attributesData as $row) {
                $productId = (int) $row['entity_id'];

                $indexValues = $this->attributeHelper->prepareIndexValue(
                    $row['attribute_id'],
                    $storeId,
                    $row['value']
                );

                $indexData[$productId] = array_replace($indexData[$productId], $indexValues);
            }
        }

        return $indexData;
    }
}
