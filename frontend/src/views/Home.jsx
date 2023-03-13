import React, { useState } from "react";
import Navbar from "../components/Navbar";
import ProductCard from "../components/ProductCard";
import Sidebar from "../components/Sidebar";
import client from "../services/axios";
import { useEffect } from "react";
import { Link } from "react-router-dom";
import Pagination from "../components/Pagination";
const Home = () => {
  const [materials, setMaterials] = useState([]);
  const [pages, setPages] = useState([]);
  const [pageIndex, setPageIndex] = useState(0);
  const [numberOfPages, setNumberOfPages] = useState(0);

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
      console.log("fetched Products", res.data);
      setMaterials(res.data);

      const numPages = Math.ceil(res.data.length / 9);
      setNumberOfPages(numPages);

      let pagesArray = [];
      for (let i = 0; i < numPages; i++) {
        pagesArray.push(paginate(res.data, i, 9));
      }
      setPages(pagesArray);
      console.log("pages", pages);
    } catch (error) {
      console.log("error on products fetch", error);
    }
  };

  useEffect(() => {
    fetchProducts();
  }, []);

  return (
    <div className="p-3 bg-[#FAFAFA] h-screen">
      <Navbar />
      <div id="wrapper" className="flex">
        <Sidebar />
        <main className="w-full flex flex-col mt-16 ml-[225px]">
          <div className="container grid grid-cols-3 gap-16 p-16">
            {pages.length > 0 ? (
              pages[pageIndex].map((item) => {
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
