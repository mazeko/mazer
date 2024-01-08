<?php

namespace App\Jobs;

use Carbon\Carbon;
use App\Models\UserLogin;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class UserLoginJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public $tries = 3;
    private $ip;
    private $flag;
    private $email;
    public function __construct($email, $ip, $flag = ERROR)
    {
        $this->ip = $ip;
        $this->flag = $flag;
        $this->email = $email;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            $userLogin = UserLogin::where("email", $this->email)->first();
            if($this->flag == ERROR){
                if (!$userLogin) {
                    UserLogin::create([
                        "email"      => $this->email,
                        "attempts"   => 1,
                        "ip_address" => $this->ip
                    ]);
                } else {
                    if ($userLogin->attempts < 5) {
                        $userLogin->increment("attempts");
                    } else {
                        $userLogin->attempts = 0;
                        $userLogin->blocked_until = Carbon::now()->addMinute(5);
                    }
                    $userLogin->save();
                }
            }else{
                if (!$userLogin) {
                    UserLogin::create([
                        "email"      => $this->email,
                        "attempts"   => 0,
                        "ip_address" => $this->ip,
                        "last_login" => Carbon::now()
                    ]);
                } else {
                    $userLogin->attempts = 0;
                    $userLogin->blocked_until = null;
                    $userLogin->last_login = Carbon::now();
                    $userLogin->save();
                }
            }
            

        } catch (\Throwable $th) {
            $this->release(30);
            throw $th;
        }
    }
}
