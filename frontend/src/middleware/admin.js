export default function admin({ next, store }) {
  const loginQuery = { path: "/login", query: { redirect: to.fullPath } };
  if (!store.getters["auth/isAdmin"]) {
    next(loginQuery);
  } else {
    next();
  }
}
