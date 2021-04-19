<?php 
namespace App\Services;

use \Epayco\Epayco;
use Illuminate\Support\Env;

class EpaycoService
  {
    protected $conection;

    public function __construct()
    {
      $this->conection = new Epayco([
                                      "apiKey" => "0dca45439d7388940c342dc32400a097",//env('API_KEY'),
                                      "privateKey" => "ad97369de2d64b7dac878ef464ad389b",//env('PRIVATE_KEY'),
                                      "lenguage" => "ES",
                                      "test" => true
                                    ]);  
    }

    /**
     * Create token card.
     *
     * @param cc_t $cc_t
     * @return stdClass Object token card id
     */
    public function createTokenCreditCard($cc_t = [])
    {

        return $this->conection->token->create($cc_t);
      
    }

    /**
     * Create customer.
     *
     * @param client $client
     * @return
     */
    public function makeCustomer($client = [])
    {
      $client = collect($client);
      $cc_t = $client->only('card[number]', 'card[exp_year]', 'card[exp_month]', 'card[cvc]');
      $token_card = $this->createTokenCreditCard($cc_t->toArray());

      return [ 
        'customer' => $this->conection->customer->create( array_merge($client->except($cc_t->keys())->toArray(), [ 'token_card' => $token_card->id ]) ),
        'token_card' => $token_card
      ];
    }

    /**
     * Create payment with creadit card.
     *
     * @param client $client
     * @return stdClass Object
     */
    public function createPayment($client = [
      "card[number]" => '4575623182290326',// to create createTokenCreditCard()
      "card[exp_year]" => "2025",// to create createTokenCreditCard()
      "card[exp_month]" => "12",// to create createTokenCreditCard()
      "card[cvc]" => "123",// to create createTokenCreditCard()
      
      // to create makeCustomer()
      "name" => "Ana Name",
      "last_name" => "Reyes",
      "email" => "ana@payco.co",
      "default" => true,
      "city" => "Bogota",
      "address" => "Cr 4 # 55 36",
      "phone" => "3005234321",
      "cell_phone"=> "3010000001",
      
      // to createPayment()
      "doc_type" => "CC",
      "doc_number" => "123456",
      "name" => "John",
      "last_name" => "Doe",
      "email" => "example@email.com",
      "bill" => "OR-1234",
      "description" => "Test Payment",
      "value" => "116000",
      "tax" => "16000",
      "tax_base" => "100000",
      "currency" => "COP",
      "dues" => "12",
      "address" => "cr 44 55 66",
      "phone"=> "2550102",
      "cell_phone"=> "3010000001",
      // "ip" => "190.000.000.000",  // This is the client's IP, it is required
      "url_response" => "https://tudominio.com/respuesta.php",
      "url_confirmation" => "https://tudominio.com/confirmacion.php",
  
      //Extra params: These params are optional and can be used by the commerce
      "use_default_card_customer" => true,/*if the user wants to be charged with the card that the customer currently has as default = true*/
      "extras"=> array(
          "extra1" => "data 1",
          "extra2" => "data 2",
          "extra3" => "data 3",
      )
    ])
    {
      $data = $this->makeCustomer($client);
      return  $this->conection->charge->create(collect([
          'token_card' => $data['token_card']->id,
          "customer_id" => $data['customer']->data->customerId,
      ])->merge($client)->toArray());
    }

  }