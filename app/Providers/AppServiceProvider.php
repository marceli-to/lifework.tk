<?php
namespace App\Providers;
use App\Observers\PostObserver;
use App\Observers\PostImageObserver;
use App\Models\Post;
use App\Models\PostImage;
use App\Observers\MemberObserver;
use App\Observers\MemberImageObserver;
use App\Observers\MemberFileObserver;
use App\Models\Member;
use App\Models\MemberImage;
use App\Models\MemberFile;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
  /**
   * Register any application services.
   *
   * @return void
   */
  public function register()
  {
    //
  }

  /**
   * Bootstrap any application services.
   *
   * @return void
   */
  public function boot()
  {
    setLocale(LC_ALL, 'de_CH.UTF-8');
    Post::observe(PostObserver::class);
    PostImage::observe(PostImageObserver::class);

    Member::observe(MemberObserver::class);
    MemberImage::observe(MemberImageObserver::class);
    MemberFile::observe(MemberFileObserver::class);

  }
}
