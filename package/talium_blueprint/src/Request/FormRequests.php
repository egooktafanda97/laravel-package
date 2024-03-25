<?php

namespace TaliumBlueprint\Request;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;
use TaliumBlueprint\Attributes\MergeDTOsDI;
use TaliumBlueprint\Handler\ArgumentAttribute\HandlerArgumentAttribute;

class FormRequests extends FormRequest
{

    public function __construct(protected $customRules)
    {
    }

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return  $this->customRules;
    }

    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        if (in_array('api', request()->route()->gatherMiddleware())) {
            $response = response()->json([
                'success' => false,
                'message' => 'Ops! Some errors occurred',
                'errors' => $validator->errors()
            ]);
        } else {
            $response = redirect()
                ->back()
                ->with('message', 'Ops! Some errors occurred')
                ->withErrors($validator);
        }

        throw (new ValidationException($validator, $response))
            ->errorBag($this->errorBag)
            ->redirectTo($this->getRedirectUrl());
    }
}
