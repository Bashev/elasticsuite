<?php
/*
 * @package      Webcode_elasticsuite
 *
 * @author       Kostadin Bashev (bashev@webcode.bg)
 * @copyright    Copyright © 2021 Webcode Ltd. (https://webcode.bg/)
 * @license      See LICENSE.txt for license details.
 */
namespace Smile\ElasticsuiteCatalogOptimizer\Ui\DataProvider;

use Magento\Framework\App\ResourceConnection;
use Magento\Framework\Data\Collection;
use Magento\Ui\DataProvider\AddFieldToCollectionInterface;
use Magento\Ui\DataProvider\AddFilterToCollectionInterface;
use Zend_Db_Expr as DbExpr;

/**
 * Add request type field and filter to collection
 *
 * @category Smile
 * @package  Smile\ElasticsuiteCatalogOptimizer
 * @author   Pierre Gauthier <pierre.gauthier@smile.fr>
 */
class SearchContainerFieldManager implements AddFieldToCollectionInterface, AddFilterToCollectionInterface
{
    /** @var ResourceConnection */
    private $resource;

    /**
     * AddSearchContainerFieldToCollection constructor.
     * @param ResourceConnection $resource Resource connection.
     */
    public function __construct(ResourceConnection $resource)
    {
        $this->resource = $resource;
    }

    /**
     * {@inheritdoc}
     */
    public function addField(Collection $collection, $field, $alias = null)
    {
        $collection
            ->join(
                ['search_container' => $this->resource->getTableName('smile_elasticsuite_optimizer_search_container')],
                'search_container.optimizer_id = main_table.optimizer_id',
                [$field => new DbExpr("GROUP_CONCAT(search_container.$field)")]
            )
            ->getSelect()
            ->group('main_table.optimizer_id');
    }

    /**
     * {@inheritdoc}
     */
    public function addFilter(Collection $collection, $field, $condition = null)
    {
        // We need to rejoin the table smile_elasticsuite_optimizer_search_container to filter in order to display all
        // the search container in grid and not only the ones we are filtering on.
        if (isset($condition['in'])) {
            $tableName = $this->resource->getTableName('smile_elasticsuite_optimizer_search_container');
            $collection
                ->join(
                    ['search_container_filter' => $tableName],
                    'search_container_filter.optimizer_id = main_table.optimizer_id',
                    []
                )
                ->getSelect()
                ->where("search_container_filter.$field in (?)", $condition['in']);
        }
    }
}
