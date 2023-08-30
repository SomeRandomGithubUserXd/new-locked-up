<script setup>
import {ref} from 'vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import {Link, usePage} from '@inertiajs/vue3';
import {Menu, MenuButton, MenuItem, MenuItems} from '@headlessui/vue'
import {ChevronDownIcon, ArrowLeftOnRectangleIcon} from '@heroicons/vue/24/solid'
const showingNavigationDropdown = ref(false);

const isBlockCurrent = (routes) => {
    for (const entity of routes) {
        if (route().current(entity + '.*')) return true
    }
    return false;
}

let routes = []
const role = usePage().props.auth.user.role
if (role === 0 || role === 1) {
    routes = [
        {
            name: 'Заказы',
            href: route('orders.index'),
            isCurrent: isBlockCurrent([
                'orders',
                'appeals',
                'certificates',
                'bookings',
                'order-filters',
                'order-stats',
                'orders-stats',
            ]),
            subRoutes: [
                {
                    name: 'Таблица заказов',
                    href: route('orders.index'),
                    isCurrent: !!route().current('orders.*')
                },
                {
                    name: 'Заявки',
                    href: route('appeals.index'),
                    isCurrent: !!route().current('appeals.*')
                },
                {
                    name: 'Сертификаты',
                    href: route('certificates.index'),
                    isCurrent: !!route().current('certificates.*')
                },
                {
                    name: 'Бронирование',
                    href: route('bookings.index'),
                    isCurrent: !!route().current('bookings.*')
                },
                {
                    name: 'Фильтры',
                    href: route('order-filters.index'),
                    isCurrent: !!route().current('order-filters.*')
                },
                {
                    name: 'Статистика',
                    href: route('orders-stats'),
                    isCurrent: !!route().current('orders-stats')
                },
            ]
        },
        {
            name: 'Каталог квестов',
            href: route('quests.index'),
            isCurrent: isBlockCurrent([
                'quests',
                'performance-quests',
                'locations',
                'services',
                'schedules',
                'quest-topics',
                'child-quest-topics',
                'certificate-instances',
                'sales',
                'reviews',
                'order-sources',
                'lounges',
                'lounge-schedules',
            ]),
            subRoutes: [
                {
                    name: 'Таблица квестов',
                    href: route('quests.index'),
                    isCurrent: !!route().current('quests.*')
                },
                {
                    name: 'Квесты-спектакли',
                    href: route('performance-quests.index'),
                    isCurrent: !!route().current('performance-quests.*')
                },
                {
                    name: 'Локации',
                    href: route('locations.index'),
                    isCurrent: !!route().current('locations.*')
                },
                {
                    name: 'Дополнительные услуги',
                    href: route('services.index'),
                    isCurrent: !!route().current('services.*')
                },
                {
                    name: 'Расписания',
                    href: route('schedules.index'),
                    isCurrent: !!route().current('schedules.*')
                },
                {
                    name: 'Рубрики',
                    href: route('quest-topics.index'),
                    isCurrent: !!route().current('quest-topics.*')
                },
                {
                    name: 'Детские рубрики',
                    href: route('child-quest-topics.index'),
                    isCurrent: !!route().current('child-quest-topics.*')
                },
                {
                    name: 'Оригинальные сертификаты',
                    href: route('certificate-instances.index'),
                    isCurrent: !!route().current('certificate-instances.*')
                },
                {
                    name: 'Акции',
                    href: route('sales.index'),
                    isCurrent: !!route().current('sales.*')
                },
                {
                    name: 'Источники',
                    href: route('order-sources.index'),
                    isCurrent: !!route().current('order-sources.*')
                },
                {
                    name: 'Отзывы',
                    href: route('reviews.index'),
                    isCurrent: !!route().current('reviews.*')
                },
                {
                    name: 'Лаунжи',
                    href: route('lounges.index'),
                    isCurrent: !!route().current('lounges.*')
                },
                {
                    name: 'Расписания лаунжей',
                    href: route('lounge-schedules.index'),
                    isCurrent: !!route().current('lounge-schedules.*')
                }
            ]
        },
        {
            name: 'Пользователи',
            href: route('users.index'),
            isCurrent: isBlockCurrent([
                'users',
            ]),
        },
        {
            name: 'Новости',
            href: route('news.index'),
            isCurrent: isBlockCurrent([
                'news',
            ]),
        },
        {
            name: 'Модальные окна',
            href: '#',
            subRoutes: [
                {
                    name: 'На главной',
                    href: route('modals.main'),
                    isCurrent: !!route().current('modals.*')
                },
            ],
            isCurrent: isBlockCurrent([
                'modals',
            ]),
        },
        {
            name: 'Настройки',
            href: route('settings.index'),
            isCurrent: isBlockCurrent([
                'settings',
            ]),
        },
    ]
} else if (role === 2) {
    routes = [
        {
            name: 'Заказы',
            href: route('orders.index'),
            isCurrent: isBlockCurrent([
                'orders',
                'appeals',
                'certificates',
                'bookings',
                'order-filters',
                'order-stats',
            ]),
            subRoutes: [
                {
                    name: 'Таблица заказов',
                    href: route('orders.index'),
                    isCurrent: !!route().current('orders.*')
                },
                {
                    name: 'Бронирование',
                    href: route('bookings.index'),
                    isCurrent: !!route().current('bookings.*')
                },
            ]
        },
    ]
} else if (role === 3) {
    routes = [
        {
            name: 'Заказы',
            href: route('orders.index'),
            isCurrent: isBlockCurrent([
                'orders',
                'appeals',
                'certificates',
                'bookings',
                'order-filters',
                'order-stats',
            ]),
            subRoutes: [
                {
                    name: 'Таблица заказов',
                    href: route('orders.index'),
                    isCurrent: !!route().current('orders.*')
                },
                {
                    name: 'Заявки',
                    href: route('appeals.index'),
                    isCurrent: !!route().current('appeals.*')
                },
                {
                    name: 'Сертификаты',
                    href: route('certificates.index'),
                    isCurrent: !!route().current('certificates.*')
                },
                {
                    name: 'Бронирование',
                    href: route('bookings.index'),
                    isCurrent: !!route().current('bookings.*')
                },
            ]
        },
        {
            name: 'Каталог квестов',
            href: route('quests.index'),
            isCurrent: isBlockCurrent([
                'quests',
                'performance-quests',
                'locations',
                'services',
                'schedules',
                'quest-topics',
                'child-quest-topics',
                'certificate-instances',
                'sales',
                'reviews',
                'order-sources',
                'lounges',
                'lounge-schedules',
            ]),
            subRoutes: [
                {
                    name: 'Дополнительные услуги',
                    href: route('services.index'),
                    isCurrent: !!route().current('services.*')
                },
                {
                    name: 'Акции',
                    href: route('sales.index'),
                    isCurrent: !!route().current('sales.*')
                },
                {
                    name: 'Расписания',
                    href: route('schedules.index'),
                    isCurrent: !!route().current('schedules.*')
                },
                {
                    name: 'Расписания лаунжей',
                    href: route('lounge-schedules.index'),
                    isCurrent: !!route().current('lounge-schedules.*')
                }
            ]
        },
    ]
} else if (role === 4) {
    routes = [
        {
            name: 'Каталог квестов',
            href: route('quests.index'),
            isCurrent: isBlockCurrent([
                'quests',
                'performance-quests',
                'locations',
                'services',
                'schedules',
                'quest-topics',
                'child-quest-topics',
                'certificate-instances',
                'sales',
                'reviews',
                'order-sources',
                'lounges',
                'lounge-schedules',
            ]),
            subRoutes: [
                {
                    name: 'Таблица квестов',
                    href: route('quests.index'),
                    isCurrent: !!route().current('quests.*')
                },
                {
                    name: 'Квесты-спектакли',
                    href: route('performance-quests.index'),
                    isCurrent: !!route().current('performance-quests.*')
                },
                {
                    name: 'Рубрики',
                    href: route('quest-topics.index'),
                    isCurrent: !!route().current('quest-topics.*')
                },
                {
                    name: 'Детские рубрики',
                    href: route('child-quest-topics.index'),
                    isCurrent: !!route().current('child-quest-topics.*')
                },
                {
                    name: 'Отзывы',
                    href: route('reviews.index'),
                    isCurrent: !!route().current('reviews.*')
                },
                {
                    name: 'Лаунжи',
                    href: route('lounges.index'),
                    isCurrent: !!route().current('lounges.*')
                },
            ]
        },
        {
            name: 'Новости',
            href: route('news.index'),
            isCurrent: isBlockCurrent([
                'news',
            ]),
        },
        {
            name: 'Модальные окна',
            href: '#',
            subRoutes: [
                {
                    name: 'На главной',
                    href: route('modals.main'),
                    isCurrent: !!route().current('modals.*')
                },
            ],
            isCurrent: isBlockCurrent([
                'modals',
            ]),
        },
        {
            name: 'Настройки',
            href: route('settings.index'),
            isCurrent: isBlockCurrent([
                'settings',
            ]),
        },
    ]
}
</script>

