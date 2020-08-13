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

use League\OAuth2\Client\Provider\GenericProvider;

class OroClientProvider extends GenericProvider
{
    public function getDefaultHeaders(): array
    {
        return ['Content-Type' => 'application/vnd.api+json'];
    }
}
