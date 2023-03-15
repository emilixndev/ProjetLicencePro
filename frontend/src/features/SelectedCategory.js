import { atom } from "recoil";

export const selectedCatState = atom({
  key: "selectedCatState", // unique ID (with respect to other atoms/selectors)
  default: "All", // default value (aka initial value)
});
