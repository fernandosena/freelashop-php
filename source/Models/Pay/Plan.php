<?php
/**
 * Created by PhpStorm.
 * User: Fernando Sena
 * Date: 02/02/2022
 * Time: 19:42
 */

namespace Source\Models\Pay;


use Source\Models\FreelaApp\AppPlan;

/**
 * Class Plan
 * @package Source\Models\Pay
 */
class Plan extends Pay
{

    /**
     * @return $this
     */
    public function listPlan()
    {
        $this->endpoint = "/plans";
        $this->get();
        return $this;
    }

    /**
     * @return $this
     */
    public function createPlan(array $data)
    {
        $this->endpoint = "/plans";
        $this->build = [
            "name" => $data["name"],
            "description" => $data["description"],
            "shippable" => $data["shippable"],
            "payment_methods" => $data["payment_methods"],
            "installments" => $data["installments"],
            "minimum_price" => $data["minimum_price"],
            "statement_descriptor" => $data["statement_descriptor"],
            "currency" => $data["currency"],
            "interval" => $data["interval"],
            "interval_count" => $data["interval_count"],
            "trial_period_days" => $data["trial_period_days"],
            "billing_type" => $data["billing_type"],
            "items" => [
                [
                    "name" => $data["name"],
                    "quantity" => 1,
                    "pricing_scheme" => [
                        "price" => $data["minimum_price"],
                    ]
                ]
            ],
            "metadata" => [
                "nivel" => $data["nivel"],
                "type" => $data["type"]
            ]
        ];
        $this->post();
        return $this;
    }

    /**
     * @return $this
     */
    public function getPlan(string $code)
    {
        $this->endpoint = "/plans/{$code}";
        $this->get();
        return $this;
    }

    /**
     * @return $this
     */
    public function editPlan(string $code,string $item, array $data)
    {
        $this->endpoint = "/plans/{$code}";
        $this->build = [
            "name" => $data["name"],
            "status" => $data["status"],
            "description" => $data["description"],
            "shippable" => $data["shippable"],
            "payment_methods" => $data["payment_methods"],
            "installments" => $data["installments"],
            "minimum_price" => $data["minimum_price"],
            "statement_descriptor" => $data["statement_descriptor"],
            "currency" => $data["currency"],
            "interval" => $data["interval"],
            "interval_count" => $data["interval_count"],
            "trial_period_days" => $data["trial_period_days"],
            "billing_type" => $data["billing_type"],
        ];
        $this->put();
        return $this;
    }

    /**
     * @param string $code
     * @return $this
     */
    public function deletPlan(string $code)
    {
        $this->endpoint = "/plans/{$code}";
        $this->delete();
        return $this;
    }
}