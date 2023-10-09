<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateTicketRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title'       => 'required|max:64',
            'description' => 'required',
            'assigned_to' => 'required',
            'status'      => 'sometimes|required', 
        ];
    }

    /**
     *   * Custom message for validation
     *
     * @return array
     */
    public function messages()
    {
        return [
            "title.required" => "Ticket Title is required",
            "title.max" => "The title has to have no more than :max characters.",
            "description.required" => "Ticket Description is required",
            "assigned_to" => "Please select the User",
            "status.required" => "Please select the Status",
        ];
    }
    }
