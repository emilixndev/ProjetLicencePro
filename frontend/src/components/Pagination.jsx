import React from "react";

const Pagination = (props) => {
  //props : numberOfPages, currentPage

  return (
    <div className="flex justify-end mr-16 btn-group">
      <button onClick={props.prevPage} className={"btn"}>
        «
      </button>
      {Array.from({ length: props.numberOfPages }, (_, i) => (
        <button
          onClick={props.selectPage}
          key={i}
          className={i == props.activePage ? "btn btn-active" : "btn"}
        >
          {i}
        </button>
      ))}
      <button onClick={props.nextPage} className={"btn"}>
        »
      </button>
    </div>
  );
};

export default Pagination;
