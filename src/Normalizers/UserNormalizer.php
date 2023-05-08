<?php

namespace Street\App\Normalizers;

use Street\App\Helper;
use Street\App\Model\User;
use Street\App\Regex\Regex;

/**
 *
 */
class UserNormalizer extends BaseNormalizer
{

    /**
     * @var array
     */
    protected array $users = [];

    /**
     * @return void
     */
    public function normalize(): void
    {
        $this->users = $this->process();
    }

    /**
     * @return void
     */
    protected function process(): array
    {
        $users = [];
        foreach ($this->data as $row){
            $result = Helper::splitBy(Regex::ONE_SPACE_OR_MORE, $row);
            $length = count($result);
            // only title and last name which are mandatory and must be present in user entered data
            // title
            $title = $result[0];
            $lastName = null;
            $initial = null;
            $firstName = null;
            // surname
            if($length === 2)$lastName = $result[1];
            else{
                $lastName = $result[$length - 1];
                // initial or first name
                if(Helper::isRegexMatch(Regex::INITIAL_REGEX, $result[1])) $initial = $result[1];
                else $firstName = $result[1];
            }

            $users[] = $this->createUser($title, $lastName, $initial, $firstName);
        }
        return $users;
    }

    protected function createUser(string $title, string $lastName, string|null $initial, string|null $firstName): User
    {
        $user = new User();
        $user->setTitle($title);
        $user->setLastName($lastName);
        if($initial) $user->setInitial($initial);
        if($firstName) $user->setFirstName($firstName);
        return $user;
    }


    /**
     * @return array
     */
    public function getUsers(): array
    {
        return $this->users;
    }




}
