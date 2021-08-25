<?php
/*
 * @package      Webcode_elasticsuite
 *
 * @author       Kostadin Bashev (bashev@webcode.bg)
 * @copyright    Copyright © 2021 Webcode Ltd. (https://webcode.bg/)
 * @license      See LICENSE.txt for license details.
 */

namespace Smile\ElasticsuiteCatalog\Model\Attribute\Source;

use Magento\Framework\Data\OptionSourceInterface;
use Smile\ElasticsuiteCore\Api\Index\Mapping\FieldInterface;

/**
 * Source model for multiple values combining logic/logical operator for filterable attributes in the layer navigation
 * (catalog and search) as well as in API requests, but NOT in catalog rules (virtual categories and search optimizers).
 *
 * @category Smile
 * @package  Smile\ElasticsuiteCatalog
 * @author   Richard Bayet <richard.bayet@smile.fr>
 */
class FilterBooleanLogic implements OptionSourceInterface
{
    /**
     * Return array of boolean logic operator.
     *
     * @return array
     */
    public function toOptionArray()
    {
        return [
            ['label' => __('Logical OR (default)'), 'value' => FieldInterface::FILTER_LOGICAL_OPERATOR_OR],
            ['label' => __('Logical AND'),          'value' => FieldInterface::FILTER_LOGICAL_OPERATOR_AND],
        ];
    }
}
