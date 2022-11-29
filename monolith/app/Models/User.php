<?php

namespace App\Models;

use App\Exceptions\EmptyPasswordException;
use App\Exceptions\PasswordHashException;
use Egal\Auth\Tokens\UserMasterRefreshToken;
use Egal\Auh\Tokens\UserMasterToken;
use Egal\AuthServiceDependencies\Exceptions\LoginException;
use Egal\AuthServiceDependencies\Models\User as BaseUser;
use Egal\Model\Model;
use Egal\Model\Traits\UsesUuidKey;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Collection;
use Staudenmeir\EloquentHasManyDeep\HasRelationships;
use Egal\Model\Model as EgalModel;

/**
 * @property $id            {@property-type field}  {@primary-key}
 * @property $email         {@property-type field}
 * @property $password      {@property-type field}
 * @property $created_at    {@property-type field}
 * @property $updated_at    {@property-type field}
 *
 * @property Collection $roles          {@property-type relation}
 * @property Collection $permissions    {@property-type relation}
 *
 * @action register                     {@statuses-access guest}
 * @action login                        {@statuses-access guest}
 * @action loginToService               {@statuses-access guest}
 * @action refreshUserMasterToken       {@statuses-access guest}
 */
class User extends EgalModel
{
    use HasFactory;
    use HasRelationships;

    protected $hidden = [
        'password',
    ];

    protected $guarder = [
        'created_at',
        'updated_at',
    ];

    public static function actionRegister(string $email, string $password): User
    {
        if (!$password) {
            throw new EmptyPasswordException();
        }

        $user = new static();
        $user->setAttribute('email', $email);
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        if (!$hashedPassword) {
            throw new PasswordHashException();
        }

        $user->setAttribute('password', $hashedPassword);
        $user->save();

        return $user;
    }

    public static function actionLogin(string $email, string $password): array
    {
        /** @var BaseUser $user */
        $user = self::query()
            ->where('email', '=', $email)
            ->first();

        if (!$user || !password_verify($password, $user->getAttribute('password'))) {
            throw new LoginException('Incorrect Email or password!');
        }

        $umt = new UserMasterToken();
        $umt->setSigningKey(config('app.service_key'));
        $umt->setAuthIdentification($user->getAuthIdentifier());

        $umrt = new UserMasterRefreshToken();
        $umrt->setSigningKey(config('app.service_key'));
        $umrt->setAuthIdentification($user->getAuthIdentifier());

        return [
            'user_master_token' => $umt->generateJWT(),
            'user_master_refresh_token' => $umrt->generateJWT()
        ];
    }

    public function winMatches()
    {
        return $this->hasMany(LotteryGameMatch::class, 'winner_id');
    }

    public function lotteryGameMatches()
    {
        return $this->belongsToMany(LotteryGameMatch::class, 'lottery_game_match_users', 'user_id', 'lottery_game_match_id');
    }
}
