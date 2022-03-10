<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CheckoutController extends Controller
{

    public function __construct()
    {
        $this->token = "";
        $this->header = array(
            "Content-Type : application/json",
            "Accept: application/json",
            "Authorization:" . base64_encode($this->token . ":"),
        );
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // buat data dummy
        $products = [
            [
                'name' => 'Tiramisu',
                'image' => asset('tiramisu.png'),
                'quantity' => 0,
                'price' => 20000,
            ],
        ];

        return view('welcome')->with(compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        // create body request
        $cust_address = [
            "receiver_name" => "gandhia",
            "receiver_phone" => "085553366554",
            "address_line_1" => "JL HR Rusuna Said",
        ];
        $customer = [
            "customer_ref_id" => "cust_" . rand(1, 100),
            "given_name" => "gandhia",
            "email" => "myemail@noemail.com",
            "mobile" => "085553366554",
            "address" => $cust_address,
        ];
        $item = [
            "name" => $request->product,
            "qty" => (int) $request->qty,
            "price" => $request->price,
        ];
        $body = [
            "amount" => $request->total,
            "payment_option" => "full_payment",
            "currency" => "IDR",
            "order_ref_id" => "gst_" . rand(1, 100),
            "is_payment_link" => true,
            "customer" => $customer,
            "items" => [$item],
        ];

        $res = json_decode($this->generatePaymentLink($body));
        $payment_url = "https://links.durianpay.id/payment/" . $res->data->payment_link_url;
        return redirect()->away($payment_url);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    // function for request api
    private function generatePaymentLink($body)
    {
        $url = "https://api.durianpay.id/v1/orders";

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => (60 * 5),
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_POSTFIELDS => json_encode($body),
            CURLOPT_HTTPHEADER => $this->header,
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);
        $info = curl_getinfo($curl);

        curl_close($curl);

        if ($err) {
            return "CURL Error" . $err;
        } else {
            return $response;
        }
    }
}
