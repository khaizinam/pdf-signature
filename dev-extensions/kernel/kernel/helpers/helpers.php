<?php

use Dev\Lead\Models\Lead;
use Dev\Base\Enums\BaseStatusEnum;
use Dev\ACL\Models\User;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;

use Google\Client;
use Revolution\Google\Sheets\Facades\Sheets;

if (!function_exists('apps_google_sheet')) {

    /**
     * Google spreadsheet function "sync_google_sheet"
     * @param array $spreadsheetData
     * @param array $spreadsheet Target connection
     * @param string|'oauth2' $credentialsType enum('service_account', 'oauth2)
     * @param string|null $credentialsFile json credential file
     * @param array|null $connection Source connection
     * @param string|null $logger
     * @param string|null $with_keys Insert with specified Spreadsheet cols name or not
     * @param array|null  $mappings : using for mapping spreadsheet cols name & leadgen formmeta
     
     * @return bool|string|null
     * @throws \Throwable
     */
    function apps_google_sheet(
        $spreadsheetData,
        $spreadsheet,
        $credentialsType = 'oauth2',
        $credentialsFile = '',
        $connection = null,
        $logger = 'daily',
        $mappings = [],
        $with_keys = true
    ) {
        try {
            #region Initial variables
            Log::channel($logger)->info("Starting with Spreadsheet {$spreadsheet['spreadsheet']['id']}");
            if (isset($spreadsheetData['status']) && $spreadsheetData['status'])
                unset($spreadsheetData['status']);
            if (!$spreadsheet['spreadsheet']['id'])
                throw new Exception("Spreadsheet can not be empty");
            if (!$spreadsheet['sheet']['name'])
                throw new Exception("Sheet can not be empty");
            #endregion Initial variables
            Log::channel($logger)->info("Spreadsheet data captured", $spreadsheetData);

            #region Spreadsheet Key process
            $spreadsheetData = array_combine(
                array_map(function ($key) use (&$spreadsheetData) {
                    unset($spreadsheetData[Str::slug($key, '')]);
                    return Str::slug($key, '');
                }, array_keys($spreadsheetData)),
                array_values($spreadsheetData)
            );

            Log::channel($logger)->info("Spreadsheet keys process captured", $spreadsheetData);
            #endregion Spreadsheet Key process

            try {
                if ($credentialsType == 'oauth2') { // using laravel style
                    #region Use a "OAuth2 Account" to connection and spreadsheet process data
                    Log::channel($logger)->info("Starting with credential '{$credentialsType}'");

                    $connection = $connection['connection'];
                    // $connection['provider_exchange_token'] = "ya29.a0AVvZVsoJMk305Wtu1stm24eJ2DMlCwhs8mWSSItVq0V71k-acxWX61UTkup1XCuNBfkOdSnuvG0yf0UD3PLmCHvKe2u4tCa5jiKUvO_1wb3iuiSgMah9lvRw6zmVghdJVMhduXA3vPIbMInl1TpbFo2ZwAACp9QaCgYKAfcSARASFQGbdwaI3e2Ft2ZwRwV4f99YkU0lKg0166";
                    // $connection['provider_exchange_refresh_token'] = "1//0g_0eeNlzaaQSCgYIARAAGBASNwF-L9IrzuHaQJMudLRfynOumPBNkpN9F21hMJcjGIpNYFAfve6MJvl2trm25JGzvYSNhDfWuyM";
                    // Log::channel($logger)->info("Connection captured", $connection);
                    $accessToken = [
                        'access_token' => $connection['provider_exchange_token'],
                        'refresh_token' => $connection['provider_exchange_refresh_token'],
                    ]; // $accessToken = json_decode(file_get_contents(storage_path('app/google-oauth2-tokens.json')), true);
                    #endregion Use a "OAuth2 Account" to connection and spreadsheet process data
                } else { // using non-laravel style
                    #region Setup Google Client & Service Account
                    $client = new Client();
                    $client->setApplicationName(env('APP_NAME'));
                    $client->setScopes([
                        \Google\Service\Sheets::DRIVE,
                        \Google\Service\Sheets::SPREADSHEETS
                    ]);
                    $client->setAccessType('offline');
                    #endregion Setup Google Client

                    #region Use a "Service Account" to connection and spreadsheet process data
                    Log::channel($logger)->info("Starting with credential '{$credentialsType}'");

                    #region Setup Google Credentials
                    if (!$credentialsFile)
                        $credentialsFile = config_path('google-pull.vn-service-account-110095136248877193658.json'); // Service Account

                    $client->setAuthConfig($credentialsFile); // use environment variable: putenv("GOOGLE_APPLICATION_CREDENTIALS=$credentialsFile"); $client->useApplicationDefaultCredentials();
                    #endregion Setup Google Credentials

                    $tokenPath = storage_path('app/google-service-account-tokens.json');
                    if (file_exists($tokenPath)) {
                        $accessToken = json_decode(file_get_contents($tokenPath), true);
                        $client->setAccessToken($accessToken);
                    }
                    if ($client->isAccessTokenExpired()) {
                        if ($client->getRefreshToken()) {
                            $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
                        } else {
                            // Exchange authorization code for an access token.
                            $accessToken = $client->fetchAccessTokenWithAssertion(); //  should store to file
                            $client->setAccessToken($accessToken);
                            // Check to see if there was an error.
                            if (array_key_exists('error', $accessToken))
                                throw new Exception(join(', ', $accessToken));
                        }
                        if (!file_exists(dirname($tokenPath)))
                            mkdir(dirname($tokenPath), 0700, true);
                        file_put_contents($tokenPath, json_encode($client->getAccessToken()));
                    }
                    #endregion Use a "Service Account" to connection and spreadsheet process data
                }
            } catch (\Throwable $th) {
                throw $th;
            }

            #region Spreadsheet process data
            $values = $values_mappings = [];
            // $spreadsheet['spreadsheet']['id'] = "1zfwtB8vh5RKp9va11F3XHRCC30Zpzbu_1I-RLwS6ugU";
            // $spreadsheet['sheet']['name'] = "LIST DATA";

            $rows = Sheets::setAccessToken($accessToken)
                ->spreadsheet($spreadsheet['spreadsheet']['id'])
                ->sheet($spreadsheet['sheet']['name'])->get();

            if ($with_keys) { // When providing an associative array, values get matched up to the headers in the provided sheet
                $headers = $rows->pull(0); // $values = Sheets::collection(header: $header, rows: $rows)->toArray();

                #region mapping sample data
                ' // sample data
                "Phone": [
                    {"id": "114974625017517","key": "1367111817480640|số_điện_thoại","label": "Phone number","form_id": "1367111817480640"},
                    {"id": "1353924855537837","key": "1009385287145182|phone_number","label": "Phone number","form_id": "1009385287145182"}]';
                #endregion mapping sample data

                if (count($mappings)) { // Custom headers mappings w/ "field key" of ads-form vs "column" name of spreadsheet.
                    foreach ($mappings as $mapping_key => $_mappings) {
                        $values_mappings[$mapping_key] = null;
                        if (count($_mappings)) {
                            foreach ($_mappings as $__mapping) {
                                $__mapping_key = Str::slug($__mapping['key'], ''); // "1009385287145182|số_điện_thoại" or "số_điện_thoại"
                                $__mapping_key = isset(explode("|", $__mapping_key)[1]) ? explode("|", $__mapping_key)[1] : $__mapping_key;

                                if (isset($spreadsheetData['providerformid']) && $spreadsheetData['providerformid']) {
                                }
                                if (isset($spreadsheetData[$__mapping_key]))
                                    $values_mappings[$mapping_key] .= "{$spreadsheetData[$__mapping_key]} ";
                            }
                        }
                    }

                    $values_mappings = array_filter($values_mappings, fn($value) => !is_null($value) && $value !== '');
                    Log::channel($logger)->info('Spreadsheet with mapping headers', $mappings);
                    // Log::channel($logger)->info('Spreadsheet Data with mapping headers', $values_mappings);
                }
                foreach ($headers as $header) { // Default headers mappings
                    if (isset($spreadsheetData[Str::slug($header, '')])) {
                        $values[$header] = $spreadsheetData[Str::slug($header, '')];
                    }
                }
                $values = array_filter($values, fn($value) => !is_null($value) && $value !== '');
                // Log::channel($logger)->info('Spreadsheet Data with default headers', $values);

                $values = array_merge($values, $values_mappings);
            } else {
                $values = array_values($spreadsheetData);
            }

            Log::channel($logger)->info('Spreadsheet Data', $values);
            $result = Sheets::sheet($spreadsheet['sheet']['name'])->append([$values]);
            #endregion Spreadsheet process data

            Log::channel($logger)->info("Spreadsheet Inserted: " . json_encode($result->toSimpleObject()));

            return json_encode([
                "result" => [
                    'message' => $spreadsheet['spreadsheet']['id']
                ],
                "success" => true,
                "error" => null
            ]);
        } catch (\Throwable $th) {
            Log::channel($logger)->error($th->getMessage());

            return json_encode([
                "result" => null,
                "success" => false,
                "error" => [
                    "code" => $th->getCode(),
                    "message" => $th->getMessage(),
                    "message_system" => $th->getMessage(),
                    "details" => json_encode($th)
                ]
            ]);
        }
    }
}
if (!function_exists('apps_phone_convert')) {
    function apps_phone_convert($phonenumber)
    {
        if (!$phonenumber)
            return false;
        try {
            $phonenumber = preg_replace("/[^0-9.]/", "", $phonenumber); // get number only, eg: p:+84982311866
            if (mb_strlen($phonenumber) > 10 && substr($phonenumber, 0, 2) == '84') { // only for vietnam
                $phonenumber = "0" . substr($phonenumber, 2);
            }

            return $phonenumber;
        } catch (\Throwable $th) {
        }

        return false;
    }
}
if (!function_exists('apps_currency_exchange')) {
    function apps_currency_exchange()
    {
        try {
            $responseAccessToken = Http::get('https://vapi.vnappmob.com/api/request_api_key?scope=exchange_rate');
            $accessToken = trim(Arr::get($responseAccessToken->json(), 'results'));

            $responseExchangeRate = Http::withHeaders([
                'Authorization' => "Bearer $accessToken"
            ])
                ->get('https://vapi.vnappmob.com/api/v2/exchange_rate/vcb');
            $result = Arr::get($responseExchangeRate->json(), 'results');
            $dollarSellPrice = Arr::get(Arr::first(array_filter($result, function ($item) {
                return Arr::get($item, 'currency') == 'USD';
            })), 'sell');

            return $dollarSellPrice ?? 24500;
        } catch (\Throwable $th) {
            return 24500;
        }
    }
}

