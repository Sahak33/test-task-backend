<?php

namespace App\Repositories;

use App\Interfaces\UserRepositoryInterface;
use App\Mail\Mail as RegisterMail;
use App\Models\User;
use App\Services\InforuSMSService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Mail;

class UserRepository implements UserRepositoryInterface
{

    public function getUser($userId)
    {
        return User::findOrFail($userId);
    }

    public function storeUser(array $data)
    {
        try {
            DB::beginTransaction();
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email']
            ]);
            $user->phone()->create([
                'phone' => $data['phone']
            ]);
            $user->country()->create(['country' => $data['country']]);
            DB::commit();
            $register = Lang::get('auth-register');
            if ($user) {
                (new InforuSMSService)->sendMessage($user->phone->phone, $register['message'] );
                $mailData = ['title' => $register['title'],
                    'message' => $register['message'],
                    'from' => $register['from']
                ];
                Mail::to($user->email)->send(new RegisterMail($mailData));
            }
            return $user;
        } catch (\Exception $e) {
            DB::rollBack();
        }
    }


}
