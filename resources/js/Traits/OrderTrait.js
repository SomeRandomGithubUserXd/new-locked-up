import {collect} from "collect.js";

export const getOptionsSum = (options = []) => {
    return collect(options).sum('price')
}

export const getPlayersSum = (playersCount, minPlayers, maxPlayers, pricePerParticipant) => {
    playersCount = Number(playersCount)
    minPlayers = Number(minPlayers)
    maxPlayers = Number(maxPlayers)
    pricePerParticipant = Number(pricePerParticipant)
    let additionalCost
    if (playersCount && playersCount > maxPlayers) {
        additionalCost = (playersCount - maxPlayers) * pricePerParticipant
    } else {
        additionalCost = 0
    }
    return additionalCost
}

export const getOrderTotal = (questPrice, order, optionsSum, playersSum) => {
    return Number(questPrice) +
        (Number(optionsSum) || 0) +
        (Number(playersSum) || 0)
}

export const getOrderPriceToPay = (orderTotal, order, promoCodeDiscount, certificateDiscount) => {
    let price = Number(orderTotal) -
        (Number(promoCodeDiscount) || 0) -
        (Number(certificateDiscount) || 0)
    for (const payment of order.order_payments) {
        price -= payment.sum
    }
    return price
}

export const getAlreadypaid = (order) => {
    return Number(order?.postpaid || 0) +
        Number(order?.pre_paid || 0) +
        Number(order?.paid_through_acquiring || 0) +
        Number(order?.paid_through_aggregator || 0)
}

export const orderProps = {
    orderStatuses: Array,
    orderPaymentTypes: Array,
    orderPaymentStatuses: Array,
    questList: Array,
    optionList: Array,
    sourceList: Array,
    promoCodeList: Array,
    certificateList: Array,
    questOptions: Array,
    loungeList: Array,
}
