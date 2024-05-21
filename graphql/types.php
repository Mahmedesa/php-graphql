<?php

use App\Models\Address;
use App\Models\User;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

$userType = new ObjectType([
    'name' => 'User',
    'description' =>'this is the data of User',
    'fields' => function() use(&$addressType){
        return[
            'id' => Type::int(),
            'name' => Type::string(),
            'email' => Type::string(),
            'mobile' => Type::string(),
            'address' => [
                "type"=>Type::listOf($addressType),
                "resolve" => function($root, $args){
                    $userId = $root['id'];
                    $user = User::where('id',$userId)->with(['address'])->first();
                    return $user->address->toArray();
                }
            ]
        ];
    }
]);

$addressType = new ObjectType([
    'name' => 'Address',
    'description' =>'this is the data of Address ',
    'fields' => [
        'id' => Type::int(),
        'user_id' => Type::int(),
        'name' => Type::string(),
        'description' => Type::string(),
        'user' => [
            "type"=> $userType,
                "resolve" => function($root, $args){
                    $addressId = $root['id'];
                    $address = Address::where('id',$addressId)->with(['user'])->first();
                    return $address->user->toArray();
                }
        ]
    ]
]);

