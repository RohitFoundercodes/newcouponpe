<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{User,Paymode,BankAccount,profileImage,Banner};
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Services\ApiService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

use Exception;

class ONDCApiController extends Controller
{
    protected $apiService;
    
    private $apiKey ='41bdaa1ae961d9d1ac0d388efd6edd512905da4851f561f8f17ec2fb5b16920a';
    private $encryptionKey ='fdc3306287bfcb82378f3b7b36244c91';

    public function fetchCatalogue(Request $request)
    { try{
        $url = 'https://staging.meribachat.in/bap/catalogue';
        $apiKey = '41bdaa1ae961d9d1ac0d388efd6edd512905da4851f561f8f17ec2fb5b16920a';

       // Build query parameters
        $queryParams = [
            'orderBy' => $request->input('orderBy'),
            'order' => $request->input('order'),
            'page' => $request->input('page', 1),
            'count' => $request->input('count', 10),
            'likeBehaviour' => $request->input('likeBehaviour'),
            // Add other optional parameters as needed
        ];

        // Make the GET request
        $response = Http::withHeaders([
            'X-API-KEY' => $this->apiKey,
        ])->get($url, $queryParams);
        
        // echo $response; die;
         //echo $respons['result'] ; die;
         
         $a = json_decode($response);
         
         $encryptedData = $a->result->data;
         $iv = $a->result->iv;
         $key = 'fdc3306287bfcb82378f3b7b36244c91';
       
        
        $decrypted = $this->decryptData($encryptedData, $key, $iv);

      if ($decrypted === false) {
             echo 'Decryption failed.';
      } else {
            // echo 'Decrypted Data: ' . $decrypted;
            // echo $decrypted;die;
        return response()->json(['success'=>true, 'message'=>'Catalogue list','data'=> $decrypted]);
        }
    }catch (Exception $e) {
            return response()->json(['error' => 'API request failed: ' . $e->getMessage()], 500);
        }
                

        ////////// end //////
        
        
    }







    protected function decryptData($encryptedData, $key, $iv) {
     $keyBinary = $key;
    $ivBinary = $iv;
    $decryptedData = openssl_decrypt(
        base64_decode($encryptedData), 
        'AES-256-CBC',
        $keyBinary,
        OPENSSL_RAW_DATA,
        $ivBinary
    );

    return $decryptedData;
    
    
}

// Search catalogue    

    public function SearchCatalogues(Request $request){
    try {
        $url = 'https://staging.meribachat.in/bap/catalogue/search';
        $apiKey = '41bdaa1ae961d9d1ac0d388efd6edd512905da4851f561f8f17ec2fb5b16920a';
         $request->validate([
            'q' => 'required|string',
            'page' => 'integer|nullable',
            'count' => 'integer|nullable',
            'nonPaginated' => 'boolean|nullable',
        ]);
        $queryParams = [
            'q' => $request->input('q'),
            'page' => $request->input('page', 1),
            'count' => $request->input('count', 10),
            'nonPaginated' => $request->input('nonPaginated', false),
        ];
        $response = Http::withHeaders([
            'X-API-KEY' => $apiKey,
        ])->get($url, $queryParams);
         $a = json_decode($response);
         
         $encryptedData = $a->result->data;
         $iv = $a->result->iv;
         $key = 'fdc3306287bfcb82378f3b7b36244c91';
         
         $decrypted = $this->decryptData($encryptedData, $key, $iv);

        if ($decrypted === false) {
                return response()->json(['error' => 'Failed to fetch data from the external API.'], $response->status());
        } else {
            // echo 'Decrypted Data: ' . $decrypted;
            
            return response()->json(['success'=>true, 'message'=>'Catalogue Search list','data'=> $decrypted]);
        }
        
        
        } catch (Exception $e) {
            return response()->json(['error' => 'API request failed: ' . $e->getMessage()], 500);
    }
}



