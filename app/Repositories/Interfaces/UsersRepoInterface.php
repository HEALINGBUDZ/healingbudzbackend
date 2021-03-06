<?php
/**
 * Created by PhpStorm.
 * User: nomantufail
 * Date: 02/05/2017
 * Time: 10:14 AM
 */

namespace RepoInterfaces;


use Models\Model;
use Models\User;

interface UsersRepoInterface
{

    /**
     * @param array $where
     * @return User
     * @Description this function will accept an array of conditions
     * and will find a user from db and returns a User
     */
    public function findBy(array $where);

    /**
     * @param array $where
     * @return User[]
     */
    public function getWhere(array $where);

    /**
     * @param User $user
     * @return User
     * @Description this function will store a user and will return a
     * User class object
     */
    public function store(User $user);
}