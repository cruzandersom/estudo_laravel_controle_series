<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Series extends Model
{
    use HasFactory;
    protected $fillable = ['nome'];
    protected $with = ['season'];
    protected $primaryKey = 'id';

    public function season()
    {
        // criando o relacionamento do tipo um para muitos
        return $this->hasMany(Season::class, 'series_id');
    }

   protected static function booted()
    {
        self::addGlobalScope('ordered', function (Builder $queryBuilder){
            $queryBuilder->orderBy('nome', 'desc');
        });
    }
}
