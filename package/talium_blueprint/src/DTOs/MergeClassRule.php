<?php

namespace TaliumBlueprint\DTOs;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use TaliumBlueprint\Attributes\MergeDTOsDI;
use TaliumBlueprint\Handler\ArgumentAttribute\HandlerArgumentAttribute;
use TaliumBlueprint\Request\FormRequests;
use Illuminate\Support\Facades\Validator;

class MergeFromClassRule
{
    use \TaliumBlueprint\Traits\UseAttributeParameter;
    use ValidatesRequests;

    private $arg = [];
    protected $customRules;

    private $valid = [];

    public function __construct()
    {
        $this->useAttributes();
        $mergeAttribute = $this->argumetAttribute(MergeDTOsDI::class)->getValue();
        if (is_array($mergeAttribute)) {
            foreach ($mergeAttribute as $attribute) {
                $this->arg[$attribute] = (new $attribute())->rules();
            }
        }
        foreach ($this->arg as $ky => $rules) {
            try {
                $requests = new Request(request()->all());
                $validated = Validator::make($requests->all(), $rules);
                if ($validated->fails()) {
                    throw new ValidationException($validated);
                }
                $this->valid[$ky] =  $validated->validate();
            } catch (ValidationException $e) {
                if (in_array('api', request()->route()->gatherMiddleware())) {
                    $response = response()->json([
                        'success' => false,
                        'message' => 'Ops! Some errors occurred',
                        'errors' => $e->validator->errors()
                    ]);
                } else {
                    $response = redirect()
                        ->back()
                        ->with('message', 'Ops! Some errors occurred')
                        ->withErrors($e->validator);
                }
                throw (new ValidationException($e->validator, $response));
            }
        }
    }

    public function getData()
    {
        return $this->valid;
    }
}
