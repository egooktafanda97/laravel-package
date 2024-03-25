<?php

namespace TaliumBlueprint\Handler\LogixHandler;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Touhidurabir\StubGenerator\Facades\StubGenerator;
use Symfony\Component\Yaml\Yaml;
use TaliumBlueprint\Config\BlueprintSetting;
use TaliumBlueprint\Traits\FileSystem;
use TaliumBlueprint\Traits\HelperBlueprint;

class Model
{
    private $config = [];

    public function __construct(public $data)
    {
        $this->config = Config::get("blueprint")['blueprint'];
    }

    public function stubBuild()
    {
        $pathStub = __DIR__ . "/../../blueprint/Model.stub";

        if (File::exists($pathStub)) {
            $data = $this->data;
            if (!empty($data["talium-model"]) && $data["talium-model"] == true) {
                $data["use"] = "use TaliumAttributes\Collection\Models\Table;\nuse TaliumBlueprint\TraitHelper\InjectModel;\n
                ";
                if (empty($data["table"])) {
                    $tables = preg_replace_callback('/(?<!^)([A-Z])/', function ($matches) {
                        return '_' . strtolower($matches[1]);
                    }, $data['class']);
                    $tables = strtolower($tables);
                    $data["table"] = $tables;
                }
                $data["attribute-class"] = "#[Table('" . $data["table"] . "')]";
                $data["trait"] = "use InjectModel;";
                $data["table"] = "";
            } else {
                $data["table"] = 'potected $table="' . $data["table"] . '"';
            }
            if (!empty($data['scema']) && !empty($data['scema']['relationship'])) {
                $relationFunModel = [];
                foreach ($data['scema']['relationship'] as $keys => $items) {
                    $relasi_skema["fild"] = $keys;
                    $items = is_string($items) ? [$items] : $items;
                    $relasi_skema["nama_relasi"] = $items[0];
                    if (empty($items[1])) {
                        $stringTanpaUnderscore = ucwords($keys, "_");
                        $model = preg_replace('/(_Id)|(_)/', '', $stringTanpaUnderscore);
                        $table = preg_replace('/(_id)/', '', $keys);
                    }
                    if (empty($items[2])) {
                        $stringTanpaUnderscore = ucwords($keys, "_");
                        $model = preg_replace('/(_Id)|(_)/', '', $stringTanpaUnderscore);
                        $table = preg_replace('/(_id)/', '', $keys);
                    }

                    $relasi_skema["model"] = empty($items[1]) ? $model : $items[1];
                    $relasi_skema["table"] = empty($items[2]) ? $table : null;

                    if (!empty($items[2]))
                        $relasi_skema["table"] = $items[2];

                    if (!empty($items[3]))
                        $relasi_skema["primary_key"] = "id";

                    $relationFunModel[] = '
    /**
     * Relation method untuk ' . $relasi_skema['table'] . '
     *
     * @return \Illuminate\Database\Eloquent\Relations\\' . $relasi_skema['nama_relasi'] . '
     */
    public function ' . $relasi_skema['table'] . '()
    {
        return $this->' . $relasi_skema['nama_relasi'] . '(' . $relasi_skema['model'] . '::class, "' . $relasi_skema['fild'] . '", "id");
    }';
                    $data["use"] .= "\nuse " . $data['namespace'] . "\\" . $relasi_skema['model'] . ";";
                }
                $relationShip = implode("\n", $relationFunModel);
            }
            $stub = StubGenerator::from($pathStub, true)->withReplacers([
                "ModelNamespace" => $data['namespace'],
                "class" => $data['class'],
                "extends" => $data['extends'] ?? "Model",
                "fillable" => $data["scema"]['fields'] ?? [],
                "method" => $data["method"] ?? "",
                "use" => $data["use"] ?? "",
                "trait" => $data["trait"] ?? "",
                "attribute-class" => $data["attribute-class"] ?? "",
                "table" => $data["table"] ?? "",
                "relationship" => $relationShip ?? ""
            ])
                ->to($this->config['output_path']['model']['path']) // the store directory path
                ->as($data['class'])
                ->replace(true)
                ->save();
        }
    }
}
