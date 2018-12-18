<?php

namespace RepoInterfaces;


use Repositories\Repository;

interface RepoFactoryInterface
{

    /**
     * @return Repository
     */
    public function getRepo();
}