export default function user({ to, next, store }) {
  const loginQuery = { path: "/login", query: { redirect: to.fullPath } };

  if (!store.getters["auth/isUser"]) {
    next(loginQuery);
  } else {
    next();
  }
}
