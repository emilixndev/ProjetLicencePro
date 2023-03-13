import React from "react";

const Navbar = () => {
  const customStyle = { width: "calc(100% - (2*0.75rem))" };
  return (
    <>
      <div
        className="bg-neutral py-2 rounded-tl-[16px] rounded-tr-[16px] rounded-br-[16px] text-neutral-content fixed z-10"
        style={customStyle}
      >
        <a className="btn btn-ghost normal-case text-xl">LabStock</a>
      </div>
    </>
  );
};

export default Navbar;
