<?php
namespace App\Console\Commands;
use App\Models\User;
use Illuminate\Console\Command;

class UserList extends Command
{
  protected $signature = 'user:list';

  protected $description = 'List all backend users';

  public function handle()
  {
    $users = User::orderBy('id')->get();

    if ($users->isEmpty())
    {
      $this->components->info('No users yet, create one with "php artisan user:create".');
      return self::SUCCESS;
    }

    $this->table(
      ['ID', 'First name', 'Name', 'Email', 'Role', 'Created'],
      $users->map(fn ($user) => [
        $user->id,
        $user->firstname,
        $user->name,
        $user->email,
        $user->role,
        optional($user->created_at)->format('d.m.Y H:i'),
      ])
    );

    return self::SUCCESS;
  }
}
