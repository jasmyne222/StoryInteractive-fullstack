<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProgressStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Vérifie si l'utilisateur peut sauvegarder sa progression
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'story_id' => 'required|exists:stories,id',
            'chapter_id' => 'required|exists:chapters,id',
            'choices_made' => 'array',
            'choices_made.*' => 'exists:choices,id'
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'story_id.required' => 'Une histoire doit être sélectionnée',
            'story_id.exists' => 'Cette histoire n\'existe pas',
            'chapter_id.required' => 'Un chapitre doit être sélectionné',
            'chapter_id.exists' => 'Ce chapitre n\'existe pas',
            'choices_made.array' => 'Les choix doivent être dans un tableau',
            'choices_made.*.exists' => 'Un des choix sélectionnés n\'existe pas'
        ];
    }
}
