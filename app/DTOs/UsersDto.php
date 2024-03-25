<?php

namespace App\DTOs;

use TaliumBlueprint\TraitHelper\InjectDto;
use WendellAdriel\ValidatedDTO\Attributes\Rules;
use WendellAdriel\ValidatedDTO\Concerns\EmptyRules;
use WendellAdriel\ValidatedDTO\ValidatedDTO;

class UsersDto extends ValidatedDTO
{
    use InjectDto;
    use EmptyRules;

    #[Rules(rules: ['required', 'string', 'max:255'])]
    public string $name;

    #[Rules(rules: ['required', 'string', 'email', 'max:255', 'unique:users'])]
    public string $email;

    #[Rules(rules: ['required', 'string', 'min:8'])]
    public string $password;
}
