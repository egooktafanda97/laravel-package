<?php

namespace TaliumBlueprint\Handler;

use Illuminate\Support\Facades\File;
use Symfony\Component\Yaml\Yaml;
use TaliumBlueprint\Config\BlueprintSetting;
use TaliumBlueprint\Console\AutoRun;
use TaliumBlueprint\Handler\LogixHandler\DataTrasferObject;
use TaliumBlueprint\Traits\FileSystem;
use TaliumBlueprint\Traits\HelperBlueprint;
use TaliumBlueprint\Handler\LogixHandler\Model;

class BladeComponentHandler
{
    use FileSystem;
    use HelperBlueprint;

    private $meta_data = [];
    private $meta_blueprint = [];

    public function __construct(public $filesName)
    {
    }

    public function main()
    {
        $blueprint = $this->blueprint_config()["blueprint"]["blueprint_path"] . $this->filesName;
        $thisBlueprint = Yaml::parseFile($blueprint);
        $conf = BlueprintSetting::lang_blueprint_settring();
        try {
            if ($conf == "talium") {
                foreach ($thisBlueprint as $enpoint => $blueprints) {
                    try {
                        $enpoint = $this->expoint($enpoint);
                        foreach ($blueprints as $names => $data) {
                            preg_match_all("/<<([^>>]+)>>/", $names, $matches);
                            if (!empty($matches[1])) {
                                try {
                                    $this->meta_blueprint[$enpoint[1]][$matches[1][0]] = $data;
                                } catch (\Throwable $th) {
                                    throw new \Exception($th->getMessage(), $names);
                                }
                            }
                        }
                    } catch (\Throwable $th) {
                        throw new \Exception($th->getMessage());
                    }
                }
            }
        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage());
        }
        return $this;
    }

    public function dump()
    {
        $data = $this->meta_blueprint;
        foreach ($data as $data_scema => $main_scema) {
            $modelClass = $data_scema;
            foreach ($main_scema as $key => $value) {
                if (method_exists($this, $key)) {
                    $this->$key($modelClass, $value);
                }
            }
        }
        return $this;
    }

    public function Schema($class, $data)
    {
        $rules = [];
        $relationship = [];
        $dto = [];
        $type = [];
        foreach ($data as $field => $inval) {
            $rules[$field] = $inval['rules'][0] ?? "nullable";
            if (isset($inval['relationship'])) {
                $relationship[$field] = $inval['relationship'];
            }
            if (isset($inval['dto'])) {
                $dto[$field] = $inval['dto'];
            }
            if (isset($inval['type'])) {
                $type[$field] = $inval['type'] ?? "string";
            }
            if (isset($inval['validation_error_message'])) {
                $valid_message[$field] = $inval['validation_error_message'] ?? "";
            }
        }

        $this->meta_data[$class]["Schema"] = [
            "fields" => collect($data)->keys()->toArray(),
            "rules" => $rules,
            "relationship" => $relationship,
            "dto" => $dto,
            "type" => $type,
            "valid_message" => $valid_message ?? []
        ];
    }

    public function Model($class, $data)
    {
        $data = array_merge($data, ["scema" => $this->meta_data[$class]["Schema"]]);
        $this->meta_data[$class]["model"] = BlueprintSetting::model_register($class, $data);
    }

    public function Controller($class, $data)
    {
        $this->meta_data[$class]["controller"] = BlueprintSetting::controller_register($class, $data);
    }

    public function Service()
    {

    }

    public function Dto($class, $data)
    {
        $data = array_merge($data, ["scema" => $this->meta_data[$class]["Schema"]]);
        $this->meta_data[$class]["Dto"] = BlueprintSetting::data_transfer_object_register($class, $data);
    }

    public function loadBlueprint($files)
    {
    }

    public function publish()
    {
        $meta = $this->meta_data;
        foreach ($meta as $clases => $value) {
            (new AutoRun())->repositoryServices($clases);
            if (is_array($value)) {
                foreach ($value as $it => $item) {
                    if ($it == "model") {
                        $classHandler = new Model($item);
                        $classHandler->stubBuild();
                    }
                    if ($it == "Dto") {
                        $classHandler = new DataTrasferObject($item);
                        $classHandler->stubBuild();
                    }
                }
            }
        }
    }
}