    public function ReadSingleCatalogueItem($id){
    try {
        $url = 'https://staging.meribachat.in/bap/catalogue/' . $id;
        $apiKey = '41bdaa1ae961d9d1ac0d388efd6edd512905da4851f561f8f17ec2fb5b16920a';

        // Make the GET request
        $response = Http::withHeaders([
            'X-API-KEY' => $apiKey,
        ])->get($url);
        
         $a = json_decode($response);
         
         $encryptedData = $a->result->data;
         $iv = $a->result->iv;
         $key = 'fdc3306287bfcb82378f3b7b36244c91';
         
         $decrypted = $this->decryptData($encryptedData, $key, $iv);

        if ($decrypted === false) {
                return response()->json(['error' => 'Failed to fetch data from the external API.'], $response->status());
        } else {
            // echo 'Decrypted Data: ' . $decrypted;
            
            return response()->json(['success'=>true, 'message'=>'Read Single Catalogue Item','data'=> $decrypted]);
        }

    } catch (Exception $e) {
        return response()->json(['error' => 'API request failed: ' . $e->getMessage()], 500);
    }
}






    public function RealyGetQuote(Request $request,$action)
    {
      try {
         $url = 'https://staging.meribachat.in/bap/catalogue/'.$action;
        $apiKey = '41bdaa1ae961d9d1ac0d388efd6edd512905da4851f561f8f17ec2fb5b16920a';
        $response = Http::withHeaders([
            'X-API-KEY' => $apiKey, 
        ])->post($url, $request->all()); 
        if ($response->successful()) {
            return response()->json($response->json(), $response->status());
        }
        return response()->json([
            'success' => false,
            'error' => 'Third-party API request failed: ' . $response->status(),
        ], $response->status());

    } catch (\Exception $e) {
         Log::error('API Request Exception', ['error' => $e->getMessage()]);
         return response()->json([
            'success' => false,
            'error' => 'API request failed: ' . $e->getMessage(),
        ], 500);
    }
}
// public function GetQuote(Request $request)
// {
//     try {
//         $url = 'https://staging.meribachat.in/bap/company_order/getQuote/';
//         $apiKey = '41bdaa1ae961d9d1ac0d388efd6edd512905da4851f561f8f17ec2fb5b16920a';

//         // Validate the incoming request
//         $request->validate([
//             'data' => 'required|array',
//             'data.companyId' => 'required|string',
//             'data.items' => 'required|array',
//             'data.items.*.itemId' => 'required|string',
//             'data.items.*.denomination' => 'required|numeric',
//             'data.items.*.quantity' => 'required|integer',
//             'data.buyerPhNumber' => 'nullable|string',
//             'data.buyerEmail' => 'nullable|email',
//             'data.address' => 'nullable|string',
//             'data.city' => 'nullable|string',
//             'data.state' => 'nullable|string',
//         ]);

//         $requestData = $request->input('data');
//         $requestData= json_encode($requestData);
//         $array=array(
//             "data"=>$requestData
//             );
        
//         // Send the request using Laravel's Http Client
//         $response = Http::withHeaders([
//             'X-API-KEY' => $apiKey,
//         ])->get($url, $array);

//         Log::info('API Response', [
//             'status' => $response->status(),
//             'headers' => $response->headers(),
//             'body' => $response->body(),
//         ]);
//         print_r($response.getBody());
//         echo json_encode($response);
//         // Handle non-200 responses
//         if ($response->failed()) {
//             $errorMessage = $response->json('message') ?? 'Unknown error';
//             return response()->json([
//                 'success' => false,
//                 'error' => "Failed to fetch data: {$errorMessage}",
//                 'status' => $response->status(),
//             ], $response->status());
//         }

//         $apiResponse = $response->json();

//         // Validate response structure
//         if (!isset($apiResponse['result']['data'], $apiResponse['result']['iv'])) {
//             return response()->json([
//                 'success' => false,
//                 'error' => 'Invalid API response structure.',
//             ], 500);
//         }

//         $encryptedData = $apiResponse['result']['data'];
//         $iv = $apiResponse['result']['iv'];
//         $key = 'fdc3306287bfcb82378f3b7b36244c91';

//         // Decrypt the data
//         $decrypted = $this->decryptData($encryptedData, $key, $iv);

//         if ($decrypted === false) {
//             return response()->json(['success' => false, 'error' => 'Decryption failed.'], 500);
//         }
//         return response()->json([
//             'success' => true,
//             'message' => 'GetQuote retrieved successfully.',
//             'data' => $decrypted,
//         ]);

//     } catch (\Exception $e) {
//         // Log the exception
//         \Log::error('API Request Exception', ['error' => $e->getMessage()]);

//         return response()->json([
//             'success' => false,
//             'error' => 'API request failed: ' . $e->getMessage(),
//         ], 500);
//     }
// }

public function getQuote(Request $request) {
    try {
        $url = 'https://staging.meribachat.in/bap/company_order/getQuote/';
        $apiKey = '41bdaa1ae961d9d1ac0d388efd6edd512905da4851f561f8f17ec2fb5b16920a';
        $requestData = $request->input('data');
        $item_id=$requestData['items'][0]['itemId']; 
        $amount=$requestData['items'][0]['denomination'];
        $companyOrderId=$requestData['companyId'];
        $userid=$request->input('userid');
        $date=date('YmdHis');
        $rand=rand(111111,999999);
        $order_id=$date.$rand;
         $queryData = http_build_query([
            'data' => json_encode($requestData)
        ]);
        $url .= '?data=' . urlencode(json_encode($requestData));
    
      
         $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_VERBOSE, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'X-API-KEY: ' . $apiKey,
            'Accept: application/json',
            'Expect:'
        ]);
     
