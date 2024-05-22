<?php


namespace App\controllers;


use App\http\Request;
use App\session\Session;
use Exception;

class AmoController extends AbstractController
{
    private string $code;
    private array $config;
    private string $accessToken;
    private string $refreshToken;
    private \DateTime $expires_in;

    public function __construct(Session $session, Request $request)
    {
        parent::__construct($session, $request);
        $this->config = require_once APP_PATH . '/config/amoCRM.php';
    }

    public function index(): void
    {
        if ($this->ifItWasRedirect()) {

                $this->checkFresh($this->config['refresh_token'], $this->config['expires_in']);
                $acc = $this->account();
                $leads = $this->leads();
                $company = $this->company();
                $customFields = $this->customFields();
                $contacts = $this->contacts();

                $this->view('blogNoButton', [
                    'acc' => $acc,
                    'leads' => $leads,
                    'customFields' => $customFields,
                    'company' => $company,
                    'contacts' => $contacts
                ]);
        } else {
            $this->view('blog');
        }
    }

    private function ifItWasRedirect(): bool
    {
        if ($this->request->GET_check('code')) {
            $this->code = $this->request->get('code');
            $this->getTokens($this->code);
        }
        if ($this->config['refresh_token']) {
            return true;
        } else {
            return false;
        }
    }

    private function setExpireTime(int $expires_in): void
    {
        $dateTime = new \DateTime();
        $expirationDateTime = $dateTime->add(new \DateInterval("PT{$expires_in}S"));
        $this->expires_in = $expirationDateTime;
    }

    private function checkFresh(string $refresh_token, \DateTime $expires_in): void
    {
        $currentDateTime = new \DateTime();
        if ($currentDateTime > $expires_in) {
            $this->refreshAccessToken($refresh_token);
        }
    }

    private function account(): array
    {
        return $this->query('/api/v4/account');
    }
    private function leads(): array
    {
        return $this->query('/api/v4/leads', ['with' => 'contacts']);
    }

    public function lead()
    {
        $id = $this->request->input('id');
        $lead = $this->query("/api/v4/leads/{$id}", ['with' => 'contacts']);
        $contact = $company = null;
        if (isset($lead['_embedded']['companies'][0]['id'])) {
            $company = $this->company($lead['_embedded']['companies'][0]['id']);
        }
        if (isset($lead['_embedded']['contacts'][0]['id'])) {
            $contact = $this->contacts($lead['_embedded']['contacts'][0]['id']);
        }
        $this->view('lead', ['lead' => $lead, 'company' => $company, 'contact' => $contact]);
    }

    private function company(int $id = null): array
    {
        return $this->query('/api/v4/companies', ['id' => $id]);

    }

    private function contacts(int $id = null): array
    {
        return $this->query('/api/v4/contacts', ['id' => $id]);
    }

    private function customFields():array
    {
        return $this->query('/api/v4/leads/custom_fields');
    }

    public function addLeadComplex()
    {
        $this->query('/api/v4/leads/complex', [ 0 => [
            'name' => $this->request->input('name'),
            'price' =>(int)$this->request->input('price'),
            '_embedded' => ['contacts' => [0 => ['first_name' => $this->request->input('name'),
                'custom_fields_values' => [
                    0 => ['field_id' => 563923,
                        'values' => [0 => [
                            "enum_id" => 741209,
                            'value' => $this->request->input('phone')
                        ]]],
                    1 => ['field_id' => 563925,
                        'values' => [0 => [
                            'enum_id' => 741221,
                            'value' => $this->request->input('email')
                        ]]],
                ]]],
                'companies' => [0 => ['name' => $this->request->input('company')]]]
            ]], 'POST');
        $this->redirect->to('blog');
    }

    public function edit(): void
    {
        $id = $this->request->input('id');
        $name = $this->request->input('name');
        $price = $this->request->input('price');
        $phone = $this->request->input('phone');
        $email = $this->request->input('email');
        $company = $this->request->input('company');

        $this->view('patch', ['id' => $id, 'leadName' => $name, 'price' => $price, 'phone' => $phone, 'email' => $email, 'company' => $company]);
    }

    public function patch()
    {
        $id = $this->request->input('id');

        $this->query("/api/v4/leads/{$id}", [
            'id' => $id,
            'name' => $this->request->input('name'),
            'price' =>(int)$this->request->input('price'),
            ], 'PATCH');
        $this->redirect->to('blog');
    }