if (!function_exists('apps_logger')) {
    function apps_logger($logger, $author_id = null)
    {
        $logger = (!blank($author_id) ? 'member-' . $author_id . '-' : '') . $logger;
        if (null == Config::get("logging.channels.{$logger}")) {
            Config::set("logging.channels.$logger", [
                'driver' => 'daily',
                'path' => storage_path("logs/$logger.log"),
                'level' => 'debug',
            ]);
        }
        Log::channel($logger)->info("\n\nBEGIN CUSTOM LOGGER =======================================================================");
        return $logger;
    }
}

if (!function_exists('apps_scan_folder')) {

    /**
     *
     * @param
     *            $path
     * @param array $ignore_files
     * @return array
     * @author Anonymous Developer Team
     */
    function apps_scan_folder($dir, $ignore_files = [])
    {
        try {
            if (is_dir($dir)) {
                $ignore_pattern = implode('|', array_merge($ignore_files, [
                    '^\.',
                    '.DS_Store'
                ]));
                $datas = preg_grep("/$ignore_pattern/i", scandir($dir), PREG_GREP_INVERT);
                natsort($datas);
                return $datas;
            }
            return [];
        } catch (Exception $ex) {
            return [];
        }
    }
}

#region Begin XML Pre-processing: Removes invalid XML
$utf_8_range = range(0, 1114111);
$output = apps_ords_to_utfstring($utf_8_range);
// $sanitized = apps_sanitize_for_xml($output);

