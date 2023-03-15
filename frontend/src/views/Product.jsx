import React, { useEffect } from "react";
import "rsuite/dist/rsuite.min.css";
import { DateRangePicker } from "rsuite";
import { useState } from "react";
import { useParams } from "react-router-dom";
import client from "../services/axios";
import Navbar from "../components/Navbar";
import ImageSlider from "../components/ImageSlider";
const usePostId = () => {
  const { id } = useParams();
  return id ? parseInt(id, 10) : -1;
};

const Product = () => {
  const imagestest = [
    "https://via.placeholder.com/300x150?text=Slide%201",
    "https://via.placeholder.com/300x150?text=Slide%202",
    "https://via.placeholder.com/300x150?text=Slide%203",
  ];
  const id = usePostId();
  const [product, setProduct] = useState({});
  const [images, setImages] = useState([]);
  const onOkDate = (value) => {
    console.log("value", value);
  };
  const fetchProduct = async () => {
    try {
      const res = await client().get("materials/" + id);
      console.log("res", res.data);
      setProduct(res.data);
    } catch (error) {
      console.log("error on products fetch", error);
    }
  };
  const addImagePathToObjectArray = (objArray, imagePath) => {
    return objArray.map((obj) => {
      return { path: `${imagePath}/${obj.path}` };
    });
  };
  const fetchImages = async () => {
    if (product.imgMaterials) {
      setImages(
        addImagePathToObjectArray(
          product.imgMaterials,
          "http://127.0.0.1:8000/images/material/"
        )
      );
    }
  };
  useEffect(() => {
    fetchProduct();
  }, [id]);
  useEffect(() => {
    console.log("product", product.imgMaterials);
    fetchImages();
    console.log("images", images);
  }, [product]);
  return (
    <div className="p-3 bg-[#FAFAFA] min-h-screen">
      <Navbar />
      <main className="mt-24 px-14 flex flex-col gap-16">
        <div className="flex gap-10">
          {product.imgMaterials ? (
            <ImageSlider images={images} />
          ) : (
            <p>loading</p>
          )}
          {Object.keys(product).length !== 0 ? (
            <div className="flex flex-col gap-3 pt-3">
              <div className="flex flex-col gap-1">
                <h1 className="text-4xl">{product.name}</h1>
                <h2 className="text-xl text-gray-600">{product.brand.name}</h2>
              </div>
              <p className="w-1/2">{product.description}</p>
              <div className="flex flex-col gap-6">
                <div className="flex gap-16">
                  <div>
                    <h3 className="font-semibold">Fournisseur:</h3>
                    <p>{product.supplier.name}</p>
                    <p>{product.supplier.phone}</p>
                    <p>{product.supplier.email}</p>
                    <p>{product.supplier.address}</p>
                    <p>
                      {product.supplier.city} {product.supplier.postalCode}
                    </p>
                  </div>
                  <div>
                    <h3 className="font-semibold">Liens associés:</h3>
                    <a href={product.link ? product.link : "#"}>
                      <p>{product.link ? product.link : "aucun"}</p>
                    </a>
                  </div>
                </div>
                <div>
                  <h2 className="text-lg font-semibold mb-2">Réservation:</h2>
                  <DateRangePicker
                    placeholder="Voir les disponibilités"
                    onOk={onOkDate}
                  />
                </div>
              </div>
            </div>
          ) : (
            <div>loading</div>
          )}
        </div>
      </main>
    </div>
  );
};

export default Product;
