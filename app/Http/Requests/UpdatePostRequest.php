<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('update', $this->post);
    }

    /**
     * Prepare the data for validation.
     * 
     * Thanks to SO user BenSampo!
     * @see https://stackoverflow.com/a/54480210/5700388
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'published_at' => $this->is_draft 
                ? null
                : Carbon::parse($this->published_at),
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'description' => 'nullable|string|max:255',
            'featured_image' => 'nullable|url|max:255',
            'tags' => 'nullable|json',
            'published_at' => 'nullable|date|after:1970-12-31T12:00|before:2038-01-09T03:14',
        ];
    }
}
