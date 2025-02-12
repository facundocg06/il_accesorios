<?php

namespace App\Models\Services;

use App\Http\Messages\ErrorMessages;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\UserResource;
use App\Models\Repository\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class UserService
{
    protected $userRepository;
    public function __construct(UserRepositoryInterface $userRepositoryInterface)
    {
        $this->userRepository = $userRepositoryInterface;
    }
    public function getAll()
    {
        return UserResource::collection($this->userRepository->all());
    }
    public function createUser($data)
    {
        return DB::transaction(function () use ($data) {
            // Buscar el usuario, incluidos los eliminados con soft deletes
            $existingUser = $this->userRepository->findByEmailWithTrashed($data['email']);

            if ($existingUser) {
                if ($existingUser->trashed()) {
                    // Si el usuario está eliminado (soft delete), restaurarlo y actualizar los datos
                    $existingUser->restore();
                    $existingUser->update($data);
                    $existingUser->assignRole($data['rolType']);
                    return new UserResource($existingUser);
                } else {
                    // Si el usuario ya existe y no está eliminado, lanzar una excepción
                    throw new \Exception(ErrorMessages::USER_ALREADY_EXIST);
                }
            } else {
                // Si no existe, crear un nuevo usuario
                $user = $this->userRepository->create($data);
                // $user->assignRole('Invitado');
                return new UserResource($user);
            }
        });
    }

    public function updateUser($data, $id)
    {
        return DB::transaction(function () use ($data, $id) {
            $user = $this->userRepository->find($id);
            if (!$user) {
                throw new \Exception(ErrorMessages::NOT_FOUND);
            }
            $user = $this->userRepository->update($data, $user);
            return new UserResource($user);
        });
    }
    public function findByUser($idUser)
    {
        return $this->userRepository->find($idUser);
    }
    public function deleteUser($idUser)
    {
        return $this->userRepository->delete($idUser);
    }
}
