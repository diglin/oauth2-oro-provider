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

interface ClientOAuthSettingsInterface
{
    public function getUrl(): string;
    public function getGrantType(): string;
    public function getClientId(): string;
    public function getClientSecret(): string;
    public function getUsername(): string;
    public function getPassword(): string;
}
