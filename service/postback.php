<?php
// Permite trafegar informações vindas do WebService de SandBox do PagSeguro
//header("access-control-allow-origin: https://sandbox.pagseguro.uol.com.br");

require __DIR__ . "/../vendor/autoload.php";

//// Resgata as informações
//Para capturar o corpo JSON
$json = json_decode(file_get_contents('php://input'), true);

if(!empty($json)){
    $type = explode(".", $json["type"]);
    $data = $json["data"];

    $customer = null;
    $subscription = null;
    $cycle = null;
    $charge = null;
    $transaction = null;
    $card = null;

    //Fatura
    if($type[0] == "invoice") {
        $customer = ($data["customer"] ?? null);
        $subscription = ($data["subscription"] ?? null);
        $cycle = ($data["cycle"] ?? null);
        $charge = ($data["charge"] ?? null);
        $last_transaction = ($data["charge"]["last_transaction"] ?? null);
        $card = ($last_transaction["card"] ?? null);
        $gateway_response = ($last_transaction["gateway_response"] ?? null);
    }

    if($type[0] == "charge") {
        $charge = ($data ?? null);
        $invoice = ($charge["invoice"] ?? null);
        $customer = ($charge["customer"] ?? null);
        $last_transaction = ($charge["last_transaction"] ?? null);
        $card = ($last_transaction["card"] ?? null);
        $gateway_response = ($last_transaction["gateway_response"] ?? null);
    }

    if(!empty($gateway_response["code"]) && $gateway_response["code"] != 200) {
        (new \Source\Support\Log())->telegram()->emergency("Erro no gateway_response POSTBACK", ["DATA"=>$data["id"]]);
        return;
    }

    //Pega usuário pelo email
    if(!empty($customer)){
        $getUser = (new \Source\Models\User())->findByEmail($customer["email"]);
        if(empty($getUser->id)){
            (new \Source\Support\Log())->telegram()->emergency("Erro ao consultar usuario no POSTBACK", ["INVOICE"=>$invoice["id"]]);
            return;
        }
    }

    //Pega Assinatura
    if(!empty($subscription)){
        $getSubscription = (new \Source\Models\FreelaApp\AppSubscription())->findByCode($subscription["id"]);
        if(empty($getSubscription)){
            (new \Source\Support\Log())->telegram()->emergency("Erro ao consultar Assinatura no POSTBACK", ["INVOICE"=>$invoice["id"]]);
        }
        $getSubscription->status = $subscription["status"];
        $getSubscription->save();
    }

    //Transaction
    if(!empty($subscription)){
        $getTransaction = (new \Source\Models\FreelaApp\AppTransaction())->findByCode($last_transaction["id"]);
        if(empty($getTransaction)){
            $getTransaction = (new \Source\Models\FreelaApp\AppTransaction());
            $getTransaction->code = $last_transaction["id"];
            $getTransaction->user_id  = $getUser->id;
        }
        $getTransaction->subscription_id  = $getSubscription->id;
        $getTransaction->transaction_type = $last_transaction["transaction_type"];
        $getTransaction->amount = $last_transaction["amount"];
        $getTransaction->status = $last_transaction["status"];
        $getTransaction->save();
    }

    if(!empty($card)){
        $getCreditCard = (new \Source\Models\FreelaApp\AppCard())->findByCode($card["id"]);
        $getCreditCard->status = $card["status"];
        $getCreditCard->save();
    }

    if(!empty($invoice)){
        $getInvoice = (new \Source\Models\FreelaApp\AppInvoice())->findByCode($invoice["id"]);
        if(empty($getInvoice)){
            $getInvoice = (new \Source\Models\FreelaApp\AppInvoice());
            $getInvoice->code = $invoice["id"];
        }
        $getInvoice->amount = $invoice["amount"];
        $getInvoice->payment_method = $invoice["payment_method"];
        $getInvoice->due_at = $invoice["due_at"];
        $getInvoice->subscription_id = ($getSubscription->id ?? null);
        $getInvoice->status = $invoice["status"];
        $getInvoice->save();
    }

    if(!empty($charge)){
        $getCharge = (new \Source\Models\FreelaApp\AppCharge())->findByCode($charge["id"]);
        if(empty($getCharge)){
            $getCharge = (new \Source\Models\FreelaApp\AppCharge());
            $getCharge->code = $charge["id"];
            $getCharge->user_id = ($getUser->id ?? null);
        }
        $getCharge->amount = $charge["amount"];
        $getCharge->paid_amount = ($charge["paid_amount"] ?? null);
        $getCharge->currency = $charge["currency"];
        $getCharge->payment_method = $charge["payment_method"];
        $getCharge->due_at = $charge["due_at"];
        $getCharge->paid_at = ($charge["paid_at"] ?? null);
        $getCharge->invoice_id = ($getInvoice->id ?? null);
        $getCharge->transaction_id = ($getTransaction->id ?? null);
        $getCharge->status = $charge["status"];
        $getCharge->save();
    }
}