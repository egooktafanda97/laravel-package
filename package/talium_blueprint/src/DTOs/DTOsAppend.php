<?php

namespace TaliumBlueprint\DTOs;

use ReflectionClass;
use ReflectionProperty;
use TaliumBlueprint\TraitHelper\InjectDto;
use WendellAdriel\ValidatedDTO\Attributes\Rules;
use WendellAdriel\ValidatedDTO\Concerns\EmptyRules;
use WendellAdriel\ValidatedDTO\ValidatedDTO;

class DTOsAppend extends ValidatedDTO
{
    use InjectDto;
    use EmptyRules;
    private $class = null;
    public function getRules($class)
    {
        $this->class = $class;
        $reflectionClass = new ReflectionClass($class);

        $dtoProperties = [];
        foreach ($reflectionClass->getProperties(ReflectionProperty::IS_PUBLIC) as $property) {
            if ($this->isforbiddenProperty($property->getName())) {
                continue;
            }

            $reflectionProperty = new ReflectionProperty($class, $property->getName());
            $attributes = $reflectionProperty->getAttributes();
            $dtoProperties[$property->getName()] = $attributes;
        }

        $validatedProperties = $this->getPropertiesForAttribute($dtoProperties, Rules::class);
        foreach ($validatedProperties as $property => $attribute) {
            $attributeInstance = $attribute->newInstance();
            $this->dtoRules[$property] = $attributeInstance->rules;
            $this->dtoMessages[$property] = $attributeInstance->messages ?? [];
        }

        return  $this->dtoRules;
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
