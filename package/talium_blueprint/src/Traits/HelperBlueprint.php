<?php

namespace TaliumBlueprint\Traits;

trait HelperBlueprint
{

    public function expoint($enpoint)
    {
        $delimiters = "<>";
        $tokens = [];
        $token = strtok($enpoint, $delimiters);
        while ($token !== false) {
            $tokens[] = $token;
            $token = strtok($delimiters);
        }
        return $tokens;
    }
}
