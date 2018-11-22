<?php
/**
 * Created by PhpStorm.
 * User: thalesmartins
 * Date: 22/11/2018
 * Time: 13:10
 */

namespace GrupoCoqueiro\CommandBus;

/**
 * Interface MappingInterface
 * @package GrupoCoqueiro\CommandBus
 */
interface MappingInterface
{
    /**
     * @return array
     */
    public function __invoke(): array;
}