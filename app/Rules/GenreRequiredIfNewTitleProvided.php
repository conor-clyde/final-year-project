<?php
// app/Rules/GenreRequiredIfNewTitleProvided.php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class GenreRequiredIfNewTitleProvided implements Rule
{
    public function passes($attribute, $value)
    {
        $newTitle = request()->input('new_title');
        $newGenre = request()->input('new_genre');

        // 'genre' is required only if 'new_title' is provided and 'new_genre' is not provided
        return ($newTitle && !$newGenre) ? !empty($value) : true;
    }

    public function message()
    {
        return 'The :attribute field is required when a new title is provided and a new genre is not.';
    }
}
