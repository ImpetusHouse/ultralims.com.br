<?php

namespace App\Mail;

use App\Models\Settings\Email;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class userNotificationsMail extends Mailable
{
    use Queueable, SerializesModels;
    protected $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $data = $this->data;

        if (isset($data['layout'])){
            $email = Email::where('id', $data['layout'])->first();
            $email->content = str_replace('#name', $data['name'], $email->content);
            $email->content = str_replace('#phone', $data['phone'], $email->content);
            $email->content = str_replace('#email', $data['email'], $email->content);
            $email->content = str_replace('#company_name', $data['company_name'], $email->content);
            $email->content = str_replace('#office', $data['office'], $email->content);
            $email->content = str_replace('#quantity', $data['quantity'], $email->content);
            $email->content = str_replace('#description', $data['description'], $email->content);
            $email->content = str_replace('#is_member', $data['is_member'], $email->content);
            $email->content = str_replace('#member_number', $data['member_number'], $email->content);
            $email->content = str_replace('#cpf_cnpj', $data['cpf_cnpj'], $email->content);
            $email->content = str_replace('#state', $data['state'], $email->content);
            $email->content = str_replace('#city', $data['city'], $email->content);
            $data['title'] = str_replace('#company_name', $data['company_name'], str_replace('#name', $data['name'], $email->subject));
            $data['subject'] = str_replace('#company_name', $data['company_name'], str_replace('#name', $data['name'], $email->subject));
            $data['layout'] = $email->content;
            if (env('APP_NAME') == 'Ultra Lims'){
                $data['button'] = [
                    'title' => 'Agendar reunião',
                    'link' => 'https://outlook.office365.com/owa/calendar/MarcelePriess@ultralims.com.br/bookings/'
                ];
            }
        }

        $this->subject($data['subject'] ?? env('APP_NAME'));
        $this->to($data['to'], $data['name']);
        if (env('APP_NAME') == 'Ultra Lims'){
            $this->replyTo('comercial@ultralims.com.br', 'Marcele Priess');
        }
        return $this->view('mails.'.env('APP_NAME').'.'.$data['type'], $data);
    }
}
