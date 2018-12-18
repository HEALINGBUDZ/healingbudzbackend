<?php
/**
 * Created by PhpStorm.
 * user: nomantufail
 * Date: 10/10/2016
 * Time: 10:13 AM
 */

namespace Repositories;

use App\Exceptions\ValidationErrorException;
use LaraModels\UserVerification as DbUserVerification;
use Models\Model;
use Models\UserVerification;
use RepoInterfaces\UsersVerificationRepoInterface;

class UsersVerificationRepository extends Repository implements UsersVerificationRepoInterface
{
    /**
     * UsersRepository constructor.
     */
    public function __construct()
    {
        $this->setModel(new DbUserVerification());
    }


    /**
     * @param UserVerification $user
     * @return UserVerification
     */
    public function store(UserVerification $user)
    {
//        return $user;
        $DbUserVerification = new DbUserVerification();
        $DbUserVerification->user_id = $user->userId;
        $DbUserVerification->token = $user->token;
        $DbUserVerification->save();

        return $this->mapUser($DbUserVerification);
    }

    public function findByToken($token){
        return $this->mapUser($this->getModel()->where('token', $token)->first());
    }

    /**
     * @param array $where
     * @return UserVerification
     */
    public function findBy(array $where)
    {
        return new UserVerification();
    }

    public function getWhere(array $where)
    {
        return [];
    }

    public function update(array $user){
        return $this->mapUser(new UserVerification());
    }


    /**
     * @param $id
     * @return UserVerification|null
     */
    public function findById($id){
        $user = UserVerification::find($id);
        return ($user != null)?$this->mapUser($user):$user;
    }

    /**
     * @param $id
     * @return boolean
     */
    public function deleteById($id){
        return $this->getModel()->destroy($id);

    }


    /**
     * @param UserVerification
     * @return UserVerification
     */
    public function mapUser($user){
        $userModel              = new UserVerification();
        $userModel->id          = $user->id;
        $userModel->userId   = $user->user_id;
        $userModel->token    = $user->token;

        return $userModel;
    }


    public function mapUsers($users){
        $maped_users = array();

        foreach ($users as $user){
            $maped_users[] = $this->mapUser($user);
        }
        return $maped_users;
    }
}