<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Validator;
use Auth;
use Redirect;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;

use Illuminate\Foundation\Auth\RegistersUsers;

class AuthController extends Controller
{
    use RegistersUsers, ThrottlesLogins;

    public function __construct()
    {
        $this->middleware('guest:admin', ['except' => 'logout']);
    }
    //登录
    public function login(Request $request)
    {
        if ($request->isMethod('post')) {
            $validator = $this->validateLogin($request->input());
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }
            if (Auth::guard('admin')->attempt(['email'=>$request->email, 'password'=>$request->password])) {
                return Redirect::to('admin')->with('success', '登录成功！');     //login success, redirect to admin
            } else {
                return Redirect::back()->with('loginError', '账号或者密码错误！');
            }
        }
        return view('admin.auth.login');
    }
    //登录页面验证
    protected function validateLogin(array $data)
    {
        return Validator::make($data, [
            'email' => 'required',
            'password' => 'required',
        ], [
            'required' => ':attribute 为必填项',
            'min' => ':attribute 长度不符合要求'
        ], [
            'email' => '账号',
            'password' => '密码'
        ]);
    }

    //退出登录
    public function logout()
    {
        if(Auth::guard('admin')->user()){
            Auth::guard('admin')->logout();
        }
        return Redirect::to('admin/login');
    }


    //注册        admin注册及验证暂时无用
    public function register(Request $request)
    {
        if ($request->isMethod('post')) {
            $validator = $this->validateRegister($request->input());
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }
            $user = new Admin();
            $user->name = $request->name;
            $user->account_number = $request->account_number;
            $user->password = bcrypt($request->password);
            $user->create_time = time();
            $user->update_time = time();
            if($user->save()){
                return redirect('admin/login')->with('success', '注册成功！');
            }else{
                return back()->with('error', '注册失败！')->withInput();
            }
        }
        return view('sys_auth.register');
    }
    protected function validateRegister(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'account_number' => 'required|unique:admins',
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required|min:6|'
        ], [
            'required' => ':attribute 为必填项',
            'min' => ':attribute 长度不符合要求',
            'confirmed' => '两次输入的密码不一致',
            'unique' => '该账户已存在',
            'alpha_num' => ':attribute 必须为字母或数字',
            'max' => ':attribute 长度过长'
        ], [
            'name' => '昵称',
            'account_number' => '账号',
            'password' => '密码',
            'password_confirmation' => '确认密码'
        ]);
    }

}