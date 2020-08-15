<?php
/**
 * Diglin GmbH - Switzerland.
 *
 * @author      Sylvain Rayé <support at diglin.com>
 * @category    OAuth2OroBundle
 * @copyright   2020 - Diglin (https://www.diglin.com)
 */
declare(strict_types=1);

namespace Diglin\OAuth2OroBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @TODO WIP
 * ORM\Entity()
 */
class OroAccessToken
{
    private $clientId;
    private $accessToken;
    private $expire;
    private $tokenType;
}
