<?php

namespace App\Http\Resources\Orders;

use App\Http\Resources\BookingQuestResource;
use App\Http\Resources\Certificates\CertificateResource;
use App\Http\Resources\Lounges\LoungeScheduleItemResource;
use App\Http\Resources\Schedules\ScheduleItemBookingInstanceResource;
use App\Http\Resources\ServiceResource;
use App\Models\Certificate;
use App\Models\Certificates\PersonCertificate;
use App\Models\Orders\Order;
use App\Models\Orders\OrderOption;
use App\Models\Orders\OrderQuestOption;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
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
            ->whereIn('id', $queryClone()->whereNotNull('certificate_data_id')->pluck('certificate_data_id'))
            ->sum('price');
        return [
            'count' => $queryClone()->count(),
            'sum' => self::priceFormat($queryClone()->sum('price_total')),
            'games_sum' => self::priceFormat($queryClone()->sum('price')),
            'services_sum' => self::priceFormat($queryClone()->sum('price_options')),
            'payed_instantly' => self::priceFormat($queryClone()->sum('fact_payment')),
            'pre_payed' => self::priceFormat($queryClone()->sum('prepayed')),
            'payed_online' => self::priceFormat($queryClone()->sum('payed_online')),
            'payed_via_aggregator' => self::priceFormat($queryClone()->sum('payed_aggregator')),
            'certificates_sum' => self::priceFormat($certificatesSum),
            'left_to_pay' => self::priceFormat(
                (int)
                $queryClone()
                    ->selectRaw('SUM(fact_payment - prepayed - payed_online - payed_aggregator) as "sum"')
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
