<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class LoginAdminRequest extends FormRequest
{
  public function rules() {
    return [
      'email' => 'required|email|exists:admin_users',
      'password' => 'required'
    ];
  }
}
