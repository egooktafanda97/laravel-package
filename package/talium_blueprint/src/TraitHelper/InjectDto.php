<?php

namespace TaliumBlueprint\TraitHelper;

use Illuminate\Validation\ValidationException;
use ReflectionClass;
use ReflectionProperty;
use WendellAdriel\ValidatedDTO\Attributes\Rules;

trait InjectDto
{


    /**
     * override failedValidation
     * @return void
     * @throws ValidationException
     * @see ValidationException
     * @see failedValidation
     * @see Illuminate\Validation\ValidationException
     */
    protected function failedValidation(): void
    {
        if (in_array('api', request()->route()->gatherMiddleware())) {
            $response = response()->json([
                'success' => false,
                'message' => 'Ops! Some errors occurred',
                'errors' => $this->validator->errors()
            ], 422);
        } else {
            $response = redirect()
                ->route('guest.login')
                ->with('message', 'Ops! Some errors occurred')
                ->withErrors($this->validator);
        }
        throw (new ValidationException($this->validator, $response))
            ->errorBag($this->errorBag)
            ->redirectTo($this->redirectTo);
    }


    protected function defaults(): array
    {
        return [];
    }

    protected function casts(): array
    {
        return [];
    }

    public function toRequest()
    {
        dd($this->buildDataForExport());
    }

    public function getRules()
    {
        $reflectionClass = new ReflectionClass($this);
        $dtoProperties = [];
        foreach ($reflectionClass->getProperties(ReflectionProperty::IS_PUBLIC) as $property) {
            if ($this->isforbiddenProperty($property->getName())) {
                continue;
            }

            $reflectionProperty = new ReflectionProperty($this, $property->getName());
            $attributes = $reflectionProperty->getAttributes();
            $dtoProperties[$property->getName()] = $attributes;
        }
        $validatedProperties = $this->getPropertiesForAttribute($dtoProperties, Rules::class);
        foreach ($validatedProperties as $property => $attribute) {
            $attributeInstance = $attribute->newInstance();
            $this->dtoRules[$property] = $attributeInstance->rules;
            $this->dtoMessages[$property] = $attributeInstance->messages ?? [];
        }
        return $this->dtoRules;
    }

    private function isforbiddenProperty(string $property): bool
    {
        return in_array($property, [
            'data',
            'validatedData',
            'requireCasting',
            'validator',
            'dtoRules',
            'dtoMessages',
            'dtoDefaults',
            'dtoCasts',
            'dtoMapData',
            'dtoMapTransform',
        ]);
    }

    private function getPropertiesForAttribute(array $properties, string $attribute): array
    {
        $result = [];
        foreach ($properties as $property => $attributes) {
            foreach ($attributes as $attr) {
                if ($attr->getName() === $attribute) {
                    $result[$property] = $attr;
                }
            }
        }

        return $result;
    }
}
