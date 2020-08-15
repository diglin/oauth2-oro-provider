<?php
/**
 * Diglin GmbH - Switzerland.
 *
 * @author      Sylvain Rayé <support at diglin.com>
 * @category    OAuth2OroBundle
 * @copyright   2020 - Diglin (https://www.diglin.com)
 */
declare(strict_types=1);

namespace Diglin\OAuth2OroBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

final class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('diglin_oauth2_oro');
        $rootNode = $treeBuilder->getRootNode();

        $rootNode
            ->children()
            ->arrayNode('api')
            ->addDefaultsIfNotSet()
            ->children()
            ->scalarNode('url')
            ->info('Url of the Oro Application, without trailing slash')
            ->isRequired()
            ->cannotBeEmpty()
            ->end()
            ->scalarNode('client_id')
            ->info('Client ID: see documentation to get the value')
            ->isRequired()
            ->cannotBeEmpty()
            ->end()
            ->scalarNode('client_secret')
            ->info('Client secret: see documentation to get the value')
            ->isRequired()
            ->cannotBeEmpty()
            ->end()
            ->scalarNode('username')
            ->info('Username: required if grant_type = password')
            ->defaultNull()
            ->end()
            ->scalarNode('password')
            ->info('Password: required if grant_type = password')
            ->defaultNull()
            ->end()
            ->scalarNode('grant_type')
            ->info('grant_type possible values: client_credentials or password')
            ->defaultValue('client_credentials')
            ->isRequired()
            ->cannotBeEmpty()
            ->end()
            ->end()
            ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
