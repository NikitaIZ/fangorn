<?php

namespace App\Models\Audit\Xml;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class XmlHistoryReport extends Model
{
    use HasFactory;

    protected $fillable = ['folder', 'date', 'dolar_id'];
}
