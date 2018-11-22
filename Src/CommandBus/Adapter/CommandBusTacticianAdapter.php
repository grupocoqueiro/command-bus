<?php
/**
 * Created by PhpStorm.
 * User: thalesmartins
 * Date: 22/11/2018
 * Time: 12:49
 */

namespace GrupoCoqueiro\CommandBus\Adapter;


use GrupoCoqueiro\CommandBus\MappingInterface;
use League\Tactician\CommandBus;
use League\Tactician\Container\ContainerLocator;
use League\Tactician\Handler\CommandHandlerMiddleware;
use League\Tactician\Handler\CommandNameExtractor\ClassNameExtractor;
use League\Tactician\Handler\MethodNameInflector\HandleInflector;
use Psr\Container\ContainerInterface;

/**
 * Class CommandBusTacticianAdapter
 * @package GrupoCoqueiro\CommandBus\Adapter
 */
class CommandBusTacticianAdapter extends CommandBus implements CommandBusTacticianAdapterInterface
{

    /**
     * CommandBusTacticianAdapter constructor.
     * @param MappingInterface $mapping
     * @param ContainerInterface $container
     */
    public function __construct(MappingInterface $mapping, ContainerInterface $container)
    {
        $handlerMiddleware = new CommandHandlerMiddleware(
            new ClassNameExtractor(),
            new ContainerLocator($container, $mapping()),
            new HandleInflector()
        );
        parent::__construct([$handlerMiddleware]);
    }
}