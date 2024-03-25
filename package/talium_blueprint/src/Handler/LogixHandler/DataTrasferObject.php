<?php

namespace TaliumBlueprint\Handler\LogixHandler;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Touhidurabir\StubGenerator\Facades\StubGenerator;

class DataTrasferObject
{
    private $config = [];

    public function __construct(public $data)
    {
        $this->config = Config::get("blueprint")['blueprint'];
    }

    public function stubBuild()
    {
        $pathStub = __DIR__ . "/../../blueprint/DataTransferObject.stub";

        if (File::exists($pathStub)) {
            $data = $this->data;
            $data_rules = $this->data['scema']['rules'] ?? [];
            $dto_data = $this->data['scema']['dto'] ?? [];
            $data_type = $this->data['scema']['type'] ?? [];
            $valid_message = $this->data['scema']['valid_message'] ?? [];
            $props = [];
            foreach ($dto_data as $data_scema => $main_scema) {
                $rules = $data_rules[$data_scema];
                if (is_string($data_rules[$data_scema])) {
                    $rulesArray = explode("|", $data_rules[$data_scema]);
                    $rules = array_map(function ($value) {
                        return "'" . $value . "'";
                    }, $rulesArray);
                    $rules = '[' . implode(",", $rules) . ']';
                }
                $messages = "";
                if (isset($valid_message[$data_scema])) {
                    $messages = ", messages:['$data_scema' => '{$valid_message[$data_scema]}']";
                }
                $props[] = "#[Rules(rules:{$rules}{$messages})]\npublic {$data_type[$data_scema]} \${$data_scema};\n";
            }
            $props = implode("\n", $props);
            $path = $this->config['output_path']['dto']['path'];
            if (!is_dir($path)) {
                // Jika tidak ada, buat direktori baru
                mkdir($path, 0755, true); // true menandakan bahwa direktori induk juga akan dibuat jika belum ada
            }
            $stub = StubGenerator::from($pathStub, true)->withReplacers([
                'namespace' => $data['namespace'],
                'class' => $data['class'],
                'DtoProperties' => $props,
                'DtoMethod' => ""
            ])
                ->to($path) // the store directory path
                ->as($data['class'])
                ->replace(true)
                ->save();
        }
    }
}
