<?php

declare(strict_types=1);

namespace Dysback\NubesMea\Model;

use Dysback\Ogo\Dao\BaseDao;

/** DAO for the `users` table. */
class User extends BaseDao
{
    protected string $table = 'users';

    public int $id;
    public string $username;
    public ?string $pw_hash = null;
    public ?string $first_name = null;
    public ?string $last_name = null;
    public ?string $email = null;
    public int $status = 1;
    public ?int $person = null;
}
