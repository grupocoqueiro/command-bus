<?php
/**
 * Created by PhpStorm.
 * User: thalesmartins
 * Date: 22/11/2018
 * Time: 15:33
 */

namespace GrupoCoqueiro\CommandBus;


use GrupoCoqueiro\CommandBus\Adapter\CommandBusTacticianAdapter;
use Psr\Container\ContainerInterface;

interface CommandBusAdpter
{

    /**
     * @param MappingInterface $mapping
     * @param ContainerInterface $container
     * @return CommandBusTacticianAdapter
     */
    public function __invoke(MappingInterface $mapping, ContainerInterface $container);

    /**
     * @param $command
     * @return mixed
     */
    public function handle($command);
}
