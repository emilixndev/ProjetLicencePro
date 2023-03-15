import { atom } from "recoil";

export const selectedBrandState = atom({
  key: "selectedBrandState", // unique ID (with respect to other atoms/selectors)
  default: [], // default value (aka initial value)
});
