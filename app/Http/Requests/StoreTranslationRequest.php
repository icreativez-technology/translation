<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTranslationRequest extends FormRequest
{
    public function rules()
    {
        return [
            'group' => 'required|string|max:50',
            'key' => 'required|string|max:100',
            'value' => 'required|string',
            'locale' => 'required|string|max:10',
            'tags' => 'sometimes|array',
            'tags.*' => 'string|max:50'
        ];
    }
}

