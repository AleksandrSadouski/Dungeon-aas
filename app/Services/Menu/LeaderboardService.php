    <?php
    namespace App\Services\Menu;

    use App\Models\Player;
    use App\Http\Resources\LeaderboardResource;
    use Illuminate\Support\Facades\Cache;


    class LeaderboardService
    {

    public function showLeaderboard(string $nameTop, string $currentColumn, int $limit)
    {
        $players = Cache::remember($nameTop, 240, function () use ($currentColumn, $limit) {
            return Player::orderBy($currentColumn, 'desc')->select('name', $currentColumn)->limit($limit)->get();
            });
        return LeaderboardResource::collection($players);
    }

    }