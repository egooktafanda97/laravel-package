<?php

namespace TaliumBlueprint\Config;

use Illuminate\Support\Facades\Config as FacadesConfig;

class BlueprintSetting
{
    public function __construct(public $config = [])
    {
    }

    public static function lang_blueprint_settring()
    {
        return "talium";
    }

    public static function model_register($class, $reg)
    {
        $configs = FacadesConfig::get("blueprint")['blueprint'];
        $conf = $configs['output_path']['model'];
        $arg = $reg;
        unset($arg['class']);
        unset($arg['namespace']);
        $d = [
            "class" => $reg['class'] == "<<Class>>" ? $class : $reg['class'] ?? null,
            "namespace" => $conf["namespace"] ?? null,
            "path" => $conf["path"] ?? null,
            ...$arg
        ];
        return array_filter($d, function ($value) {
            return !is_null($value);
        });
    }

    public static function controller_register($class, $reg)
    {
        $configs = FacadesConfig::get("blueprint")['blueprint'];
        $conf = $configs['output_path']['controller'];
        $arg = $reg;
        unset($arg['class']);
        unset($arg['namespace']);
        $d = [
            "class" => $reg['class'] == "<<Class>>" ? $class."Controller" : $reg['class'] ?? null,
            "namespace" => $conf["namespace"] ?? null,
            "path" => $conf["path"] ?? null,
            ...$arg
        ];
        return array_filter($d, function ($value) {
            return !is_null($value);
        });
    }

    public static function data_transfer_object_register($class, $reg)
    {
        $configs = FacadesConfig::get("blueprint")['blueprint'];
        $conf = $configs['output_path']['dto'];
        $arg = $reg;
        unset($arg['class']);
        unset($arg['namespace']);
        $d = [
            "class" => $reg['class'] == "<<Class>>" ? $class."Dto" : $reg['class'] ?? null,
            "namespace" => $conf["namespace"] ?? null,
            "path" => $conf["path"] ?? null,
            ...$arg
        ];
        return array_filter($d, function ($value) {
            return !is_null($value);
        });
//        $configs = FacadesConfig::get("blueprint")['blueprint'];
//        $conf = $configs['output_path']['data_transfer_object'];
//        $arg = $reg;
//        unset($arg['class']);
    }
}
