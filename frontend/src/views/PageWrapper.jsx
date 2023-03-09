import React from "react";
import Home from "./Home";
import { Route, Routes } from "react-router-dom";
import Product from "./Product";

const PageWrapper = () => {
  return (
    <div>
      <Routes>
        <Route path={"/"} element={<Home />} />
        <Route path={"/product/:id"} element={<Product />}></Route>
      </Routes>
    </div>
  );
};

export default PageWrapper;
