<?php

namespace Street\App\Normalizers;

use Street\App\Model\User;

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
            $result = CsVNormalizer::splitBySpace(trim($row));
            $length = count($result);
            // only title and last name which are mandatory and must be present in user entered data
            $user = new User();
            if($length === 2){
                $user->setTitle(trim($result[0]));
                $user->setLastName(trim($result[1]));
            }
            else{
                $user->setTitle(trim(trim($result[0])));
                $user->setLastName(trim($result[$length - 1]));
                if(self::isInitial($result[1])) $user->setInitial(trim($result[1]));
                else $user->setFirstName(trim($result[1]));
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

    /**
     * @param string $result
     * @return bool
     */
    public static function isInitial(string $result): bool
    {
        if(preg_match('/^[A-Z]\.?$/i', trim($result))) return true;
        return false;
    }


}
