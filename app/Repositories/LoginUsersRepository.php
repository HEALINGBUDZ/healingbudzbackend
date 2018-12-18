<?php

namespace Repositories;

use Illuminate\Support\Facades\DB;
use App\UserLogin as DbLoginUser;
use Models\LoginUser;

class LoginUsersRepository extends Repository {

    public function __construct() {
        $this->setModel(new DbLoginUser());
    }

    /**
     * @param LoginUser $user
     * @return LoginUser
     */
    public function store(LoginUser $user) {
//        return $user;
        $DbUser=DbLoginUser::where(array('device_id'=> $user->deviceId,'device_type'=>$user->deviceType))->first();
        if(!$DbUser){
          $DbUser = new DbLoginUser(); 
          $DbUser->user_id = $user->userId;
        }
       
        $DbUser->session_key = $user->sessionKey;
        $DbUser->device_type = $user->deviceType;
        $DbUser->device_id = $user->deviceId;
        $DbUser->lat = $user->lat;
        $DbUser->lat = $user->lat;
        $DbUser->save();
        return $this->mapLoginUser($DbUser);
    }

    public function userLogout($token) {
        if ($this->getModel()->where('session_key', $token)->delete()) {
            return true;
        }
        return false;
    }

    /**
     * @return LoginUser|null
     * @param string $token
     */
    public function findByToken($token) {
        $loginUser = $this->getModel()->where('session_key', $token)->first();
        if ($loginUser != null) {
            return $this->mapLoginUser($loginUser);
        }
        return null;
    }

    /**
     * @param array $where
     * @return LoginUser
     */
    public function findBy(array $where) {
        return new LoginUser();
    }

    public function getWhere(array $where) {
        return [];
    }

    public function update(array $where, array $update) {

        return $this->getModel()->where($where)->update($update);
    }

    /**
     * @param $id
     * @return LoginUser|null
     */
    public function getByUserId($id) {
        $user = $this->getModel()->where('user_id', $id)->get();
        return ($user != null) ? $this->mapLoginUsers($user) : $user;
    }

    /**
     * @param $id
     * @return LoginUser|null
     */
    public function findById($id) {
        $user = \LaraModels\LoginUser::find($id);
        return ($user != null) ? $this->mapLoginUser($user) : $user;
    }

    /**
     * @param $id
     * @param $token
     * @return LoginUser|null
     */
    public function deleteOtherLoginSession($id, $token) {
        $this->getModel()->where('user_id', '=', $id)->where('session_key', '!=', $token)->delete();
    }

    /**
     * @param User
     * @return LoginUser
     */
    public function mapLoginUser($user) {
        $userModel = new LoginUser();
        $userModel->id = $user->id;
        $userModel->userId = $user->user_id;
        $userModel->sessionKey = $user->session_key;
        $userModel->deviceType = $user->device_type;
        $userModel->deviceId = $user->device_id;
        $userModel->lat = $user->lat;
        $userModel->lng = $user->lng;
        return $userModel;
    }

    public function mapLoginUsers($users) {
        $maped_users = array();

        foreach ($users as $user) {
            $maped_users[] = $this->mapLoginUser($user);
        }
        return $maped_users;
    }

}
