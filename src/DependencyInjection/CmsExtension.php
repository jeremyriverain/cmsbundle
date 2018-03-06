<?php

namespace Geekco\CmsBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\Config\FileLocator;

class CmsExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
		$loader = new YamlFileLoader($container, new FileLocator(dirname(__DIR__).'/Resources/config'));
		$loader->load('services.yaml');

        $configuration = new Configuration();

        $config = $this->processConfiguration($configuration, $configs);

        $container->setParameter( 'cms.user_namespace', $config[ 'user_namespace' ]);
        $container->setParameter( 'cms.userType_namespace', $config[ 'userType_namespace' ]);
        $container->setParameter( 'cms.image_directory', $config[ 'image_directory' ]);
        $container->setParameter( 'cms.image_directory_relative_path', $config[ 'image_directory_relative_path' ]);

    }
}
