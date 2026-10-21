<?php

namespace App\Services;

use App\Models\Category;
use App\Models\GrammarTemplate;
use Illuminate\Support\Collection;

use function PHPUnit\Framework\isEmpty;

class GrammarEngineService
{
    /**
     * Create a new class instance.
     */
    public function __construct(protected TextPolisherService $polisher)
    {}
    
    public function generate (?string $group = null, ?int $seed = null): string
    {
        if ($seed !== null)
        {
            mt_srand($seed);
        }else{
            mt_srand(rand(1,999));
        }

        $template = $this->pickTemplate($group);

        if(!$template){
            return "Abadu Badadi.";
        }

        $raw = $this->expand($template->pattern);

        return $this->polisher->polish($raw);

    }

    protected function pickTemplate(?string $group = null): ?GrammarTemplate
    {
        $query = GrammarTemplate::where('is_active', true);

        if($group)
        {
            $query->where('group', $group);
        }

        $templates = $query->get();

        if($templates->isEmpty())
        {
            return null;
        }

        return $this->pickWeightedItem($templates);
    }

    protected function expand(string $text, int $depth = 0): string
    {
        if($depth >= 5)
        {
            return $text;
        }

        return preg_replace_callback('/\{([a-zA-Z0-9_]+)\}/', function ($matches) use ($depth) {
            $tag = $matches[1];
            
            $category = Category::where('tag', $tag)->with('words')->first();

            if(!$category || $category->words->isEmpty())
            {
                return "[unknown: {$tag}]";
            }

            $chosenWord = $this->pickWeightedItem($category->words);

            return $this->expand($chosenWord->text, $depth + 1);

        }, $text);

    }

    protected function pickWeightedItem(Collection $items)
    {
        $totalWeight = $items->sum('weight');
        $roll = mt_rand(1, max(1, $totalWeight));
        foreach ($items as $item) {
            $roll -= $item->weight;
            if ($roll <= 0) {
                return $item; 
            }
        }
        return $items->first();
    }
}
