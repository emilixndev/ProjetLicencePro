import React from "react";
import FilterProduct from "../components/filterProduct";
import Navbar from "../components/Navbar";
import ProductCard from "../components/productCard";
import SearchBar from "../components/SearchBar";
import Sidebar from "../components/Sidebar";
const Home = () => {
  const dataFake = [
    {
      name: "Nom matériel",
      brand: "Marque",
      image: "https://picsum.photos/200",
      categoryId: 1,
    },
    {
      name: "Nom matériel 2",
      brand: "Marque 2",
      image: "https://picsum.photos/200",
      categoryId: 0,
    },
    {
      name: "Nom matériel 3",
      brand: "Marque 3",
      image: "https://picsum.photos/200",
      categoryId: 1,
    },
    {
      name: "Nom matériel",
      brand: "Marque",
      image: "https://picsum.photos/200",
      categoryId: 1,
    },
    {
      name: "Nom matériel 2",
      brand: "Marque 2",
      image: "https://picsum.photos/200",
      categoryId: 0,
    },
    {
      name: "Nom matériel 3",
      brand: "Marque 3",
      image: "https://picsum.photos/200",
      categoryId: 1,
    },
    {
      name: "Nom matériel",
      brand: "Marque",
      image: "https://picsum.photos/200",
      categoryId: 1,
    },
    {
      name: "Nom matériel 2",
      brand: "Marque 2",
      image: "https://picsum.photos/200",
      categoryId: 0,
    },
    {
      name: "Nom matériel 3",
      brand: "Marque 3",
      image: "https://picsum.photos/200",
      categoryId: 1,
    },
  ];
  const categories = [
    {
      id: 0,
      name: "casque VR",
    },
    {
      id: 1,
      name: "Ordinateur",
    },
    {
      id: 2,
      name: "Composant",
    },
  ];
  return (
    <div>
      <Navbar />
      <div id="wrapper" className="flex">
        <Sidebar />
        <main className="w-full flex flex-col">
          <div className="self-end">
            <SearchBar />
            <FilterProduct />
          </div>
          <div className="container grid grid-cols-4 gap-6">
            {dataFake.map((item) => {
              return (
                <ProductCard
                  name={item.name}
                  image={item.image}
                  brand={item.brand}
                />
              );
            })}
          </div>
        </main>
      </div>
    </div>
  );
};

export default Home;
