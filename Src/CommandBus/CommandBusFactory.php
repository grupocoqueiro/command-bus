<?php
/**
 * Created by PhpStorm.
 * User: thalesmartins
 * Date: 22/11/2018
 * Time: 14:58
 */

namespace GrupoCoqueiro\CommandBus;


use GrupoCoqueiro\CommandBus\Adapter\CommandBusTacticianAdapter;
use Psr\Container\ContainerInterface;

/**
 * Class CommandBusFactory
 * @package GrupoCoqueiro\CommandBus
 */
class CommandBusFactory
{

    /**
     * @param MappingInterface $mapping
     * @param ContainerInterface $container
     * @return CommandBusTacticianAdapter
     */
    public function __invoke(MappingInterface $mapping, ContainerInterface $container)
    {
        return new CommandBusTacticianAdapter($mapping, $container);
    }
}