<?php
namespace App\Console\Commands\Concerns;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use function Laravel\Prompts\password;

/**
 * Shared helpers for the user:* commands
 */
trait ManagesUsers
{
  /**
   * Find a user by id or email, or fail with an error
   *
   * @param string $identifier
   * @return User|null
   */
  protected function findUser($identifier)
  {
    $user = ctype_digit((string) $identifier)
      ? User::find($identifier)
      : User::where('email', $identifier)->first();

    if (!$user)
    {
      $this->components->error("No user found for [{$identifier}].");
    }

    return $user;
  }

  /**
   * Validation rules per field
   *
   * @param User|null $user  the user being updated (for the unique email rule)
   * @return array
   */
  protected function rules($user = null)
  {
    return [
      'firstname' => ['required', 'string', 'max:255'],
      'name'      => ['required', 'string', 'max:255'],
      'email'     => ['required', 'email', 'max:255', 'unique:users,email' . ($user ? ',' . $user->id : '')],
      'password'  => ['required', 'string', 'min:8'],
    ];
  }

  /**
   * Validate a single field; returns the error message or null (for prompt callbacks)
   *
   * @param string $field
   * @param mixed $value
   * @param User|null $user
   * @return string|null
   */
  protected function validateField($field, $value, $user = null)
  {
    $validator = Validator::make([$field => $value], [$field => $this->rules($user)[$field]]);
    return $validator->fails() ? $validator->errors()->first($field) : null;
  }

  /**
   * Validate the given fields; prints the errors and returns false if invalid
   *
   * @param array $data
   * @param User|null $user
   * @return bool
   */
  protected function validateFields(array $data, $user = null)
  {
    $validator = Validator::make($data, array_intersect_key($this->rules($user), $data));

    if ($validator->fails())
    {
      foreach ($validator->errors()->all() as $error)
      {
        $this->components->error($error);
      }
      return false;
    }

    return true;
  }

  /**
   * Ask for a new password twice (hidden input)
   *
   * @return string
   */
  protected function askPassword()
  {
    // Validated after the prompts, not in them: a prompt keeps the rejected
    // (hidden) input in the field, so the next attempt would be appended to it
    while (true)
    {
      $password = password(label: 'Password', required: true, hint: 'At least 8 characters.');

      if ($error = $this->validateField('password', $password))
      {
        $this->components->error($error);
        continue;
      }

      if (password(label: 'Confirm password', required: true) !== $password)
      {
        $this->components->error('The passwords do not match. Please try again.');
        continue;
      }

      return $password;
    }
  }

  /**
   * A random password
   *
   * @return string
   */
  protected function generatePassword()
  {
    return Str::password(20, symbols: false);
  }

  /**
   * Print a generated password on its own line (no trailing period to copy along)
   *
   * @param string $password
   * @return void
   */
  protected function showGeneratedPassword($password)
  {
    $this->components->warn('Generated password, shown only once:');
    $this->line('  <options=bold>' . $password . '</>');
    $this->newLine();
  }

  /**
   * Log the user out everywhere: drop their database sessions
   * and "remember me" token
   *
   * @param User $user
   * @return void
   */
  protected function endSessions(User $user)
  {
    $user->setRememberToken(Str::random(60));

    if (config('session.driver') === 'database')
    {
      DB::table(config('session.table', 'sessions'))->where('user_id', $user->id)->delete();
    }
  }

  /**
   * Print a user as a two-column table
   *
   * @param User $user
   * @return void
   */
  protected function showUser(User $user)
  {
    $this->table([], [
      ['ID', $user->id],
      ['First name', $user->firstname],
      ['Name', $user->name],
      ['Email', $user->email],
      ['Role', $user->role],
      ['Created', optional($user->created_at)->format('d.m.Y H:i')],
    ]);
  }
}
