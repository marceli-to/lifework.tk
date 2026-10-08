<?php
namespace App\Http\Controllers;
use Intervention\Image\ImageManager;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;

class ImageController extends Controller
{
  protected $maxWidth;
  protected $maxHeight;
  protected $coords;

  /**
   * Get HTTP response of either original image file or
   * template applied file.
   *
   * @param  \Illuminate\Http\Request $request
   * @param  string $template
   * @param  string $filename
   * @return \Illuminate\Http\Response
   */

  public function getResponse(Request $request, $template, $filename)
  {
    $this->maxWidth  = $request->query('w');
    $this->maxHeight = $request->query('h');
    $this->coords    = $request->query('c');

    switch (strtolower($template)) {
      case 'original':
        return $this->getOriginal($request, $filename);

      case 'download':
        return $this->getDownload($request, $filename);

      default:
        return $this->getImage($request, $template, $filename);
    }
  }

  /**
   * Get HTTP response of template applied image file
   *
   * @param  \Illuminate\Http\Request $request
   * @param  string $template
   * @param  string $filename
   * @return \Illuminate\Http\Response
   */
  protected function getImage(Request $request, $template, $filename)
  {
    $filter = $this->getTemplate($template);
    $path   = $this->getImagePath($filename);

    $key = 'imagecache.' . md5(implode('|', [
      $template, $path, filemtime($path), $this->maxWidth, $this->maxHeight, $this->coords
    ]));

    $content = Cache::remember($key, config('imagecache.lifetime') * 60, function () use ($filter, $path) {
      $image = (new ImageManager(config('image')))->make($path);
      $image = is_callable($filter) ? $filter($image) : $image->filter($filter);
      return (string) $image->encode();
    });

    return $this->buildResponse($request, $content);
  }

  /**
   * Get HTTP response of original image file
   *
   * @param  \Illuminate\Http\Request $request
   * @param  string $filename
   * @return \Illuminate\Http\Response
   */
  protected function getOriginal(Request $request, $filename)
  {
    return $this->buildResponse($request, file_get_contents($this->getImagePath($filename)));
  }

  /**
   * Get HTTP response of original image as download
   *
   * @param  \Illuminate\Http\Request $request
   * @param  string $filename
   * @return \Illuminate\Http\Response
   */
  protected function getDownload(Request $request, $filename)
  {
    return $this->getOriginal($request, $filename)
                ->header('Content-Disposition', 'attachment; filename=' . basename($filename));
  }

  /**
   * Returns corresponding template object from given template name
   *
   * @param  string $template
   * @return mixed
   */
  protected function getTemplate($template)
  {
    $template = config("imagecache.templates.{$template}");

    switch (true) {
    // closure template found
    case is_callable($template):
      return $template;

    // filter template found
    case is_string($template) && class_exists($template):
      return new $template($this->maxWidth, $this->maxHeight, $this->coords);

    default:
      // template not found
      abort(404);
    }
  }

  /**
   * Returns full image path from given filename
   *
   * @param  string $filename
   * @return string
   */
  protected function getImagePath($filename)
  {
    foreach (config('imagecache.paths') as $path) {
      // don't allow '..' in filenames
      $image_path = $path . '/' . str_replace('..', '', $filename);
      if (is_file($image_path)) {
        return $image_path;
      }
    }

    abort(404);
  }

  /**
   * Builds HTTP response from given image data
   *
   * @param  \Illuminate\Http\Request $request
   * @param  string $content
   * @return \Illuminate\Http\Response
   */
  protected function buildResponse(Request $request, $content)
  {
    $mime = (new \finfo(FILEINFO_MIME_TYPE))->buffer($content);

    // respond with 304 not modified if browser has the image cached
    $etag = md5($content);
    $not_modified = $request->header('If-None-Match') === $etag;

    return new Response($not_modified ? null : $content, $not_modified ? 304 : 200, [
      'Content-Type' => $mime,
      'Cache-Control' => 'max-age=' . (config('imagecache.lifetime') * 60) . ', public',
      'Content-Length' => $not_modified ? 0 : strlen($content),
      'Etag' => $etag,
    ]);
  }
}
