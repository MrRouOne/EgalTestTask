<?php

namespace App\Models;

use Egal\Model\Model as EgalModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property $id {@property-type field} {@primary-key}
 * @property $game_id {@property-type field}
 * @property $start_date {@property-type field}
 * @property $start_time {@property-type field}
 * @property $winner_id {@property-type field}
 * @property $created_at {@property-type field}
 * @property $updated_at {@property-type field}
 *
 * @action getMetadata {@statuses-access guest|logged}
 * @action getItem {@statuses-access guest|logged}
 * @action getItems {@statuses-access logged} {@roles-access super_first_role|super_second_role}
 * @action create {@statuses-access logged} {@roles-access super_first_role,super_second_role}
 * @action update {@statuses-access logged} {@permissions-access super_first_permission|super_second_permission}
 * @action delete {@statuses-access logged} {@permissions-access super_first_permission,super_second_permission}
 */
class LotteryGameMatch extends EgalModel
{
    use HasFactory;

    protected $fillable = [
        'game_id',
        'start_date',
        'start_time',
        'winner_id',
    ];

    protected $guarder = [
        'created_at',
        'updated_at',
    ];

    public function lotteryGame()
    {
        return $this->belongsTo(LotteryGame::class, 'game_id');
    }

    public function winner()
    {
        return $this->belongsTo(User::class, 'winner_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'lottery_game_match_users','lottery_game_match_id','user_id');
    }

}
