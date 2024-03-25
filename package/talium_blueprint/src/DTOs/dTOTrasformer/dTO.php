<?php

namespace TaliumBlueprint\DTOs\dTOTrasformer;

class dTO
{
    public function __construct(public $data = null)
    {
    }


    public function toModel($model = null)
    {
        return $this->trasFromException(function () use ($model) {
            return !empty($model) ? new $model() : $this->data;
        });
    }


    public function toArray($array)
    {
        return $this->trasFromException(function () use ($array) {
            return collect($this->data)->toArray();
        });
    }

    public function message($message)
    {
        return [
            'message' => $message,
            'data' => $this->data
        ];
    }

    public function trasFromException(callable $callback)
    {
        try {
            return $callback();
        } catch (\Exception $e) {
            return $this->message($e->getMessage());
        }
    }
}