// Recursive apps_sanitize_for_xml.
function apps_recursive_sanitize_for_xml(&$input)
{
    if (is_null($input) || is_bool($input) || is_numeric($input)) {
        return;
    }
    if (!is_array($input) && !is_object($input)) {
        $input = apps_sanitize_for_xml($input);
    } else {
        foreach ($input as &$value) {
            apps_recursive_sanitize_for_xml($value);
        }
    }
}

/**
 * Removes invalid XML
 *
 * https://stackoverflow.com/questions/3466035/how-to-skip-invalid-characters-in-xml-file-using-php
 *
 * @access public
 * @param string $value
 * @return string
 */
function apps_sanitize_for_xml($input)
{
    // Convert input to UTF-8.
    $old_setting = ini_set('mbstring.substitute_character', '"none"');
    $input = mb_convert_encoding($input, 'UTF-8', 'auto');
    ini_set('mbstring.substitute_character', $old_setting);

    // Use fast preg_replace. If failure, use slower chr => int => chr conversion.
    $output = preg_replace('/[^\x{0009}\x{000a}\x{000d}\x{0020}-\x{D7FF}\x{E000}-\x{FFFD}]+/u', '', $input);
    if (is_null($output)) {
        // Convert to ints.
        // Convert ints back into a string.
        $output = apps_ords_to_utfstring(apps_utfstring_to_ords($input), TRUE);
    }
    return $output;
}

