<?php
/**
 * Created by PhpStorm.
 * User: thalesmartins
 * Date: 22/11/2018
 * Time: 13:10
 */

namespace GrupoCoqueiro\CommandBus;


interface MappingInterface
{
    public function __invoke(): array;
}