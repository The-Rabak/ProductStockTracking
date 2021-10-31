<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    protected $table = "stock_history";
    protected $casts = [
        "in_stock" => "boolean"
    ];
    use HasFactory;
}
