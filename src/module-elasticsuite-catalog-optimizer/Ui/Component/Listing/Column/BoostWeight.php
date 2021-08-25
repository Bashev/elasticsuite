<?php
/*
 * @package      Webcode_elasticsuite
 *
 * @author       Kostadin Bashev (bashev@webcode.bg)
 * @copyright    Copyright © 2021 Webcode Ltd. (https://webcode.bg/)
 * @license      See LICENSE.txt for license details.
 */
namespace Smile\ElasticsuiteCatalogOptimizer\Ui\Component\Listing\Column;

use Magento\Framework\Serialize\SerializerInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;

/**
 * Optimizers Boost Weight Column for Ui Component
 *
 * @category Smile
 * @package  Smile\ElasticsuiteCatalogOptimizer
 * @author   Pierre GAUTHIER <pigau@smile.fr>
 */
class BoostWeight extends Column
{
    /**
     * Serializer
     *
     * @var SerializerInterface
     */
    protected $serializer;

    /**
     * @param ContextInterface    $context            Context.
     * @param UiComponentFactory  $uiComponentFactory UI Component factory.
     * @param SerializerInterface $serializer         Serializer.
     * @param array               $components         Components.
     * @param array               $data               Data.
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        SerializerInterface $serializer,
        array $components = [],
        array $data = []
    ) {
        $this->serializer = $serializer;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * Prepare Data Source
     *
     * @param array $dataSource Data source.
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as &$item) {
                $config = $this->serializer->unserialize($item['config']);
                $value  = $config['constant_score_value'] ? ($config['constant_score_value'] . '%') : '';
                $item[$this->getData('name')] = $value;
            }
        }

        return $dataSource;
    }
}
