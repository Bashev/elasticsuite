<?php
/*
 * @package      Webcode_elasticsuite
 *
 * @author       Kostadin Bashev (bashev@webcode.bg)
 * @copyright    Copyright © 2021 Webcode Ltd. (https://webcode.bg/)
 * @license      See LICENSE.txt for license details.
 */

namespace Smile\ElasticsuiteCore\Setup;

use Magento\Search\Model\SearchEngine\ValidatorInterface;
use Smile\ElasticsuiteCore\Api\Client\ClientConfigurationInterface;
use Smile\ElasticsuiteCore\Api\Client\ClientInterface;

/**
 * Elasticsuite configuration validator
 *
 * @category Smile
 * @package  Smile\ElasticsuiteCore
 * @author   Romain Ruaud <romain.ruaud@smile.fr>
 */
class Validator implements ValidatorInterface
{
    /**
     * Validator constructor.
     *
     * @param \Smile\ElasticsuiteCore\Api\Client\ClientInterface $client ES Client (injected as proxy in DI).
     */
    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * {@inheritDoc}
     */
    public function validate(): array
    {
        $errors = [];

        try {
            $this->client->info();
        } catch (\Exception $e) {
            $errors[] = "ElasticSuite : Unable to validate connection to Elasticsearch server : {$e->getMessage()}";
        }

        return $errors;
    }
}
