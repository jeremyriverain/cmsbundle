<?php
namespace Geekco\CmsBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{

    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('cms');

        $rootNode
            ->children()
            ->scalarNode('user_namespace')->isRequired()->cannotBeEmpty()->end()
            ->scalarNode('userType_namespace')->isRequired()->cannotBeEmpty()->end()
            ->scalarNode('image_directory')->isRequired()->cannotBeEmpty()->end()
            ->scalarNode('image_directory_relative_path')->isRequired()->cannotBeEmpty()->end()
            ->end()
            ;

        return $treeBuilder;
    }
}
