<?php

namespace App\Http\Controllers\Boilerplate\Auth;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;


class ForgotPasswordController
{
    use SendsPasswordResetEmails;

    protected function credentials(Request $request)
    {
        return $request->only('employee_id');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
    'employee_id' => 'required|exists:users,employee_id|string',
], [
    'employee_id.exists' => 'No user was found with this employee ID.',
]);

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $response = $this->broker()->sendResetLink(
            $this->credentials($request)
        );

        return $response == Password::RESET_LINK_SENT
                    ? $this->sendResetLinkResponse($request, $response)
                    : $this->sendResetLinkFailedResponse($request, $response);
    }

    /**
     * Get password request form view.
     *
     * @return Application|Factory|View
     */
    public function showLinkRequestForm()
    {
        $userModel = config('auth.providers.users.model');

        if ($userModel::count() === 0) {
            return redirect(route('boilerplate.register'));
        }

        return view('boilerplate::auth.passwords.email');
    }
}
