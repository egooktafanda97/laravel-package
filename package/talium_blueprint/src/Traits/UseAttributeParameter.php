<?php

namespace TaliumBlueprint\Traits;

use TaliumAbstract\Attributes\ArgumentAttribute\Handler;
use TaliumBlueprint\Handler\ArgumentAttribute\HandlerArgumentAttribute;

trait UseAttributeParameter
{
    private $myattributes;

    public function setAttribute($attr)
    {
        $this->myattributes = $attr;
    }

    public function __construct()
    {
        $this->useAttributes();
    }

    public function useAttributes()
    {
        $trace = debug_backtrace();
        $this->setAttribute((new HandlerArgumentAttribute(basename(__CLASS__), $trace))->attributes());
    }

    public function useAttributesConstruct()
    {
        $trace = debug_backtrace();
        $this->setAttribute((new HandlerArgumentAttribute(basename(__CLASS__), $trace))->attributesByConstrusctor());
    }

    /**
     * struktur 2
     */

    public function argumetAttribute($class)
    {
        return $this->myattributes->getArgument($class);
    }
}
