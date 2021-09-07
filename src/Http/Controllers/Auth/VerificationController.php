<?php

namespace Juzaweb\Http\Controllers\Auth;

use Juzaweb\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Juzaweb\Models\User;

class VerificationController extends Controller
{
    public function verification($email, $token)
    {
        $user = User::whereEmail($email)
            ->where('verification_token', '=', $token)
            ->first();
        
        if ($user) {
            DB::beginTransaction();
    
            try {
                $user->update([
                    'status' => 'active',
                    'verification_token' => null,
                ]);
                
                DB::commit();
            } catch (\Exception $exception) {
                DB::rollBack();
                throw $exception;
            }
            
            return redirect()->route('auth.login');
        }
        
        return abort(404);
    }
}
