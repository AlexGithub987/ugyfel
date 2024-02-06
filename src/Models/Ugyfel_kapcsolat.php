<?php

namespace AlexGithub987\Ugyfel\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ugyfel_kapcsolat extends Model
{
    use HasFactory, SoftDeletes;

    protected $connection = 'mysql';
    protected $table = 'ugyfel_kapcsolat';

    protected $guarded = ['id'];


}
