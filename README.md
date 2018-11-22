# CommandBus
Adaptador para o Command Bus da Tactician

## Instalação

Usando o composer:
`composer require grupocoqueiro/command-bus`

## Como utilizar

- Crie uma classe que implemente a `GrupoCoqueiro\CommandBus\MappingInterface`
- Utilize alguma classe que implemente a ``Psr\Container\ContainerInterface``

Exemplo:

```php
class Mapping implements MappingInterface
 {
     public function __invoke(): array
     {
         return [
            Command::class => CommandHandler::class
         ];
     }
 };
 
 $mapping = new Mapping();
 $container = new SomeImplementationContainerInterface();
 
 $commandBus = new CommandBusTacticianAdapter($mapping, $container);
 
 ...
 
 $commandBus->handle(new Command($something));
 
 
 ```