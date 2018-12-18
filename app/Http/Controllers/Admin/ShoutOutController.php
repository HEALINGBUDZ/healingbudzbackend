<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
//Model
use App\ShoutOut;

class ShoutOutController extends Controller
{
    use AuthenticatesUsers;
    protected $redirectTo = '/';
    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }
    public function getShoutOuts(){
        $data['title'] = 'Shout Outs';
        $data['shout_outs'] = ShoutOut::orderBy('updated_at', 'Desc')->with('getSubUser')->withCount('likes','views', 'shares')->get();
        return view('admin.shout_outs.view_shout_outs',$data);
    }

}