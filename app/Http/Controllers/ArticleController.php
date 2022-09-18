<?php

namespace App\Http\Controllers;

use App\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::all();
        $response = [
            'success' => true,
            'message' => 'Articles Retrieved Successfully.',
            'data' => $articles
        ];
        return response($response, 200);
    }

    public function show(Article $article)
    {
        if (is_null($article)) {
            return response('Article not found.', 204);
        }
        return response([
            'success' => true,
            'message' => 'Article Retrieved Successfully.',
            'data' => $article
        ], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'body' => 'required',
            'user_id' =>'required'
        ]);

        if ($validator->fails()) {
            return response(['success' => false, 'message' => 'Validation Error.', 'data' => $validator->errors()], 400);
        }
        $article = Article::create($request->all());

        return response([
            'success' => true,
            'message' => 'Article Created Successfully.',
            'data' => $article
        ], 201);
    }

    public function update(Request $request, Article $article)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'body' => 'required'
        ]);
        if ($validator->fails()) {
            return response(['success' => false, 'message' => 'Validation Error.', 'data' => $validator->errors()], 400);
        }
        $article->update($request->all());

        return response([
            'success' => true,
            'message' => 'Article Updated Successfully.',
            'data' => $article
        ], 200);
    }

    public function destroy(Article $article)
    {
        $article->delete();

        return response([
            'success' => true,
            'message' => 'Article Deleted Successfully.',
        ], 204);
    }
}
