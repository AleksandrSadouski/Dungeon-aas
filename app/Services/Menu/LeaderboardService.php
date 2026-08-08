    <?php
    namespace App\Services\Menu;

    use App\Models\Player;
    use App\Http\Resources\LeaderboardResource;
    use Illuminate\Support\Facades\Cache;


    class LeaderboardService
    {
    public function detLeaderboard(string $typeTop): array
    {
        return match($typeTop)
        {
            'kol_gold' => ['nameTop' => 'top_kol_gold', 'currentColumn' => 'kol_gold', 'limit' => 5];
            'kol_rooms' => ['nameTop' => 'top_kol_rooms', 'currentColumn' => 'kol_rooms', 'limit' => 5];
            'max_rooms' => ['nameTop' => 'top_max_rooms', 'currentColumn' => 'max_rooms', 'limit' => 5];
            default => ['nameTop' => 'top_max_rooms', 'currentColumn' => 'max_rooms', 'limit' => 5];
        };
    }

    public function createLeaderboard(string $nameTop, string $currentColumn, int $limit)
    {
        $players = Cache::remember($nameTop, 240, function () use ($currentColumn, $limit) {
            return Player::orderBy($currentColumn, 'desc')->select('name', $currentColumn)->limit($limit)->get();
            });
        return LeaderboardResource::collection($players);
    }

    public function getLeaderboard(string $typeTop)
    {
        $data = $this->detLeaderboard($typeTop);
        return $this->createLeaderboard($data['nameTop'], $data['currentColumn'], $data['limit']);
    }
    }