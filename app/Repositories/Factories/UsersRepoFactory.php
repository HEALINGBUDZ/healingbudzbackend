<?php


namespace RepoFactories;


//use RepoInterfaces\RepoFactoryInterface;
use RepoInterfaces\RepoFactoryInterface;
use Repositories\Repository;
use Repositories\UsersRepository;

class UsersRepoFactory implements RepoFactoryInterface
{
    /**
     * @return UsersRepository
     */
    public function getRepo()
    {
        return new UsersRepository();
    }
}