        $response = curl_exec($ch);
       
     
        if (curl_errno($ch)) {
            throw new Exception('cURL Error: ' . curl_error($ch));
        }
        curl_close($ch);
       
        preg_match('/quoteEnc:\s*(\{.*?\})/', $response, $matches);
         if (isset($matches[1])) {
            $data=$matches[1];
        } else {
            $data="";
        }
       if(empty($data)){
           return [
            'success' => false,
            'error' => "items out of stock",
            'status' => 400
        ];
       }
        $response=json_decode($data);
     
        $encryptedData =$response->data;
         $iv = $response->iv;
        $key = 'fdc3306287bfcb82378f3b7b36244c91';
        $decrypted = $this->decryptData($encryptedData, $key, $iv);
         if ($decrypted === false) {
            return [
                'success' => false,
                'error' => 'Decryption failed.',
                'status' => 500
            ];
        }
       $data=json_decode($decrypted);
        $txn_id=$data->transaction_id;
        $quote=json_encode($data->quote);
        
        $urlgetItem = 'https://staging.meribachat.in/bap/catalogue/' . $item_id;
 
        // Make the GET request
        $responseitem = Http::withHeaders([
            'X-API-KEY' => $apiKey,
        ])->get($urlgetItem);
        
         $aitemdata= json_decode($responseitem);
         
         $encryptedDataItem = $aitemdata->result->data;
         $ivitem = $aitemdata->result->iv;
         $keyItemss = 'fdc3306287bfcb82378f3b7b36244c91';
         
         $decryptedItemData = $this->decryptData($encryptedDataItem, $keyItemss, $ivitem);
         $decryptedItemData=json_decode($decryptedItemData);
        $itemname=$decryptedItemData->name;
        
        $logo=$decryptedItemData->logo;
       
       $insert=DB::table('getQuote')->insert(['txn_id' =>$txn_id,'userid' => $userid,'quote'=>$quote,'iv'=>$iv,'item_id'=>$item_id,'company_id'=>$companyOrderId,'itemname'=>$itemname,'logo'=>$logo,'amount'=>$amount,'discount'=>0,'orderid'=>$order_id]);
        return [
            'success' => true,
            'message' => 'GetQuote retrieved successfully.',
            'transaction_id' => $txn_id,
            'orderid'=>$order_id,
            'iv'=>$iv
        ];

    } catch (Exception $e) {
         error_log('API Request Exception: ' . $e->getMessage());

        return [
            'success' => false,
            'error' => 'API request failed: ' . $e->getMessage(),
            'status' => 400
        ];
    }
}



// Place Order

