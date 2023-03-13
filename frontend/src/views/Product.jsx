import React from "react";
import Navbar from "../components/Navbar";
const Product = () => {
  return (
    <div className="p-3 bg-[#FAFAFA] min-h-screen">
      <Navbar />
      <main className="mt-24 px-14 flex flex-col gap-16">
        <div className="flex gap-10">
          <img src="https://picsum.photos/500" />
          <div className="flex flex-col gap-3 pt-3">
            <div className="flex flex-col gap-1">
              <h1 className="text-4xl">Casque VR</h1>
              <h2 className="text-xl text-gray-600">Octopus</h2>
            </div>
            <p>
              Description du produit. Lorem ipsum dolor sit amet, consectetur
              adipiscing elit. Etiam eu turpis molestie, dictum est a, mattis
              tellus. Sed dignissim, metus nec fringilla accumsan, risus sem
              sollicitudin lacus, ut interdum tellus elit sed risus. Maecenas
              eget condimentum velit, sit amet feugiat lectus.
            </p>
            <div className="flex justify-between">
              <div>
                <div>
                  <h3>Fournisseur:</h3>
                  <p>Nom</p>
                  <p>Rue</p>
                  <p>Ville 67200</p>
                </div>
                <div>
                  <h3>Liens associés:</h3>
                  <a href="#">https://seafile.com/xxxx</a>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div className="flex justify-between"></div>
      </main>
    </div>
  );
};

export default Product;
