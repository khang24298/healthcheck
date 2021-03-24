<?php 
namespace App\Http\Controllers\Model;
use Illuminate\Database\Eloquent\Model;

class IPAddress extends Model{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table ="ipaddresses";

    protected $fillable = [
        'name', 'email',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];
}

?>