<?php

namespace App\Http\Requests;

use App\Models\Account;
use Illuminate\Foundation\Http\FormRequest;

class AdjustBalanceRequest extends FormRequest
{
    public $account = null;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $this->account = Account::where([
            'id' => $this->get('account_id'),
            'user_id' => $this->user()->id
        ])->first();

        if ($this->account) {
            return true;
        }

        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'account_id' => 'required',
            'amount' => 'integer',
        ];
    }

    /**
     * Returns the account with a given ID.
     *
     * @return array|null
     */
    public function getAccount()
    {
        return $this->account;
    }
}
