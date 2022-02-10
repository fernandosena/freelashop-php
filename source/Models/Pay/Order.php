<?php
/**
 * Created by PhpStorm.
 * User: Fernando Sena
 * Date: 06/02/2022
 * Time: 09:34
 */

namespace Source\Models\Pay;


class Order extends Client
{
    public function createOrder(string $description, int $amount, int $quantity = 1, ?int $code = 1): Client
    {
        $this->endpoint = "/orders";
        $this->build = [
            "items" => [
                [
                    "amount" => "{$amount}",
                    "description" => $description,
                    "quantity" => $quantity,
                    "code" => $code,
                ]
            ]
        ];
        return $this;
    }

    public function getOrder(string $order)
    {
        $this->endpoint = "/orders/{$order}";
        $this->get();
        return $this->getCallback();
    }

    public function listOrder(
        int $page = 1,
        int $size = 30,
        ?string $code = null,
        ?string $status = null,
        ?string $customer_id = null,
        ?string $created_since = null,
        ?string $created_until = null)
    {
        $this->endpoint = "/orders";
        $this->build = [
            "code" => $code,
            "status" => $status,
            "customer_id" => $customer_id,
            "created_since" => $created_since,
            "created_until" => $created_until,
            "size" => $size,
            "page" => $page,
        ];
        $this->get();
        return $this->getCallback();
    }
}