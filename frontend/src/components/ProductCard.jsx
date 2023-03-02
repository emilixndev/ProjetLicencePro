import React from "react";

const ProductCard = (props) => {
  return (
    <div className="card bg-base-100 shadow-xl">
      <figure>
        <img src={props.image} alt="Shoes" />
      </figure>
      <div className="card-body">
        <h2 className="card-title">{props.name}</h2>
        <p>{props.brand}</p>
      </div>
    </div>
  );
};

export default ProductCard;
