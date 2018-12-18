<?php

namespace RepoFactories;


use RepoInterfaces\RepoFactoryInterface;
use Repositories\Repository;
use Repositories\LoginUsersRepository;

class LoginUsersRepoFactory implements RepoFactoryInterface
{
    /**
     * @return LoginUsersRepository
     */
    public function getRepo()
    {
        return new LoginUsersRepository();
    }
}