<?php
/**
 * Created by PhpStorm.
 * User: Fernando Sena
 * Date: 02/02/2022
 * Time: 10:37
 */

namespace Source\Models\Pay;


class Payments extends Pay
{
    public function creditCard(
        string $number,
        int $exp_month,
        int $exp_year,
        int $cvv,
        ?string $holder_name = null,
        ?string $holder_document = null,
        ?string $statement_descriptor = null)
    {
        $param = [
            "payments" => [
                [
                    "payment_method" => "credit_card",
                    "credit_card" => [
                        "statement_descriptor" => $statement_descriptor,
                        "operation_type" => "auth_only",
                        "card" => [
                            "number" => $number,
                            "holder_name" => $holder_name,
                            "exp_month" => $exp_month,
                            "exp_year" => $exp_year,
                            "cvv" => $cvv,
                            "holder_document" => $holder_document
                        ]
                    ]
                ]
            ]
        ];
        $this->build = array_merge($this->build, $param);
        return $this->post();
    }

    public function boleto(
        int $due_at = 5,
       ?string $document_number = null,
       ?string $nosso_numero = null,
       ?string $bank = null,
       ?string $instructions = null,
       ?string $type = null)
    {
        $param = [
            "payments" => [
                [
                    "payment_method" => "boleto",
                    "boleto" => [
                        "due_at" => date("Y-m-d", strtotime("+{$due_at}days")),
                        "document_number" => $document_number,
                        "nosso_numero" => $nosso_numero,
                        "bank" => $bank,
                        "instructions" => $instructions,
                        "type" => $type
                    ]
                ]
            ]
        ];

        $this->build = array_merge($this->build, $param);
        return $this->post();
    }

    public function pix(string $name, int $value, int $expire_day = 3)
    {
        $param = [
            "payments" => [
                [
                    "payment_method" => "pix",
                    "pix" => [
                        "expires_at" => date("Y-m-d", strtotime("+{$expire_day}days")),
                        "additional_information" => [
                            [
                                "name" => $name,
                                "value" => "{$value}",
                            ]
                        ]
                    ]
                ]
            ]
        ];

        $this->build = array_merge($this->build, $param);
        return $this->post();
    }

    public function transfer(?string $bank = null)
    {
        $param = [
            "payments" => [
                [
                    "payment_method" => "bank_transfer",
                    "bank_transfer" => [
                        "bank" => $bank
                    ]
                ]
            ]
        ];

        $this->build = array_merge($this->build, $param);
        return $this->post();
    }
}