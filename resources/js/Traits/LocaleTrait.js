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
    title: {
        ru: 'title_ru',
        en: 'title_en',
    },
    description: {
        ru: 'description_ru',
        en: 'description_en',
    },
    og_title: {
        ru: 'og_title_ru',
        en: 'og_title_en',
    },
    og_description: {
        ru: 'og_description_ru',
        en: 'og_description_en',
    },
    keywords: {
        ru: 'keywords_ru',
        en: 'keywords_en',
    },
    seo: {
        ru: 'seo_ru',
        en: 'seo_en',
    },
}

export const getAttribute = (name, locale) => {
    return localePointers[name][locale]
}
