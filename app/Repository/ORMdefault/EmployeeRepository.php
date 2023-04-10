<?php

namespace App\Repository\ORMdefault;

use App\Models\Employee;
use App\Repository\DefaulRepositoryInterface;
use App\Repository\Trait\PagerTrait;

class EmployeeRepository extends BaseRepository implements DefaulRepositoryInterface
{
    use PagerTrait;

    private object $token;

    public function __construct()
    {
        $this->token = service('library', 'token');
        parent::__construct(new Employee());
    }

    public function add(array $employeeData): bool|string
    {
        $db = db_connect('default');

        $activationData = [
            'email' => $employeeData['email'],
            'token_hash' => $this->token->getTokenHash(),
            'created_at' => Date('Y-m-d H:i:s', time() + 3600)
        ];

        $db->transBegin();

        $db->table('employees')->insert($employeeData);
        $db->table('activation_tokens')->insert($activationData);

        if ($db->transStatus() === false) {
            $db->transRollback();
            return false;
        }

        $db->transCommit();
        return $this->token->getToken();
    }

    public function getLike(string $like): array
    {
        return $this->model->where('type_user_id', 2)->like('name', $like)->orderBy('id', 'asc')->paginate(10);
    }

    public function all(): array
    {
        return $this->model->where('type_user_id', 2)->orderBy('id', 'asc')->paginate(10);
    }
}