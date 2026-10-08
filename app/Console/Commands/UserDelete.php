<?php
namespace App\Console\Commands;
use App\Console\Commands\Concerns\ManagesUsers;
use App\Models\User;
use Illuminate\Console\Command;
use function Laravel\Prompts\confirm;

class UserDelete extends Command
{
  use ManagesUsers;

  protected $signature = 'user:delete
                          {user : ID or email of the user}
                          {--force : Delete without asking}';

  protected $description = 'Delete a backend user';

  public function handle()
  {
    $user = $this->findUser($this->argument('user'));
    if (!$user)
    {
      return self::FAILURE;
    }

    // Nobody could log in to the backend anymore
    if (User::count() === 1)
    {
      $this->components->error('This is the last user and can\'t be deleted. Create another one first.');
      return self::FAILURE;
    }

    $this->showUser($user);

    if (!$this->option('force') && !confirm(label: "Delete {$user->email}?", default: false))
    {
      $this->components->info('Cancelled.');
      return self::SUCCESS;
    }

    $this->endSessions($user);
    $user->delete();

    $this->components->info("User {$user->email} deleted.");

    return self::SUCCESS;
  }
}
