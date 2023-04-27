<?php

namespace Street\App\model;

class User
{
    protected string $initial;

    public function setInitial(string $initial):void
    {
        $this->initial = $initial;
    }

    public function getInitial():string
    {
        return $this->initial;
    }

}
