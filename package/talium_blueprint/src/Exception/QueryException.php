<?php

namespace TaliumBlueprint\Exception;

use RuntimeException;
class QueryException extends \Exception
{
    public function __construct()
    {
        parent::__construct();
    }

    public function failedQuery($message)
    {
        throw new RuntimeException($message);
    }

}
