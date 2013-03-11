<?php

namespace MinSal\SCA\UsersBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class MinSalSCAUsersBundle extends Bundle
{
     public function getParent()
    {
        return 'FOSUserBundle';
    }
}
