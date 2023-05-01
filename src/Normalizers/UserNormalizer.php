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
    function normalize(): void
    {
        $this->process();
    }

    /**
     * @return void
     */
    function process(): void
    {
        $this->users = [];
        foreach ($this->data as $row){
            $result = Helper::splitBy(Regex::ONE_SPACE_OR_MORE, $row);
            $length = count($result);
            // only title and last name which are mandatory and must be present in user entered data
            $user = new User();
            // title
            $user->setTitle($result[0]);
            // surname
            if($length === 2)$user->setLastName($result[1]);
            else{
                $user->setLastName($result[$length - 1]);
                // initial or first name
                if(Helper::isRegexMatch(Regex::INITIAL_REGEX, $result[1])) $user->setInitial($result[1]);
                else $user->setFirstName($result[1]);
            }
            $this->users[] = $user;
        }
    }

    /**
     * @return array
     */
    public function getUsers(): array
    {
        return $this->users;
    }




}
