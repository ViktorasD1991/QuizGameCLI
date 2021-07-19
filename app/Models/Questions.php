<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Questions extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['question', 'answer'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [];

    /**
     * The table associated with the Model
     *
     * @var string
     */
    protected $table = 'questions';

    /**
     * Returns the status of all questions
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function status(): HasOne
    {
        return $this->HasOne(QuestionsStatus::class, 'question_id', 'id');
    }
}
