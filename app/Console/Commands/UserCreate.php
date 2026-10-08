<?php
namespace App\Console\Commands;
use App\Console\Commands\Concerns\ManagesUsers;
use App\Models\User;
use Illuminate\Console\Command;
use function Laravel\Prompts\text;

class UserCreate extends Command
{
  use ManagesUsers;

  protected $signature = 'user:create
                          {--firstname= : First name}
                          {--name= : Last name}
                          {--email= : Email address (used to log in)}
                          {--generate-password : Generate a random password instead of asking for one}';

  protected $description = 'Create a backend user (admin)';

  public function handle()
  {
    $data = [
      'firstname' => $this->option('firstname') ?? text(
        label: 'First name',
        required: true,
        validate: fn ($value) => $this->validateField('firstname', $value)
      ),
      'name' => $this->option('name') ?? text(
        label: 'Last name',
        required: true,
        validate: fn ($value) => $this->validateField('name', $value)
      ),
      'email' => $this->option('email') ?? text(
        label: 'Email',
        required: true,
        validate: fn ($value) => $this->validateField('email', $value)
      ),
    ];

    // Options skip the prompts' validation
    if (!$this->validateFields($data))
    {
      return self::FAILURE;
    }

    $generated = $this->option('generate-password');
    $password = $generated ? $this->generatePassword() : $this->askPassword();

    $user = new User;
    $user->firstname = $data['firstname'];
    $user->name = $data['name'];
    $user->email = $data['email'];
    $user->password = bcrypt($password);
    $user->role = 'admin';
    // No verification mail: the backend requires a verified address
    $user->email_verified_at = now();
    $user->save();

    $this->components->info('User created.');
    $this->showUser($user);

    if ($generated)
    {
      $this->showGeneratedPassword($password);
    }

    return self::SUCCESS;
  }
}
