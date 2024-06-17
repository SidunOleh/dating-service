<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class Template extends Model
{
    use HasFactory;

    protected $fillable = [
        'template',
    ];
    
    protected $casts = [
        'template' => 'array',
    ];

    public function count(string $block): int
    {
        $blocks = array_filter($this->template, fn ($item) => $item == $block);

        return count($blocks);
    }

    public function fillData(int $page = 1): void
    {
        $ads = Ad::active()
            ->inRandomOrder()
            ->limit($this->count('ad'))
            ->get();
        $roulettes = Creator::showOnSite()
            ->playRoulette()
            ->inRandomOrder()
            ->limit($this->count('roulette') * 2)
            ->get();
        $profiles = Creator::mainList($page, $this->count('profile'));

        $this->blocks = new Collection();
        foreach ($this->template as $block) {
            if (
                $block == 'ad' and
                $ads->count()
            ) {
                $this->blocks->push($ads->shift());
            }

            if (
                $block == 'roulette' and
                $roulettes->count() >= 2
            ) {
                $this->blocks->push([
                    $roulettes->shift(),
                    $roulettes->shift(),
                ]);
            }

            if (
                $block == 'profile' and
                $profiles->count()
            ) {
                $this->blocks->push($profiles->shift());
            }
        }
    }

    public function total(): int
    {
        return Creator::mainListTotalCount();
    }
}
