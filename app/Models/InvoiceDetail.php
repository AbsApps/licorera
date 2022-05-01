<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'invoice_id',
        'product_id',
        'quatity',
        'active',
        'created_at',
        'updated_at'
    ];
}
