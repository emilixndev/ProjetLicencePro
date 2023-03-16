import React, { useEffect } from "react";
import "rsuite/dist/rsuite.min.css";
import { DateRangePicker } from "rsuite";
import { useParams } from "react-router";
import { useState } from "react";
import client from "../services/axios";
import imageDefault from "../assets/default-image.jpg";
import "reactjs-popup/dist/index.css";
import Popup from "reactjs-popup";
import Navbar from "../components/Navbar";
import ImageSlider from "../components/ImageSlider";

const Product = () => {
  const [product, setProduct] = useState({});
  const [images, setImages] = useState([]);
  const [isModalOpen, setIsModalOpen] = useState(false);
  const [firstName, setFirstName] = useState("");
  const [lastName, setLastName] = useState("");
  const [email, setEmail] = useState("");
  const [startDate, setStartDate] = useState(null);
  const [endDate, setEndDate] = useState(null);
  const [status, setStatus] = useState("");
  const [reservations, setReservations] = useState([]);

  const usePostId = () => {
    const { id } = useParams();
    return id ? parseInt(id, 10) : -1;
  };

  const id = usePostId();

  const fetchProduct = async () => {
    try {
      const res = await client().get("materials/" + id);
      console.log("res", res.data);
      setProduct(res.data);
      console.log("reservations", res.data.reservations);
      setReservations(res.data.reservations);
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

  const handleOk = async (date) => {
    const startDate = date[0];
    const endDate = date[1];
    const formattedStartDate = startDate.toISOString().substring(0, 10);
    const formattedEndDate = endDate.toISOString().substring(0, 10);

    setStartDate(formattedStartDate);
    setEndDate(formattedEndDate);
    setIsModalOpen(true);
  };

  const handleModalClose = () => {
    setIsModalOpen(false);
  };

  const isDateDisabled = (date) => {
    const disabledDates = reservations.flatMap((reservation) => {
      const startDate = new Date(reservation.startDate);
      const endDate = reservation.endDate
        ? new Date(reservation.endDate)
        : null;
      const disabledDates = [];
      let currentDate = startDate;
      while (!endDate || currentDate <= endDate) {
        disabledDates.push(currentDate.toISOString().substring(0, 10));
        currentDate.setDate(currentDate.getDate() + 1);
      }
      return disabledDates;
    });
    const dateString = date.toISOString().substring(0, 10);
    return disabledDates.includes(dateString);
  };

  const handleFirstNameChange = (e) => {
    setFirstName(e.target.value);
  };

  const handleLastNameChange = (e) => {
    setLastName(e.target.value);
  };

  const handleEmailChange = (e) => {
    setEmail(e.target.value);
  };

  const handleStatusChange = (e) => {
    setStatus(e.target.value);
  };

  const handleSubmit = async () => {
    try {
      const reservationData = {
        firstName,
        lastName,
        emailBorrower: email,
        statutBorrower: status,
        startDate,
        endDate,
        material: "/api/materials/" + id,
      };
      client().post("/reservations", reservationData);
      console.log("Reservation post", reservationData);
      setIsModalOpen(false);
    } catch (error) {
      console.error("Erreur lors de la réservation :", error);
    }
  };

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
            <div className="flex flex-col gap-3 pt-3 md:w-1/2">
              <div className="flex flex-col gap-1">
                <h1 className="text-4xl">{product.name}</h1>
                <h2 className="text-xl text-gray-600">{product.brand.name}</h2>
              </div>
              <div className="flex flex-col xl:flex-row justify-between gap-3">
                <div className="">
                  <p className="">{product.description}</p>
                </div>
                <div className="flex gap-10">
                  <div>
                    <p className="font-semibold">Fournisseur:</p>
                    <p>{product.supplier.name}</p>
                    <p>{product.supplier.phone}</p>
                    <p>{product.supplier.email}</p>
                    <p>{product.supplier.address}</p>
                    <p>
                      {product.supplier.city} {product.supplier.postalCode}
                    </p>
                  </div>
                  <div>
                    <p className="font-semibold">Liens associés:</p>
                    <a href="#">
                      <p>https://seafile.com/xxxx</p>
                    </a>
                  </div>
                </div>
              </div>
              <div className="">
                <h2 className="text-lg font-semibold mb-2">Réservation:</h2>
                <h3>Avec une date de fin prédéfinie:</h3>
                <DateRangePicker
                  onOk={handleOk}
                  disabledDate={isDateDisabled}
                  showOneCalendar
                  placeholder="Voir les disponibilités"
                />
              </div>
              <Popup open={isModalOpen} onClose={handleModalClose}>
                <div className="">
                  <form className="px-8 py-6 ">
                    <div className="mb-4">
                      <label
                        className="block text-gray-700 text-sm font-bold mb-2"
                        htmlFor="firstname"
                      >
                        Prénom
                      </label>
                      <input
                        className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        id="firstname"
                        type="text"
                        placeholder="Prénom"
                        onChange={handleFirstNameChange}
                      />
                    </div>
                    <div className="mb-4">
                      <label
                        className="block text-gray-700 text-sm font-bold mb-2"
                        htmlFor="firstname"
                      >
                        Nom
                      </label>
                      <input
                        className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        id="lastname"
                        type="text"
                        placeholder="Nom"
                        onChange={handleLastNameChange}
                      />
                    </div>
                    <div className="mb-4">
                      <label
                        className="block text-gray-700 text-sm font-bold mb-2"
                        htmlFor="emailBorrower"
                      >
                        Adresse mail
                      </label>
                      <input
                        className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        id="emailBorrower"
                        type="text"
                        placeholder="Adresse mail"
                        onChange={handleEmailChange}
                      />
                    </div>
                    <div className="mb-4">
                      <label
                        className="block text-gray-700 text-sm font-bold mb-2"
                        htmlFor="statutBorrower"
                      >
                        Statut
                      </label>
                      <select
                        className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        id="statutBorrower"
                        value={status}
                        onChange={handleStatusChange}
                      >
                        <option value="">Choisissez votre statut</option>
                        <option value="Perma">Perma</option>
                        <option value="Doc">Doc</option>
                        <option value="PostDoc">PostDoc</option>
                        <option value="Etudiant">Etudiant</option>
                        <option value="EXT">EXT</option>
                      </select>
                    </div>
                    <button
                      className="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                      type="button"
                      onClick={handleSubmit}
                    >
                      Réserver
                    </button>
                  </form>
                </div>
              </Popup>
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