/**
 * Given a UTF-8 string, output an array of ordinal values.
 *
 * @param string $input
 *   UTF-8 string.
 * @param string $encoding
 *   Defaults to UTF-8.
 *
 * @return array
 *   Array of ordinal values representing the input string.
 */
function apps_utfstring_to_ords($input, $encoding = 'UTF-8')
{
    // Turn a string of unicode characters into UCS-4BE, which is a Unicode
    // encoding that stores each character as a 4 byte integer. This accounts for
    // the "UCS-4"; the "BE" prefix indicates that the integers are stored in
    // big-endian order. The reason for this encoding is that each character is a
    // fixed size, making iterating over the string simpler.
    $input = mb_convert_encoding($input, "UCS-4BE", $encoding);

    // Visit each unicode character.
    $ords = array();
    for ($i = 0; $i < mb_strlen($input, "UCS-4BE"); $i++) {
        // Now we have 4 bytes. Find their total numeric value.
        $s2 = mb_substr($input, $i, 1, "UCS-4BE");
        $val = unpack("N", $s2);
        $ords[] = $val[1];
    }
    return $ords;
}

/**
 * Given an array of ints representing Unicode chars, outputs a UTF-8 string.
 *
 * @param array $ords
 *   Array of integers representing Unicode characters.
 * @param bool $scrub_XML
 *   Set to TRUE to remove non valid XML characters.
 *
 * @return string
 *   UTF-8 String.
 */
function apps_ords_to_utfstring($ords, $scrub_XML = FALSE)
{
    $output = '';
    foreach ($ords as $ord) {
        // 0: Negative numbers.
        // 55296 - 57343: Surrogate Range.
        // 65279: BOM (byte order mark).
        // 1114111: Out of range.
        if (
            $ord < 0
            || ($ord >= 0xD800 && $ord <= 0xDFFF)
            || $ord == 0xFEFF
            || $ord > 0x10ffff
        ) {
            // Skip non valid UTF-8 values.
            continue;
        }
        // 9: Anything Below 9.
        // 11: Vertical Tab.
        // 12: Form Feed.
        // 14-31: Unprintable control codes.
        // 65534, 65535: Unicode noncharacters.
        elseif (
            $scrub_XML && ($ord < 0x9
                || $ord == 0xB
                || $ord == 0xC
                || ($ord > 0xD && $ord < 0x20)
                || $ord == 0xFFFE
                || $ord == 0xFFFF)
        ) {
            // Skip non valid XML values.
            continue;
        } // 127: 1 Byte char.
        elseif ($ord <= 0x007f) {
            $output .= chr($ord);
            continue;
        } // 2047: 2 Byte char.
        elseif ($ord <= 0x07ff) {
            $output .= chr(0xc0 | ($ord >> 6));
            $output .= chr(0x80 | ($ord & 0x003f));
            continue;
        } // 65535: 3 Byte char.
        elseif ($ord <= 0xffff) {
            $output .= chr(0xe0 | ($ord >> 12));
            $output .= chr(0x80 | (($ord >> 6) & 0x003f));
            $output .= chr(0x80 | ($ord & 0x003f));
            continue;
        } // 1114111: 4 Byte char.
        elseif ($ord <= 0x10ffff) {
            $output .= chr(0xf0 | ($ord >> 18));
            $output .= chr(0x80 | (($ord >> 12) & 0x3f));
            $output .= chr(0x80 | (($ord >> 6) & 0x3f));
            $output .= chr(0x80 | ($ord & 0x3f));
            continue;
        }
    }
    return $output;
}
#endregion

/**
 * Check if a given string is a valid UUID
 * 
 * @param   string  $uuid   The string to check
 * @return  boolean
 */
if (!function_exists('is_valid_uuid')) {
    function is_valid_uuid($uuid)
    {
        if (!is_string($uuid) || (preg_match('/^[0-9a-f]{8}-[0-9a-f]{4}-4[0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/', $uuid) !== 1)) {
            return false;
        }
        return true;
    }
}

/**
 * Convert JSON data to array, adding ne
 * 
 * @param   string  $originData
 * @param   mixed  $value
 * @param   int|string|null  $key
 * @return  string
 */
if (!function_exists('apps_json_store')) {
    function apps_json_store($originData, $value, $key = null, $override = true): string
    {
        $originData = json_decode($originData, true);
        if (!blank($key)) :
            $newData = Arr::set(
                $originData,
                $key,
                $override ? $value : array_merge(
                    Arr::get(
                        $originData,
                        $key,
                        []
                    ),
                    $value
                )
            );
        else:
            $newData = array_merge($originData, $value);
        endif;

        dump($newData);
        return json_encode($newData);
    }
}
