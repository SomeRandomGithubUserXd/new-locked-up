<?php

namespace App\Http\Resources\Orders;

use App\Models\Certificates\Certificate;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Orders\Order */
class OrderMetaResource extends JsonResource
{
    public static function getAsArray(Builder $query): array
    {
        $queryClone = function () use ($query): Builder {
            return clone $query;
        };
        $certificatesSum = Certificate::query()
            ->whereIn('id', $queryClone()->whereNotNull('certificate_id')->pluck('certificate_id'))
            ->sum('price');
        return [
            'count' => $queryClone()->count(),
            'sum' => self::priceFormat($queryClone()->sum('price_total')),
            'games_sum' => self::priceFormat($queryClone()->sum('price')),
            'services_sum' => self::priceFormat($queryClone()->sum('additional_options_cost')),
            'payed_instantly' => self::priceFormat($queryClone()->sum('postpaid')),
            'pre_payed' => self::priceFormat($queryClone()->sum('pre_paid')),
            'payed_online' => self::priceFormat($queryClone()->sum('paid_through_acquiring')),
            'payed_via_aggregator' => self::priceFormat($queryClone()->sum('paid_through_aggregator')),
            'certificates_sum' => self::priceFormat($certificatesSum),
            'left_to_pay' => self::priceFormat(
                (int)
                $queryClone()
                    ->selectRaw('SUM(postpaid - pre_paid - paid_through_acquiring - paid_through_aggregator) as "sum"')
                    ->first()
                    ?->toArray()['sum']
            ),
        ];
    }

    public static function priceFormat(int $price): string
    {
        return number_format($price, 2, '.', ' ') . ' руб.';
    }
}
