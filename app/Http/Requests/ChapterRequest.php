<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChapterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'story_id' => 'required|exists:stories,id',
            'chapter_number' => 'required|integer|min:1',
            'content' => 'required|string|min:10'
        ];
    }

    public function messages(): array
    {
        return [
            'story_id.required' => 'L\'histoire est requise',
            'story_id.exists' => 'Cette histoire n\'existe pas',
            'chapter_number.required' => 'Le numéro du chapitre est requis',
            'chapter_number.integer' => 'Le numéro du chapitre doit être un nombre',
            'content.required' => 'Le contenu est requis',
            'content.min' => 'Le contenu doit faire au moins 10 caractères'
        ];
    }
}