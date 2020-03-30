<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Foundation\Application;

/**
 * Class AbstractEloquentRepository.
 *
 * @version    1.0.0
 *
 * @author     Odenktools
 * @license    MIT
 * @copyright  (c) 2015 - 2020, Odenktools
 *
 * @link       https://odenktools.com
 */
abstract class AbstractEloquentRepository
{
    /**
     * @var Application
     */
    protected $app;

    /**
     * @var Model|\Illuminate\Database\Eloquent\Builder
     */
    protected $model;

    /**
     * @param Application $app
     * @param Model $model
     */
    public function __construct(Application $app, Model $model)
    {
        $this->app = $app;
        $this->model = $model;
    }
}
