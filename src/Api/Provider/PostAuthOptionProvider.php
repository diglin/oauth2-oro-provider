<?php
/**
 * Diglin GmbH - Switzerland.
 *
 * @author      Sylvain Rayé <support at diglin.com>
 * @category    OAuth2OroBundle
 * @copyright   2020 - Diglin (https://www.diglin.com)
 */
declare(strict_types=1);

namespace Diglin\OAuth2OroBundle\Api\Provider;

use League\OAuth2\Client\OptionProvider\PostAuthOptionProvider as LeaguePostAuthOptionProvider;
use League\OAuth2\Client\Provider\AbstractProvider;

class PostAuthOptionProvider extends LeaguePostAuthOptionProvider
{
    public function getAccessTokenOptions($method, array $params): array
    {
        $options = [];

        if ($method === AbstractProvider::METHOD_POST) {
            $options['body'] = $this->getAccessTokenBody($params);
        }

        $options = array_merge($options, [
            'headers' =>
                [
                    'Content-Length' => \mb_strlen($options['body']),
                ],
        ]);

        return $options;
    }

    protected function buildQueryString(array $params): string
    {
        return \json_encode($params);
    }
}
