import React, { useEffect, useState } from "react";

const Sidebar = () => {
  const [open, setOpen] = useState(false);
  const toggle = () => {
    setOpen(!open);
  };
  useEffect(() => {
    console.log(open);
  }, [open]);

  return (
    <ul className="menu bg-base-100 w-56 p-2 shadow-xl">
      <li className="menu-title">
        <span>Filtrer par</span>
      </li>
      <li className="">
        <div></div>

        <div className="flex justify-between">
          <p>Catégorie</p>
          <p onClick={toggle}>a</p>
        </div>
        <div className={`${open ? "h-fit" : "h-0 overflow-hidden"}`}>
          <ul className={`${open ? "block" : "hidden"}`}>
            <li>Filtre 1</li>
            <li>Filtre 2</li>
          </ul>
        </div>
      </li>
      <li>
        <a>Disponibilité</a>
      </li>
      <li>
        <a>Marque</a>
      </li>
    </ul>
  );
};

export default Sidebar;
