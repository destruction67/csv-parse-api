<?php

namespace App\Models\customer;

use App\Models\CsvParseFillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerInvite extends Model
{
    use HasFactory;

    protected $fillable = CsvParseFillable::CUSTOMER_INVITE;


}
