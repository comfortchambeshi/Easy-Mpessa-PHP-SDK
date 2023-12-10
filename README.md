# Easy **Mpessa PHP** integration SDK

This PHP SDK is a simplied version of ever made **Mpessa** integration script. Here are a few things you need to do to get started:

### NO.1: Configure the database:
- You will find database.sql file in the root folder of the repository. Import it first.
- Setup the database connection configuration in /classes/db.php as shown below:
  ```
  private $dbname = "MPESSA";
  private $dbhost = "localhost";
  private $dbuser = "";
  private $dbpwd = "";
  ```

### NO.2: Setup Mpessa API credentials:
- Decide either in **sandbox** or **openapi** mode
- In classes/VodacomMpessa.php, configure API key, service provider code and prompt code.
  Kindly note that, the default service provider code when in sandbox is **000000**

  Here is the demonstation:
  ```

  private static $api_key = "your_API_key";

  //Environment options are sandbox or openapi
  private static $environment = "sandbox";

  //Service provider code
  private static $ServiceProviderCode = "service_code";
  
  //This is only required in production (openapi)
  private static $promptCode = "prompt_org_code";

  ```


### NO.3: Configure country and currency:
- In inc/pay.inc.php, change these lines of code to fit your details:
   ```
   //Initiate transaction
   $pay = $VodacomMpessa->c2b($amount, $phone_number, "GHS", 'GHA', "Product title");
   ```


That's all you need to do. For more information and collaboration reach out to us on Whatsapp +260968793843 and Email: witlevels04@gmail.com

Don't forget to support and share!