//     public function PlaceOrder(Request $request){
//     try {
//         $url = 'https://staging.meribachat.in/bap/company_order/place-order';
//         $apiKey = '41bdaa1ae961d9d1ac0d388efd6edd512905da4851f561f8f17ec2fb5b16920a';

//         // Validate the incoming request
//         $request->validate([
//             'user_id' => 'required|string',
//         ]);
//       $requessst=$request->input('data');
//       $datas=urlencode(json_encode($requessst));
//         $requestData = [
//             'data' => $datas,
//             'iv' => $request->input('iv'),
//         ];
       
        
        

//         // Make the POST request
//         $response = Http::withHeaders([
//             'X-API-KEY' => $apiKey,
//         ])->post($url, $requestData);
     
//         // Check if the response is successful
//         if ($response->successful()) {
//             return response()->json($response->json(), 200);
//         } else {
//             return response()->json(['error' => 'Failed to place order.'], $response->status());
//         }

//     } catch (Exception $e) {
//         return response()->json(['error' => 'API request failed: ' . $e->getMessage()], 500);
//     }
// }
// public function PlaceOrder(Request $request)
// {
//     try {
//         $url = 'https://staging.meribachat.in/bap/company_order/place-order';
//         $apiKey = '41bdaa1ae961d9d1ac0d388efd6edd512905da4851f561f8f17ec2fb5b16920a';

//         // Validate the incoming request
//         $request->validate([
//             'user_id' => 'required|string',
//         ]);

//         $requessst = $request->input('data');
//         $datas = urlencode(json_encode($requessst));
//         $iv = $request->input('iv');

//         $postData = [
//             'data' => $datas,
//             'iv' => $iv,
//         ];

//         // Initialize cURL session
//         $ch = curl_init();

//         // Set cURL options
//         curl_setopt($ch, CURLOPT_URL, $url);
//         curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//         curl_setopt($ch, CURLOPT_POST, true);
//         curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));  // Form data
//         curl_setopt($ch, CURLOPT_HTTPHEADER, [
//             'X-API-KEY: ' . $apiKey, // API Key header
//             'Content-Type: application/x-www-form-urlencoded', // Content type
//         ]);

//         // Execute the request
//         $response = curl_exec($ch);

//         // Check for errors
//         if ($response === false) {
//             $error = curl_error($ch);
//             curl_close($ch);
//             return response()->json(['error' => 'cURL Error: ' . $error], 500);
//         }

//         // Close cURL session
//         curl_close($ch);

//         // Decode the response
//         $responseData = json_decode($response, true);

//         // Check if the response is valid and successful
//         if (isset($responseData['status']) && $responseData['status'] === 'success') {
//             return response()->json($responseData, 200);
//         } else {
//             return response()->json(['error' => 'Failed to place order.'], 500);
//         }

