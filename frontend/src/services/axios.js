import axios from "axios";

const getHeadersKeys = () => {
  return {
    Accept: "application/json",
    "Content-Type": "application/json",
    "Access-Control-Allow-Credentials": false,
  };
};
export const client = () => {
  const instance = axios.create({
    baseURL: `https://labstock.muckensturm.etu.mmi-unistra.fr/api/`,
    // baseURL: `http://127.0.0.1:8000/api/`,

    withCredentials: true,
    headers: getHeadersKeys(),
  });

  return instance;
};

export default client;
