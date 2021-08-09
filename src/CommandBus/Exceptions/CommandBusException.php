<?php

namespace GrupoCoqueiro\CommandBus\Exceptions;

use Exception;

class CommandBusException extends Exception
{
    /**
     * @param string|null $command
     * @throws CommandBusException
     */
    public static function handlerNaoEncontrada(?string $command = null): void
    {
        throw new self("Handler não encontrada para a command '$command'.", 1);
    }

    /**
     * @param string|null $command
     * @throws CommandBusException
     */
    public static function handlerRegistradaNaoExiste(?string $command = null): void
    {
        throw new self("A handler registrada para a command '$command' não foi encontrada.", 2);
    }

    /**
     * @param string|null $handler
     * @throws CommandBusException
     */
    public static function handlerNaoPossuiMetodoHandle(?string $handler = null): void
    {
        throw new self("A classe '$handler' não possui o método 'handle'.", 3);
    }
}