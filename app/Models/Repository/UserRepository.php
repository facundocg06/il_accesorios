<?php

namespace App\Models\Repository;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserRepository implements UserRepositoryInterface
{

    public function all()
    {
        return User::all();
    }
    public function create($data)
    {
        $userData = [
            'username' => $data['name'].' '.$data['lastname'],
            'first_name' => $data['name'],
            'last_name' => $data['lastname'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'phone' => $data['phone'],
        ];
        return User::create($userData);
    }
    public function update($data, $user)
    {
        $userData = [
            'username' => $data['name'].' '.$data['lastname'],
            'first_name' => $data['name'],
            'last_name' => $data['lastname'],
            'email' => $data['email'],
            'phone' => $data['phone'],
        ];
        return $user->update($userData);
    }
    public function delete($id)
    {
        return User::destroy($id);
    }
    public function find($id)
    {
        return User::find($id);
    }
    public function findWhere($column, $value)
    {
        return User::where($column, $value)->get();
    }
    public function findByEmail($email){
        return User::where('email', $email)->first();
    }
    public function findByEmailWithTrashed($email)
    {
        return User::withTrashed()->where('email', $email)->first();
    }

}
