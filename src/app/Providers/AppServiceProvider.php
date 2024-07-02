<?php

namespace App\Providers;

use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // カスタムメールのテンプレート
        VerifyEmail::toMailUsing(function (object $notifiable, string $url) {
            return (new MailMessage)
                ->subject('メールアドレスの確認')
                ->line('以下のボタンをクリックしてメールアドレスを認証してください。')
                ->action('メールアドレス認証', $url)
                ->line('このメールの内容に覚えがない場合は、このまま破棄してください。');
        });
    }
}
