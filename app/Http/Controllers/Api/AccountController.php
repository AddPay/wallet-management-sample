<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdjustBalanceRequest;
use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AccountController extends Controller
{
    /**
     * Get all accounts for the authenticated user.
     *
     * @param $request \Illuminate\Http\Request
     * @return \Illuminate\Http\JsonResponse
     */
    public function all(Request $request)
    {
        return response()->json([
            'accounts' => $request->user()->accounts
        ]);
    }

    /**
     * Create an account with a given account ID.
     *
     * @param $request \Illuminate\Http\Request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request)
    {
        $validator = Validator::make($request->only('name'), [
            'name' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ]);
        }

        Account::create([
            'user_id' => $request->user()->id,
            'name' => $request->get('name'),
            'balance' => 0
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Account created successfully.'
        ]);
    }

    /**
     * Delete an account with a given account ID.
     *
     * @param $request \Illuminate\Http\Request
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request)
    {
        $validator = Validator::make($request->only('account_id'), [
            'account_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ]);
        }

        $account = Account::where([
            'id' => $request->get('account_id'),
            'user_id' => $request->user()->id
        ])->first();

        if (!$account) {
            return response()->json([
                'success' => false,
                'message' => 'Account not found.'
            ], 404);
        }

        $account->delete();

        return response()->json([
            'success' => true,
            'message' => 'Account deleted successfully.'
        ]);
    }

    /**
     * Get the balance of the given account ID.
     *
     * @param $request \Illuminate\Http\Request
     * @return \Illuminate\Http\JsonResponse
     */
    public function balance(Request $request)
    {
        $validator = Validator::make($request->only('account_id'), [
            'account_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ]);
        }

        $account = Account::where([
            'id' => $request->get('account_id'),
            'user_id' => $request->user()->id
        ])->first();

        if (!$account) {
            return response()->json([
                'success' => false,
                'message' => 'Account not found.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'balance' => $account->balance,
                'formatted_balance' => $account->formatted_balance
            ]
        ]);
    }

    /**
     * Add to account balance with give account ID.
     *
     * @param $request \Illuminate\Http\Request
     * @return \Illuminate\Http\JsonResponse
     */
    public function balanceAdd(AdjustBalanceRequest $request)
    {
        $account = $request->getAccount();

        $account->balance = $account->balance + $request->get('amount', 0);
        $account->save();

        return response()->json([
            'success' => true,
            'data' => [
                'balance' => $account->balance,
                'formatted_balance' => $account->formatted_balance
            ]
        ]);
    }

    /**
     * Deduct from account balance with given account ID.
     *
     * @param $request \Illuminate\Http\Request
     * @return \Illuminate\Http\JsonResponse
     */
    public function balanceDeduct(AdjustBalanceRequest $request)
    {
        $account = $request->getAccount();

        $account->balance = $account->balance - $request->get('amount', 0);
        $account->save();

        return response()->json([
            'success' => true,
            'data' => [
                'balance' => $account->balance,
                'formatted_balance' => $account->formatted_balance
            ]
        ]);
    }
}
