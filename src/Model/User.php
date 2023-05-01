<?php

namespace Street\App\Model;

/**
 *
 */
class User
{
    /**
     * @var string
     */
    protected string $title;
    /**
     * @var string
     */
    protected ?string $first_name = null;

    /**
     * @var string
     */
    protected ?string $initial = null;

    /**
     * @var string
     */
    protected string $last_name;

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = trim($title);
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->first_name;
    }

    /**
     * @param string $first_name
     */
    public function setFirstName(string $first_name): void
    {
        $this->first_name = trim($first_name);
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->last_name;
    }

    /**
     * @param string $last_name
     */
    public function setLastName(string $last_name): void
    {
        $this->last_name = trim($last_name);
    }

    /**
     * @param string $initial
     * @return void
     */
    public function setInitial(string $initial):void
    {
        $this->initial = trim($initial);
    }

    /**
     * @return string
     */
    public function getInitial():string
    {
        return $this->initial;
    }


}
