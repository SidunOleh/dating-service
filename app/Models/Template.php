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
        $ads = Ad::active()
            ->inRandomOrder()
            ->limit($this->count('ad'))
            ->get();
        $roulettes = Creator::showOnSite()
            ->playRoulette()
            ->inRandomOrder()
            ->limit($this->count('roulette') * 2)
            ->get();
        $profiles = Creator::mainList(
            $this->page, 
            $this->count('profile'), 
            $this->filters
        );

        $this->data = new Collection();
        foreach ($this->template as $block) {
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

            if (
                $block == 'profile' and
                $profiles->count()
            ) {
                $this->data->push($profiles->shift());
            }
        }

        $this->total = ceil(Creator::mainListTotalCount($this->filters) / $this->count('profile'));
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
