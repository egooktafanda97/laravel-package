<?php

namespace TaliumBlueprint\DTOs\dTOTrasformer;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;
use TaliumAttributes\Collection\Models\Rules;
use TaliumBlueprint\Abstracts\DTOsClass;

class dTOValidate extends FormRequest
{
    use \TaliumBlueprint\Traits\UseAttributeParameter;

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $dtoClass = $this->argumetAttribute(DTOsClass::class)->getValue();
        return (new $dtoClass)->getRules() ?? [];
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
