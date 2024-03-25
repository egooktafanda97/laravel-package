<?php

namespace App\DTOs;

use TaliumBlueprint\TraitHelper\InjectDto;
use WendellAdriel\ValidatedDTO\Attributes\Rules;
use WendellAdriel\ValidatedDTO\Concerns\EmptyRules;
use WendellAdriel\ValidatedDTO\ValidatedDTO;

class PersonDto extends ValidatedDTO
{
    use InjectDto;
    use EmptyRules;

    public function __construct(?array $data = null)
    {
        parent::__construct($data);
    }

    #[Rules(rules: ['required', 'string', 'max:255'], messages: ['name' => 'nama wajib di isi'])]
    public string $name;

    #[Rules(rules: ['nullable', 'integer'])]
    public int|null $user_id;

    // #[Rules(rules: ['required', 'integer', 'exists:users,id'])]
    // public int $user_id;
}
