<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Http\Resources\DataCollection;
use App\Models\Post;
use App\Http\Requests\PostStoreRequest;
use Illuminate\Http\Request;

class PostController extends Controller
{
  public function __construct(Post $post)
  {
    $this->post = $post;
  }

  /**
   * Get a list of post
   * 
   * @return \Illuminate\Http\Response
   */
  public function get()
  {
    return new DataCollection($this->post->orderBy('date', 'DESC')->get());
  }

  /**
   * Get a single post for a given post or authenticated post
   * 
   * @param Post $post
   * @return \Illuminate\Http\Response
   */
  public function find(Post $post)
  {
    $post = $this->post->findOrFail($post->id);
    return response()->json($post);
  }

  /**
   * Store a newly created Post
   *
   * @param  \Illuminate\Http\Request $request
   * @return \Illuminate\Http\Response
   */
  public function store(PostStoreRequest $request)
  {
    $post = Post::create($request->all());
    $post->save();
    return response()->json(['postId' => $post->id]);
  }

  /**
   * Update a Post for a given Post
   *
   * @param Post $post
   * @param  \Illuminate\Http\Request $request
   * @return \Illuminate\Http\Response
   */
  public function update(Post $post, PostStoreRequest $request)
  {
    $post = $this->post->findOrFail($post->id);
    $post->update($request->all());
    $post->save();
    return response()->json('successfully updated');
  }

  /**
   * Update the order of the given posts
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function order(Request $request)
  {
    $posts = $request->get('post');
    foreach($posts as $post)
    {
      $p = $this->post->find($post['id']);
      $p->order = $post['order'];
      $p->save(); 
    }
    return response()->json('successfully updated');
  }

  /**
   * Toggle the status a given Post
   *
   * @param  Post $post
   * @return \Illuminate\Http\Response
   */
  public function toggle(Post $post)
  {
    $post->publish = $post->publish == 0 ? 1 : 0;
    $post->save();
    return response()->json($post->publish);
  }

  /**
   * Remove a Post
   *
   * @param  Post $post
   * @return \Illuminate\Http\Response
   */
  public function destroy(Post $post)
  {
    $post->delete();
    return response()->json('successfully deleted');
  }
}
