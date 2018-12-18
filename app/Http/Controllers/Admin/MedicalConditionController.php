<?php
namespace App\Http\Controllers\Admin;
use App\Admin;
use App\Http\Controllers\Controller;
use App\MedicalConditions;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MedicalConditionController extends Controller
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
    public function getMedicalConditions(){
        $medical_conditions = MedicalConditions::orderBy('updated_at','desc')->get();
        return view('admin.medical_conditions.medical_condition_view',['title' => 'Medical Conditions' , 'medical_conditions' => $medical_conditions]);
    }
    public function medicalConditionApproveStatus(Request $request , $status  ,$id){
        if($status == 1){
            MedicalConditions::where('id',$id)->update(['is_approved' => 1]);
            return redirect()->back()->with('success' , 'Medical condition has been approved');
        }else {
            MedicalConditions::where('id', $id)->update(['is_approved' => 0]);
            return redirect()->back()->with('success' , 'Medical condition has been rejected');
        }
    }
    public function addMedicalCondition(Request $request){
        Validator::make($request->all(), [
            'medical_condition' => 'required',
        ])->validate();
        $medi_condations=explode(',',$request->input('medical_condition'));
        foreach ($medi_condations as $m_c){
        if($m_c){
        $medical_condition = new MedicalConditions();
        $medical_condition->m_condition = $m_c;
        $medical_condition->is_approved = 1;
        $medical_condition->save();
        }}
        return redirect()->back()->with('success' , 'Medical condition has been added');

    }
    public function deleteMedicalCondition($id){
        MedicalConditions::where('id' , $id)->delete();
        return redirect()->back()->with('success' , 'Medical condition has been deleted');
    }
    function deleteMultipleMedical(Request $request){
        $ids= explode(',', $request['ids']);
        MedicalConditions::whereIn('id' , $ids)->delete();
        return response()->json(['success'=>"Medical Deleted successfully."]);
    }
    public function updateMedicalCondition(Request $request , $id){
        Validator::make($request->all(), [
            'medical_condition' => 'required',
        ])->validate();
        MedicalConditions::where('id',$id)->update(['m_condition' => $request->input('medical_condition')]);
        return redirect()->back()->with('success' , 'Medical condition has been updated');
    }
    
    function approveDisapproveMultipleMedical(Request $request){
        $ids= explode(',', $request['ids']);
        MedicalConditions::whereIn('id' , $ids)->update(array('is_approved' => $request->status));
        return response()->json(['success'=>"Medical Status successfully Updated."]);
    }
}