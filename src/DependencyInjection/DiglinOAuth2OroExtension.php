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

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\ConfigurableExtension;

class DiglinOAuth2OroExtension extends ConfigurableExtension
{
    const ALIAS = 'diglin_oauth2_oro';

    public function loadInternal(array $mergedConfig, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yml');

        $container->getDefinition('diglin_oauth2_oro.api.client_settings')->replaceArgument(0, $mergedConfig['api']['url']);
        $container->getDefinition('diglin_oauth2_oro.api.client_settings')->replaceArgument(1, $mergedConfig['api']['client_id']);
        $container->getDefinition('diglin_oauth2_oro.api.client_settings')->replaceArgument(2, $mergedConfig['api']['client_secret']);
        $container->getDefinition('diglin_oauth2_oro.api.client_settings')->replaceArgument(3, $mergedConfig['api']['grant_type']);
        $container->getDefinition('diglin_oauth2_oro.api.client_settings')->replaceArgument(4, $mergedConfig['api']['username']);
        $container->getDefinition('diglin_oauth2_oro.api.client_settings')->replaceArgument(5, $mergedConfig['api']['password']);
    }

    public function getAlias()
    {
        return self::ALIAS;
    }
}
