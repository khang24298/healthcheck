<?php 
namespace App\Http\Controllers\Model;
use Illuminate\Database\Eloquent\Model;

class Supervisor extends Model{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table ="queue_monitor";

    protected $fillable = [
        'program_name', 'autostart','autorestart','user','numprocs','redirect_stderr',
        'stopwaitsecs','sleep','tries','queue','timeout','file_exec'
    ];

}

?>