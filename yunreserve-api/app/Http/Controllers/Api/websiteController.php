<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Member;
use Mail;

class websiteController extends Controller
{
    //
    public function signup(Request $request)
    {
        $name = $request->input("name",null);
        $account = $request->input("user",null);
        $email = $request->input("email",null);
        $password = $request->input("pwd1",null);
        $password_verify = $request->input("pwd2",null);
        $phone = $request->input("phone",null);
        $bankCode = $request->input("bankCode",null);
        $bankAccount = $request->input("bankACC",null);
        if($name==null){
            return "1-1";
        }
        $name_pattern = "/^\p{Han}{1,10}$/u";
        if(preg_match($name_pattern, $name)==0){
            return "1-2";
        }
        if($account==null){
            return "2-1";
        }
        $account_pattern = "/^\w{6,18}$/";
        if(preg_match($account_pattern, $account)==0){
            return "2-2";
        }
        if($email==null){
            return "3-1";
        }
        $email_pattern = "/^[a-zA-Z0-9_.-]+@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*\.[a-zA-Z0-9]{2,6}$/";
        if(preg_match($email_pattern, $email)==0){
            return "3-2";
        }
        if($password==null){
            return "4-1";
        }
        $password_pattern = "/^\w{6,12}$/";
        if(preg_match($password_pattern, $password)==0){
            return "4-2";
        }
        if(strcmp($password, $password_verify)!=0){
            return "5-1";
        }
        if($phone==null){
            return "6-1";
        }
        $phone_pattern = "/^\d{0,10}$/";
        if(preg_match($phone_pattern, $phone)==0){
            return "6-2";
        }
        if($bankCode==null){
            return "7-1";
        }
        $bankCode_pattern = "/^\d{3}$/";
        if(preg_match($bankCode_pattern, $bankCode)==0){
            return "7-1";
        }
        if($bankAccount==null){
            return "8-1";
        }
        $bankAccount_pattern = "/^\d{0,20}$/";
        if(preg_match($bankAccount_pattern, $bankAccount)==0){
            return "8-2";
        }
        $member = Member::where('member_account',$account)->first();
        if($member!=null){
            return "3306-1";
        }
        $member = Member::where('member_email',$email)->first();
        if($member!=null){
            return "3306-2";
        }
        $member = Member::where('member_phone',$phone)->first();
        if($member!=null){
            return "3306-3";
        }
        Member::create([
            "member_name"=>$name,
            "member_account"=>$account,
            "member_password"=>hash('sha256', $password),
            "member_email"=>$email,
            "member_phone"=>$phone,
            "member_bankCode"=>$bankCode,
            "member_bankAccount"=>$bankAccount,
            "verify"=>"0"
            ]);
        $member = Member::where('member_account', $account)->first();
        $this->sendMail_verify($member->id,
            $name, $account, $bankCode, 
            $bankAccount, $phone, $email);
        return "OKOKOK";
    }

    public function changeAccount(Request $request)
    {
        $account = $request->input("user",null);
        $pwd = $request->input("pwd",null);
        $name = $request->input("name",null);
        $email = $request->input("email",null);
        $password = $request->input("pwd1",null);
        $password_verify = $request->input("pwd2",null);
        $phone = $request->input("phone",null);
        $bankCode = $request->input("bankCode",null);
        $bankAccount = $request->input("bankACC",null);
        if($account==null){
            return "1";
        }
        $member = Member::where('member_account',$account)->first();
        if($member==null){
            return "1";
        }
        if($pwd==null){
            return "2";
        }
        if(strcmp($member->member_password, hash('sha256', $pwd))!=0){
            return "3";
        }
        if($name!=null){
            $name_pattern = "/^\p{Han}{1,10}$/u";
            if(preg_match($name_pattern, $name)==0){
                return "4";
            }else{
                $member->member_name = $name;
            }
        }
        if($email!=null){
            $email_pattern = "/^[a-zA-Z0-9_.-]+@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*\.[a-zA-Z0-9]{2,6}$/";
            if(preg_match($email_pattern, $email)==0){
                return "5";
            }else{
                $memberTMP = Member::where('member_email',$email)->first();
                if($memberTMP==null){
                    $member->member_email = $email;
                }else{
                    return "3306-1";
                }
            }
        }
        if($password!=null){
            $password_pattern = "/^\w{6,12}$/";
            if(preg_match($password_pattern, $password)==0){
                return "6";
            }else{
                if(strcmp($password, $password_verify)!=0){
                    return "7";
                }else{
                    $member->member_password = hash('sha256', $password);
                }
            }
        }
        if($phone!=null){
            $phone_pattern = "/^\d{0,10}$/";
            if(preg_match($phone_pattern, $phone)==0){
                return "8";
            }else{
                $memberTMP = Member::where('member_phone',$phone)->first();
                if($memberTMP==null){
                    $member->member_phone = $phone;
                }else{
                    return "3306-2";
                }
            }
        }
        if($bankCode!=null){
            $bankCode_pattern = "/^\d{3}$/";
            if(preg_match($bankCode_pattern, $bankCode)==0){
                return "9";
            }else{
                $member->member_bankCode = $bankCode;
            }
        }
        if($bankAccount!=null){
            $bankAccount_pattern = "/^\d{0,20}$/";
            if(preg_match($bankAccount_pattern, $bankAccount)==0){
                return "10";
            }else{
                $member->member_bankAccount = $bankAccount;
            }
        }
        if($name==null && $password==null && $phone==null && 
        $bankCode==null && $bankAccount==null){
            return "99";
        }
        $member->verify = "0";
        $member->save();

        $this->sendMail_verify($member->id,
            $member->member_name, $member->member_account, 
            $member->member_bankCode, $member->member_bankAccount, 
            $member->member_phone, $member->member_email
        );

        return "OKOKOK";
    }

