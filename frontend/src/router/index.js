import Vue from "vue";
import store from "@/store/index";
import VueRouter from "vue-router";
import user from "@/middleware/user";
import guest from "@/middleware/guest";
import middlewarePipeline from "@/router/middlewarePipeline";
import editor from "@/middleware/editor";

Vue.use(VueRouter);

const routes = [
  {
    path: "/",
    name: "home",
    meta: { middleware: [guest] },
    component: () => import(/* webpackChunkName: "home" */ "../views/Home"),
  },
  {
    path: "/login",
    name: "login",
    meta: { middleware: [guest] },
    component: () => import(/* webpackChunkName: "login" */ "../views/Login"),
  },
  {
    path: "/register",
    name: "register",
    meta: { middleware: [guest] },
    component: () =>
      import(/* webpackChunkName: "register" */ "../views/Register"),
  },
  {
    path: "/email-verify/:email/:token",
    name: "email-verify",
    meta: { middleware: [guest] },
    component: () =>
      import(/* webpackChunkName: "register" */ "../views/EmailVerify"),
  },
  {
    path: "/forgot-password",
    name: "forgot-password",
    meta: { middleware: [guest] },
    component: () =>
      import(/* webpackChunkName: "register" */ "../views/ForgotPassword"),
  },
  {
    path: "/reset-password",
    name: "reset-password",
    meta: { middleware: [guest] },
    component: () =>
      import(/* webpackChunkName: "register" */ "../views/ResetPassword"),
  },
  {
    path: "/blogs",
    name: "blogs-list",
    meta: { middleware: [user] },
    component: () =>
      import(/* webpackChunkName: "register" */ "../views/Blog/Blogs"),
  },
  {
    path: "/blogs/create",
    name: "blog-create",
    meta: { middleware: [editor] },
    component: () =>
      import(/* webpackChunkName: "register" */ "../views/Blog/BlogPost"),
  },
  {
    path: "/blogs/view/:id",
    name: "blog-view",
    meta: { middleware: [user] },
    component: () =>
      import(/* webpackChunkName: "register" */ "../views/Blog/BlogView"),
  },
  {
    path: "/blogs/update",
    name: "blog-update",
    meta: { middleware: [editor] },
    component: () =>
      import(/* webpackChunkName: "register" */ "../views/Blog/BlogPost"),
  },
  {
    path: "*",
    name: "not-found",
    meta: { middleware: [guest] },
    component: () =>
      import(/* webpackChunkName: "register" */ "../views/NotFound"),
  },
];

const router = new VueRouter({
  mode: "history",
  routes,
  scrollBehavior(to, from, savedPosition) {
    if (savedPosition) {
      return savedPosition;
    } else {
      return { x: 0, y: 0 };
    }
  },
});

router.beforeEach((to, from, next) => {
  const middleware = to.meta.middleware;
  const context = { to, from, next, store };

  if (!middleware) {
    return next();
  }

  middleware[0]({
    ...context,
    next: middlewarePipeline(context, middleware, 1),
  });
});

export default router;
