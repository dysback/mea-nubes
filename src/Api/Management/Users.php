<?php

declare(strict_types=1);

namespace Dysback\NubesMea\Api\Management;

use Dysback\Ogo\App;
use Dysback\Ogo\Controller\BaseController;
use Dysback\Ogo\Dao\DaoFilter;
use Dysback\Ogo\Dao\Filter;
use Dysback\Ogo\Dao\FilterOperator;
use Dysback\NubesMea\Model\User;

/** REST controller for user management. */
class Users extends BaseController
{
    private User $dao;

    public function __construct()
    {
        parent::__construct();
        $this->dao = new User(App::getInstance());
    }

    /**
     * Creates a new user.
     * POST JSON: { "username": "...", "pw_hash": "...", "first_name": "...", ... }
     */
    public function createUser(
        string $username,
        ?string $pw_hash = null,
        ?string $first_name = null,
        ?string $last_name = null,
        ?string $email = null,
        int $status = 1,
        ?int $person = null,
    ): array {
        $this->dao->username   = $username;
        $this->dao->pw_hash    = $pw_hash;
        $this->dao->first_name = $first_name;
        $this->dao->last_name  = $last_name;
        $this->dao->email      = $email;
        $this->dao->status     = $status;
        $this->dao->person     = $person;
        $id = $this->dao->insert();
        return ['status' => 'success', 'id' => $id];
    }

    /**
     * Updates an existing user.
     * POST JSON: { "id": 1, "email": "new@example.com", ... }
     */
    public function updateUser(
        int $id,
        ?string $username = null,
        ?string $pw_hash = null,
        ?string $first_name = null,
        ?string $last_name = null,
        ?string $email = null,
        ?int $status = null,
        ?int $person = null,
    ): array {
        if (!$this->dao->findById($id)) {
            return ['status' => 'not_found'];
        }
        if ($username !== null)   $this->dao->username   = $username;
        if ($pw_hash !== null)    $this->dao->pw_hash    = $pw_hash;
        if ($first_name !== null) $this->dao->first_name = $first_name;
        if ($last_name !== null)  $this->dao->last_name  = $last_name;
        if ($email !== null)      $this->dao->email      = $email;
        if ($status !== null)     $this->dao->status     = $status;
        if ($person !== null)     $this->dao->person     = $person;
        $ok = $this->dao->update();
        return ['status' => $ok ? 'success' : 'error'];
    }

    /**
     * Deletes a user by id.
     * GET /api/Management/Users/deleteUser/{id}
     */
    public function deleteUser(int $id): array
    {
        $this->dao->id = $id;
        $ok = $this->dao->delete();
        return ['status' => $ok ? 'success' : 'not_found'];
    }

    /**
     * Returns a single user by username.
     * GET /api/Management/Users/getUserByUsername/{username}
     */
    public function getUserByUsername(string $username): array
    {
        $daoFilter = new DaoFilter($this->dao);
        $rows = $daoFilter->filter(
            filters: [new Filter('username', FilterOperator::EQ, $username)],
            limit: 1,
        );
        return $rows[0] ?? [];
    }

    /**
     * Filters users by any attribute.
     * POST JSON: { "filters": [{"column":"status","operator":"EQ","value":1}], "offset":0, "limit":20 }
     */
    public function findUsers(
        array $filters = [],
        int $offset = 0,
        ?int $limit = null,
    ): array {
        $filterObjects = array_map(
            function ($f) {
                return new Filter($f['column'], FilterOperator::getByName($f['operator']), $f['value'] ?? null);
            },
            $filters
        );
        $daoFilter = new DaoFilter($this->dao);
        return $daoFilter->filter($filterObjects, $offset, $limit);
    }
}
