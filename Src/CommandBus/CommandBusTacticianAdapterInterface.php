<?php
/**
 * Created by PhpStorm.
 * User: thalesmartins
 * Date: 22/11/2018
 * Time: 13:09
 */

namespace GrupoCoqueiro\CommandBus;


use Psr\Container\ContainerInterface;

/**
 * Interface CommandBusTacticianAdapterInterface
 * @package GrupoCoqueiro\CommandBus
 */
interface CommandBusTacticianAdapterInterface
{
    /**
     * CommandBusTacticianAdapterInterface constructor.
     * @param MappingInterface $mapping
     * @param ContainerInterface $container
     */
    public function __construct(MappingInterface $mapping, ContainerInterface $container);

    /**
     * @param $command
     * @return mixed
     */
    public function handle($command);
}