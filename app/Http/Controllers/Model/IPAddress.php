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
        'ip', 'port','attempts','first_check','final_check','status'
    ];

}

?>