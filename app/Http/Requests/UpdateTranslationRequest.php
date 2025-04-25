<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTranslationRequest extends StoreTranslationRequest
{
    public function rules()
    {
        return array_merge(parent::rules(), [
            'group' => 'sometimes|string|max:50',
            'key' => 'sometimes|string|max:100',
            'value' => 'sometimes|string',
            'locale' => 'sometimes|string|max:10'
        ]);
    }
}
