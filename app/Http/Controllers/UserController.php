<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function create()
    {
        return view("users.register");
    }

    public function store(Request $request)
    {
        $formFields = $request->validate([
            "firstname" => ["required", "min:3"],
            "lastname" => ["required", "min:3"],
            "email" => ["required", "email", Rule::unique("users", "email")],
            "password" => ["required", "confirmed", "min:6"]
        ]);
        $formFields["password"] = bcrypt($formFields["password"]);
        $user = User::create($formFields);
        return redirect("/")->with("message", "Účet bol úspešne vytvorený!");
    }

    public function edit()
    {
        return view("users.edit");
    }

    public function updateName(Request $request)
    {
        $user = Auth::user();
        $formFields = $request->validate([
            "new_firstname" => ["required", "min:3"],
            "new_lastname" => ["required", "min:3"]
        ]);
        $user->firstname = $formFields["new_firstname"];
        $user->lastname = $formFields["new_lastname"];
        $user->save();
        return back()->with("message", "Meno bolo úspešne zmenené!");
    }

    public function updateEmail(Request $request)
    {
        $user = Auth::user();
        $formFields = $request->validate([
            "new_email" => ["required", "email", Rule::unique("users", "email")]
        ]);
        $user->email = $formFields["new_email"];
        $user->save();
        return back()->with("message", "Email bol úspešne zmenený!");
    }

    public function updatePassword(Request $request)
    {
        $user = Auth::user();
        $formFields = $request->validate([
            "current_password" => ["required",
                function ($attribute, $value, $fail) use ($user) {
                    if (!\Hash::check($value, $user->password)) {
                        return $fail(__('The current password is incorrect.'));
                    }
                }],
            "new_password" => ["required", "confirmed", "min:6"]
        ]);
        $formFields["new_password"] = bcrypt($formFields["new_password"]);
        $user->password = $formFields["new_password"];
        $user->save();
        return back()->with("message", "Heslo bolo úspešne zmenené!");
    }

    public function destroy(Request $request)
    {
        $user = Auth::user();
        $user->delete();
        return redirect("/")->with("message", "Účet bol odstránený!");
    }

    public function login(Request $request)
    {
        return view("users.login");
    }

    public function authenticate(Request $request)
    {
        $formFields = $request->validate([
            "email" => ["required", "email"],
            "password" => ["required"]
        ]);
        if (auth()->attempt($formFields, $request->get("remember_me"))) {
            $request->session()->regenerate();
            return redirect("/")->with("message", "Ste prihlásený!");
        }
        return back()->withErrors(["email" => "Invalid credentials."])->onlyInput("email");
    }

    public function logout(Request $request)
    {
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect("/")->with("message", "Ste odhlásený!");
    }
}
