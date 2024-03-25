<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use TaliumAttributes\Collection\Models\Table;
use TaliumBlueprint\TraitHelper\InjectModel;


use App\Models\User;

#[Table('person')]
class Person extends Model
{
    use InjectModel;

    protected $fillable = ["name", "user_id"];


    /**
     * Relation method untuk user
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, "user_id", "id");
    }
}
