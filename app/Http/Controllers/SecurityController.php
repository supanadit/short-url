<?php

namespace App\Http\Controllers;

use App\Mail\ForgotPassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class SecurityController extends Controller
{
    public function formLogin(Request $request)
    {
        $request->validate([
            "email" => "required",
            "password" => "required",
        ]);
        $user = \App\User::where("email", $request->input("email"))->first();
        if ($user != null) {
            if (Hash::check($request->input('password'), $user->password)) {
                // Set Session
                $request->session()->put('user', $user->id);
                $request->session()->put('name', $user->name);
                $request->session()->put('email', $user->email);

                return response()->json([
                    "message" => "Success login",
                ], 200);
            } else {
                return response()->json([
                    "message" => "Username or password is wrong",
                ], 401);
            }
        } else {
            return response()->json([
                "message" => "Username or password is wrong",
            ], 401);
        }
    }

    public function formRegister(Request $request)
    {
        $request->validate([
            "name" => "required",
            "email" => "required",
            "password" => "required",
            "password_confirm" => "required",
        ]);
        $user = \App\User::where("email", $request->input("email"))->first();
        if ($user != null) {
            return response()->json([
                "message" => "User with email " . $user->email . " is exist",
            ], 400);
        } else {
            if ($request->input('password') != $request->input('password_confirm')) {
                return response()->json([
                    "message" => "Confirm password is different with provided password",
                ], 400);
            } else {
                $user = new \App\User();
                $user->name = $request->input("name");
                $user->email = $request->input("email");
                $user->password = Hash::make($request->input("password"));
                if ($user->save()) {
                    return response()->json([
                        "message" => "Register success, now you can login...",
                    ], 200);
                } else {
                    return response()->json([
                        "message" => "Failed to register new user",
                    ], 400);
                }
            }
        }
    }

    public function formForgotPassword(Request $request)
    {
        $request->validate([
            "email" => "required",
        ]);
        $user = \App\User::where("email", $request->input("email"))->first();
        if ($user != null) {
            $name = $user->name;
            $newPassword = Str::random(4);
            $user->password = Hash::make($newPassword);
            Mail::to($user->email)->send(new ForgotPassword($name, $newPassword));
            $user->save();
            return response()->json([
                "message" => "Please check your email",
            ], 200);
        } else {
            return response()->json([
                "message" => "Email " . $request->input('email') . " is not exist",
            ], 400);
        }
    }

    public function formChangePassword(Request $request)
    {
        $request->validate([
            "email" => "required",
            "password" => "required",
            "password_confirm" => "required",
        ]);
        $user = \App\User::where("email", $request->input("email"))->first();
        if ($user != null) {
            if ($request->input('password') == $request->input('password_confirm')) {
                $user->password = Hash::make($request->input('password'));
                if ($user->save()) {
                    return response()->json([
                        "message" => "Success change password",
                    ], 200);
                } else {
                    return response()->json([
                        "message" => "Failed change password",
                    ], 400);
                }
            } else {
                return response()->json([
                    "message" => "New password is not match with confirm password",
                ], 400);
            }
        } else {
            return response()->json([
                "message" => "Email " . $request->input('email') . " is not exist",
            ], 400);
        }
    }

    public function formLogout(Request $request)
    {
        $request->session()->flush();
        return redirect('/');
    }
}
