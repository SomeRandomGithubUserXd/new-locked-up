export const getCurrentUrlParam = (param, all = false, type) => {
    let data
    if (all) {
        let local = []
        for (let item of (new URLSearchParams(location.search)).getAll(param) || []) {
            if(type) {
                item = type(item)
            }
            local.push(item)
        }
        data = local
    } else {
        data = (new URLSearchParams(location.search)).get(param)
    }
    return data || null
}

export const numberFormat = (number) => {
    return new Intl.NumberFormat('ru-RU', { style: 'currency', currency: 'RUB'}).format(number)
}
