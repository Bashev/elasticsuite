/*
 * @package      Webcode_elasticsuite
 *
 * @author       Kostadin Bashev (bashev@webcode.bg)
 * @copyright    Copyright © 2021 Webcode Ltd. (https://webcode.bg/)
 * @license      See LICENSE.txt for license details.
 */

define(['jquery', 'mage/cookies'], function ($) {
    return function(config) {
        return config.cookieRestrictionEnabled == false || $.mage.cookies.get(config.cookieRestrictionName) !== null;
    };
});
