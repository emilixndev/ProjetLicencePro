import React from "react";

const ProductCard = (props) => {
  return (
    <div className="bg-base-100 shadow-xl rounded-t-[16px] rounded-b-[5px]">
      <figure>
        <div className="h-64 overflow-clip">
          <img
            className="w-full rounded-t-[16px] h-full"
            src={props.image}
            alt={"Image du matériel " + props.name}
          />
        </div>
      </figure>
      <div className="p-5 flex flex-col gap-2 rounded-b-2 bg-gradient-to-r from-[#EBF4F5] to-[#BFD1EC] rounded-b-[5px]">
        <h2 className="text-xl font-bold">{props.name}</h2>
        <p>{props.brand}</p>
      </div>
    </div>
  );
};

export default ProductCard;
