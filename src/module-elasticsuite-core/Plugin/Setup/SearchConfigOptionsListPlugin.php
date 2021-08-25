<?php
/*
 * @package      Webcode_elasticsuite
 *
 * @author       Kostadin Bashev (bashev@webcode.bg)
 * @copyright    Copyright © 2021 Webcode Ltd. (https://webcode.bg/)
 * @license      See LICENSE.txt for license details.
 */
namespace Smile\ElasticsuiteCore\Plugin\Setup;

/**
 * Search Config options plugin. Used to add Elasticsuite as authorized engine.
 *
 * @category Smile
 * @package  Smile\ElasticsuiteCore
 * @author   Romain Ruaud <romain.ruaud@smile.fr>
 */
class SearchConfigOptionsListPlugin
{
    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     *
     * @param \Magento\Setup\Model\SearchConfigOptionsList $subject Search Config Options List
     * @param array                                        $result  Search Result Configuration
     *
     * @return array
     */
    public function afterGetAvailableSearchEngineList(\Magento\Setup\Model\SearchConfigOptionsList $subject, $result)
    {
        if (!is_array($result)) {
            $result = [];
        }

        return array_merge($result, ['elasticsuite' => 'Smile Elastic Suite']);
    }
}
