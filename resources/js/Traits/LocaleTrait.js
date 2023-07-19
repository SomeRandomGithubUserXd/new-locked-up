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
    meta_title: {
        ru: 'meta_title_ru',
        en: 'meta_title_en',
    },
    meta_description: {
        ru: 'meta_description_ru',
        en: 'meta_description_en',
    },
    meta_keywords: {
        ru: 'meta_keywords_ru',
        en: 'meta_keywords_en',
    },
    announce: {
        ru: 'announce_ru',
        en: 'announce_en',
    },
    badge: {
        ru: 'badge_ru',
        en: 'badge_en',
    },
    text: {
        ru: 'text_ru',
        en: 'text_en',
    },
    conditions_header: {
        ru: 'conditions_header_ru',
        en: 'conditions_header_en',
    },
    conditions_text: {
        ru: 'conditions_text_ru',
        en: 'conditions_text_en',
    },
    book_button_text: {
        ru: 'book_button_text_ru',
        en: 'book_button_text_en',
    },
    book_button_link: {
        ru: 'book_button_link_ru',
        en: 'book_button_link_en',
    },
    instruction_text: {
        ru: 'instruction_text_ru',
        en: 'instruction_text_en',
    },
    seo_text: {
        ru: 'seo_text_ru',
        en: 'seo_text_en',
    },
    quests_title: {
        ru: 'quests_title_ru',
        en: 'quests_title_en',
    },
    button_text: {
        ru: 'button_text_ru',
        en: 'button_text_en',
    },
    button_url: {
        ru: 'button_url_ru',
        en: 'button_url_en',
    },
    lead: {
        ru: 'lead_ru',
        en: 'lead_en',
    },
    time: {
        ru: 'time_ru',
        en: 'time_en',
    },
    program: {
        ru: 'program_ru',
        en: 'program_en',
    },
    packages_description: {
        ru: 'packages_description_ru',
        en: 'packages_description_en',
    },
    packages_example: {
        ru: 'packages_example_ru',
        en: 'packages_example_en',
    },
    advantages: {
        ru: 'advantages_ru',
        en: 'advantages_en',
    },
    alias: {
        ru: 'alias_ru',
        en: 'alias_en',
    },
}

export const getAttribute = (name, locale) => {
    return localePointers[name][locale]
}