    private function query(string $uri, array $parameters = null, string $method = 'GET', bool $is_settings = false)
    {
        $subdomain = $this->config['subdomain'];
        $link = 'https://' . $subdomain . ".amocrm.ru{$uri}";

        if ($method === 'GET' && !empty($parameters)) {
            $link .= "?" . http_build_query($parameters);
        } elseif ($method === 'POST' || $method === 'PATCH') {
            $data = $parameters;
        }
        if (isset($this->config['access_token'])) {
            $headers = [
                'Authorization: Bearer ' . $this->config['access_token']
            ];
//            if ($data) {
//                dd(json_encode($data));
//            }
        $curl = curl_init();
        curl_setopt($curl,CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl,CURLOPT_USERAGENT,'amoCRM-oAuth-client/1.0');
        curl_setopt($curl,CURLOPT_URL, $link);
        if ($method === 'POST' || $method === 'PATCH') {
            curl_setopt($curl,CURLOPT_HTTPHEADER,['Content-Type:application/json']);
        }

        if ($method === 'POST') {
            curl_setopt($curl,CURLOPT_CUSTOMREQUEST, 'POST');
            curl_setopt($curl,CURLOPT_POSTFIELDS, json_encode($data));
        } elseif ($method === 'PATCH') {
            curl_setopt($curl,CURLOPT_CUSTOMREQUEST, 'PATCH');
            curl_setopt($curl,CURLOPT_POSTFIELDS, json_encode($data));
        }
        if (!$is_settings) {
            curl_setopt($curl,CURLOPT_HTTPHEADER, $headers);
        }
        curl_setopt($curl,CURLOPT_HEADER, false);
        $out = curl_exec($curl);
        $code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        $code = (int)$code;

        $errors = [
            400 => 'Bad request',
            401 => 'Unauthorized',
            403 => 'Forbidden',
            404 => 'Not found',
            500 => 'Internal server error',
            502 => 'Bad gateway',
            503 => 'Service unavailable',
        ];

        try
        {
            if ($code < 200 || $code > 204) {
                throw new Exception(isset($errors[$code]) ? $errors[$code] : 'Undefined error', $code);
            }
        } catch(\Exception $e)
        {
            die('Ошибка: ' . $e->getMessage() . PHP_EOL . 'Код ошибки: ' . $e->getCode());
        }
            return json_decode($out, true);

        }
    }

    private function getTokens(string $code): void
    {
        $subdomain = $this->config['subdomain'];
        $link = 'https://' . $subdomain . '.amocrm.ru/oauth2/access_token';

        $data = [
            'client_id' => $this->config['client_id'],
            'client_secret' => $this->config['client_secret'],
            'grant_type' => 'authorization_code',
            'code' => $code,
            'redirect_uri' => 'http://localhost/blog/blog',
        ];

        $curl = curl_init(); //Сохраняем дескриптор сеанса cURL

        curl_setopt($curl,CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl,CURLOPT_USERAGENT,'amoCRM-oAuth-client/1.0');
        curl_setopt($curl,CURLOPT_URL, $link);
        curl_setopt($curl,CURLOPT_HTTPHEADER,['Content-Type:application/json']);
        curl_setopt($curl,CURLOPT_HEADER, false);
        curl_setopt($curl,CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($curl,CURLOPT_POSTFIELDS, json_encode($data));
        $out = curl_exec($curl);
        $code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        $code = (int)$code;
        $errors = [
            400 => 'Bad request',
            401 => 'Unauthorized',
            403 => 'Forbidden',
            404 => 'Not found',
            500 => 'Internal server error',
            502 => 'Bad gateway',
            503 => 'Service unavailable',
        ];

        try
        {
            if ($code < 200 || $code > 204) {
                throw new Exception(isset($errors[$code]) ? $errors[$code] : 'Undefined error', $code);
            }
        }
        catch(\Exception $e)
        {
            die('Ошибка: ' . $e->getMessage() . PHP_EOL . 'Код ошибки: ' . $e->getCode());
        }

        $response = json_decode($out, true);

        $this->config['access_token'] = $response['access_token'];
        $this->config['refresh_token'] = $response['refresh_token'];
        $this->config['token_type'] = $response['token_type'];
        $expires_in = $response['expires_in'];
        $this->setExpireTime($expires_in);
        $this->config['expires_in'] = $this->expires_in;
        file_put_contents(APP_PATH . '/config/amoCRM.php', '<?php return ' . var_export($this->config, true) . ';');
    }

    private function refreshAccessToken(string $refresh_token): void
    {
        $subdomain = $this->config['subdomain'];
        $link = 'https://' . $subdomain . '.amocrm.ru/oauth2/access_token';

        $data = [
            'client_id' => $this->config['client_id'],
            'client_secret' => $this->config['client_secret'],
            'grant_type' => 'refresh_token',
            'refresh_token' => $refresh_token,
            'redirect_uri' => 'http://localhost/blog/blog',
        ];

        $curl = curl_init();

        curl_setopt($curl,CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl,CURLOPT_USERAGENT,'amoCRM-oAuth-client/1.0');
        curl_setopt($curl,CURLOPT_URL, $link);
        curl_setopt($curl,CURLOPT_HTTPHEADER,['Content-Type:application/json']);
        curl_setopt($curl,CURLOPT_HEADER, false);
        curl_setopt($curl,CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($curl,CURLOPT_POSTFIELDS, json_encode($data));

        $out = curl_exec($curl);
        $code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        $code = (int)$code;
        $errors = [
            400 => 'Bad request',
            401 => 'Unauthorized',
            403 => 'Forbidden',
            404 => 'Not found',
            500 => 'Internal server error',
            502 => 'Bad gateway',
            503 => 'Service unavailable',
        ];

        try
        {
            if ($code < 200 || $code > 204) {
                throw new Exception(isset($errors[$code]) ? $errors[$code] : 'Undefined error', $code);
            }
        }
        catch(\Exception $e)
        {
            die('Ошибка: ' . $e->getMessage() . PHP_EOL . 'Код ошибки: ' . $e->getCode());
        }

        $response = json_decode($out, true);

        $this->config['access_token'] = $response['access_token'];
        $this->config['refresh_token'] = $response['refresh_token'];
        $this->config['token_type'] = $response['token_type'];
        $expires_in = $response['expires_in'];
        $this->setExpireTime($expires_in);
        $this->config['expires_in'] = $this->expires_in;
        file_put_contents(APP_PATH . '/config/amoCRM.php', '<?php return ' . var_export($this->config, true) . ';');
    }

}