//     } catch (Exception $e) {
//         return response()->json(['error' => 'API request failed: ' . $e->getMessage()], 500);
//     }
// }
public function PlaceOrder(Request $request)
{
    try {
        $url = 'https://staging.meribachat.in/bap/company_order/place-order';
        $apiKey = '41bdaa1ae961d9d1ac0d388efd6edd512905da4851f561f8f17ec2fb5b16920a';
        $request->validate([
            'user_id' => 'required|string',
            'transactionId' => 'required|string',
            'iv' => 'required|string',
            'companyOrderId' => 'required|string',
        ]);

        // Extract the input values
        $iv =$request->input('iv');  // Convert IV from hex to binary
        $transactionId = $request->input('transactionId');
        $companyOrderId = $request->input('companyOrderId');

        // Sample transaction details
        $transactionDetails = [
            'transactionId' => $transactionId,
            'companyOrderId' => $companyOrderId,
        ];

        // Convert transaction details to JSON
        $data = json_encode($transactionDetails);
     

        // Define your AES key (ensure it's 32 bytes for AES-256-CBC)
        $key = 'fdc3306287bfcb82378f3b7b36244c91'; // Example key, use your own secure key

        // Encrypt the data using AES-256-CBC
        $encryptedData = openssl_encrypt($data, 'AES-256-CBC', $key, OPENSSL_RAW_DATA, $iv);
        
        $encryptedDataBase64 = base64_encode($encryptedData); // Convert encrypted data to base64
        $ivHex =$iv; // Convert IV to hexadecimal for transport
 
        // Prepare the POST data for the API request
        $postData = [
            'data' => $encryptedDataBase64,
            'iv' => $ivHex,
        ];

        // Initialize cURL session
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData)); // Form data
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'X-API-KEY: ' . $apiKey,
            'Content-Type: application/json',
        ]);

        // Execute the request
        $response = curl_exec($ch);
     
        if ($response === false) {
            $error = curl_error($ch);
            curl_close($ch);
            return response()->json(['error' => 'cURL Error: ' . $error], 500);
        }
         curl_close($ch);
         $responseData = json_decode($response, true);
         
      
        // Check if the response is valid and successful
        if ($responseData['message']=='Success') {
            $order_id=$responseData['result'];
            $update=DB::table('getQuote')->where('txn_id', $transactionId)->update(['orderid' => $order_id,'status'=>1]);
            return response()->json(['data' => $responseData,'status'=>true,'message'=>'Order placed Successfully'], 200);
        } else {
            return response()->json(['data' => $responseData,'status'=>false,'message'=>'order not placed'], 200);
        }
    } catch (\Exception $e) {
        return response()->json(['error' => 'API request failed: ' . $e->getMessage()], 500);
    }
}
public function OrderStatus($companyOrderId, $transactionId)
{
    try {
        $url = 'https://staging.meribachat.in/bap/company_order/status?companyOrderId='.$companyOrderId.'&ondcOrderId='.$transactionId;
        $apiKey = '41bdaa1ae961d9d1ac0d388efd6edd512905da4851f561f8f17ec2fb5b16920a';

        // Initialize cURL session
        $ch = curl_init();

        // Set cURL options
        curl_setopt($ch, CURLOPT_URL, $url); // Set the URL
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Return the response as a string
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'X-API-KEY: ' . $apiKey // Add the API key in the headers
        ]);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30); // Set a timeout (optional)

        // Execute the cURL request
        $response = curl_exec($ch);
        
      
        // Check if any error occurred during the request
        if (curl_errno($ch)) {
            throw new Exception('cURL Error: ' . curl_error($ch));
        }

        // Close the cURL session
        curl_close($ch);

        // Decode the response JSON
        $a = json_decode($response);
       
 
        if ($a === null) {
            return response()->json(['error' => 'Invalid JSON response from API.'], 500);
        }
         $encryptedData = $a;
         $encryptedDataItem=$encryptedData->result->vouchers->data;
         $ivitem=$encryptedData->result->vouchers->iv;
         $keyItemss = 'fdc3306287bfcb82378f3b7b36244c91';
         
         $decryptedItemData = $this->decryptData($encryptedDataItem, $keyItemss, $ivitem);
         $decryptedItemData=json_decode($decryptedItemData);
         $datas=$decryptedItemData[0];
         $getdata = DB::table('getQuote')->where('orderid', $transactionId)->where('status', 1)->first();
         $mergedArray = [];
             foreach ($getdata as $key => $value) {
                $mergedArray[$key] = $value;
            }
            foreach ($decryptedItemData[0] as $key => $value) {
                $mergedArray[$key] = $value;
            }
 
         if ($encryptedData->status->code == "200") {
            return response()->json(['success' => true, 'message' => 'Successfully', 'data'=>$mergedArray]);
        } else {
            return response()->json(['success' => true, 'message' => 'Read Single Catalogue Item', 'data' ]);
        }

    } catch (Exception $e) {
        return response()->json(['error' => 'API request failed: ' . $e->getMessage()], 500);
    }
}
public function orderhistory($userid)
{
     try {
         $getdata = DB::table('getQuote')->where('userid', $userid)->where('status', 1)->get();
        if($getdata)
        {
            return response()->json(['status'=>true,'message' =>'Successfully','data'=>$getdata]);
        }else{
            return response()->json(['message'=>'not dat found','status'=>false], 200);
        }
           
            
     }catch (Exception $e) {
            return response()->json(['error' => 'API request failed: ' . $e->getMessage()], 500);
        }
}





    
}









