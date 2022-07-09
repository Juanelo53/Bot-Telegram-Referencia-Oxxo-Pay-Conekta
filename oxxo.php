<?php
require_once("lib/Conekta.php");
\Conekta\Conekta::setApiKey("AQUI VA LA KEY DE CONEKTA PRODUCCION"); // Tu api Key Privada de CONEKTA
\Conekta\Conekta::setApiVersion("2.0.0");


try{
    $thirty_days_from_now = (new DateTime())->add(new DateInterval('P1D'))->getTimestamp(); 
  
    $order = \Conekta\Order::create(
      [
        "line_items" => [
          [
            "name" => "Producto de Belleza",
            "unit_price" => 2500, // 2500 Equivalente a $25 Pesos
            "quantity" => 1 //Cantidad de productos por vender
          ]
        ],
        "shipping_lines" => [
          [
            "amount" => 0, // Precio de envio si deseas agregar
            "carrier" => "ESTAFETA"
          ]
        ], //Direcciones y mas
        "currency" => "MXN",
        "customer_info" => [
          "name" => "Empresa Spartan", // Datos del Cliente
          "email" => "fulano@michitos.xyz",
          "phone" => "+5511223342"
        ],
        "shipping_contact" => [
          "address" => [
            "street1" => "Ciudad de Mexico",
            "postal_code" => "06100",
            "country" => "MX"
          ]
        ], //Cargos y mas
        "charges" => [
          [
            "payment_method" => [
              "type" => "oxxo_cash",
              "expires_at" => $thirty_days_from_now
            ]
          ]
        ]
      ]
    );
  } catch (\Conekta\ParameterValidationError $error){
    echo $error->getMessage();
  } catch (\Conekta\Handler $error){
    echo $error->getMessage();
  }




