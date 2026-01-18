<?php

  namespace App\Http\Requests;

  use Illuminate\Contracts\Validation\ValidationRule;
  use Illuminate\Foundation\Http\FormRequest;

  class UpdateUrlStatusRequest extends FormRequest
  {
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
      return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
      return [
        'status' => 'required|numeric|between:0,1',
      ];
    }

    public function messages(): array
    {
      return [
        'status.required' => 'Status is required',
      ];
    }
  }
