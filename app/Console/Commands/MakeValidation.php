<?php

namespace App\Console\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MakeValidation extends Command
{
    protected function configure()
    {
        $this
            ->setName('make:validation')
            ->setDescription('Create a new validation')
            ->addArgument('name', InputArgument::REQUIRED, 'The name of the validation');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $name = $input->getArgument('name');
        $path = __DIR__ . '/../../Validations/' . $name . '.php';

        if (file_exists($path)) {
            $output->writeln("<error>Validation {$name} already exists!</error>");
            return Command::FAILURE;
        }

        $stub = $this->getStub();
        $stub = str_replace('{{validationName}}', $name, $stub);

        if(!file_put_contents($path, $stub)){
            $output->writeln("<error>Failed to create validation {$name}!</error>");
            return Command::FAILURE;
        }

        $output->writeln("<info>Validation {$name} created successfully.</info>");
        return Command::SUCCESS;
    }

    protected function getStub()
    {
        return <<<EOT
<?php

namespace App\Validations;

use Rakit\Validation\Validator;

class {{validationName}} {
    
    protected \$validator;
    protected \$data;
    protected \$rules;
    protected \$messages;

    public function __construct(array \$data){
        \$this->validator = new Validator;
        \$this->data = \$data;
        \$this->rules = \$this->rules();
        \$this->messages = \$this->messages();
    }

    // Định nghĩa quy tắc xác thực
    public function rules(): array
    {
        return [
            'name' => 'required',
        ];
    }

    // Định nghĩa thông báo lỗi
    public function messages(): array
    {
        return [
            'name:required' => 'Tên không được để trống',
        ];        
    }

    // Phương thức validate chạy xác thực
    public function validate()
    {
        \$validation = \$this->validator->make(\$this->data, \$this->rules, \$this->messages);
        \$validation->validate();

        if (\$validation->fails()) {
            return \$validation->errors()->firstOfAll();
        }

        return true;
    }

}

EOT;
    }
}