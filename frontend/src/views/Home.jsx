import React, { useState } from "react";
import FilterProduct from "../components/filterProduct";
import Navbar from "../components/Navbar";
import ProductCard from "../components/ProductCard";
import SearchBar from "../components/SearchBar";
import Sidebar from "../components/Sidebar";
import client from "../services/axios";
import { useEffect } from "react";
import { Link } from "react-router-dom";
import { atom, useRecoilValue } from "recoil";
const Home = () => {
  const [materials, setMaterials] = useState([]);
  // const materialsListState = atom({
  //   key: "MaterialsList",
  //   default: [],
  // });

  const fetchProducts = async () => {
    try {
      const res = await client().get("materials");
      console.log("fetched Products", res.data);
      setMaterials(res.data);
      // const materialList = useRecoilValue(materialsListState);
      // return res.data.data;
      // console.log(materialList);
    } catch (error) {
      console.log("error on products fetch", error);
    }
  };

  useEffect(() => {
    fetchProducts();
  }, []);

  return (
    <div className="p-3 bg-[#FAFAFA]">
      <Navbar />
      <div id="wrapper" className="flex">
        <Sidebar />
        <main className="w-full flex flex-col mt-16 ml-[225px]">
          <div className="container grid grid-cols-3 gap-16 p-16">
            {materials.map((item) => {
              return (
                <Link key={item.id} to={"/product/" + item.id}>
                  {" "}
                  {/**A remplacer par un id */}
                  <ProductCard
                    name={item.name}
                    image={item.budget}
                    brand={item.brand.name}
                  />
                </Link>
              );
            })}
          </div>
        </main>
      </div>
    </div>
  );
};

export default Home;