<template>
    <div>
        <div class="min-h-screen bg-gray-100">
            <nav class="bg-white border-b border-gray-100">
                <div class="max-w-ful mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex">
                            <div class="flex flex-col shrink-0 flex justify-center">
                                <Link :href="route('orders.index')">
                                    <ApplicationLogo
                                        class="block w-auto fill-current text-gray-800"
                                    />
                                </Link>
                            </div>

                            <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                                <NavLink v-for="route in routes" :href="route.subRoutes?.length ? '': route.href"
                                         :active="route.isCurrent">
                                    <Menu v-if="route.subRoutes?.length" as="div"
                                          class="relative inline-block text-left z-40">
                                        <div>
                                            <MenuButton
                                                class="inline-flex justify-center w-full px-4 py-2 bg-white text-sm font-medium text-gray-700">
                                                {{ route.name }}
                                                <ChevronDownIcon class="-mr-1 ml-2 h-5 w-5" aria-hidden="true"/>
                                            </MenuButton>
                                        </div>

                                        <transition enter-active-class="transition ease-out duration-100"
                                                    enter-from-class="transform opacity-0 scale-95"
                                                    enter-to-class="transform opacity-100 scale-100"
                                                    leave-active-class="transition ease-in duration-75"
                                                    leave-from-class="transform opacity-100 scale-100"
                                                    leave-to-class="transform opacity-0 scale-95">
                                            <MenuItems
                                                class="origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none">
                                                <div>
                                                    <MenuItem v-for="subRoute in route.subRoutes" class="py-3">
                                                        <Link :href="subRoute.href"
                                                              :class="[subRoute.isCurrent ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'block px-4 py-2 text-sm']">
                                                            {{ subRoute.name }}
                                                        </Link>
                                                    </MenuItem>
                                                </div>
                                            </MenuItems>
                                        </transition>
                                    </Menu>
                                    <span v-else>{{ route.name }}</span>
                                </NavLink>
                            </div>
                        </div>
                        <div class="-mr-2 flex items-center sm:hidden">
                            <button
                                @click="showingNavigationDropdown = !showingNavigationDropdown"
                                class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out"
                            >
                                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                    <path
                                        :class="{
                                            hidden: showingNavigationDropdown,
                                            'inline-flex': !showingNavigationDropdown,
                                        }"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M4 6h16M4 12h16M4 18h16"
                                    />
                                    <path
                                        :class="{
                                            hidden: !showingNavigationDropdown,
                                            'inline-flex': showingNavigationDropdown,
                                        }"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"
                                    />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <div
                    :class="{ block: showingNavigationDropdown, hidden: !showingNavigationDropdown }"
                    class="sm:hidden"
                >
                    <div class="pt-2 pb-3 space-y-1">
                        <ResponsiveNavLink v-for="route in routes" :href="route.href" :active="route.isCurrent">
                            {{ route.name }}
                        </ResponsiveNavLink>
                    </div>

                    <!-- Responsive Settings Options -->
                    <div class="pt-4 pb-1 border-t border-gray-200">
                        <div class="px-4">
                            <div class="font-medium text-base text-gray-800">
                                {{ $page.props.auth.user.username }}
                            </div>
                            <div class="font-medium text-sm text-gray-500">{{ $page.props.auth.user.email }}</div>
                        </div>

                        <div class="mt-3 space-y-1">
                            <ResponsiveNavLink :href="route('profile.edit')">Профиль</ResponsiveNavLink>
                            <ResponsiveNavLink :href="route('logout')" method="post" as="button">
                                Выйти
                            </ResponsiveNavLink>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Page Heading -->
            <header class="bg-white shadow" v-if="$slots.header">
                <div class="mx-auto lg:py-6 py-3 px-4 sm:px-6 lg:px-8">
                    <slot name="header"/>
                </div>
            </header>

            <!-- Page Content -->
            <main>
                <slot/>
            </main>
        </div>
    </div>
</template>
