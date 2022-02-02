import { authClient } from '@/services/AuthService';

export const getError = (error) => {
  const errorMessage = "API Error, please try again.";

  if (error.name === "Fetch User") {
    return error.message;
  }

  if (!error.response) {
    console.error(`API ${error.config.url} not found`);
    return errorMessage;
  }
  if (process.env.NODE_ENV === "development") {
    console.error(error.response.data);
    console.error(error.response.status);
    console.error(error.response.headers);
  }
  if (error.response.data && error.response.data.errors) {
    return error.response.data.errors;
  }

  return errorMessage;
};

export const setToken = (token) => {
  if (token) {
    window.localStorage.setItem("lvtest-token", token);
    authClient.defaults.headers.common["Authorization"] = `Bearer ${token}`;
  } else {
    window.localStorage.removeItem("lvtest-token");
    delete authClient.defaults.headers.common["Authorization"];
  }
}

export const getToken = () => {
  return window.localStorage.getItem("lvtest-token");
}
