<?php

namespace App\Models;

use App\Events\CreatingUserEvent;
use App\Events\DeletingUserEvent;
use App\Events\UpdatingUserEvent;
use Egal\Auth\Tokens\UserServiceToken;
use Egal\AuthServiceDependencies\Exceptions\LoginException;
use Egal\AuthServiceDependencies\Models\User as BaseUser;
use Egal\Core\Session\Session;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Hash;
use Staudenmeir\EloquentHasManyDeep\HasRelationships;

/**
 * @property $id                        {@property-type field}  {@primary-key}
 * @property $first_name                {@property-type field}
 * @property $last_name                 {@property-type field}
 * @property $email                     {@property-type field}
 * @property $password                  {@property-type field}
 * @property $is_admin                  {@property-type field}
 * @property $points                    {@property-type field}
 * @property $created_at                {@property-type field}
 * @property $updated_at                {@property-type field}
 *
 * @action register                     {@statuses-access guest}
 * @action login                        {@statuses-access guest}
 * @action change                       {@statuses-access logged}
 * @action remove                       {@statuses-access logged}
 * @action getItems                     {@statuses-access logged} {@roles-access admin}
 */
class User extends BaseUser
{
    use HasFactory;
    use HasRelationships;

    protected $hidden = [
        'password',
        'is_admin',
    ];

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'points',
    ];

    protected $guarder = [
        'created_at',
        'updated_at',
    ];

    protected $dispatchesEvents = [
        'creating' => CreatingUserEvent::class,
        'updating' => UpdatingUserEvent::class,
        'deleting' => DeletingUserEvent::class,
    ];

    public static function actionRegister(array $attributes)
    {
        return self::actionCreate($attributes);
    }

    public static function actionChange(array $attributes)
    {
        $id = Session::getUserServiceToken()->getAuthInformation()['id'];
        return self::actionUpdate($id, $attributes);
    }

    public static function actionRemove()
    {
        $id = Session::getUserServiceToken()->getAuthInformation()['id'];
        return self::actionDelete($id);
    }

    public static function actionLogin(string $email, string $password)
    {
        $user = self::query()
            ->where('email', '=', $email)
            ->first();

        if (!$user || !Hash::check($password,$user->getAttribute('password'))) {
            throw new LoginException('Incorrect Email or password!');
        }

        $ust = new UserServiceToken();
        $ust->setSigningKey(env('APP_SERVICE_KEY'));
        $ust->setAuthInformation($user->generateAuthInformation());
        $ust->setTargetServiceName("monolith");

        return $ust->generateJWT();
    }

    public function winMatches()
    {
        return $this->hasMany(LotteryGameMatch::class, 'winner_id');
    }

    public function lotteryGameMatches()
    {
        return $this->belongsToMany(LotteryGameMatch::class, 'lottery_game_match_users', 'user_id', 'lottery_game_match_id');
    }


    protected function getRoles(): array
    {
        return !!self::getAttribute('is_admin') ? ["admin"] : ["user"];
    }

    protected function getPermissions(): array
    {
        return [];
    }
}
