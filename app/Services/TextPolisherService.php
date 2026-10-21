<?php

namespace App\Services;

class TextPolisherService
{
    /**
     * Create a new class instance.
     */
    public function polish(string $text)
    {
        $text = preg_replace('/\s+/', ' ', $text);
        $text = preg_replace('/\s+([.,?!;:])/', '$1', $text);
        $text = preg_replace('/\b(a)\s+([aeiou])/i', '${1}n $2', $text);
        $text = preg_replace('/([.,?!])\1+/', '$1', $text);
        $text = ucfirst(trim($text));

        if (!preg_match('/[,.!?]$/', $text))
        {
            $text .= '.';
        }

        return $text;
    }
}
