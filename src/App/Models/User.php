<?php

namespace LPF\App\Models;

use LPF\Framework\Database\ORM\Model;

class User extends Model
{
    protected static $modelTable = 'users';
    protected static $idColumn = 'id';
}
