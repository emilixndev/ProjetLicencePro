import React, { useEffect, useState } from "react";
import client from "../services/axios";

import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { faChevronDown } from "@fortawesome/free-solid-svg-icons";
const Sidebar = () => {
  const [openCat, setOpenCat] = useState(false);
  const [openBrand, setOpenBrand] = useState(false);
  const [categories, setCategories] = useState([]);
  const [brands, setBrands] = useState([]);
  const fetchCategories = async () => {
    try {
      const res = await client().get("material_types");
      console.log("fetched Categories", res.data);
      setCategories(res.data);
    } catch (error) {
      console.log("error on products fetch", error);
    }
  };
  const fetchBrands = async () => {
    try {
      const res = await client().get("brands");
      console.log("fetched Brands", res.data);
      setBrands(res.data);
    } catch (error) {
      console.log("error on products fetch", error);
    }
  };
  useEffect(() => {
    fetchCategories();
    fetchBrands();
  }, []);
  const toggleCat = () => {
    setOpenCat(!openCat);
  };
  const toggleBrand = () => {
    setOpenBrand(!openBrand);
  };

  return (
    <ul className=" w-56 shadow-xl pt-[50px] fixed h-full mt-16">
      <li className="text-xs text-gray-400 px-4">Filtrer par</li>
      <hr className="my-2" />
      <li className="overflow-auto max-h-96">
        <div
          className="flex items-center justify-between px-4 sticky bg-[#FAFAFA] top-0"
          onClick={toggleCat}
        >
          <p className="text-base">Catégorie</p>
          <FontAwesomeIcon
            icon={faChevronDown}
            className={`${openCat ? "rotate-180" : ""}`}
          />
        </div>
        <div className={`${openCat ? "h-fit" : "h-0 overflow-hidden"} px-4`}>
          <ul className={`${openCat ? "block" : "hidden"}`}>
            {categories.map((item) => {
              return (
                <div className="form-control" key={item.id}>
                  <label className="label cursor-pointer justify-start gap-2">
                    <input
                      type="checkbox"
                      className="checkbox checkbox-primary"
                    />
                    <span className="label-text">{item.name}</span>
                  </label>
                </div>
              );
            })}
          </ul>
        </div>
        <hr className="my-2" />
      </li>
      <li className="overflow-auto max-h-96">
        <p className="px-4">Disponibilité</p>
        <hr className="my-2" />
      </li>
      <li className="overflow-auto max-h-96">
        <div
          className="flex items-center justify-between sticky bg-[#FAFAFA] top-0 px-4"
          onClick={toggleBrand}
        >
          <p className="text-base">Marque</p>
          <FontAwesomeIcon
            icon={faChevronDown}
            className={`${openBrand ? "rotate-180" : ""}`}
          />
        </div>
        <div className={`${openBrand ? "h-fit" : "h-0 overflow-hidden"} px-4`}>
          <ul className={`${openBrand ? "block" : "hidden"} px-4`}>
            {brands.map((item) => {
              return (
                <div className="form-control" key={item.id}>
                  <label className="label cursor-pointer justify-start gap-2">
                    <input
                      type="checkbox"
                      className="checkbox checkbox-primary"
                    />
                    <span className="label-text">{item.name}</span>
                  </label>
                </div>
              );
            })}
          </ul>
        </div>
        <hr className="my-2" />
      </li>
    </ul>
  );
};

export default Sidebar;
