import { atom } from "recoil";

export const productsState = atom({
  key: "products", // unique ID (with respect to other atoms/selectors)
  default: undefined, // default value (aka initial value)
});
