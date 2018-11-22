<?php
/**
 * Created by PhpStorm.
 * User: thalesmartins
 * Date: 22/11/2018
 * Time: 15:02
 */

namespace Test\CommandBus\Adapter;


use GrupoCoqueiro\CommandBus\Adapter\CommandBusTacticianAdapter;
use GrupoCoqueiro\CommandBus\CommandBusFactory;
use GrupoCoqueiro\CommandBus\CommandBusTacticianAdapterInterface;
use GrupoCoqueiro\CommandBus\MappingInterface;
use League\Tactician\CommandBus;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;

class CommandBusFactoryTest extends TestCase
{
    /**
     * @test
     */
    public function should_create_new_instance_of_CommandBusTacticianAdapter_and_other_instances()
    {
        $mapping = new class implements MappingInterface
        {
            public function __invoke(): array
            {
                return [];
            }
        };
        $container = new class implements ContainerInterface
        {
            public function get($id)
            {
                return $id;
            }

            public function has($id)
            {
                return (bool)$this->get($id);
            }
        };

        $instance = new CommandBusFactory();

        $this->assertInstanceOf(CommandBusTacticianAdapter::class, $instance($mapping, $container));
        $this->assertInstanceOf(CommandBus::class, $instance($mapping, $container));
        $this->assertInstanceOf(CommandBusTacticianAdapterInterface::class, $instance($mapping, $container));
    }
}