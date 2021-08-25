<?php
/*
 * @package      Webcode_elasticsuite
 *
 * @author       Kostadin Bashev (bashev@webcode.bg)
 * @copyright    Copyright © 2021 Webcode Ltd. (https://webcode.bg/)
 * @license      See LICENSE.txt for license details.
 */

namespace Smile\ElasticsuiteCatalogGraphQl\Model\Layer\Filter\ViewMore;

/**
 * ViewMore context. Used as a singleton to pass filter name to the aggregation modifier.
 *
 * @category Smile
 * @package  Smile\ElasticsuiteCatalogGraphQl
 * @author   Romain Ruaud <romain.ruaud@smile.fr>
 */
class Context
{
    /**
     * @var null|string
     */
    private $filterName = null;

    /**
     * @param string $filterName The filter name
     */
    public function setFilterName(string $filterName)
    {
        $this->filterName = $filterName;
    }

    /**
     * Get filter name
     *
     * @return string|null
     */
    public function getFilterName()
    {
        return $this->filterName;
    }
}
