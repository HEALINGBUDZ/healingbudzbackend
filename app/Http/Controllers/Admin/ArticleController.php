<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;
//Models
use App\Article;
use App\Strain;
use App\Question;
use App\UserStrain;
use App\ArticalCategory;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;

class ArticleController extends Controller {

    function index() {
        $data['title'] = 'Articles';
        $type = '';
        if (isset($_GET['type'])) {
            $type = $_GET['type'];
        }
        $data['articles'] = Article::with('getQuestion', 'getUserStrain')
                        ->when($type == 'Article', function ($q) {
                            $q->where('type', 'Article');
                        })
                        ->when($type == 'Question', function ($q) {
                            $q->where('type', 'Question');
                        })
                        ->when($type == 'Strain', function ($q) {
                            $q->where('type', 'Strain');
                        })
                        ->orderBy('display_date', 'desc')->get();

        $data['strain_articles_count'] = Article::where('type', 'Strain')->count();
        $data['question_articles_count'] = Article::where('type', 'Question')->count();
        $data['user_strains'] = UserStrain::orderBy('updated_at', 'Desc')->get();
        $data['questions'] = Question::orderBy('updated_at', 'Desc')->get();
        return view('admin.article.view_articles', $data);
        return Response::json(array('data' => $data));
    }

    public function addArticleView() {
        $data['title'] = 'Article';
        $data['cats'] = ArticalCategory::orderBy('title')->get();
        $data['user_strains'] = UserStrain::orderBy('updated_at', 'Desc')->get();
        $data['questions'] = Question::orderBy('updated_at', 'Desc')->get();
        return view('admin.article.add_article', $data);
    }

    function addArticle(request $request) {
        Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required',
            'image' => 'mimes:jpeg,jpg,png,gif|required' // max 10000kb
        ])->validate();


        $article = new Article;
        if ($request['article_id']) {
            $article = Article::where('id', $request['article_id'])->first();
        }
        $article->title = $request['title'];
        $article->cat_id = $request->cat_id;
        $article->description = $request['description'];
        $article->teaser_text = $request['teaser_text'];
        $article->type = $request['type'];
        if ($request['image']) {
             $file_thumb = $request['image'];
            $file_size = Image::make($file_thumb->getRealPath())->filesize();
            if ($file_size > 2092446) {
                $fileName = 'image_' . Str::random(15) . '.' . $file_thumb->getClientOriginalExtension();
                Image::make($file_thumb)->resize(500, null, function ($constraints) {
                            $constraints->aspectRatio();
                        })
                        ->save('public/images/articles/' . $fileName);
                $article->thumb = '/articles/' . $fileName;
            }
            $article->image = addFile($request['image'], 'articles');
            if ($file_size < 2092446) {
                $article->thumb = $article->image;
            }
        }
        if ($request['type'] == 'Question') {
            $article->question_id = $request['question_id'];
            $article->user_strain_id = NULL;
        } else if ($request['type'] == 'Strain') {
            $article->user_strain_id = $request['user_strain_id'];
            $article->question_id = NULL;
        } else {
            $article->user_strain_id = NULL;
            $article->question_id = NULL;
        }

        if ($request['display_date'] && !empty($request['display_date'])) {
            $date = explode('/', $request['display_date']);
            $article->display_date = $date[2] . "-" . $date[0] . "-" . $date[1];
        }
        $article->save();

        return redirect('admin_articles')->with('success', 'Article added successfully');
    }

    public function changeArticleStatus($status, $article_id) {
//        Order::where('id', $order_id)->update(['status'=> $status]);
        if ($status == 0) {
            Article::where('id', $article_id)->update(['displayed' => $status]);
        } else {
            $article = Article::find($article_id);
            Article::where('type', $article->type)->update(['displayed' => 0]);
            Article::where('id', $article_id)->update(['displayed' => $status]);
        }

        return redirect()->back()->with('success', 'Article status has been changed');
    }

    public function deleteArticle($article_id) {
        Article::where('id', $article_id)->delete();

        return redirect()->back()->with('success', 'Article deleted successfully');
    }

    public function editArticle($article_id) {
        $data['title'] = 'Update Article';
        $data['article'] = Article::where('id', $article_id)->with('getQuestion', 'getUserStrain')->first();
        $data['user_strains'] = UserStrain::orderBy('updated_at', 'Desc')->get();
        $data['cats'] = ArticalCategory::orderBy('title')->get();
        $data['questions'] = Question::orderBy('updated_at', 'Desc')->get();
        return view('admin.article.edit_article', $data);

        return Response::json(array('data' => $data));
    }

    function updateArticle(request $request) {
        Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required',
        ])->validate();

        $article = Article::where('id', $request['article_id'])->first();
        $article->title = $request['title'];
        $article->cat_id = $request->cat_id;
        $article->description = $request['description'];
        $article->type = $request['type'];
        if ($request['display_date'] && !empty($request['display_date'])) {
            $date = explode('/', $request['display_date']);
            if (isset($date[2])) {
                $article->display_date = $date[2] . "-" . $date[0] . "-" . $date[1];
            }
        }
        if ($request['image']) {
             $file_thumb = $request['image'];
            $file_size = Image::make($file_thumb->getRealPath())->filesize();
            if ($file_size > 2092446) {
                $fileName = 'image_' . Str::random(15) . '.' . $file_thumb->getClientOriginalExtension();
                Image::make($file_thumb)->resize(500, null, function ($constraints) {
                            $constraints->aspectRatio();
                        })
                        ->save('public/images/articles/' . $fileName);
                $article->thumb = '/articles/' . $fileName;
            }
            $article->image = addFile($request['image'], 'articles');
            if ($file_size < 2092446) {
                $article->thumb = $article->image;
            }
        }
        if ($request['type'] == 'Question') {
            $article->question_id = $request['question_id'];
            $article->user_strain_id = NULL;
        } else if ($request['type'] == 'Strain') {
            $article->user_strain_id = $request['user_strain_id'];
            $article->question_id = NULL;
        } else {
            $article->user_strain_id = NULL;
            $article->question_id = NULL;
        }
        $article->teaser_text = $request['teaser_text'];
        $article->save();

        return redirect('admin_articles')->with('success', 'Article updated successfully');
    }

    function adminArticlesCategories() {
        $data['title'] = 'Article Categories';
        $data['cats'] = ArticalCategory::orderBy('updated_at', 'Desc')->get();
        return view('admin.article.article_categories', $data);
    }

    function addArticleCategory(Request $request) {
        if (!$request->title) {
            return redirect()->back()->with('error', 'Title is required');
        }
        $add_category = new ArticalCategory;
        $message = 'Category added successfully';
        if ($request->id) {
            $add_category = ArticalCategory::find($request->id);
            $message = 'Category updated successfully';
        }
        $add_category->title = $request->title;
        $add_category->save();
        return redirect()->back()->with('success', $message);
    }

    function deleteCategory($cat_id) {
        ArticalCategory::where('id', $cat_id)->delete();
        return redirect()->back()->with('success', 'Category deleted successfully');
    }

    function deleteMultipleArticalCategories(Request $request) {
        $ids = explode(',', $request['ids']);
        ArticalCategory::whereIn('id', $ids)->delete();
        return response()->json(['success' => "Categories deleted successfully."]);
    }

}
