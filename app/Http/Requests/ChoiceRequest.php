<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChoiceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'chapter_id' => 'required|exists:chapters,id',
            'text' => 'required|string|min:5',
            'next_chapter_id' => 'required|exists:chapters,id'
        ];
    }

    public function messages(): array
    {
        return [
            'chapter_id.required' => 'Le chapitre est requis',
            'chapter_id.exists' => 'Ce chapitre n\'existe pas',
            'text.required' => 'Le texte du choix est requis',
            'text.min' => 'Le texte doit faire au moins 5 caractères',
            'next_chapter_id.required' => 'Le chapitre suivant est requis',
            'next_chapter_id.exists' => 'Le chapitre suivant n\'existe pas'
        ];
    }
}