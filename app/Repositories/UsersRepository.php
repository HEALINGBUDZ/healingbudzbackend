<?php
/**
 * Created by PhpStorm.
 * user: nomantufail
 * Date: 10/10/2016
 * Time: 10:13 AM
 */

namespace Repositories;

use App\Events\UserRegistered;
use App\Exceptions\ValidationErrorException;
use Illuminate\Support\Facades\Event;
use LaraModels\User as DbUser;
use Models\User;
use LaraModels\Follower;
use LaraModels\ForgetPassword as DbForgetPassword;
use Models\ForgetPassword;



use LaraModels\LoginUser as DbLoginUser;
use Models\LoginUser;


use RepoInterfaces\UsersRepoInterface;
use RepoFactories\LoginUsersRepoFactory;
use Illuminate\Support\Facades\Hash;

use Requests\FollowUserRequest;
use Requests\UnfollowUserRequest;
use Requests\GetFollowerRequest;
use Requests\GetFollowsRequest;

class UsersRepository extends Repository implements UsersRepoInterface
{
    /**
     * UsersRepository constructor.
     */

    public $loginUsersRepo = null;
    public $forgetPasswordModel = null;
    public $followModel = null;

    public function __construct()
    {
        $this->setModel(new DbUser());
        $this->loginUsersRepo = (new LoginUsersRepoFactory())->getRepo();
        $this->forgetPasswordModel = new DbForgetPassword();
        $this->followModel = new follower();
    }


    /**
     * @param User $user
     * @return User
     * @param bool $verify
     */
    public function store(User $user, $verify = false)
    {
//        return $user;
        $DbUser = new DbUser();
        $DbUser->first_name = $user->firstName;
        $DbUser->last_name = $user->lastName;
        $DbUser->email = $user->email;
        if($verify) {
            $DbUser->password = Hash::make($user->password);
            $DbUser->verified = 0;
        }

        $DbUser->platform = $user->platform;
        $DbUser->platform_id = $user->platformId;
        $DbUser->created_at = $user->createdAt;
        $DbUser->updated_at = $user->updatedAt;
        $DbUser->save();
        $user = $this->mapUser($DbUser);
        if($verify) {
            Event::fire(new UserRegistered($user));
        }
        return $user;
    }

    public function findByToken($token){
        $user = $this->loginUsersRepo->findByToken($token);
        if($user){
            $registered_user = $this->findById($user->userId);
            return $registered_user;
        }
        return null;

    }

    /**
     * @param $email
     * @return boolean
     */
    public function checkUserVerification($email){
        $user = $this->getModel()->where('email',$email)->first();
        $user = $this->mapUser($user);
        if($user->verified == 0){
            return false;
        }
        return true;
    }

    /**
     * @param array $where
     * @return User
     */
    public function findBy(array $where)
    {
        return new User();
    }

    public function getWhere(array $where)
    {
        return [];
    }

    public function updateWhere(array $where, array $user){
        return $this->getModel()->where($where)->update($user);
    }

    /**
     * @param $email
     * @return User|null
     */
    public function findByEmail($email){
        $user = $this->getModel()->where('email',$email)->first();
        return ($user != null)?$this->mapUser($user):$user;
    }


    /**
     * @param $id
     * @return User|null
     */
    public function findById($id){
        $user = $this->getModel()->find($id);
        return ($user != null)?$this->mapUser($user):$user;
    }



    /**
     * @param $id
     * @param $loginUserId
     * @return User|null
     */
    public function getUserWithIsFollowed($id, $loginUserId){
        $user = $this->getModel()->where('id',$id)
                    ->withcount(['followers'=>function($q) use($loginUserId){
                        $q->where('follower_id', $loginUserId);
                    }])
                    ->first();
        return ($user != null)?$this->mapUser($user):$user;
    }


    /**
     * @param FollowUserRequest $request
     * @return boolean
     */
    public function followUser($request){
        $follower_id = $request->user()->id;
        $follow = new Follower();
        $follow->follower_id = $follower_id;
        $follow->follows_id = $request->input('follows_id');
        $follow->created_at = $request->input('created_at');
        $follow->updated_at = $request->input('created_at');
        if($follow->save()){
            return true;
        }

    }

