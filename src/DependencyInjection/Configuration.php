<?php
namespace Geekco\CmsBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{

    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('geekco_cms');

        $rootNode
            ->children()
            ->scalarNode('targetDir')->isRequired()->cannotBeEmpty()->end()
            ->scalarNode('targetDir_relative')->isRequired()->cannotBeEmpty()->end()
            ->end()
            ;

        return $treeBuilder;
    }
}
