<?php

namespace Novatura\Laravel\MakeCommands\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Novatura\Laravel\Core\Utils\FileUtils;
use Novatura\Laravel\Support\GenerateStub;

class MantineTableCommand extends Command
{
    use FileUtils;

    protected $signature = 'novatura:make:table {--T|type= : A type inside resources/js/types to base the table off of}';
    protected $description = 'Create a Mantine React Table.';

    public function handle()
    {
        $type = $this->option('type');

        // Check if type exists (assume its passed as a relative path)
        if (!file_exists(base_path($type))) {
            // Not a relative path, maybe they just gave the type name
            if (file_exists(resource_path("js/types/$type.ts"))) {
                $type = resource_path("js/types/$type.ts");
            } else {
                $this->error("Type $type does not exist.");
                return;
            }
        } else {
            $type = base_path($type);
        }

        $this->makeTable(pathinfo($type, PATHINFO_FILENAME), $this->extractTypes($type));
    }

    public function makeTable(string $name, array $type)
    {
        $cols = array_reduce($type, function ($carry, $item) {

            $header = ucwords(str_replace('_', ' ', $item['name']));
            $accessorKey = $item['name'];

            $carry .= "        {\n";
            $carry .= "            header: \"$header\",\n";
            $carry .= "            accessorKey: \"$accessorKey\",\n";
            $carry .= "        },\n";

            return $carry;
        }, '');

        $contents = (new GenerateStub(__DIR__ . '/../stubs/MantineTable.tsx.stub', [
            'name' => $name,
            'fields' => $cols,
        ]))->generate();

        $path = resource_path("js/components/{$name}Table.tsx");

        if (file_exists($path)) {
            if (!$this->confirm("{$name}Table.tsx already exists. Overwrite?")) {
                $answer = $this->ask("Enter new name for the file, or leave blank to cancel");
                if (empty($answer)) {
                    $this->error("Aborting.");
                    return;
                } else {
                    $answer = ucwords($answer);
                    $path = resource_path("js/components/{$answer}Table.tsx");
                }
            }
        }

        file_put_contents($path, $contents);

        $this->info("Created table at $path.");
    }
}