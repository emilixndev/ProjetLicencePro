import axios from "axios";
const getHeadersKeys = () => {
  return {
    Accept: "application/ld+json",
    "Content-Type": "application/ld+json",
    "Access-Control-Allow-Credentials": true,
  };
};
export const client = () => {
  const instance = axios.create({
    baseURL: `http://127.0.0.1:8000/api/`,
    withCredentials: true,
    headers: getHeadersKeys(),
  });

  return instance;
};

export default client;
