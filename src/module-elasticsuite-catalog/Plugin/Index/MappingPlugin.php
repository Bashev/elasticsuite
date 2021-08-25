<?php
/*
 * @package      Webcode_elasticsuite
 *
 * @author       Kostadin Bashev (bashev@webcode.bg)
 * @copyright    Copyright © 2021 Webcode Ltd. (https://webcode.bg/)
 * @license      See LICENSE.txt for license details.
 */

namespace Smile\ElasticsuiteCatalog\Plugin\Index;

use Smile\ElasticsuiteCore\Index\Mapping;

/**
 * Mapping Plugin.
 * Used to add a copy_to for category names.
 *
 * @category Smile
 * @package  Smile\ElasticsuiteCatalog
 * @author   Romain Ruaud <romain.ruaud@smile.fr>
 */
class MappingPlugin
{
    /**
     * Collector field for products category names.
     */
    public const CATEGORY_NAME_FIELD = '_category_name';

    /**
     * Add a copy_to from "category.name" to "_category_name".
     * This is due to the fact that "category.name" being nested cannot be use directly in fulltext queries.
     *
     * @param Mapping $subject Index Mapping
     * @param array   $result  Mapping properties
     *
     * @return array
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function afterGetProperties(Mapping $subject, array $result): array
    {
        if (isset($result['category']['properties']['name']['copy_to'])) {
            $result['category']['properties']['name']['copy_to'][] = self::CATEGORY_NAME_FIELD;
        }

        return $result;
    }
}
