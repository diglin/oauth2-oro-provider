<?php
/**
 * Diglin GmbH - Switzerland.
 *
 * @author      Sylvain Rayé <support at diglin.com>
 * @category    OAuth2OroBundle
 * @copyright   2020 - Diglin (https://www.diglin.com)
 */
declare(strict_types=1);

namespace Diglin\OAuth2OroBundle\Api\Endpoints;

interface EndpointInterface
{
    public function getEndpoint(): string;
}
