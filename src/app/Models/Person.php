<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['name', 'role'])]
class Person extends Model
{
    /**
     * このモデルが使うテーブル名。
     * Person の複数形は "persons" になるため明示的に指定する。
     */
    protected $table = 'people';

    /**
     * この人が持つ挨拶の一覧。
     *
     * @return HasMany<Greeting, $this>
     */
    public function greetings(): HasMany
    {
        return $this->hasMany(Greeting::class);
    }
}
