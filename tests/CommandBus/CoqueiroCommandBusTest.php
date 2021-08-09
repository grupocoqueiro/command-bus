<?php

namespace Test\CommandBus;

use GrupoCoqueiro\CommandBus\Exceptions\CommandBusException;
use GrupoCoqueiro\CommandBus\MappingInterface;
use GrupoCoqueiro\CommandBus\CoqueiroCommandBus;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use ReflectionException;
use ReflectionMethod;

/**
 * Class SimpleCommandBusTest
 * @package Test\CommandBus
 * @coversDefaultClass \GrupoCoqueiro\CommandBus\CoqueiroCommandBus
 */
class CoqueiroCommandBusTest extends TestCase
{
    /**
     * @test
     * @covers ::resolvCommand
     * @throws ReflectionException
     */
    public function deve_retornar_FQN_da_handler_registrada_para_a_command()
    {
        $mapping = $this->createMock(MappingInterface::class);
        $mapping->method('__invoke')->willReturn([
            Command::class => Handler::class
        ]);

        $container = $this->createMock(ContainerInterface::class);

        $coqueiroCommandBus = new CoqueiroCommandBus($mapping, $container);

        $rfxResolvCommand = new ReflectionMethod($coqueiroCommandBus, 'resolvCommand');
        $rfxResolvCommand->setAccessible(true);
        $fqnHandler = $rfxResolvCommand->invoke($coqueiroCommandBus, Command::class);

        $this->assertEquals(Handler::class, $fqnHandler);
    }

    /**
     * @test
     * @covers ::resolvCommand
     * @throws ReflectionException
     */
    public function deve_lancar_CommandBusException_quando_nao_encontrar_registro_da_command()
    {
        $mapping = $this->createMock(MappingInterface::class);
        $mapping->method('__invoke')->willReturn([]);

        $container = $this->createMock(ContainerInterface::class);

        $this->expectException(CommandBusException::class);
        $this->expectExceptionCode(1);

        $coqueiroCommandBus = new CoqueiroCommandBus($mapping, $container);

        $rfxResolvCommand = new ReflectionMethod($coqueiroCommandBus, 'resolvCommand');
        $rfxResolvCommand->setAccessible(true);
        $rfxResolvCommand->invoke($coqueiroCommandBus, Command::class);
    }

    /**
     * @test
     * @covers ::resolvCommand
     * @throws ReflectionException
     */
    public function deve_lancar_CommandBusException_quando_handler_registrada_nao_for_uma_classe_existente()
    {
        $mapping = $this->createMock(MappingInterface::class);
        $mapping->method('__invoke')->willReturn([
            Command::class => 'Handler\\QueNao\\Existe'
        ]);

        $container = $this->createMock(ContainerInterface::class);

        $this->expectException(CommandBusException::class);
        $this->expectExceptionCode(2);

        $coqueiroCommandBus = new CoqueiroCommandBus($mapping, $container);

        $rfxResolvCommand = new ReflectionMethod($coqueiroCommandBus, 'resolvCommand');
        $rfxResolvCommand->setAccessible(true);
        $rfxResolvCommand->invoke($coqueiroCommandBus, Command::class);
    }

    /**
     * @test
     * @covers ::resolvHandler
     * @throws ReflectionException
     */
    public function deve_retornar_uma_instancia_da_handler_registrada_para_a_command()
    {
        $mapping = $this->createMock(MappingInterface::class);

        $container = $this->createMock(ContainerInterface::class);
        $container->method('get')->with(Handler::class)->willReturn(new Handler());

        $coqueiroCommandBus = new CoqueiroCommandBus($mapping, $container);

        $rfxResolvHandler = new ReflectionMethod($coqueiroCommandBus, 'resolvHandler');
        $rfxResolvHandler->setAccessible(true);
        $handler = $rfxResolvHandler->invoke($coqueiroCommandBus, Handler::class);

        $this->assertInstanceOf(Handler::class, $handler);
    }

    /**
     * @test
     * @covers ::resolvHandler
     * @throws ReflectionException
     */
    public function deve_lancar_CommandBusException_quando_a_handler_informada_nao_possuir_o_metodo_handle()
    {
        $mapping = $this->createMock(MappingInterface::class);
        $container = $this->createMock(ContainerInterface::class);

        $this->expectException(CommandBusException::class);
        $this->expectExceptionCode(3);

        $coqueiroCommandBus = new CoqueiroCommandBus($mapping, $container);

        $rfxResolvHandler = new ReflectionMethod($coqueiroCommandBus, 'resolvHandler');
        $rfxResolvHandler->setAccessible(true);
        $rfxResolvHandler->invoke($coqueiroCommandBus, HandlerSemHandle::class);
    }

    /**
     * @test
     * @covers ::handle
     * @throws CommandBusException
     */
    public function deve_retornar_o_mesmo_retorno_do_metodo_handle_da_class_Handler()
    {
        $mapping = $this->createMock(MappingInterface::class);
        $mapping->method('__invoke')->willReturn([
            Command::class => Handler::class
        ]);

        $container = $this->createMock(ContainerInterface::class);
        $container->method('get')->with(Handler::class)->willReturn(new Handler());

        $coqueiroCommandBus = new CoqueiroCommandBus($mapping, $container);
        $retornoCommandBus = $coqueiroCommandBus->handle(new Command());

        $retornoHandler = (new Handler())->handle();

        $this->assertEquals($retornoHandler, $retornoCommandBus);
    }
}

class Command {}
class Handler {
    public function handle(): bool { return true; }
}
class HandlerSemHandle {}
