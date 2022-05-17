<script setup>
import {computed} from 'vue'
import {usePage} from '@inertiajs/inertia-vue3';

const user = computed(() => usePage().props.value.auth.user)
</script>

<script>
import {Link, usePage} from '@inertiajs/inertia-vue3';

export default {
    components: {Link},
    data() {
        return {
            drawer: false,
            windowWidth: window.innerWidth,
            avatar: '',
        }
    },
    computed: {
        getAvatar() {
            axios.get('/media/' + usePage().props.value.auth.user.id + '/avatar')
                .then((response) => {
                    if (response.data != '') {
                        this.avatar = response.data
                    } else {
                        let first_name = usePage().props.value.auth.user.first_name
                        let last_name = usePage().props.value.auth.user.last_name
                        this.avatar = 'https://ui-avatars.com/api/?name=' + last_name[0] + first_name[0] + '&background=random'
                    }
                });
        }
    },
    methods: {

    },
    mounted() {
        window.onresize = () => {
            this.windowWidth = window.innerWidth
            if (this.windowWidth > 768)
                this.drawer = false
        }

        this.avatar = this.getAvatar
    }
}
// if ('serviceWorker' in navigator && 'PushManager' in window) {
//     Notification.requestPermission()
//         .then(result => console.log(result))
// }
</script>

<template>
    <div class="h-screen md:flex md:flex-wrap">

        <!--    OVERLAY    -->
        <div :class="{hidden: !drawer}" class="fixed h-full w-full bg-gray-800 opacity-75 z-50"
             @click="drawer = false"></div>
        <svg :class="{hidden: !drawer}" class="h-8 w-8 fixed z-50 left-3 top-3 text-white cursor-pointer" fill="none"
             stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
             xmlns="http://www.w3.org/2000/svg" @click="drawer = false">
            <path d="M6 18L18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>

        <!--    TOP BAR    -->
        <header class="bg-gray-100 md:relative w-full h-16 flex justify-between px-6 items-center border-b">
            <svg class="h-7 w-7 text-slate-400 cursor-pointer hover:text-indigo-500" fill="none"
                 stroke="currentColor"
                 stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" @click="drawer = !drawer">
                <path d="M4 6h16M4 12h16M4 18h16" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <svg version="1.0" class="w-32 h-6" xmlns="http://www.w3.org/2000/svg"
                 width="1080.000000pt" height="259.000000pt" viewBox="0 0 1080.000000 259.000000"
                 preserveAspectRatio="xMidYMid meet">

                <g transform="translate(0.000000,259.000000) scale(0.100000,-0.100000)"
                   fill="#000000" stroke="none">
                    <path d="M9195 2152 l-150 -3 -390 -708 -390 -708 -3 438 -2 439 -250 0 -250
0 0 -358 c0 -197 3 -487 7 -643 l6 -284 261 2 c285 3 365 11 441 50 64 32 76
42 145 133 129 171 297 436 516 818 240 417 356 614 421 718 35 56 63 104 63
108 0 6 -99 5 -425 -2z"/>
                    <path d="M3075 2135 c-245 -45 -417 -183 -568 -456 -61 -109 -43 -131 41 -51
84 80 188 126 357 159 93 18 543 31 569 16 13 -7 -108 -121 -634 -593 l-650
-585 -25 -80 c-14 -44 -36 -115 -49 -158 l-24 -77 808 0 808 0 51 153 c28 83
51 155 51 159 0 4 -212 9 -471 10 l-470 3 548 496 c301 273 550 495 552 493 2
-2 -4 -15 -13 -29 -19 -29 -48 -105 -40 -105 2 0 21 11 42 24 93 59 292 139
308 124 2 -3 -10 -38 -26 -79 -228 -550 -255 -908 -85 -1138 26 -37 50 -55
105 -80 119 -55 226 -72 450 -72 178 0 261 6 641 47 l56 6 62 221 c34 121 60
221 58 223 -1 2 -20 -1 -42 -6 -91 -20 -320 -40 -460 -40 -196 0 -341 21 -374
54 -35 35 -38 108 -9 216 20 72 27 85 48 91 14 4 171 7 350 8 l325 1 49 157
c26 87 50 164 53 171 4 9 -68 12 -337 12 -270 0 -341 3 -337 13 52 134 78 186
108 221 l37 41 423 5 424 5 57 195 c31 107 60 205 63 217 l5 23 -517 -4 c-559
-3 -646 -10 -843 -62 -99 -26 -243 -88 -297 -130 -17 -13 -34 -24 -36 -24 -3
0 10 48 29 108 19 59 34 108 34 110 0 1 -255 2 -567 1 -419 -1 -586 -4 -638
-14z"/>
                    <path d="M6456 2141 l-230 -6 -97 -325 c-54 -179 -176 -587 -272 -908 l-174
