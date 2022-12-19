<?php

namespace App\Models;

use App\Events\CreatingUserEvent;
use App\Events\DeletingUserEvent;
use App\Events\UpdatingUserEvent;
use Carbon\Carbon;
use Egal\Auth\Tokens\UserServiceToken;
use Egal\AuthServiceDependencies\Exceptions\LoginException;
use Egal\AuthServiceDependencies\Models\User as BaseUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

/**
 * @property integer $id                        {@property-type field}  {@primary-key}
 * @property string $first_name                 {@property-type field}
 * @property string $last_name                  {@property-type field}
 * @property string $email                      {@property-type field}
 * @property string $password                   {@property-type field}
 * @property boolean $is_admin                  {@property-type field}
 * @property integer $points                    {@property-type field}
 * @property Carbon $created_at                 {@property-type field}
 * @property Carbon $updated_at                 {@property-type field}
 *
 * @property Collection $matches                {@property-type relation}
 * @property Collection $won_matches            {@property-type relation}
 *
 * @action create                               {@statuses-access guest}
 * @action login                                {@statuses-access guest}
 * @action update                               {@statuses-access logged} {@roles-access admin|user}
 * @action delete                               {@statuses-access logged} {@roles-access admin|user}
 * @action getItems                             {@statuses-access logged} {@roles-access admin}
 */
class User extends BaseUser
{
    use HasFactory;

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

    /**
     * @throws LoginException
     */
    public static function actionLogin(string $email, string $password): string
    {

        $user = self::query()->where('email', '=', $email)->first();

        if (!$user || !password_verify($password, $user->password)) {
            throw new LoginException('Incorrect Email or password!');
        }

        return $user->generateAuthToken($user->generateAuthInformation());
    }

    public function wonMatches(): HasMany
    {
        return $this->hasMany(LotteryGameMatch::class, 'winner_id');
    }

    public function matches(): BelongsToMany
    {
        return $this->belongsToMany(
            LotteryGameMatch::class,
            'lottery_game_match_users',
            'user_id',
            'lottery_game_match_id'
        );
    }

    protected function getRoles(): array
    {
        return self::getAttribute('is_admin') ? ["admin"] : ["user"];
    }

    protected function getPermissions(): array
    {
        return [];
    }

    protected function generateAuthToken(array $authInformation): string
    {
        $ust = new UserServiceToken();
        $ust->setSigningKey(env('APP_SERVICE_KEY'));
        $ust->setAuthInformation($authInformation);
        $ust->setTargetServiceName(config('app.service_name'));

        return $ust->generateJWT();
    }
}
