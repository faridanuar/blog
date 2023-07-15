<?php

namespace App\Utilities\User;

use App\Models\User;

class OptionList extends \App\Utilities\OptionList
{
    public static function list()
    {
        $list = parent::list();

        $list['user-role'] = [
            User::ROLE_REGISTERED => 'Registered',
            User::ROLE_AUTHOR => 'Author',
            User::ROLE_ADMIN => 'Admin',
        ];

        return $list;
    }
}
