<?php
namespace App\Models;
use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'email', 'pass', 'admin'];

    public function getUser($id = null)
    {
        return $id ? $this->find($id) : $this->findAll();
    }

    public function login($data){
        return $this->asArray()->where($data)->first();
    }

    public function create_user($data)
    {
        // Insertar los datos en la base de datos
        return $this->db->insert('users', $data);
    }
}
