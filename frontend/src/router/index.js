import Vue from "vue";
import VueRouter from "vue-router";
import store from '../store'
import { Locales } from "../modules/i18n";
import guest from "./middleware/guest";
import auth from "./middleware/auth";
import middlewarePipeline from './middlewarePipeline'

Vue.use(VueRouter);

const localesCode = Locales.map((item) => item.code);

const routes = [
    {
        path: '/:lang',
        component: () => import("../layouts/MainLayout"),
        beforeEnter(to, from, next) {
            const lang = to.params.lang;

            if (!localesCode.includes(lang)) return next(process.env.VUE_APP_I18N_LOCALE);

            store.dispatch('changeLocale', lang);
            return next();
        },
        children: [
            {
                path: "/",
                name: "home",
                component: () => import("../pages/home")
            },
            {
                path: "auth",
                name: "auth",
                component: () => import("../pages/auth/index"),
                children: [
                    {
                        path: "main",
                        name: "auth-main",
                        meta: {
                            middleware: [guest]
                        },
                        component: () => import("../pages/auth/main"),
                    },
                    {
                        path: "login",
                        name: "login",
                        meta: {
                            middleware: [guest]
                        },
                        component: () => import("../pages/auth/login"),
                    },
                    {
                        path: "logout",
                        name: "logout",
                        component: () => import("../pages/auth/logout"),
                    },
                    {
                        path: "forgot",
                        name: "forgot",
                        meta: {
                            middleware: [guest]
                        },
                        component: () => import("../pages/auth/forgot"),
                    },
                    {
                        path: "register",
                        name: "register",
                        meta: {
                            middleware: [guest]
                        },
                        component: () => import("../pages/auth/register/index"),
                        children: [
                            {
                                path: "1",
                                name: "register-step-1",
                                component: () => import("../pages/auth/register/step-1"),
                            },
                        ]
                    }
                ]
            },
            {
                path: "deals",
                name: "deals",
                component: () => import("../pages/deals/index"),
                children: [
                    {
                        path: "search",
                        name: "deals-search",
                        component: () => import("../pages/deals/search"),
                    },
                    {
                        path: "view/:id",
                        name: "deals-view",
                        component: () => import("../pages/deals/view"),
                    }
                ]
            },
            {
                path: "rooms",
                name: "rooms",
                component: () => import("../pages/rooms/index"),
                children: [
                    {
                        path: "list/:id",
                        name: "rooms-list",
                        component: () => import("../pages/rooms/list"),
                    },
                    {
                        path: "view/:id",
                        name: "rooms-view",
                        component: () => import("../pages/rooms/view"),
                    }
                ]
            },
            {
                path: "booking",
                name: "booking",
                component: () => import("../pages/booking/index"),
                children: [
                    {
                        path: ":id",
                        name: "booking-view",
                        component: () => import("../pages/booking/view"),
                    }
                ]
            },
            {
                path: "payment",
                name: "payment",
                component: () => import("../pages/payment/index"),
                children: [
                    {
                        path: ":id",
                        name: "payment-view",
                        component: () => import("../pages/payment/view"),
                    }
                ]
            },
            {
                path: "user",
                name: "user",
                component: () => import("../pages/user/index"),
                children: [
                    {
                        path: "bookings",
                        name: "user-bookings",
                        meta: {
                            middleware: [auth]
                        },
                        component: () => import("../pages/user/bookings"),
                    },
                    {
                        path: "favorite",
                        name: "user-favorite",
                        meta: {
                            middleware: [auth]
                        },
                        component: () => import("../pages/user/favorite"),
                    },
                    {
                        path: "profile",
                        name: "user-profile",
                        meta: {
                            middleware: [auth]
                        },
                        component: () => import("../pages/user/profile/index"),
                        children: [
                            {
                                path: "about",
                                name: "user-profile-about",
                                component: () => import("../pages/user/profile/about"),
                            },
                            {
                                path: "payments",
                                name: "user-profile-payments",
                                component: () => import("../pages/user/profile/payments"),
                            },
                            {
                                path: "notifications",
                                name: "user-profile-notifications",
                                component: () => import("../pages/user/profile/notifications"),
                            },
                            {
                                path: "contacts",
                                name: "user-profile-contacts",
                                component: () => import("../pages/user/profile/contacts"),
                            }
                        ]
                    }
                ]
            },
            {
                path: "partner",
                name: "partner",
                meta: {
                    partner: true,
                    middleware: [auth]
                },
                component: () => import("../pages/partner/index"),
                children: [
                    {
                        path: "",
                        name: "partner-welcome",
                        component: () => import("../pages/partner/welcome"),
                        meta: {
                            partner: true,
                            middleware: [auth]
                        }
                    },
                    {
                        path: "entities",
                        meta: {
                            partner: true
                        },
                        component: () => import("../pages/partner/index"),
                        children: [
                            {
                                path: "",
                                name: "partner-entities",
                                meta: {
                                    partner: true
                                },
                                component: () => import("../pages/partner/entities/index")
                            }
                        ]
                    },
                    {
                        path: "add",
                        name: "partner-deals-add",
                        component: () => import("../pages/partner/deals/add/index"),
                        meta: {
                            partner: true,
                            middleware: [auth]
                        },
                        children: [
                            {
                                path: "step-1",
                                name: "partner-deals-add-step-1",
                                meta: {
                                    partner: true,
                                    middleware: [auth]
                                },
                                component: () => import("../pages/partner/deals/add/step-1")
                            },
                            {
                                path: "step-2",
                                name: "partner-deals-add-step-2",
                                meta: {
                                    partner: true,
                                    middleware: [auth]
                                },
                                component: () => import("../pages/partner/deals/add/step-2")
                            },
                            {
                                path: "step-3",
                                name: "partner-deals-add-step-3",
                                meta: {
                                    partner: true,
                                    middleware: [auth]
                                },
                                component: () => import("../pages/partner/deals/add/step-3")
                            },
                            {
                                path: "step-4",
                                name: "partner-deals-add-step-4",
                                meta: {
                                    partner: true,
                                    middleware: [auth]
                                },
                                component: () => import("../pages/partner/deals/add/step-4")
                            },
                            {
                                path: "step-5",
                                name: "partner-deals-add-step-5",
                                component: () => import("../pages/partner/deals/add/step-5")
                            },
                            {
                                path: "step-6",
                                name: "partner-deals-add-step-6",
                                meta: {
                                    partner: true,
                                    middleware: [auth]
                                },
                                component: () => import("../pages/partner/deals/add/step-6")
                            }
                        ]
                    },
                    {
                        path: "list",
                        name: "partner-deals-list",
                        meta: {
                            partner: true,
                            middleware: [auth]
                        },
                        component: () => import("../pages/partner/deals/list")
                    }
                ]
            },
            {
                path: "about",
                name: "about",
                meta: {
                    partner: true,
                    middleware: [auth]
                },
                component: () => import("../pages/about")
            },
            {
                path: "support",
                name: "support",
                component: () => import("../pages/support")
            },
            {
                path: "contacts",
                name: "contacts",
                component: () => import("../pages/contacts")
            }
        ]
    },
    {
        path: "*",
        redirect: process.env.VUE_APP_I18N_LOCALE
    }
];

const router = new VueRouter({
    mode: "history",
    base: process.env.BASE_URL,
    routes,
    scrollBehavior() {
        return { x: 0, y: 0 }
    }
});

router.beforeEach((to, from, next) => {
    if (!to.meta.middleware) {
        return next()
    }
    const middleware = to.meta.middleware;

    const context = {
        to,
        from,
        next,
        store
    };


    return middleware[0]({
        ...context,
        next: middlewarePipeline(context, middleware, 1)
    })

});

export default router;
