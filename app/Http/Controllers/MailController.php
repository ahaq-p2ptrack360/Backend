<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


class MailController extends Controller
{
    public function basic_email($email,$username)
    {
        // $mailContent = 'check';
        $password = Str::random(8);
        $hashedPassword = Hash::make($password);
        DB::update('update users set two_factor_secret=? , password=? WHERE email=?',[$password,$hashedPassword,$username]);

        $data=[ 'email' =>$username,
        'password'=>$password];
        $mailContent = view('mail4', $data)->render();

        Mail::send([], [], function ($message) use ( $mailContent,$email) {
            $message->to($email, 'User Login Credentials')
                ->subject('User Login Credentials')
                ->setBody($mailContent, 'text/html');

        });


        // Provide a meaningful response or redirect as needed.
        return response("Success", 200);


        //   Mail::send(['text'=>'mail'], $data, function($message) {
        //      $message->to('wa2341733@gmail.com', 'User Login Credentials')->subject
        //         ('Here is your login credentials for your Account email:abdulsamadq67@gmail.com  password:12345678');
        //      $message->from('wa2341733@gmail.com','Abdul Samad');
        //   });
        //   echo "Basic Email Sent. Check your inbox.";

    }
    public function html_email()
    {
        $data = array('name' => "Virat Gandhi");
        Mail::send('mail', $data, function ($message) {
            $message->to('abc@gmail.com', 'Tutorials Point')->subject('Laravel HTML Testing Mail');
            $message->from('xyz@gmail.com', 'Virat Gandhi');
        });
        echo "HTML Email Sent. Check your inbox.";
    }
    public function attachment_email()
    {
        $data = array('name' => "Virat Gandhi");
        Mail::send('mail', $data, function ($message) {
            $message->to('abc@gmail.com', 'Tutorials Point')->subject('Laravel Testing Mail with Attachment');
            $message->attach('C:\laravel-master\laravel\public\uploads\image.png');
            $message->attach('C:\laravel-master\laravel\public\uploads\test.txt');
            $message->from('xyz@gmail.com', 'Virat Gandhi');
        });
        echo "Email Sent with attachment. Check your inbox.";
    }
}
