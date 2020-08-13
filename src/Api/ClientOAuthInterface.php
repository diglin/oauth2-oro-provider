<?php
/**
 * Diglin GmbH - Switzerland.
 *
 * @author      Sylvain Rayé <support at diglin.com>
 * @category    OAuth2Oro
 * @copyright   2020 - Diglin (https://www.diglin.com)
 */
declare(strict_types=1);

namespace Diglin\OAuth2Oro\Client\Api;

interface ClientOAuthInterface
{
    const REQUEST_POST  = 'post';
    const REQUEST_GET   = 'get';
    const REQUEST_PUT   = 'put';
    const REQUEST_PATCH = 'patch';
    const REQUEST_DELETE = 'delete';

    public function init(ClientOAuthSettings $config): void;
    public function request(string $method = self::REQUEST_GET, string $url = '', array $options = []);
}
