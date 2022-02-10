<?php
/**
 * Created by PhpStorm.
 * User: Fernando Sena
 * Date: 02/02/2022
 * Time: 19:40
 */

namespace Source\Models\Pay;


use Source\Models\User;

class Client extends Payments
{
    public function client(User $user): ?Payments
    {
        $param = [
            "customer" => [
                "name" => $user->fullName(),
                "email" => $user->email,
                "code" => $user->id,
                "document" => $this->clear($user->document),
                "type" => "individual",
                "document_type" => "CPF",
                "gender" => $user->genre,
                "phones" => [
                    "mobile_phone" => [
                        "country_code" => "55",
                        "area_code" => substr($this->clear($user->cell), 0, 2),
                        "number" => substr($this->clear($user->cell), 2)
                    ]
                ],
                "birthdate" => date_fmt($user->datebirth, "Y-m-d"),
                "address" => [
                    "country" => "BR",
                    "state" => "SP",
                    "city" => "São Paulo",
                    "zip_code" => "05207130",
                    "line_1" => "Magalhães Lemos",
                ],
                "metadata" => [
                    "company" => CONF_SITE_NAME
                ]
            ]
        ];

        $this->build = array_merge($this->build, $param);
        return $this;
    }

    /**
     * USER CLIENT
     * @param User $user
     */
    public function createClient(User $user)
    {
        $this->endpoint = "/customers";
        $this->build = [
            "name" => $user->fullName(),
            "email" => $user->email,
            "code" => $user->id,
            "document" => $this->clear($user->document),
            "type" => "individual",
            "document_type" => "CPF",
            "gender" => $user->genre,
            "birthdate" => date_fmt_br($user->datebirth),
            "phones" => [
                "mobile_phone" => [
                    "country_code" => "55",
                    "area_code" => substr($this->clear($user->cell), 0, 2),
                    "number" => substr($this->clear($user->cell), 2)
                ]
            ],
            "metadata" => [
                "company" => CONF_SITE_NAME
            ]
        ];

        $this->post();
    }

    public function getClient(User $user)
    {
        $this->endpoint = "/customers/customers/customer_id/$user->code";

        $this->get();
    }

    public function editClient(User $user)
    {
        $this->endpoint = "/customers";
        $this->build = [
            "name" => $user->fullName(),
            "email" => $user->email,
            "code" => $user->id,
            "document" => $this->clear($user->document),
            "type" => "individual",
            "document_type" => "CPF",
            "gender" => $user->genre,
            "birthdate" => date_fmt_br($user->datebirth),
            "phones" => [
                "mobile_phone" => [
                    "country_code" => "55",
                    "area_code" => substr($this->clear($user->cell), 0, 2),
                    "number" => substr($this->clear($user->cell), 2)
                ]
            ],
            "metadata" => [
                "company" => CONF_SITE_NAME
            ]
        ];
        $this->put();
    }

}