-582 265 2 265 3 76 255 77 255 170 3 171 2 89 -260 89 -260 253 0 c138 0 252
3 252 6 0 6 -165 519 -176 549 -3 8 20 31 58 56 217 147 351 370 388 646 16
120 9 242 -19 315 -43 111 -164 197 -331 233 -85 19 -455 26 -854 16z m606
-349 c35 -17 52 -34 67 -66 53 -109 -7 -323 -114 -411 -98 -80 -199 -108 -387
-109 -75 -1 -139 1 -141 4 -5 4 146 542 167 596 5 14 28 15 183 12 162 -3 182
-5 225 -26z"/>
                    <path d="M9891 2118 c-5 -18 -128 -422 -272 -898 -144 -476 -264 -871 -266
-877 -4 -10 54 -13 270 -13 254 0 276 1 281 18 3 9 125 416 271 904 146 487
265 889 265 892 0 3 -121 6 -269 6 l-269 0 -11 -32z"/>
                    <path d="M1140 2129 c-113 -5 -242 -8 -288 -6 l-83 3 -21 -70 c-12 -39 -135
-449 -273 -911 l-251 -840 260 -3 c175 -1 262 1 266 8 4 6 40 123 81 260 l74
250 172 0 172 0 19 -52 c10 -29 50 -144 88 -255 l69 -203 253 0 c138 0 252 3
252 6 0 6 -166 521 -176 549 -3 6 24 29 59 52 238 156 379 422 394 739 8 161
-13 236 -88 318 -130 142 -384 183 -979 155z m454 -349 c28 -14 59 -37 70 -52
25 -35 32 -120 16 -200 -34 -174 -148 -283 -337 -323 -65 -14 -304 -21 -315
-10 -4 4 142 531 167 602 2 8 54 11 177 10 163 -2 176 -3 222 -27z"/>
                </g>
            </svg>
        </header>

        <!--      MAIN MENU      -->
        <nav :class="{'fixed top-0 w-3/4 sm:w-1/2': drawer, hidden: !drawer}"
             class="h-screen md:block md:fixed md:w-2/6 lg:w-1/4 p-6 text-md lg:text-lg bg-gray-100 z-50 border-l">

            <!--      MENU - PROFILE INFO      -->
            <div class="flex items-center mb-10">
                <img :src="avatar" class="rounded-xl ml-4 shadow-lg" height="60"
                     width="60">
                <h3 class="font-medium text-slate-600">{{ $page.props.auth.user.first_name }}
                    {{ $page.props.auth.user.last_name }}</h3>
                <Link :href="route('setting')" class="mr-auto text-slate-600 cursor-pointer hover:text-indigo-500">
                    <svg class="h-6 w-6"
                         fill="none" stroke="currentColor"
                         stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" stroke-linecap="round"
                              stroke-linejoin="round"/>
                        <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </Link>
            </div>

            <!--      MENU - MENU ITEMS      -->
            <div class="space-y-2">
                <Link @click="drawer = false" :class="{'flex items-center cursor-default text-white p-2 bg-gray-900 w-full rounded-xl': $page.url.includes('/dashboard') ,'flex items-center cursor-pointer text-slate-600 p-2 hover:text-indigo-500': !$page.url.includes('/dashboard')}" :href="route('dashboard')"
                      preserve-scroll>
                    <svg class="h-6 w-6 ml-2" fill="none" stroke="currentColor" stroke-width="2"
                         viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z" stroke-linecap="round"
                              stroke-linejoin="round"/>
                    </svg>
                    داشبورد
                </Link>
                <Link @click="drawer = false" v-if="user.type == 'admin'" :class="{'flex items-center cursor-default text-white p-2 bg-gray-900 w-full rounded-xl': $page.url.includes('/admin/users'),'flex items-center cursor-pointer text-slate-600 p-2 hover:text-indigo-500': !$page.url.includes('/admin/users')}" :href="route('admin.users')"
                      preserve-scroll>
                    <svg class="h-6 w-6 ml-2" fill="none" stroke="currentColor" stroke-width="2"
                         viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" stroke-linecap="round"
                              stroke-linejoin="round"/>
                    </svg>
                    کاربران
                </Link>
                <Link @click="drawer = false" v-if="user.type == 'admin'" :class="{'flex items-center cursor-default text-white p-2 bg-gray-900 w-full rounded-xl': $page.url.includes('/admin/services'),'flex items-center cursor-pointer text-slate-600 p-2 hover:text-indigo-500': !$page.url.includes('/admin/services')}" :href="route('admin.services')"
                      preserve-scroll>
                    <svg class="h-6 w-6 ml-2" fill="none" stroke="currentColor" stroke-width="2"
                         viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" stroke-linecap="round"
                              stroke-linejoin="round"/>
                    </svg>
                    سرویس ها
                </Link>
                <Link @click="drawer = false" v-if="user.type == 'admin'" :class="{'flex items-center cursor-default text-white p-2 bg-gray-900 w-full rounded-xl': $page.url.includes('/admin/providers'),'flex items-center cursor-pointer text-slate-600 p-2 hover:text-indigo-500': !$page.url.includes('/admin/providers')}" :href="route('admin.providers')"
                      preserve-scroll>
                    <svg class="h-6 w-6 ml-2" fill="none" stroke="currentColor" stroke-width="2"
                         viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M14.121 14.121L19 19m-7-7l7-7m-7 7l-2.879 2.879M12 12L9.121 9.121m0 5.758a3 3 0 10-4.243 4.243 3 3 0 004.243-4.243zm0-5.758a3 3 0 10-4.243-4.243 3 3 0 004.243 4.243z" stroke-linecap="round"
                              stroke-linejoin="round"/>
                    </svg>
                    سرویس دهندگان
                </Link>

                <!--        Providers' Menu Items        -->
                <Link @click="drawer = false" v-if="user.type == 'provider'" :class="{'flex items-center cursor-default text-white p-2 bg-gray-900 w-full rounded-xl': $page.url.includes('/provider/users'),'flex items-center cursor-pointer text-slate-600 p-2 hover:text-indigo-500': !$page.url.includes('/provider/users')}" :href="route('provider.users')"
                      preserve-scroll>
                    <svg class="h-6 w-6 ml-2" fill="none" stroke="currentColor" stroke-width="2"
                         viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" stroke-linecap="round"
                              stroke-linejoin="round"/>
                    </svg>
                    مشتریان
                </Link>
                <Link @click="drawer = false" v-if="user.type == 'provider'" :class="{'flex items-center cursor-default text-white p-2 bg-gray-900 w-full rounded-xl': $page.url.includes('/provider/services'),'flex items-center cursor-pointer text-slate-600 p-2 hover:text-indigo-500': !$page.url.includes('/provider/services')}" :href="route('provider.services')"
                      preserve-scroll>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                    </svg>
                    خدمات
                </Link>
                <Link @click="drawer = false" v-if="user.type == 'provider'" :class="{'flex items-center cursor-default text-white p-2 bg-gray-900 w-full rounded-xl': $page.url.includes('/provider/requests'),'flex items-center cursor-pointer text-slate-600 p-2 hover:text-indigo-500': !$page.url.includes('/provider/requests')}" :href="route('provider.requests')"
                      preserve-scroll>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 3l-6 6m0 0V4m0 5h5M5 3a2 2 0 00-2 2v1c0 8.284 6.716 15 15 15h1a2 2 0 002-2v-3.28a1 1 0 00-.684-.948l-4.493-1.498a1 1 0 00-1.21.502l-1.13 2.257a11.042 11.042 0 01-5.516-5.517l2.257-1.128a1 1 0 00.502-1.21L9.228 3.683A1 1 0 008.279 3H5z" />
                    </svg>
                    رزرواسیون
                </Link>
                <!--        End of providers Menu Items        -->


                <!--        Customers Menu Items        -->
                <Link @click="drawer = false" v-if="user.type == 'customer'" :class="{'flex items-center cursor-default text-white p-2 bg-gray-900 w-full rounded-xl': $page.url.includes('/customer/servers'),'flex items-center cursor-pointer text-slate-600 p-2 hover:text-indigo-500': !$page.url.includes('/customer/servers')}" :href="route('customer.servers')"
                      preserve-scroll>
                    <svg class="h-6 w-6 ml-2" fill="none" stroke="currentColor" stroke-width="2"
                         viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M14.121 14.121L19 19m-7-7l7-7m-7 7l-2.879 2.879M12 12L9.121 9.121m0 5.758a3 3 0 10-4.243 4.243 3 3 0 004.243-4.243zm0-5.758a3 3 0 10-4.243-4.243 3 3 0 004.243 4.243z" stroke-linecap="round"
                              stroke-linejoin="round"/>
                    </svg>
                    خدمت دهندگان
                </Link>
                <Link @click="drawer = false" v-if="user.type == 'customer'" :class="{'flex items-center cursor-default text-white p-2 bg-gray-900 w-full rounded-xl': $page.url.includes('/customer/requests'),'flex items-center cursor-pointer text-slate-600 p-2 hover:text-indigo-500': !$page.url.includes('/customer/requests')}" :href="route('customer.requests')"
                      preserve-scroll>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                    </svg>
                    رزرواسیون
                </Link>

                <!--        End of Customers Menu Items        -->



                <Link :href="route('logout')" as="button" class="flex items-center cursor-pointer text-slate-600 p-2 hover:text-red-400" method="post"
                      preserve-scroll>
                    <svg class="h-6 w-6 ml-2" fill="none" stroke="currentColor" stroke-width="2"
                         viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" stroke-linecap="round"
                              stroke-linejoin="round"/>
                    </svg>
                    خروج
                </Link>
            </div>

        </nav>

        <!--    MAIN CONTENT    -->
        <section id="main"
                 class="min-h-screen bg-gray-50 w-full md:w-4/6 lg:w-3/4 pt-6 pb-6 px-4 md:pt-24 md:mr-1/3% lg:mr-1/4%">
            <slot/>
        </section>

    </div>
</template>

<style scoped>
#app {
    height: 100vh;
}

#main {

}
</style>
