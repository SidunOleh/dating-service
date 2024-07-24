<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class Template extends Model
{
    use HasFactory;

    protected $fillable = [
        'template',
    ];
    
    protected $casts = [
        'template' => 'array',
    ];

    private int $page = 1;
    
    private array $filters = [];

    private Collection $data;

    private int $total;

    public function count(string $block): int
    {
        $blocks = array_filter($this->template, fn ($item) => $item == $block);

        return count($blocks);
    }

    public function getPage(): int
    {
        return $this->page;
    }
    
    public function setPage(int $page): self
    {
        $this->page = $page;

        return $this;
    }

    public function setFilters(array $filters): self
    {
        $this->filters = $filters;

        return $this;
    }

    public function fillData(): void
    {
        $this->data = new Collection();
        $this->total = 0;

        $profiles = Creator::mainList(
            $this->page, 
            $this->count('profile'), 
            $this->filters
        );

        if (! $profiles->count()) {
            return;
        }

        $this->total = ceil(
            Creator::mainListTotalCount($this->filters) / $this->count('profile')
        );

        $ads = Ad::with('image')
            ->active()
            ->type('block')
            ->inRandomOrder()
            ->limit($this->count('ad'))
            ->get();
        $roulettes = Creator::with('gallery')
            ->showOnSite()
            ->playRoulette()
            ->inRandomOrder()
            ->limit($this->count('roulette') * 2)
            ->get();

        foreach ($this->template as $block) {
            if ($block == 'profile') {
                if ($profiles->count()) {
                    $this->data->push($profiles->shift());
                } else {
                    break;
                }
            }

            if (
                $block == 'ad' and
                $ads->count()
            ) {
                $this->data->push($ads->shift());
            }

            if (
                $block == 'roulette' and
                $roulettes->count() >= 2
            ) {
                $this->data->push([
                    $roulettes->shift(),
                    $roulettes->shift(),
                ]);
            }
        }
    }

    public function data(): Collection
    {
        return $this->data;
    }

    public function total(): int
    {
        return $this->total;
    }
}
