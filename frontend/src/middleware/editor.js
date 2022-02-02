export default function editor({ to, next, store }) {
  const loginQuery = { path: "/login", query: { redirect: to.fullPath } };

  if (!store.getters["auth/isEditor"]) {
    next(loginQuery);
  } else {
    next();
  }
}
