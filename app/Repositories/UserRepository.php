<?php

namespace App\Repositories;

use Illuminate\Contracts\Foundation\Application;
use App\User;

class UserRepository extends AbstractEloquentRepository
{
    /**
     * @param \Illuminate\Contracts\Foundation\Application $app
     * @param \App\User $model
     */
    public function __construct(Application $app, User $model)
    {
        parent::__construct($app, $model);
    }

    /**
     * Dynamic Model `method` calling,
     * @param $method
     * @param $parameters
     *
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        if (is_callable([$this->model, $method])) {
            return call_user_func_array([$this->model, $method], $parameters);
        }

        return false;
    }
}
