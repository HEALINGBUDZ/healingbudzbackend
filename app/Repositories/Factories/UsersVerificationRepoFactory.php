<?php


namespace RepoFactories;


use RepoInterfaces\RepoFactoryInterface;
use Repositories\Repository;
use Repositories\UsersVerificationRepository;

class UsersVerificationRepoFactory implements RepoFactoryInterface
{
    /**
     * @return UsersVerificationRepository
     */
    public function getRepo()
    {
        return new UsersVerificationRepository();
    }
}