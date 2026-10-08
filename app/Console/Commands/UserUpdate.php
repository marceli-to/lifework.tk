<?php
namespace App\Console\Commands;
use App\Console\Commands\Concerns\ManagesUsers;
use Illuminate\Console\Command;
use function Laravel\Prompts\confirm;
use function Laravel\Prompts\text;

class UserUpdate extends Command
{
  use ManagesUsers;

  protected $signature = 'user:update
                          {user : ID or email of the user}
                          {--firstname= : New first name}
                          {--name= : New last name}
                          {--email= : New email address}
                          {--password : Set a new password (asked for, hidden)}
                          {--generate-password : Set a new random password}';

  protected $description = 'Update a backend user (name, email, password)';

  public function handle()
  {
    $user = $this->findUser($this->argument('user'));
    if (!$user)
    {
      return self::FAILURE;
    }

    $data = array_filter([
      'firstname' => $this->option('firstname'),
      'name'      => $this->option('name'),
      'email'     => $this->option('email'),
    ], fn ($value) => $value !== null);

    $changePassword = $this->option('password') || $this->option('generate-password');

    // No options: ask for every field, the current value as default
    if (!$data && !$changePassword)
    {
      $this->showUser($user);

      $data = [
        'firstname' => text(label: 'First name', default: $user->firstname, required: true,
          validate: fn ($value) => $this->validateField('firstname', $value, $user)),
        'name' => text(label: 'Last name', default: $user->name, required: true,
          validate: fn ($value) => $this->validateField('name', $value, $user)),
        'email' => text(label: 'Email', default: $user->email, required: true,
          validate: fn ($value) => $this->validateField('email', $value, $user)),
      ];

      $changePassword = confirm(label: 'Set a new password?', default: false);
    }

    if (!$this->validateFields($data, $user))
    {
      return self::FAILURE;
    }

    $user->forceFill($data);

    $password = null;
    if ($changePassword)
    {
      $password = $this->option('generate-password') ? $this->generatePassword() : $this->askPassword();
      $user->password = bcrypt($password);
    }

    $changes = array_keys($user->getDirty());
    if (!$changes)
    {
      $this->components->info('Nothing changed.');
      return self::SUCCESS;
    }

    // Logged in sessions shouldn't survive a password or email change
    if ($user->isDirty('password') || $user->isDirty('email'))
    {
      $this->endSessions($user);
    }

    $user->save();

    $this->components->info('User updated: ' . implode(', ', $changes) . '.');
    $this->showUser($user);

    if ($password && $this->option('generate-password'))
    {
      $this->showGeneratedPassword($password);
    }

    return self::SUCCESS;
  }
}
