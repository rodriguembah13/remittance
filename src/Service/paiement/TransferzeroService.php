<?php


namespace App\Service\paiement;


use GuzzleHttp\Client;
use http\Exception;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use TransferZero\Api\CurrencyInfoApi;
use TransferZero\Api\TransactionsApi;
use TransferZero\ApiException;
use TransferZero\Configuration;
use TransferZero\Model\ApiLog;
use TransferZero\Model\PayinMethod;
use TransferZero\Model\PayinMethodDetails;
use TransferZero\Model\PayoutMethod;
use TransferZero\Model\PayoutMethodDetails;
use TransferZero\Model\Recipient;
use TransferZero\Model\Sender;
use TransferZero\Model\Transaction;
use TransferZero\Model\TransactionRequest;

class TransferzeroService
{
    private $params;
    /**
     * @var Client
     */
    private $client;
    private $tokencinet;
    private $logger;

    /**
     * EkolopayService constructor.
     * @param LoggerInterface $logger
     * @param ParameterBagInterface $params
     */
    public function __construct(LoggerInterface $logger, ParameterBagInterface $params)
    {
        $this->params = $params;
        $this->logger = $logger;
        $this->client = new Client([
            'base_uri' => $params->get('EKOLO_URL'),
        ]);
        Configuration::getDefaultConfiguration()
            ->setHost($params->get('ZERO_URL'))
            ->setApiKey($params->get('ZERO_API_KEY'))
            ->setApiSecret($params->get('ZERO_API_SECRET'));
    }

    function postpaiement($data)
    {
        $sender = new Sender();
        $sender->setFirstName($data['sender_firstname']);
        $sender->setLastName($data['sender_lastname']);

        $sender->setPhoneCountry($data['sender_countrycode']);
        $sender->setPhoneNumber($data['sender_phone']);

        $sender->setCountry($data['sender_countrycode']);
        $sender->setCity($data['sender_city']);
        $sender->setStreet($data['sender_street']);
        $sender->setPostalCode($data['sender_codepostal']);
        $sender->setAddressDescription("");

        $sender->setBirthDate($data['sender_birthdate']);

// you can usually use your company's contact email address here
        $sender->setEmail("info@agensic.com");

        $sender->setExternalId("Sender:CG:234523");

// you'll need to set these fields but usually you can leave them the default
        $sender->setIp("127.0.0.1");
        $sender->setDocuments([]);


        $details = new PayoutMethodDetails();
        $details->setFirstName($data['receiver_firstname']);
        $details->setLastName($data['receiver_lastname']);
        $details->setBankAccount($data['receiver_bankaccount']);
        $details->setBankCode($data['receiver_bankcode']);
        $details->setBankAccountType($data['receiver_banktype']);

        $payout = new PayoutMethod();
        $payout->setType($data['payout_type']);
        $payout->setDetails($details);

        $recipient = new Recipient();
        $recipient->setRequestedAmount(100);
        $recipient->setRequestedCurrency($data['receiver_currency']);
        $recipient->setType("person");
        $recipient->setPayoutMethod($payout);


        $transaction = new Transaction();
        $transaction->setSender($sender);
        $transaction->setRecipients([$recipient]);
        $transaction->setInputCurrency($data['receiver_currency']);
        $transaction->setExternalId($data['reference']);


        $request = new TransactionRequest();
        $request->setTransaction($transaction);

        $api = new TransactionsApi();

        try {
            $response = $api->createAndFundTransaction($request);
        } catch (ApiException $e) {
            if ($e->isValidationError()) {
                $response = $e->getResponseObject();
                // Process validation error
            }
            throw $e;
        }

        return $response;
    }
    function postcollection($data)
    {
        $sender = new Sender();
        $sender->setFirstName($data['sender_firstname']);
        $sender->setLastName($data['sender_lastname']);

        $sender->setPhoneCountry($data['sender_countrycode']);
        $sender->setPhoneNumber($data['sender_phone']);

        $sender->setCountry($data['sender_countrycode']);
        $sender->setCity($data['sender_city']);
        $sender->setStreet($data['sender_street']);
        $sender->setPostalCode($data['sender_codepostal']);
        $sender->setAddressDescription("");

        $sender->setBirthDate($data['sender_birthdate']);

// you can usually use your company's contact email address here
        $sender->setEmail("info@agepnsic.com");

        $sender->setExternalId("Sender:CG:2378555554523");

// you'll need to set these fields but usually you can leave them the default
        $sender->setIp("127.0.0.1");
        $sender->setDocuments([]);

        $details = new PayoutMethodDetails();
        $details->setReference("Collection:GHS:91554555576");

        $payout = new PayoutMethod();
        $payout->setType("XOF::Balance");
        $payout->setDetails($details);

        $recipient = new Recipient();
        $recipient->setRequestedAmount($data['receiver_amount']);
        $recipient->setRequestedCurrency($data['receiver_currency']);
        $recipient->setPayoutMethod($payout);


        $details = new PayinMethodDetails();
        $details->setPhoneNumber($data['receiver_phone']);
        $details->setMobileProvider("orange");
        $details->setCountry('SN');
        $details->setOtp('123456');

        $method = new PayinMethod();
        $method->setType("XOF::Mobile");
        $method->setUxFlow("ussd_voucher");
        $method->setInDetails($details);


        $recipient = new Recipient();
        $recipient->setRequestedAmount(100);
        $recipient->setRequestedCurrency($data['receiver_currency']);
        $recipient->setType("person");
        $recipient->setPayoutMethod($payout);


        $transaction = new Transaction();
        $transaction->setSender($sender);
        $transaction->setRecipients([$recipient]);
        $transaction->setInputCurrency($data['receiver_currency']);
        $transaction->setExternalId($data['reference']);
        $transaction->setPayinMethods([$method]);


        $request = new TransactionRequest();
        $request->setTransaction($transaction);

        $api = new TransactionsApi();

        try {
            $response = $api->postTransactions($request);
        } catch (ApiException $e) {
            if ($e->isValidationError()) {
                $response = $e->getResponseObject();
                // Process validation error
            }
            throw $e;
        }

        return $response;
    }
}
