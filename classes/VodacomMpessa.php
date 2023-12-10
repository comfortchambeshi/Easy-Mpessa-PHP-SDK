<?php


include 'Mpessa/APIContext.php';
include 'Mpessa/APIMethodType.php';
include 'Mpessa/APIRequest.php';






class VodacomMpessa
{
  private static $api_key = "your_API_key";

  //Environment options are sandbox or openapi
  private static $environment = "sandbox";

  //Service provider code
  private static $ServiceProviderCode = "service_code";
  
  //This is only required in production (openapi)
  private static $promptCode = "prompt_org_code";
  //Generate random thirdparty
  public static function generateRandomString($length) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[random_int(0, $charactersLength - 1)];
    }
    return $randomString;
  }	
  public static function c2b($amount, $accountNumber, $currency, $country, $productName)
  { 
  	    //UUID ID generator
             $uuid = vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex(random_bytes(16)), 4));
  	    // This is to ensure browser does not timeout after 30 seconds
        /*ini_set('max_execution_time', 300);
        set_time_limit(300);*/

        // Public key on the API listener used to encrypt keys
        if (VodacomMpessa::$environment == 'openapi') {
          $public_key = 'MIICIjANBgkqhkiG9w0BAQEFAAOCAg8AMIICCgKCAgEAietPTdEyyoV/wvxRjS5pSn3ZBQH9hnVtQC9SFLgM9IkomEX9Vu9fBg2MzWSSqkQlaYIGFGH3d69Q5NOWkRo+Y8p5a61sc9hZ+ItAiEL9KIbZzhnMwi12jUYCTff0bVTsTGSNUePQ2V42sToOIKCeBpUtwWKhhW3CSpK7S1iJhS9H22/BT/pk21Jd8btwMLUHfVD95iXbHNM8u6vFaYuHczx966T7gpa9RGGXRtiOr3ScJq1515tzOSOsHTPHLTun59nxxJiEjKoI4Lb9h6IlauvcGAQHp5q6/2XmxuqZdGzh39uLac8tMSmY3vC3fiHYC3iMyTb7eXqATIhDUOf9mOSbgZMS19iiVZvz8igDl950IMcelJwcj0qCLoufLE5y8ud5WIw47OCVkD7tcAEPmVWlCQ744SIM5afw+Jg50T1SEtu3q3GiL0UQ6KTLDyDEt5BL9HWXAIXsjFdPDpX1jtxZavVQV+Jd7FXhuPQuDbh12liTROREdzatYWRnrhzeOJ5Se9xeXLvYSj8DmAI4iFf2cVtWCzj/02uK4+iIGXlX7lHP1W+tycLS7Pe2RdtC2+oz5RSSqb5jI4+3iEY/vZjSMBVk69pCDzZy4ZE8LBgyEvSabJ/cddwWmShcRS+21XvGQ1uXYLv0FCTEHHobCfmn2y8bJBb/Hct53BaojWUCAwEAAQ==';
        }else
        {
          $public_key = 'MIICIjANBgkqhkiG9w0BAQEFAAOCAg8AMIICCgKCAgEArv9yxA69XQKBo24BaF/D+fvlqmGdYjqLQ5WtNBb5tquqGvAvG3WMFETVUSow/LizQalxj2ElMVrUmzu5mGGkxK08bWEXF7a1DEvtVJs6nppIlFJc2SnrU14AOrIrB28ogm58JjAl5BOQawOXD5dfSk7MaAA82pVHoIqEu0FxA8BOKU+RGTihRU+ptw1j4bsAJYiPbSX6i71gfPvwHPYamM0bfI4CmlsUUR3KvCG24rB6FNPcRBhM3jDuv8ae2kC33w9hEq8qNB55uw51vK7hyXoAa+U7IqP1y6nBdlN25gkxEA8yrsl1678cspeXr+3ciRyqoRgj9RD/ONbJhhxFvt1cLBh+qwK2eqISfBb06eRnNeC71oBokDm3zyCnkOtMDGl7IvnMfZfEPFCfg5QgJVk1msPpRvQxmEsrX9MQRyFVzgy2CWNIb7c+jPapyrNwoUbANlN8adU1m6yOuoX7F49x+OjiG2se0EJ6nafeKUXw/+hiJZvELUYgzKUtMAZVTNZfT8jjb58j8GVtuS+6TM2AutbejaCV84ZK58E2CRJqhmjQibEUO6KPdD7oTlEkFy52Y1uOOBXgYpqMzufNPmfdqqqSM4dU70PO8ogyKGiLAIxCetMjjm6FCMEA3Kc8K0Ig7/XtFm9By6VxTJK1Mg36TlHaZKP6VzVLXMtesJECAwEAAQ==';
        }

        //Mpessa Market values
        $market = "vodafoneGHA";

        if ($country == "TZN") {
          $market = "vodacomTZN";
        }

        if ($country == "LES") {
          $market = "vodacomLES";
        }

        if ($country == "DRC") {
          $market = "vodacomDRC";
        }
        

        // Create Context with API to request a SessionKey
        $context = new APIContext();
        // Api key
        $context->set_api_key(VodacomMpessa::$api_key);
        // Public key
        $context->set_public_key($public_key);
        // Use ssl/https
        $context->set_ssl(true);
        // Method type (can be GET/POST/PUT)
        $context->set_method_type(APIMethodType::GET);
        // API address
        $context->set_address('openapi.m-pesa.com');
        // API Port
        $context->set_port(443);
        // API Path
        $context->set_path('/'.VodacomMpessa::$environment.'/ipg/v2/'.$market.'/getSession/');

        // Add/update headers
        $context->add_header('Origin', '*');

        // Parameters can be added to the call as well that on POST will be in JSON format and on         GET will be URL parameters
        // context->add_parameter('key', 'value');

        // Create a request object
        $request = new APIRequest($context);

        // Do the API call and put result in a response packet
        $response = null;

        try {
	        $response = $request->execute();
        } catch(exception $e) {
	        echo 'Call failed: ' . $e->getMessage() . '<br>';
        }

        if ($response->get_body() == null) {
	        throw new Exception('SessionKey call failed to get result. Please check.');
        }

        // Display results
      

        // Decode JSON packet
        $decoded = json_decode($response->get_body());

        // The above call issued a sessionID which can be used as the API key in calls that needs         the sessionID
        $context = new APIContext();
        $context->set_api_key($decoded->output_SessionID);
        $context->set_public_key($public_key);
        $context->set_ssl(true);
        $context->set_method_type(APIMethodType::POST);
        $context->set_address('openapi.m-pesa.com');
        $context->set_port(443);
        $context->set_path('/'.VodacomMpessa::$environment.'/ipg/v2/'.$market.'/c2bPayment/singleStage/');

        $context->add_header('Origin', '*');
        //Change ORG001 to your organisation short code

        $context->add_parameter('prompt', ''.VodacomMpessa::$promptCode.'');

        $context->add_parameter('input_Amount', ''.$amount.'');
        $context->add_parameter('input_Country', ''.$country.'');
        $context->add_parameter('input_Currency', ''.$currency.'');
       
        $context->add_parameter('input_CustomerMSISDN', ''.$accountNumber.'');


        //Change service 000000 provider code to yours
        
        
        $context->add_parameter('input_ServiceProviderCode', ''.VodacomMpessa::$ServiceProviderCode.'');
        $context->add_parameter('input_ThirdPartyConversationID', ''.VodacomMpessa::generateRandomString(31).'');
        $context->add_parameter('input_TransactionReference', ''.VodacomMpessa::generateRandomString(10).'');
        $context->add_parameter('input_PurchasedItemsDesc', ''.$productName.'');

        $request = new APIRequest($context);

        // SessionID can take up to 30 seconds to become 'live' in the system and will be invalid         until it is
       

        $response = null;

        try {
	        $response = $request->execute();
        } catch(exception $e) {
	        echo 'Call failed: ' . $e->getMessage() . '<br>';
        }

        if ($response->get_body() == null) {
	        throw new Exception('API call failed to get result. Please check.');
        }

        $result = json_decode($response->get_body(), true);
        return ["result"=>$result, "input_TransactionReference"=>VodacomMpessa::generateRandomString(10)];

  }


  //Verify transaction

  public static function verifyTransaction($input_ThirdPartyConversationID, $country)
  {
        // This is to ensure browser does not timeout after 30 seconds
        ini_set('max_execution_time', 1);
        set_time_limit(1);

        // Public key on the API listener used to encrypt keys
        if (VodacomMpessa::$environment == 'openapi') {
          $public_key = 'MIICIjANBgkqhkiG9w0BAQEFAAOCAg8AMIICCgKCAgEAietPTdEyyoV/wvxRjS5pSn3ZBQH9hnVtQC9SFLgM9IkomEX9Vu9fBg2MzWSSqkQlaYIGFGH3d69Q5NOWkRo+Y8p5a61sc9hZ+ItAiEL9KIbZzhnMwi12jUYCTff0bVTsTGSNUePQ2V42sToOIKCeBpUtwWKhhW3CSpK7S1iJhS9H22/BT/pk21Jd8btwMLUHfVD95iXbHNM8u6vFaYuHczx966T7gpa9RGGXRtiOr3ScJq1515tzOSOsHTPHLTun59nxxJiEjKoI4Lb9h6IlauvcGAQHp5q6/2XmxuqZdGzh39uLac8tMSmY3vC3fiHYC3iMyTb7eXqATIhDUOf9mOSbgZMS19iiVZvz8igDl950IMcelJwcj0qCLoufLE5y8ud5WIw47OCVkD7tcAEPmVWlCQ744SIM5afw+Jg50T1SEtu3q3GiL0UQ6KTLDyDEt5BL9HWXAIXsjFdPDpX1jtxZavVQV+Jd7FXhuPQuDbh12liTROREdzatYWRnrhzeOJ5Se9xeXLvYSj8DmAI4iFf2cVtWCzj/02uK4+iIGXlX7lHP1W+tycLS7Pe2RdtC2+oz5RSSqb5jI4+3iEY/vZjSMBVk69pCDzZy4ZE8LBgyEvSabJ/cddwWmShcRS+21XvGQ1uXYLv0FCTEHHobCfmn2y8bJBb/Hct53BaojWUCAwEAAQ==';
        }else
        {
          $public_key = 'MIICIjANBgkqhkiG9w0BAQEFAAOCAg8AMIICCgKCAgEArv9yxA69XQKBo24BaF/D+fvlqmGdYjqLQ5WtNBb5tquqGvAvG3WMFETVUSow/LizQalxj2ElMVrUmzu5mGGkxK08bWEXF7a1DEvtVJs6nppIlFJc2SnrU14AOrIrB28ogm58JjAl5BOQawOXD5dfSk7MaAA82pVHoIqEu0FxA8BOKU+RGTihRU+ptw1j4bsAJYiPbSX6i71gfPvwHPYamM0bfI4CmlsUUR3KvCG24rB6FNPcRBhM3jDuv8ae2kC33w9hEq8qNB55uw51vK7hyXoAa+U7IqP1y6nBdlN25gkxEA8yrsl1678cspeXr+3ciRyqoRgj9RD/ONbJhhxFvt1cLBh+qwK2eqISfBb06eRnNeC71oBokDm3zyCnkOtMDGl7IvnMfZfEPFCfg5QgJVk1msPpRvQxmEsrX9MQRyFVzgy2CWNIb7c+jPapyrNwoUbANlN8adU1m6yOuoX7F49x+OjiG2se0EJ6nafeKUXw/+hiJZvELUYgzKUtMAZVTNZfT8jjb58j8GVtuS+6TM2AutbejaCV84ZK58E2CRJqhmjQibEUO6KPdD7oTlEkFy52Y1uOOBXgYpqMzufNPmfdqqqSM4dU70PO8ogyKGiLAIxCetMjjm6FCMEA3Kc8K0Ig7/XtFm9By6VxTJK1Mg36TlHaZKP6VzVLXMtesJECAwEAAQ==';
        }
        // Create Context with API to request a SessionKey
        $context = new APIContext();
        // Api key
        $context->set_api_key(VodacomMpessa::$api_key);
        // Public key
        $context->set_public_key($public_key);
        // Use ssl/https
        $context->set_ssl(true);
        // Method type (can be GET/POST/PUT)
        $context->set_method_type(APIMethodType::GET);
        // API address
        $context->set_address('openapi.m-pesa.com');
        // API Port
        $context->set_port(443);

        //Mpessa Market values
        $market = "vodafoneGHA";

        if ($country == "TZN") {
          $market = "vodacomTZN";
        }
        
        if ($country == "LES") {
          $market = "vodacomLES";
        }
        
        if ($country == "DRC") {
          $market = "vodacomDRC";
        }
        // API Path
        $context->set_path('/'.VodacomMpessa::$environment.'/ipg/v2/'.$market.'/getSession/');

        // Add/update headers
        $context->add_header('Origin', '*');

        // Parameters can be added to the call as well that on POST will be in JSON format and on         GET will be URL parameters
        // context->add_parameter('key', 'value');

        // Create a request object
        $request = new APIRequest($context);

        // Do the API call and put result in a response packet
        $response = null;

        try {
          $response = $request->execute();
        } catch(exception $e) {
          echo 'Call failed: ' . $e->getMessage() . '<br>';
        }

        if ($response->get_body() == null) {
          throw new Exception('SessionKey call failed to get result. Please check.');
        }

        // Display results
        //echo $response->get_status_code() . '<br>';
        //echo $response->get_headers() . '<br>';
        //echo $response->get_body() . '<br>';

        // Decode JSON packet
        $decoded = json_decode($response->get_body());

        // The above call issued a sessionID which can be used as the API key in calls that needs         the sessionID
        $context = new APIContext();
        $context->set_api_key($decoded->output_SessionID);
        $context->set_public_key($public_key);
        $context->set_ssl(true);
        $context->set_method_type(APIMethodType::GET);
        $context->set_address('openapi.m-pesa.com');
        $context->set_port(443);
        $context->set_path('/'.VodacomMpessa::$environment.'/ipg/v2/'.$market.'/queryTransactionStatus/');

        $context->add_header('Origin', '*');

        //Query reference used for sandbox transactions

        $qReferenceInitial = '000000000000000000001';

        if (VodacomMpessa::$environment == 'openapi') {

          $qReferenceInitial = $input_ThirdPartyConversationID;


        }

        $context->add_parameter('input_QueryReference', ''.$qReferenceInitial.'');
        $context->add_parameter('input_ServiceProviderCode', ''.VodacomMpessa::$ServiceProviderCode.'');
        $context->add_parameter('input_ThirdPartyConversationID', ''.$qReferenceInitial.'');
        $context->add_parameter('input_Country', ''.$country.'');

        $request = new APIRequest($context);

        // SessionID can take up to 30 seconds to become 'live' in the system and will be invalid         until it is
        sleep(1);

        $response = null;

        try {
          $response = $request->execute();
        } catch(exception $e) {
          echo 'Call failed: ' . $e->getMessage() . '<br>';
        }

        if ($response->get_body() == null) {
          throw new Exception('API call failed to get result. Please check.');
        }

       
       $result = json_decode($response->get_body(), true);
        return ["result"=>$result, "environment"=>VodacomMpessa::$environment];
  }

}



?>