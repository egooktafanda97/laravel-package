<?php

namespace TaliumBlueprint\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;
use Illuminate\Support\Facades\DB;
use TaliumBlueprint\DTOs\dTOTrasformer\dTO;
use TaliumBlueprint\Exception\QueryException;

class Eloquent
{
    protected $model;
    protected $response;

    protected function catchErrors(callable $callback)
    {
        try {
            return $callback();
        } catch (ModelNotFoundException $e) {
            $this->failedQuery("model not found");
        } catch (Exception $e) {
            $this->failedQuery($e->getMessage());
        }
    }

    public function all()
    {
        return $this->catchErrors(function () {
            return new dTO($this->model::all());
        });
    }

    public function find($id)
    {
        return $this->catchErrors(function () use ($id) {
            return new dTO($this->model::find($id));
        });
    }

    public function create($data)
    {
        return $this->catchErrors(function () use ($data) {
            return new dTO($this->model::create($data));
        });
    }

    public function update($id, $data)
    {
        return $this->catchErrors(function () use ($id, $data) {
            $record = $this->model::findOrFail($id);
            $record->update($data);
            return new dTO($record);
        });
    }

    public function delete($id)
    {
        return $this->catchErrors(function () use ($id) {
            $record = $this->model::findOrFail($id);
            $record->delete();
            return new dTO($record);
        });
    }

    public function failedQuery(string $message)
    {
        throw (new QueryException())->failedQuery($message);
    }


    public function dbTransaction(callable $callback)
    {
        return $this->catchErrors(function () use ($callback) {
            DB::beginTransaction();
            try {
                $response = $callback();
                DB::commit();
                return $response;
            } catch (Exception $e) {
                DB::rollBack();
                $this->failedQuery($e->getMessage());
            }
        });
    }
}
