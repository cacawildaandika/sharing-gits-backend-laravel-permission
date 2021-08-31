<?php

namespace App\Http\Controllers;

use App\Exceptions\NotFoundException;
use App\Helpers\BasicResponse;
use App\Models\Article;
use Auth;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 *
 */
class ArticleController extends Controller
{
    /**
     * @var BasicResponse
     */
    private $basicResponse;

    /**
     *
     */
    public function __construct()
    {
        $this->basicResponse = new BasicResponse();
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        if (!Auth::user()->hasPermissionTo('read-article', 'api')) {
            return $this->basicResponse
                ->setStatusCode(403)
                ->setMessage('You are not allowed to read article')
                ->send();
        }

        $articles = Article::paginate(10);

        return $this->basicResponse
            ->setStatusCode(200)
            ->setMessage('Success get articles')
            ->setData($articles)
            ->send();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        if (!Auth::user()->hasPermissionTo('create-article', 'api')) {
            return $this->basicResponse
                ->setStatusCode(403)
                ->setMessage('You are not allowed to create article')
                ->send();
        }

        $data = (object)$request->only(['title', 'content', 'published_at']);

        $article = new Article();
        $article->author = Auth::id();
        $article->title = $data->title ?? 'untitled';
        $article->content = $data->content;
        $article->published_at = Carbon::createFromFormat('H:i d-m-Y', $data->published_at);
        $article->save();

        return $this->basicResponse
            ->setStatusCode(201)
            ->setMessage('Success create article')
            ->setData($this->findArticleById($article->id))
            ->send();
    }

    /**
     * @param $id
     * @return Article|Article[]|Collection|Model|JsonResponse
     */
    public function findArticleById($id)
    {
        $article = Article::find($id);
        if ($article != null) {
            return $article;
        }

        throw new NotFoundException('Article not found');
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        if (!Auth::user()->hasPermissionTo('read-article', 'api')) {
            return $this->basicResponse
                ->setStatusCode(403)
                ->setMessage('You are not allowed to read article')
                ->send();
        }

        $article = $this->findArticleById($id);

        return $this->basicResponse
            ->setStatusCode(200)
            ->setMessage('Success update article')
            ->setData($this->findArticleById($article->id))
            ->send();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param $id
     * @param Request $request
     * @return JsonResponse
     */
    public function update($id, Request $request): JsonResponse
    {
        if (!Auth::user()->hasPermissionTo('update-article', 'api')) {
            return $this->basicResponse
                ->setStatusCode(403)
                ->setMessage('You are not allowed to update article')
                ->send();
        }

        $data = (object)$request->only(['title', 'content', 'published_at']);

        $article = $this->findArticleById($id);
        if (property_exists($data, 'title')) $article->title = $data->title;
        if (property_exists($data, 'content')) $article->content = $data->content;
        if (property_exists($data, 'published_at')) $article->published_at = Carbon::createFromFormat('H:i d-m-Y', $data->published_at);
        $article->save();

        return $this->basicResponse
            ->setStatusCode(200)
            ->setMessage('Success update article')
            ->setData($this->findArticleById($article->id))
            ->send();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        if (!Auth::user()->hasPermissionTo('delete-article', 'api')) {
            return $this->basicResponse
                ->setStatusCode(403)
                ->setMessage('You are not allowed to delete article')
                ->send();
        }

        $article = $this->findArticleById($id);

        $article->delete();

        return $this->basicResponse
            ->setStatusCode(204)
            ->setMessage('Success delete article')
            ->send();
    }
}
