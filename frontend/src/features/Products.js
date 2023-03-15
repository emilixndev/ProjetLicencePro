import { atom } from "recoil";

export const productsState = atom({
  key: "productsState", // unique ID (with respect to other atoms/selectors)
  default: [], // default value (aka initial value)
});
