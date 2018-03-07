<?php

namespace App\Console\Commands;


use App\API\TextMagicAPI;
use App\APIV\SmsGateway;
use Illuminate\Console\Command;

class SendSMS extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'marias:bulk';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $phones = [
            "+351911031333", "+351913239083", "+351913395659", "+351913662394", "+351914937505", "+351915191404", "+351917303759", "+351917603422",
            "+351917613983", "+351917820720", "+351917875704", "+351918306181", "+351918448096", "+351919015838", "+351919019436", "+351919443071",
            "+351919443671", "+351919690382", "+351919757750", "+351919757751", "+351919855621", "+351919952237", "+351925646282", "+351926721867",
            "+351932548176", "+351932548179", "+351933265016", "+351934986164", "+351935091567", "+351936463709", "+351938839582", "+351939312758",
            "+351962713819", "+351962876490", "+351963083260", "+351963097743", "+351965063793", "+351965290539", "+351965365812", "+351966066629",
            "+351968772878", "+351969042645", "+351914903755" ];

        /*$device = $smsGateway->getDevices($page); */

        $text = "Bom Dia, 
A Páscoa está a chegar : até 20/03 visite a nova loja Marias bonitas e ganhe 20% de desconto numa compra superior a 50 euros ao mostrar este sms.
Aproveite Já! 
mariasbonitas.com";


        $smsGateway = new SmsGateway('marcelo.t80@gmail.com', 'marcelo');

        $deviceID = 82264;

        $options = [
            'send_at' => strtotime('+1 minutes'), // Send the message in 10 minutes
            'expires_at' => strtotime('+1 hour') // Cancel the message in 1 hour if the message is not yet sent
        ];

//Please note options is no required and can be left out
      //  $result = $smsGateway->sendMessageToContact($contact, $message, $deviceID, $options);

        /*foreach ($phones as $key => $phone) {
            $result = $smsGateway->createContact('Client ' . $key, $phone);
        } */


        $page= 1;
        $contacts = $smsGateway->getContacts($page);
        $contactIDs = [];
        foreach ($contacts as $contact) {
            if(isset($contact['result']['data'])) {
                foreach ($contact['result']['data'] as $contactId) {
                    $contactIDs[] = $contactId['id'];

                }
            }
        }
        $result = $smsGateway->sendMessageToManyContacts($contactIDs, $text, $deviceID, $options);


    }
}
