import React from "react";
import Home from "./Home";
import { Route, Routes } from "react-router-dom";

const PageWrapper = () => {
  return (
    <div>
      <Routes>
        <Route path={"/"} element={<Home />} />
      </Routes>
    </div>
  );
};

export default PageWrapper;
