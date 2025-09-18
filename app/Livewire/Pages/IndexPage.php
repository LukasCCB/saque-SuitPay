<?php

namespace App\Livewire\Pages;

use Flux\Flux;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Livewire\Attributes\Validate;
use Livewire\Component;

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
        $client = new Client;

        $host = 'https://ws.suitpay.app/api/v1'; // https://ws.suitpay.app

        $referenceID = Str::uuid()->toString();

        $body = [
            'key' => $data['pix_key'],
            'typeKey' => $data['pix_key_type'],
            'value' => $data['amount'],
            'callbackUrl' => 'https://webhook.site/957732e1-5f19-41d6-8f20-c1024623c4fd',
            'documentValidation' => $this->genCPF(),
            'externalId' => $referenceID,
        ];

        $headers = [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'ci' => $data['key_pub'],
            'cs' => $data['key_secret'],
        ];

        $response = $client->request('POST', $host."/gateway/pix-payment", [
            'http_errors' => false,
            'headers' => $headers,
            'json' => $body,
        ]);

        $data = json_decode((string) $response->getBody(), true);

        Log::info($data);

        $status = 'Sucesso';

        if (data_get($data, 'error') > 0){
            $message = data_get($data, 'message', 'Desconhecido');
            $status = 'Erro';
        }

        $message = data_get($data, 'message', 'Desconhecido');

        $this->live_log = now()->format('h:m:i d/m/Y') . " | [$status]: $message";

    }

    public function genCPF(): string
    {
        $n = [];
        for ($i = 0; $i < 9; $i++) {
            $n[$i] = rand(0, 9);
        }

        $d1 = 0;
        for ($i = 0, $j = 10; $i < 9; $i++, $j--) {
            $d1 += $n[$i] * $j;
        }
        $d1 = 11 - ($d1 % 11);
        $d1 = ($d1 >= 10) ? 0 : $d1;

        $d2 = 0;
        for ($i = 0, $j = 11; $i < 9; $i++, $j--) {
            $d2 += $n[$i] * $j;
        }
        $d2 += $d1 * 2;
        $d2 = 11 - ($d2 % 11);
        $d2 = ($d2 >= 10) ? 0 : $d2;

        return implode('', $n).$d1.$d2;
    }

    public function render()
    {
        return view('livewire.pages.index-page');
    }
}
