<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Borrowed extends Model
{
    protected $guarded = [];

    public function users()
    {
        return parent::belongsTo(User::class, "user_id");
    }
    public function helment()
    {
        return parent::belongsTo(Helment::class);
    }
    public function HelmReturn()
    {
        return $this->hasOne(Helm_Return::class, "borrowed_id", "id");
    }
}
