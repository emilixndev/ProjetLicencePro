import React, { useState } from "react";
import Navbar from "../components/Navbar";
import ProductCard from "../components/ProductCard";
import Sidebar from "../components/Sidebar";
import client from "../services/axios";
import { useEffect } from "react";
import { Link } from "react-router-dom";
import Pagination from "../components/Pagination";
import { useRecoilState } from "recoil";
import { productsState } from "../features/Products";
import { selectedCatState } from "../features/SelectedCategory";
import imageDefault from "../assets/default-image.jpg";
import { selectedBrandState } from "../features/SelectedBrand";
const Home = () => {
  const [materials, setMaterials] = useState([]);
  const [pages, setPages] = useState([]);
  const [pageIndex, setPageIndex] = useState(0);
  const [numberOfPages, setNumberOfPages] = useState(0);
  const [products, setProducts] = useRecoilState(productsState);
  const [selectedCat, setSelectedCat] = useRecoilState(selectedCatState);
  const [selectedBrand, setSelectedBrand] = useRecoilState(selectedBrandState);
  function paginate(a, pageIndex, pageSize) {
    var endIndex = Math.min((pageIndex + 1) * pageSize, a.length);
    return a.slice(Math.max(endIndex - pageSize, 0), endIndex);
  }
  const nextPage = () => {
    if (pageIndex < numberOfPages - 1) {
      console.log("next page", pageIndex);
      setPageIndex(pageIndex + 1);
    }
  };
  const prevPage = () => {
    if (pageIndex > 0) {
      console.log("prev page", pageIndex);
      setPageIndex(pageIndex - 1);
    }
  };
  const selectPage = (index) => {
    console.log("select page", parseInt(index.target.innerText));
    setPageIndex(parseInt(index.target.innerText, 10));
  };
  const fetchProducts = async () => {
    try {
      const res = await client().get("materials");
      setProducts(res.data);
      const numPages = Math.ceil(res.data.length / 9);
      setNumberOfPages(numPages);

      let pagesArray = [];
      for (let i = 0; i < numPages; i++) {
        pagesArray.push(paginate(res.data, i, 9));
      }
      setPages(pagesArray);
    } catch (error) {
      console.log("error on products fetch", error);
    }
  };
  const filterProducts = () => {
    console.log("selectedCat", selectedCat);
    console.log("pages", products);
    if (selectedCat === "All") {
      const numPages = Math.ceil(products.length / 9);
      setNumberOfPages(numPages);
      let pagesArray = [];
      for (let i = 0; i < numPages; i++) {
        pagesArray.push(paginate(products, i, 9));
      }
      setProducts(products);
      setPages(pagesArray);
    } else {
      console.log("selectedCatdsfdfgd", selectedCat);
      const result = products.filter((product) => {
        return product.materialTypes[0].name === selectedCat;
      });
      setPages([result]);
      const numPages = Math.ceil(pages.length / 9);
      setNumberOfPages(numPages);
      // const numPages = Math.ceil(pages.length / 9);
      // setNumberOfPages(numPages);
      // console.log("pages", pages, pageIndex);
    }
  };
  const filterProductsByBrand = () => {
    if (selectedBrand.length === 0) {
      const numPages = Math.ceil(products.length / 9);
      setNumberOfPages(numPages);

      let pagesArray = [];
      for (let i = 0; i < numPages; i++) {
        pagesArray.push(paginate(products, i, 9));
      }
      setPages(pagesArray);
    } else {
      const result = products.filter((product) => {
        for (let i = 0; i < selectedBrand.length; i++) {
          if (product.brand.name === selectedBrand[i]) {
            return true;
          }
        }
      });
      setPages([result]);
      const numPages = Math.ceil(pages.length / 9);
      setNumberOfPages(numPages);
    }
  };
  useEffect(() => {
    fetchProducts();
  }, []);
  useEffect(() => {
    filterProducts();
  }, [selectedCat, products]);
  useEffect(() => {
    filterProductsByBrand();
  }, [selectedBrand, products]);

  return (
      <div className="p-3 bg-[#FAFAFA] min-h-screen">
        <Navbar />
        <div id="wrapper" className="flex">
          <Sidebar productList={products} />
          <main className="w-full flex flex-col mt-16 ml-[225px]">
            <div className="container grid xl:grid-cols-3 gap-16 p-16 lg:grid-cols-2">
              {pages.length > 0 ? (
                  pages[pageIndex].map((item) => {
                    return (
                        <Link key={item.id} to={"/product/" + item.id}>
                          <ProductCard
                              name={item.name}
                              image={
                                item.imgMaterials.length > 0
                                    ? "https://labstock.muckensturm.etu.mmi-unistra.fr//images/material/" +
                                    item.imgMaterials[0].path
                                    : imageDefault
                              }
                              brand={item.brand.name}
                          />
                        </Link>
                    );
                  })
              ) : (
                  <p>not loaded</p>
              )}
            </div>
            <Pagination
                numberOfPages={numberOfPages}
                nextPage={nextPage}
                prevPage={prevPage}
                selectPage={selectPage}
                activePage={pageIndex}
            />
          </main>
        </div>
      </div>
  );
};

export default Home;
