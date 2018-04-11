<?php

declare(strict_types=1);

namespace Chubbyphp\Lazy;

use Psr\Container\ContainerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface as Input;
use Symfony\Component\Console\Output\OutputInterface as Output;

final class LazyCommand extends Command
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @var string
     */
    private $serviceId;

    /**
     * @param ContainerInterface $container
     * @param string             $serviceId
     * @param string             $name
     * @param array              $definition
     * @param string|null        $description
     * @param string|null        $help
     */
    public function __construct(
        ContainerInterface $container,
        string $serviceId,
        string $name,
        array $definition = [],
        string $description = null,
        string $help = null
    ) {
        parent::__construct($name);

        $this->container = $container;
        $this->serviceId = $serviceId;

        $this->setDefinition($definition);
        $this->setDescription($description);
        $this->setHelp($help);
    }

    /**
     * @param Input  $input
     * @param Output $output
     *
     * @return int|null
     */
    protected function execute(Input $input, Output $output)
    {
        $command = $this->container->get($this->serviceId);

        return $command($input, $output);
    }
}
