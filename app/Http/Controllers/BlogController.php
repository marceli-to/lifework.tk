<?php
namespace App\Http\Controllers;
use App\Http\Controllers\BaseController;
use App\Models\Post;
use Illuminate\Http\Request;

class BlogController extends BaseController
{
  protected $viewPath = 'web.pages.';

  public function __construct(Post $post)
  {
    parent::__construct();
    $this->post = $post;
  }

  /**
   * Blog posts
   */

  public function index()
  {
    $posts = $this->post->published()->with('publishedImages')->orderBy('date', 'DESC')->get();
    return view($this->viewPath . 'blog', ['title' => 'Blog', 'posts' => $posts]);
  }

}