    public function forgetAccount(Request $request)
    {
        $email = $request->input('email',null);
        if($email==null){
            return "1-1";
        }
        $email_pattern = "/^[a-zA-Z0-9_.-]+@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*\.[a-zA-Z0-9]{2,6}$/";
        if(preg_match($email_pattern, $email)==0){
            return "1-1";
        }
        $member = Member::where("member_email",$email)->first();
        if($member==null){
            return "1-2";
        }
        $member_newPassword = (string)rand(1000,9999);
        $member->member_password = hash('sha256', $member_newPassword);
        $member->verify = "0";
        $member->save();
        $this->sendMail_forget(
            $member->member_email,
            $member->member_name,
            $member->member_account,
            $member_newPassword
            );
        return "OKOKOK";
    }

    public function verifyAccount(Request $request, $account, $verifyCode)
    {
        $member = Member::where('member_account', $account)->first();
        $verifyCode_verify = hash('sha256', $member->id.$member->member_account);
        if(strcmp($verifyCode, $verifyCode_verify)==0){
            $member->verify = "1";
            $member->save();
            header("Location: https://sinshengcci.com/account-verification-succeeded/");
            exit();
        }
    }

    public function sendMail_verify($receiver_id,
        $receiver_name, $receiver_account, $receiver_bankCode,
        $receiver_bankAccount, $reciever_phone, $receiver_email)
    {
        $from = [
            "email"=>"yunreserve@gmail.com",
            "name" =>"芯生文創",
            "subject"=>"信件驗證"
        ];
        $to = [
            "email"=>$receiver_email,
            "name"=>$receiver_name
        ];
        $verifyCode = hash('sha256', $receiver_id.$receiver_account);
        $data = [
            "name"=>$receiver_name,
            "account"=>$receiver_account,
            "bankCode"=>$receiver_bankCode,
            "bankAccount"=>$receiver_bankAccount,
            "phone"=>$reciever_phone,
            "verifyURL"=>"https://yunreserve.com/api/website/verifyAccount/".$receiver_account."/".$verifyCode,
            "subject"=>"芯生文創－帳號驗證信件",
            "msg"=>"請確認以下內容無誤，驗證後即可使用本平台服務"
        ];
        Mail::send("emails.verify", $data, function($message) use ($from, $to){
            $message->from($from['email'], $from['name']);
            $message->to($to['email'], $to['name'])->subject($from['subject']);
        });
    }

    public function sendMail_forget(
        $receiver_email, $receiver_name, $receiver_account, 
        $receiver_newPassword)
    {
        $from = [
            "email"=>"yunreserve@gmail.com",
            "name" =>"芯生文創",
            "subject"=>"回復密碼"
        ];
        $to = [
            "email"=>$receiver_email,
            "name"=>$receiver_name
        ];
        $data = [
            "name"=>$receiver_name,
            "account"=>$receiver_account,
            "password"=>$receiver_newPassword,
            "changeAccountURL"=>"https://sinshengcci.com/yunreserve/member/change-info/",
            "subject"=>"芯生文創－回復密碼信件",
            "msg"=>"請至以下連結更改密碼"
        ];
        Mail::send("emails.forget", $data, function($message) use ($from, $to){
            $message->from($from['email'], $from['name']);
            $message->to($to['email'], $to['name'])->subject($from['subject']);
        });
    }

}
