<?php

namespace App\Livewire\Pages;

use Flux\Flux;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Illuminate\Support\Facades\Http;

class IndexPage extends Component
{
    #[Validate('required|string')]
    public $key_pub;

    #[Validate('required|string')]
    public $key_secret;

    #[Validate('required|string')]
    public $pix_key;

    #[Validate('required|string|in:document,randomKey,phoneNumber,email,paymentCode')]
    public $pix_key_type;

    #[Validate('required|string')]
    public $cpf;

    #[Validate('required|integer|min:10')]
    public $amount;
    public $live_log;

    public function send()
    {
        $validate = $this->validate();

        $this->suitpay($validate);

        Flux::toast(
            text: 'Pedido de retirada foi realizada com sucesso!',
            heading: 'Operação Realizada',
            variant: 'success'
        );
    }

    public function suitpay(array $data)
    {
        $referenceID = Str::uuid()->toString();

        $body = [
            'key' => $data['pix_key'],
            'typeKey' => $data['pix_key_type'],
            'value' => $data['amount'],
            'callbackUrl' => 'https://webhook.site/957732e1-5f19-41d6-8f20-c1024623c4fd',
            'documentValidation' => $data['cpf'],
            'externalId' => $referenceID,
        ];

        $response = Http::suitpay( $data['key_pub'], $data['key_secret'])
            ->timeout(20)
            ->retry(3, 200)
            ->post('/gateway/pix-payment', $body);

        $data = json_decode((string) $response->getBody(), true);

        $status = 'Sucesso';

        if (data_get($data, 'error') > 0){
            $message = data_get($data, 'message', 'Desconhecido');
            $status = 'Erro';
        }

        $message = data_get($data, 'message', 'Desconhecido');

        $this->live_log = now()->format('h:m:i d/m/Y') . " | [$status]: $message";
    }

    public function render()
    {
        return view('livewire.pages.index-page');
    }
}
