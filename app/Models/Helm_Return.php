<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Helm_Return extends Model
{
    protected $fillable = [
        "borrowed_id",
        "due_date"
    ];
    protected $table = "helmreturn";

    public function borroweds()
    {
        return parent::hasOne(Borrowed::class, "borrowed_id", "id");
    }
}
