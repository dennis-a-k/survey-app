import { createRouter, createWebHistory } from "vue-router";
import store from "../store";

const routes = [
  {
    path: "/",
    name: "Home",
    redirect: "/dashboard",
    component: () => import("../layouts/Index.vue"),
    meta: { requiresAuth: true },
    children: [
      {
        path: "/dashboard",
        name: "Dashboard",
        component: () => import("../views/Dashboard.vue"),
      },
      {
        path: "/surveys",
        name: "Surveys",
        component: () => import("../views/Surveys.vue"),
      },
      {
        path: "/survey/create",
        name: "SurveyCreate",
        component: () => import("../views/SurveyView.vue"),
      },
      {
        path: "/survey/:id",
        name: "SurveyView",
        component: () => import("../views/SurveyView.vue"),
      },
    ],
  },
  {
    path: "/view/survey/:slug",
    name: "SurveyPublicView",
    component: () => import("../views/SurveyPublicView.vue"),
  },
  {
    path: "/auth",
    name: "Auth",
    redirect: "/login",
    component: () => import("../layouts/Auth.vue"),
    meta: { isGuest: true },
    children: [
      {
        path: "/login",
        name: "Login",
        component: () => import("../views/Login.vue"),
      },
      {
        path: "/register",
        name: "Register",
        component: () => import("../views/Register.vue"),
      },
    ],
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

router.beforeEach((to, from, next) => {
  if (to.meta.requiresAuth && !store.state.user.token) {
    next({ name: "Login" });
  } else if (store.state.user.token && to.meta.isGuest) {
    next({ name: "Dashboard" });
  } else {
    next();
  }
});

export default router;
