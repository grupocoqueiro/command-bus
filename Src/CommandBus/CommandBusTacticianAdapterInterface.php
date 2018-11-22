<?php
/**
 * Created by PhpStorm.
 * User: thalesmartins
 * Date: 22/11/2018
 * Time: 13:09
 */

namespace GrupoCoqueiro\CommandBus;


use Psr\Container\ContainerInterface;

interface CommandBusTacticianAdapterInterface
{
    public function __construct(MappingInterface $mapping, ContainerInterface $container);

    public function handle($command);
}