export const localePointers = {
    name: {
        ru: 'name_ru',
        en: 'name_en',
    },
    h1: {
        ru: 'h1_ru',
        en: 'h1_en',
    },
    short_description: {
        ru: 'short_description_ru',
        en: 'short_description_en',
    },
    full_description: {
        ru: 'full_description_ru',
        en: 'full_description_en',
    },
    address: {
        ru: 'address_ru',
        en: 'address_en',
    },
}

export const getAttribute = (name, locale) => {
    return localePointers[name][locale]
}
