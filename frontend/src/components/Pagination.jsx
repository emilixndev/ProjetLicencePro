import React from "react";

const Pagination = (props) => {
  //props : numberOfPages, currentPage

  return (
    <div>
      <button
        onClick={() => {
          props.prevPage;
        }}
      >
        Prev
      </button>
      {Array.from({ length: props.numberOfPages }, (_, i) => (
        <button key={i}>{i}</button>
      ))}
      <button
        onClick={() => {
          props.nextPage;
        }}
      >
        Next
      </button>
    </div>
  );
};

export default Pagination;
