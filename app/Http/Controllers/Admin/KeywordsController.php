<?php
namespace App\Http\Controllers\Admin;
use App\Admin;
use App\Http\Controllers\Controller;
use App\MedicalConditions;
use App\NegativeEffect;
use App\SearchedKeyword;
use App\Sensation;
use App\SubUser;
use App\Tag;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Stripe\Subscription;

class KeywordsController extends Controller
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
    public function getKeywords(){
        //$keywords = SearchedKeyword::with('search_count')->get();
        $keywords = DB::table('searched_keywords')->select(DB::raw('searched_keywords.* , search_counts.date,search_counts.count'))
            ->leftJoin('search_counts', 'searched_keywords.id', '=', 'search_counts.keyword_id')
            ->orderBy('search_counts.count', 'desc')
            ->get();
        return view('admin.keywords.keywords_view',['title' => 'keywords' , 'keywords' => $keywords]);
    }

    public function addKeyword(Request $request){
        $keyword = new SearchedKeyword();
        $keyword->price = $request->input('keyword');
        $keyword->save();
        return redirect()->back()->with('success' , 'Keyword has been added');
    }

    public function deleteKeyword($id){
        SearchedKeyword::where('id' , $id)->delete();
        return redirect()->back()->with('success' , 'Keyword has been deleted');
    }
    public function onSale(Request $request , $id){
        $this->validate($request , [
            'price' => 'required',
        ]);
        SearchedKeyword::where('id',$id)->update(['on_sale' => 1, 'price' => $request->input('price')]);
        return redirect()->back()->with('success','Keyword is put on sale');
    }
    public function saleRemove($id){
        SearchedKeyword::where('id',$id)->update(['on_sale' => 0,'price' => '']);
        return redirect()->back()->with('success','Keyword is removed from sale');
    }
    public function updatePrice(Request $request , $id){
        $this->validate($request , [
            'price' => 'required',
        ]);
        SearchedKeyword::where('id',$id)->update(['price' => $request->input('price')]);
        return redirect()->back()->with('success','Price is updated');
    }
}