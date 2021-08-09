<?php

namespace GrupoCoqueiro\CommandBus;

use Exception;
use GrupoCoqueiro\CommandBus\CommandBusAdapter;
use GrupoCoqueiro\CommandBus\Exceptions\CommandBusException;
use GrupoCoqueiro\CommandBus\MappingInterface;
use Psr\Container\ContainerInterface;

/**
 * @covers CoqueiroCommandBusTest
 */
class CoqueiroCommandBus
{
    /**
     * @var MappingInterface
     */
    private $mapping;

    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @param MappingInterface $mapping
     * @param ContainerInterface $container
     */
    public function __construct(MappingInterface $mapping, ContainerInterface $container)
    {
        $this->mapping = $mapping;
        $this->container = $container;
    }

    /**
     * @param $command
     * @return mixed
     * @throws CommandBusException
     */
    public function handle($command)
    {
        $handler = $this->resolvCommand(get_class($command));
        $instance = $this->resolvHandler($handler);

        return $instance->handle($command);
    }

    /**
     * @param string $command
     * @return string
     * @throws CommandBusException
     */
    private function resolvCommand(string $command): string
    {
        $mapping = call_user_func($this->mapping);

        if (!array_key_exists($command, $mapping)) {
            CommandBusException::handlerNaoEncontrada($command);
        }

        if (!class_exists($mapping[$command])) {
            CommandBusException::handlerRegistradaNaoExiste($command);
        }

        return $mapping[$command];
    }

    /**
     * @param string $handler
     * @return mixed
     * @throws CommandBusException
     */
    private function resolvHandler(string $handler)
    {
        $instancia = $this->container->get($handler);

        if (!method_exists($handler, 'handle')) {
            CommandBusException::handlerNaoPossuiMetodoHandle($handler);
        }

        return $instancia;
    }
}