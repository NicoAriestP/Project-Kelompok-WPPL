<?php

namespace App\Http\Requests\Task;

use App\Enum\Task\EffortType;
use App\Enum\Task\PriorityType;
use App\Enum\Task\StatusType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Validation\Rule;

class EditTaskFormRequest extends FormRequest
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
            'category_id' => 'required|exists:App\Models\Category,id',
            'pic_id' => 'required|exists:App\Models\User,id',
            'title' => 'required|string|max:255',
            'description' => 'required',
            'due_at' => 'required|date_format:Y-m-d H:i:s',
            'finished_at' => 'required|date_format:Y-m-d H:i:s',
            'estimation' => 'required|string|max:20',
            'priority' => ['required', 
                Rule::in([
                    PriorityType::LOW->value,
                    PriorityType::NORMAL->value,
                    PriorityType::HIGH->value,
                    PriorityType::URGENT->value,
                ]),
            ],
            'effort' => ['required', 
                Rule::in([
                    EffortType::EASY->value,
                    EffortType::MEDIUM->value,
                    EffortType::HARD->value,
                ]),
            ],
            'status' => ['required', 
                Rule::in([
                    StatusType::OPEN->value,
                    StatusType::IN_PROGRESS->value,
                    StatusType::RESOLVED->value,
                    StatusType::CLOSED->value,
                    StatusType::REOPEN->value,
                ]),
            ],
            'file' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:4096',
        ];
    }
}
