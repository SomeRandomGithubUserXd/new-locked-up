import {collect} from "collect.js";

export const getOptionsSum = (options = []) => {
    return collect(options).sum('price')
}

export const getPlayersSum = (playersCount, minPlayers, pricePerParticipant) => {
    let additionalCost
    if (playersCount && playersCount > minPlayers) {
        additionalCost = (playersCount - minPlayers) * pricePerParticipant
    } else {
        additionalCost = 0
    }
    return additionalCost
}

export const getOrderTotal = (questPrice, order, optionsSum, playersSum) => {
    return Number(questPrice) -
        (Number(order.promo_code?.value) || 0) -
        (Number(order.certificate?.price) || 0) +
        (Number(optionsSum) || 0) +
        (Number(playersSum) || 0)
}

export const getOrderPriceToPay = (orderTotal, order) => {
    return Number(orderTotal) -
        Number(order?.fact_payment || 0) -
        Number(order?.pre_payed || 0) -
        Number(order?.online_payment || 0) -
        Number(order?.payed_aggregator || 0)
}

export const orderProps = {
    orderStatuses: Array,
    questList: Array,
    optionList: Array,
    sourceList: Array,
    promoCodeList: Array,
    certificateList: Array,
    questOptions: Array,
}