    /**
     * @param UnfollowUserRequest $request
     * @return boolean
     */
    public function unfollowUser($request){
        $follower_id = $request->user()->id;
        $follows_id = $request->input('follows_id');

        if(Follower::where('follower_id', $follower_id)->where('follows_id', $follows_id)->delete()){
            return true;
        }

    }

    /**
     * @param $id
     * @return array
     */
    public function getUserFollowers($id){
        $user = DbUser::where('id', $id)->with('followers')->first();
        return ($user != null)?$this->mapUsers($user->followers):$user;

    }

    /**
     * @param $id
     * @return array
     */
    public function getUserFollows($id){
        $user = DbUser::where('id', $id)->with(['follows'=>function($query){
                    $query->orderBy('first_name', 'asc');
                }])->first();
        return ($user != null)?$this->mapUsers($user->follows):$user;
    }


    /**
     * @param User
     * @return User
     */
    public function mapUser($user){
        $userModel              = new User();
        $userModel->id          = $user->id;
        $userModel->firstName   = $user->first_name;
        $userModel->lastName    = $user->last_name;
        $userModel->email       = $user->email;
        $userModel->password    = $user->password;
        $userModel->description = $user->description;
        $userModel->photo       = $user->photo;
        $userModel->platform   = $user->platform;
        $userModel->platformId = $user->platform_id;
        $userModel->verified    = $user->verified;
        $userModel->createdAt   = $user->created_at;
        $userModel->updatedAt   = $user->updated_at;
        if(isset($user->followers_count)){
            $userModel->isFollowed = $user->followers_count;
        }

        return $userModel;
    }


    public function mapUsers($users){
        $maped_users = array();

        foreach ($users as $user){
            $maped_users[] = $this->mapUser($user);
        }
        return $maped_users;
    }




    public function saveForgetPasswordToken($userId, $token){
        $userToken = new DbForgetPassword();
        $userToken->user_id = $userId;
        $userToken->token = $token;
        $userToken->save();
        return $this->mapForgetPassword($userToken);
    }


    /**
     * @param DbForgetPassword
     * @return ForgetPassword
     */
    public function mapForgetPassword($forgetPassword){
        $userToken = new ForgetPassword();
        $userToken->id = $forgetPassword->id;
        $userToken->userId = $forgetPassword->user_id;
        $userToken->token = $forgetPassword->token;

        return $userToken;
    }


    public function updatePassword($password, $token){
        $user = $this->getUserByToken($token);
        return $this->updateWhere(['id'=>$user->id], ['password'=>Hash::make($password)]);
    }


    public function getUserByToken($token){
        $user = $this->forgetPasswordModel->where('token', $token)->with('user')->first();
        return $this->mapUser($user->user);
    }


    public function getUserLike($term, $loginUserId){
        $users = $this->getModel()
                    ->where('id','!=',$loginUserId)
                    ->where(function($q) use($term) {
                        $q->where('first_name', 'like', '%'.$term.'%')
                            ->orwhere('last_name', 'like', '%'.$term.'%');
                    })
                    ->withcount(['followers'=>function($q) use($loginUserId){
                        $q->where('follower_id', $loginUserId);
                    }])
                    ->get();

        return ($users != null)?$this->mapUsers($users):$users;

    }


    public function getUserFollowersLike($term, $loginUserId){
        $users = $this->getModel()
            ->where('id',$loginUserId)
            ->with(['followers'=>function($q) use($term){
                $q->where('first_name', 'like', '%'.$term.'%')
                    ->orwhere('last_name', 'like', '%'.$term.'%')
                    ->orderBy('first_name', 'ASC');
            }])
            ->first();
        return ($users != null)?$this->mapUsers($users->followers):$users;

    }



    public function isFollowed($followerId, $followsId){
        $users = $this->followModel->where('follower_id', $followerId)->where('follows_id', $followsId)->first();
        return ($users != null)?$users:null;

    }
}