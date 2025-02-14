<?php

namespace App\Console\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MakeController extends Command
{
    protected function configure()
    {
        $this
            ->setName('make:controller')
            ->setDescription('Create a new controller')
            ->addArgument('name', InputArgument::REQUIRED, 'The name of the controller');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $name = $input->getArgument('name');
        $path = __DIR__ . '/../../Controllers/' . $name . '.php';

        if (file_exists($path)) {
            $output->writeln("<error>Controller {$name} already exists!</error>");
            return Command::FAILURE;
        }

        $stub = $this->getStub();
        $stub = str_replace('{{controllerName}}', $name, $stub);

        if (!file_put_contents($path, $stub)) {
            $output->writeln("<error>Failed to create controller {$name}.</error>");
            return Command::FAILURE;
        }

        $output->writeln("<info>Controller {$name} created successfully.</info>");
        return Command::SUCCESS;
    }

    protected function getStub()
    {
        return <<<EOT
<?php

namespace App\Controllers;
use Core\BaseController;

class {{controllerName}} extends BaseController
{
    //
}
EOT;
    }
}