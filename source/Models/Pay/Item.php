<?php
/**
 * Created by PhpStorm.
 * User: Fernando Sena
 * Date: 04/02/2022
 * Time: 13:12
 */

namespace Source\Models\Pay;


class Item extends Pay
{
    public function editItem(string $plan, string $item, array $data)
    {
        $this->endpoint = "/plans/{$plan}/items/{$item}";
        $this->build = [
            "name" => $data["name"],
            "quantity" => 1,
            "pricing_scheme" => [
                "price" => $data["minimum_price"]
            ],
            "status" => $data["status"]
        ];
        $this->put();
        return $this;
    }
}