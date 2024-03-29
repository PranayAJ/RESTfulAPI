<?php

namespace App\Transformers;

use App\Models\Transaction;
use League\Fractal\TransformerAbstract;

class TransactionTransformer extends TransformerAbstract
{
    /**
     * List of resources to automatically include
     *
     * @var array
     */
    protected array $defaultIncludes = [
        //
    ];

    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected array $availableIncludes = [
        //
    ];

    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Transaction $transaction)
    {
        return [
            'identifier' => (int)$transaction->id,
            'quantity' => (string)$transaction->quantity,
            'buyer' => (int)$transaction->buyer_id,
            'product' => (int)$transaction->product_id,
            'creationDate' => $transaction->created_at,
            'lastChange' => $transaction->updated_at,
            'deletedDate' => isset($transaction->deleted_at) ? (string)$transaction->deleted_at : NULL,
        ];
    }
    public static function attributeMapper(string $key){
        $attributes = [
            'identifier' => "id",
            'stock' => "quantity",
            'buyer_id' => "buyer_id",
            'product_id' => "product_id",
            'creationDate' => "created_at",
            'lastChange' => "updated_at",
            'deletedDate' => "deleted_at",
        ];
        return $attributes[$key] ?? null;
    }
}
