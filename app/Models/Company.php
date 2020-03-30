<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Company Model.
 *
 * @author     Pribumi Technology
 * @license    MIT
 * @copyright  (c) 2019, Pribumi Technology
 */
class Company extends Model
{
    public $table = 'companies';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['created_at', 'updated_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code',
        'name'
    ];

    public function sql()
    {
        return $this
            ->select(
                $this->table . '.id',
                $this->table . '.code',
                $this->table . '.name'
            );
    }

    /**
     * <code>
     * $model = \App\Models\Company::findOrFail(1);
     * echo json_encode($model->users->count());
     * </code>
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users()
    {
        return $this->hasMany('App\User');
    }
}
