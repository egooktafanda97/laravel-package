<?php

namespace TaliumBlueprint\TraitHelper;


use TaliumAttributes\Collection\Models\Table;
use TaliumAttributes\Services\ReflectionMeta;

trait InjectModel
{
    public function Iject()
    {
        if (method_exists($this, 'rules')) {
            $this->fillable = collect(self::rules())->keys()->toArray();
        }
        $getClass =  ReflectionMeta::getAttribute($this, Table::class);

        if (!empty($getClass->table))
            $this->table = $getClass->table;
    }
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->Iject();
    }
}
