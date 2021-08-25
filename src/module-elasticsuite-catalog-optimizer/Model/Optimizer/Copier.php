<?php
/*
 * @package      Webcode_elasticsuite
 *
 * @author       Kostadin Bashev (bashev@webcode.bg)
 * @copyright    Copyright © 2021 Webcode Ltd. (https://webcode.bg/)
 * @license      See LICENSE.txt for license details.
 */
namespace Smile\ElasticsuiteCatalogOptimizer\Model\Optimizer;

use Magento\Ui\DataProvider\Modifier\PoolInterface;
use Smile\ElasticsuiteCatalogOptimizer\Api\Data\OptimizerInterface;
use Smile\ElasticsuiteCatalogOptimizer\Api\Data\OptimizerInterfaceFactory;
use Smile\ElasticsuiteCatalogOptimizer\Model\Optimizer;

/**
 * Optimizer copier.
 *
 * @category Smile
 * @package  Smile\ElasticsuiteCatalogOptimizer
 * @author   Dmytro ANDROSHCHUK <dmand@smile.fr>
 */
class Copier
{
    /**
     * Optimizer Factory
     *
     * @var OptimizerInterfaceFactory
     */
    protected $optimizerFactory;

    /**
     * @var PoolInterface
     */
    private $modifierPool;

    /**
     * @param OptimizerInterfaceFactory $optimizerFactory Optimizer Factory.
     * @param PoolInterface             $modifierPool     Modifiers Pool.
     */
    public function __construct(
        OptimizerInterfaceFactory $optimizerFactory,
        PoolInterface $modifierPool
    ) {
        $this->optimizerFactory = $optimizerFactory;
        $this->modifierPool = $modifierPool;
    }

    /**
     * Create optimizer duplicate
     *
     * @param OptimizerInterface $optimizer Optimizer model.
     *
     * @return OptimizerInterface
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    public function copy(OptimizerInterface $optimizer): OptimizerInterface
    {
        $optimizerData = [$optimizer->getId() => $optimizer->getData()];
        foreach ($this->modifierPool->getModifiersInstances() as $modifier) {
            $optimizerData = $modifier->modifyData($optimizerData);
        }
        $optimizerData = array_shift($optimizerData);
        /** @var Optimizer $duplicate */
        $duplicate = $this->optimizerFactory->create();
        $duplicate->setData($optimizerData);
        if ($fromDate = \DateTime::createFromFormat('Y-m-d', $optimizerData['from_date'])) {
            // Warning: user locale dependent.
            $duplicate->setFromDate($fromDate->format('m/d/Y'));
        }
        if ($toDate = \DateTime::createFromFormat('Y-m-d', $optimizerData['to_date'])) {
            // Warning: user locale dependent.
            $duplicate->setToDate($toDate->format('m/d/Y'));
        }
        $duplicate->setId(null);

        return $duplicate;
    }
}
