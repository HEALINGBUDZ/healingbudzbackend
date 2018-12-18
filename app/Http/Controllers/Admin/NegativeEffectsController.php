<?php
namespace App\Http\Controllers\Admin;
use App\Admin;
use App\Http\Controllers\Controller;
use App\NegativeEffect;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NegativeEffectsController extends Controller
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
    public function getNegativeEffects(){
        $negative_effects = NegativeEffect::orderBy('updated_at','desc')->get();
        return view('admin.negative_effects.negative_effects_view',['title' => 'Negative Effects' , 'negative_effects' => $negative_effects]);
    }
    public function negativeEffectApproveStatus(Request $request , $status  ,$id){
        if($status == 1){
            NegativeEffect::where('id',$id)->update(['is_approved' => 1]);
            return redirect()->back()->with('success' , 'Negative effect has been approved');
        }else {
            NegativeEffect::where('id', $id)->update(['is_approved' => 0]);
            return redirect()->back()->with('success' , 'Negative effect has been rejected');
        }
    }
    public function addNegativeEffect(Request $request){
        
        Validator::make($request->all(), [
            'negative_effect' => 'required',
        ])->validate();
        $effects= explode(',', $request->input('negative_effect'));
        foreach ($effects as $effect){
            if($effect){
        $negative_effect = new NegativeEffect();
        $negative_effect->effect =$effect;
        $negative_effect->is_approved = 1;
        $negative_effect->save();
    }}
        return redirect()->back()->with('success' , 'Negative effect has been added');

    }
    public function deleteNegativeEffect($id){
        NegativeEffect::where('id' , $id)->delete();
        return redirect()->back()->with('success' , 'Negative effect has been deleted');
    }
    public function updateNegativeEffect(Request $request){
        Validator::make($request->all(), [
            'negative_effect' => 'required',
        ])->validate();
        NegativeEffect::where('id',$request['effect_id'])->update(['effect' => $request->input('negative_effect')]);
        return redirect()->back()->with('success' , 'Negative effect has been updated');
    }
function deleteMultipleEffect(Request $request){
        $ids= explode(',', $request['ids']);
        NegativeEffect::whereIn('id' , $ids)->delete();
        return response()->json(['success'=>"Negative Effects Deleted successfully."]);
    }
    function approveDisapproveMultipleNegitive(Request $request){
        $ids= explode(',', $request['ids']);
        NegativeEffect::whereIn('id' , $ids)->update(array('is_approved' => $request->status));
        return response()->json(['success'=>"Negative Effect Status successfully Updated."]);
    }
}