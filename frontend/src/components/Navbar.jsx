import React from "react";
import { Link } from "react-router-dom";

const Navbar = () => {
  const customStyle = { width: "calc(100% - (2*0.75rem))" };
  return (
    <>
      <div
        className="bg-neutral py-2 rounded-tl-[16px] rounded-tr-[16px] rounded-br-[16px] text-neutral-content fixed z-10"
        style={customStyle}
      >
        <Link to={"/"} className="btn btn-ghost normal-case text-xl">
          <h1>LabStock</h1>
        </Link>
      </div>
    </>
  );
};

export default Navbar;
