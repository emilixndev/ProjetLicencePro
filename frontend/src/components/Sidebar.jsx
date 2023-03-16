import React, { useEffect, useState } from "react";
import client from "../services/axios";
import { useRecoilState } from "recoil";
import { selectedCatState } from "../features/SelectedCategory";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { faChevronDown } from "@fortawesome/free-solid-svg-icons";
import { selectedBrandState } from "../features/SelectedBrand";
const Sidebar = (props) => {
  const [openCat, setOpenCat] = useState(false);
  const [openBrand, setOpenBrand] = useState(false);
  const [categories, setCategories] = useState([]);
  const [brands, setBrands] = useState([]);
  const [selectedCat, setSelectedCat] = useRecoilState(selectedCatState);
  const [selectedBrand, setSelectedBrand] = useRecoilState(selectedBrandState);

  const fetchCategories = async () => {
    try {
      const res = await client().get("material_types");
      const newData = [...res.data];
      newData.forEach((cat) => {
        cat.checked = false;
      });
      setCategories(newData);
    } catch (error) {
      console.log("error on products fetch", error);
    }
  };
  const fetchBrands = async () => {
    try {
      const res = await client().get("brands");
      const newData = [...res.data];
      newData.forEach((brand) => {
        brand.checked = false;
      });
      setBrands(newData);
    } catch (error) {
      console.log("error on products fetch", error);
    }
  };
  useEffect(() => {
    fetchCategories();
    fetchBrands();
  }, []);
  const toggleCat = () => {
    setOpenBrand(false);
    setOpenCat(!openCat);
  };
  const toggleBrand = () => {
    setOpenCat(false);
    setOpenBrand(!openBrand);
  };
  const handleCat = (e) => {
    console.log("******", e.target.nextSibling.innerText);
    const selected = e.target.nextSibling.innerText;
    setSelectedCat(selected);
    setCategories((value) => {
      const newData = [...value];
      console.log("newData", newData);
      newData.forEach((cat) => {
        if (cat.name === selected) {
          cat.checked = true;
        } else {
          cat.checked = false;
        }
      });
      return newData;
    });
  };
  const eraseFilters = () => {
    setSelectedCat("All");
    setSelectedBrand([]);
    setBrands((value) => {
      const newData = [...value];
      newData.forEach((brand) => {
        brand.checked = false;
      });
      return newData;
    });
    setCategories((value) => {
      const newData = [...value];
      newData.forEach((cat) => {
        cat.checked = false;
      });
      return newData;
    });
  };
  const handleBrand = (e) => {
    if (e.target.checked) {
      const selected = e.target.nextSibling.innerText;
      setSelectedBrand((value) => [...value, selected]);
      setBrands((value) => {
        const newData = [...value];
        newData.forEach((brand) => {
          if (brand.name === selected) {
            brand.checked = true;
          }
        });
        return newData;
      });
    } else {
      const selected = e.target.nextSibling.innerText;
      setSelectedBrand((value) => value.filter((item) => item !== selected));
    }
  };
  return (
    <ul
      className=" w-56 shadow-xl pt-[50px] fixed h-full mt-16 overflow-auto pb-4"
      style={{ height: "calc(100% - 4.5rem)" }}
    >
      <li className="text-xs text-gray-400 px-4">Filtrer par</li>
      <hr className="my-2" />
      <li className="overflow-auto max-h-96">
        <p className="px-4">Filtres actifs</p>
        <div className="px-4">
          {selectedCat !== "All" ? (
            <p className="p-2 badge m-1">{selectedCat}</p>
          ) : null}
          {selectedBrand.map((brand, i) => (
            <p className="p-2 badge m-1" key={i}>
              {brand}
            </p>
          ))}
        </div>
      </li>

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
                  <label
                    className="label cursor-pointer justify-start gap-2"
                    htmlFor="category"
                  >
                    <input
                      type="radio"
                      className="radio radio-primary"
                      name="category"
                      onChange={handleCat}
                      checked={item.checked}
                    />
                    <span className="label-text text-neutral">{item.name}</span>
                  </label>
                </div>
              );
            })}
          </ul>
        </div>
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
                      onChange={handleBrand}
                      checked={item.checked}
                    />
                    <span className="label-text text-neutral">{item.name}</span>
                  </label>
                </div>
              );
            })}
          </ul>
        </div>
        <hr className="my-2" />
      </li>
      <li>
        <button className="btn btn-primary mx-4" onClick={eraseFilters}>
          Effacer tous les filtres
        </button>
      </li>
    </ul>
  );
};

export default Sidebar;
